<?php

namespace DAL\Poll;

use Model\Poll\Poll;
use Model\Poll\PollAnswer;
use DAL\Tools\DBConnection;
use Contract\Poll\IPollDA;

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
                            , ":creation_date" => $poll->GetCreationDate()->format("Y-m-d")
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
}