<?php

namespace DAL\Poll;

use Model\Poll\Poll;
use Model\Poll\PollAnswer;
use Model\User\User;
use DAL\Tools\DBConnection;
use Contract\Poll\IPollDA;
use Contract\Poll\PollFilter;

class PollDA implements IPollDA {
    /**
     * @var DBConnection
     */
    private $connect;

    public function __construct(DBConnection $connect = null) {
        if ($connect == null) {
            $this->connect = new DBConnection();
        } else {
            $this->connect = $connect;
        }
    }

    /**
     * 
     * 
     * @param array $polls Sondages à ajouter
     * @return bool true si succès, false sinon
     */
    public function Add(array $polls) : bool {
        $query = "INSERT INTO polls (question, creation_date, creation_user_id, duration) VALUES (:question, :creation_date, :creation_user_id, :duration);";

        $result = false;

        try {
            if ($this->connect->BeginTransac()) {
                $answers = [];

                foreach ($polls as $poll) {
                    $result = $this->connect->Execute(
                        $query
                        , [ 
                            ":question" => $poll->GetQuestion()
                            , ":creation_date" => $poll->GetCreationDate()->format("Y-m-d H:i:s")
                            , ":creation_user_id" => $poll->GetCreationUser()->GetId()
                            , ":duration" => $poll->GetDuration()
                        ]);

                    if (!$result)
                        break;                   

                    $id = intval($this->connect->GetLastInsertId());
                    
                    $answers[$id] = $poll->GetAnswers();
                }

                if ($result) {
                    $answerDA = new PollAnswerDA($this->connect);
                    $result = $answerDA->Add($answers);
                }

                if ($result)
                    $result = $this->connect->CommitTransac();
            }
        } catch (Exception $e) {
            $result = $this->connect->RollBackTransac();
        }

        return $result;
    }

    public function Get(PollFilter $filter) : array {
        $query = "SELECT P.id AS id, P.question AS question, P.duration AS duration, P.creation_date AS creation_date, U.id AS user_id, U.login AS user_login FROM polls P INNER JOIN users U ON P.creation_user_id = U.id";

        $wheres = [];
        if ($filter->GetOnGoing()) {
            $wheres[] = "DATE_ADD(P.creation_date, INTERVAL P.duration DAY) >= :current_date";
        }

        $index = 0;
        foreach ($wheres as $where) {
            if ($index == 0) {
                $query .= " WHERE " . $where;
            } else {
                $query .= " AND " . $where;
            }
            $index++;
        }

        $orderBys = [];
        if ($filter->GetCreationDateSort() == "ASC" || $filter->GetCreationDateSort() == "DESC") {
            $orderBys[] = "P.creation_date " . $filter->GetCreationDateSort();
        }

        $index = 0;
        foreach ($orderBys as $orderBy) {
            if ($index == 0) {
                $query .= " ORDER BY " . $orderBy;
            } else {
                $query .= ", " . $orderBy;
            }
            $index++;
        }

        $polls = [];

        try {
            if ($this->connect->BeginTransac()) {
                $params = [];

                if ($filter->GetOnGoing()) {
                    $currentDate = new \DateTime();
                    $params[":current_date"] = $currentDate->format("Y-m-d H:i:s");
                }

                $items = $this->connect->FetchAll($query, $params);

                $pollIds = [];

                foreach ($items as $item) {
                    $poll = new Poll();
                    $pollId = $item["id"];
                    $pollIds[] = $pollId;
                    $poll->SetId($pollId);
                    $poll->SetQuestion($item["question"]);
                    $poll->SetDuration($item["duration"]);
                    $poll->SetCreationDate(new \DateTime($item["creation_date"]));
                    $user = new User();
                    $user->SetId($item["user_id"]);
                    $user->SetLogin($item["user_login"]);
                    $poll->SetCreationUser($user);
                    $polls[$poll->GetId()] = $poll;
                }

                if (count($pollIds) > 0) {
                    $answerDA = new PollAnswerDA($this->connect);
                    $answers = $answerDA->Get($pollIds);

                    if (count($answers) > 0) {
                        foreach ($polls as $poll) {
                            $poll->SetAnswers($answers[$poll->GetId()]);
                        }
                    }
                }

                $this->connect->CommitTransac();
            }
        } catch (Exception $e) {
            $this->connect->RollBackTransac();
        }

        return $polls;
    }
}