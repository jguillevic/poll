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
}