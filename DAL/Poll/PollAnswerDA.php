<?php

namespace DAL\Poll;

use Model\Poll\PollAnswer;
use DAL\Tools\DBConnection;

class PollAnswerDA {
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

    public function Add(array $answers) : bool {
        $query = "INSERT INTO poll_answers (label, poll_id) VALUES (:label, :poll_id);";

        $result = false;

        try {
            if ($this->connect->BeginTransac()) {

                foreach ($answers as $pollId => $answersForOnePoll) {
                    foreach ($answersForOnePoll as $answer) {
                        $result = $this->connect->Execute(
                            $query
                            , [ 
                                ":label" => $answer->GetLabel()
                                , ":poll_id" => $pollId
                            ]);   

                        if (!$result)
                            break;   
                    }        
                }

                $result = $this->connect->CommitTransac();
            }
        } catch (Exception $e) {
            $result = $this->connect->RollBackTransac();
        }

        return $result;
    }

    public function Get(array $pollIds) : array {
        $query = "SELECT id, label, poll_id FROM poll_answers WHERE poll_id IN (";

        $answers = [];
        $params = [];

        $i = 0;
        foreach ($pollIds as $pollId) {
            if ($i > 0) {
                $query .= ", ";
            }

            $idParamName = ":poll_id_" . $i;

            $query .= $idParamName;

            $answers[$pollId] = [];
            $params[$idParamName] = $pollId;

            $i++;
        }

        $query .= ");";

        try {
            if ($this->connect->BeginTransac()) {

                $items = $this->connect->FetchAll($query, $params);

                $this->connect->CommitTransac();

                foreach ($items as $item) {
                    $answer = new PollAnswer();
                    $answer->SetId($item["id"]);
                    $answer->SetLabel($item["label"]);                
                    $answers[$item["poll_id"]][$answer->GetId()] = $answer;
                }
            }
        } catch (Exception $e) {
            $this->connect->RollBackTransac();
        }

        return $answers;
    }
}