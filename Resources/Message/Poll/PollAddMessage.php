<?php

namespace Resources\Message\Poll;

class PollAddMessage {
    /**
     * @var string
    */
    public static $QuestionEmpty = "La saisie de la question est obligatoire.";
    /**
     * @var string
     */
    public static $QuestionTooLong = "La question est trop longue (%d caractères max).";
    /**
     * @var string
     */
    public static $LessThanTwoAnswers = "La saisie d'au moins 2 questions est obligatoire.";
    /**
     * @var string
     */
    public static $AnswerTooLong = "La réponse est trop longue (%d caractères max).";
}