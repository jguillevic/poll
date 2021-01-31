<?php

namespace Controller\Poll;

use Model\Poll\Poll;
use Model\Poll\PollAnswer;
use Contract\Poll\IPollDA;
use Contract\User\IUserSession;
use Contract\Render\IRenderer;
use Contract\Redirection\IRedirector;
use Contract\Request\IRequestInfoProvider;
use Helper\Route\RouteHelper;
use Resources\Message\Poll\PollAddMessage;

class PollController {
    /**
     * @var IPollDA
     */
    private $da;

    /**
     * @var IUserSession
     */
    private $session;

    /**
     * @var IRenderer En charge du rendu de la page
     */
    private $renderer;

    /**
     * @var IRedirector
     */
    private $redirector;

    /**
     * @var IRequestInfoProvider
     */
    private $rip;

    /**
     * @var RouteHelper
     */
    private $rh;

    const DefaultDuration = 7;
    const QuestionMaxLength = 100;
    const AnswerMaxLength = 100;

    function __construct(IPollDA $da, IUserSession $session, IRenderer $renderer, IRedirector $redirector, IRequestInfoProvider $rip) {
        $this->da = $da;
        $this->session = $session;
        $this->renderer = $renderer;
        $this->redirector = $redirector;
        $this->rip = $rip;
        $this->rh = new RouteHelper();
    }

    public function Add() : void {
        if (!$this->session->IsLogin())
            $this->redirector->Redirect($this->rh->GetRoute("HomeDisplay"));

        $errors = [ 
            "question" => []
            , "answer_1" => []
            , "answer_2" => []
            , "answer_3" => []
            , "answer_4" => []
            , "answer_5" => []
         ];

        if ($this->rip->IsGet()) {
            $question = "";
            $duration = self::DefaultDuration;
            $answer1 = "";
            $answer2 = "";
            $answer3 = "";
            $answer4 = "";
            $answer5 = "";
        } else if ($this->rip->IsPost()) {
            $data = $this->rip->GetSubmitData();
            $question = self::GetQuestion($data);
            $duration = self::GetDuration($data);
            $answer1 = self::GetAnswer1($data);
            $answer2 = self::GetAnswer2($data);
            $answer3 = self::GetAnswer3($data);
            $answer4 = self::GetAnswer4($data);
            $answer5 = self::GetAnswer5($data);

            $hasErrors = false;

            if (empty($question)) {
                $errors["question"][] = PollAddMessage::$QuestionEmpty;
                $hasErrors = true;
            } else if (strlen($question) > self::QuestionMaxLength) {
                $errors["question"][] = PollAddMessage::$QuestionTooLong;
                $hasErrors = true;
            }

            $answersCount = 0;
            if (!empty($answer1)) {
                $answersCount++;
                if (strlen($answer1) > self::AnswerMaxLength) {
                    $errors["answer_1"][] = PollAddMessage::$AnswerTooLong;
                    $hasErrors = true;
                }
            }
            if (!empty($answer2)) {
                $answersCount++;
                if (strlen($answer2) > self::AnswerMaxLength) {
                    $errors["answer_2"][] = PollAddMessage::$AnswerTooLong;
                    $hasErrors = true;
                }
            }
            if (!empty($answer3)) {
                $answersCount++;
                if (strlen($answer3) > self::AnswerMaxLength) {
                    $errors["answer_3"][] = PollAddMessage::$AnswerTooLong;
                    $hasErrors = true;
                }
            }
            if (!empty($answer4)) {
                $answersCount++;
                if (strlen($answer4) > self::AnswerMaxLength) {
                    $errors["answer_4"][] = PollAddMessage::$AnswerTooLong;
                    $hasErrors = true;
                }
            }
            if (!empty($answer5)) {
                $answersCount++;
                if (strlen($answer5) > self::AnswerMaxLength) {
                    $errors["answer_5"][] = PollAddMessage::$AnswerTooLong;
                    $hasErrors = true;
                }
            }

            if ($answersCount < 2) {
                if (empty($answer1))
                    $errors["answer_1"][] = PollAddMessage::$LessThanTwoAnswers;
                if (empty($answer2) 
                    && ($answersCount == 0 || $answersCount == 1 && !empty($answer1)))
                    $errors["answer_2"][] = PollAddMessage::$LessThanTwoAnswers;
                
                $hasErrors = true;
            }

            if (!$hasErrors) {
                $poll = new Poll();
                $poll->SetQuestion($question);
                $poll->SetDuration($duration);
                $poll->SetCreationDate(new \DateTime());
                $poll->SetCreationUser($this->session->GetUser());
                $answers = [];
                if (!empty($answer1)) {
                    $answer = new PollAnswer();
                    $answer->SetLabel($answer1);
                    $answers[] = $answer;
                }
                if (!empty($answer2)) {
                    $answer = new PollAnswer();
                    $answer->SetLabel($answer2);
                    $answers[] = $answer;
                }
                if (!empty($answer3)) {
                    $answer = new PollAnswer();
                    $answer->SetLabel($answer3);
                    $answers[] = $answer;
                }
                if (!empty($answer4)) {
                    $answer = new PollAnswer();
                    $answer->SetLabel($answer4);
                    $answers[] = $answer;
                }
                if (!empty($answer5)) {
                    $answer = new PollAnswer();
                    $answer->SetLabel($answer5);
                    $answers[] = $answer;
                }
                $poll->SetAnswers($answers);

                $result = $this->da->Add([ $poll ]);

                $this->redirector->Redirect($this->rh->GetRoute("HomeDisplay"));
            }
        } else {
            $this->redirector->Redirect($this->rh->GetRoute("HomeDisplay"));
        }

        echo $this->renderer->Render(join(DIRECTORY_SEPARATOR,[ "Poll", "Add.twig" ])
        , [ 
            "question" => $question
            , "duration" => $duration
            , "answer_1" => $answer1
            , "answer_2" => $answer2
            , "answer_3" => $answer3
            , "answer_4" => $answer4
            , "answer_5" => $answer5
            , "errors" => $errors
            ]);
    }

    public static function GetQuestion(array $data) : string {
        if (!array_key_exists("question", $data)) {
            return "";
        } else {
            return $data["question"];
        }
    }

    public static function GetDuration(array $data) : int {
        if (!array_key_exists("duration", $data)) {
            return self::DefaultDuration;
        } else {
            return intval($data["duration"]);
        }
    }

    public static function GetAnswer1(array $data) : string {
        if (!array_key_exists("answer_1", $data)) {
            return "";
        } else {
            return $data["answer_1"];
        }
    }

    public static function GetAnswer2(array $data) : string {
        if (!array_key_exists("answer_2", $data)) {
            return "";
        } else {
            return $data["answer_2"];
        }
    }

    public static function GetAnswer3(array $data) : string {
        if (!array_key_exists("answer_3", $data)) {
            return "";
        } else {
            return $data["answer_3"];
        }
    }

    public static function GetAnswer4(array $data) : string {
        if (!array_key_exists("answer_4", $data)) {
            return "";
        } else {
            return $data["answer_4"];
        }
    }

    public static function GetAnswer5(array $data) : string {
        if (!array_key_exists("answer_5", $data)) {
            return "";
        } else {
            return $data["answer_5"];
        }
    }
}