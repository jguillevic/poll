<?php

namespace Model\Poll;

use Model\User\User;

class Poll {
    /**
     * @var int Identifiant
     */
    private $id;
    /**
     * @var string Question
     */
    private $question;
    /**
     * @var \DateTime Date de création
     */
    private $creationDate;
    /**
     * @var User Utilisateur à l'origine de la création
     */
    private $creationUser;
    /**
     * @var int Durée
     */
    private $duration;
    /**
     * @var array Tableau de ProbeChoice
     */
    private $answers;

    public function __construct() {
        $this->answers = [];
    }

    /**
     * Get identifiant
     *
     * @return  int
     */ 
    public function GetId()
    {
        return $this->id;
    }

    /**
     * Set identifiant
     *
     * @param  int  $id  Identifiant
     *
     * @return  self
     */ 
    public function SetId(int $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get question
     *
     * @return  string
     */ 
    public function GetQuestion()
    {
        return $this->question;
    }

    /**
     * Set question
     *
     * @param  string  $question  Question
     *
     * @return  self
     */ 
    public function SetQuestion(string $question)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get date de création
     *
     * @return  \DateTime
     */ 
    public function GetCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set date de création
     *
     * @param  \DateTime  $creationDate  Date de création
     *
     * @return  self
     */ 
    public function SetCreationDate(\DateTime $creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get utilisateur à l'origine de la création
     *
     * @return  User
     */ 
    public function GetCreationUser()
    {
        return $this->creationUser;
    }

    /**
     * Set utilisateur à l'origine de la création
     *
     * @param  User  $creationUser  Utilisateur à l'origine de la création
     *
     * @return  self
     */ 
    public function SetCreationUser(User $creationUser)
    {
        $this->creationUser = $creationUser;

        return $this;
    }

    /**
     * Get durée
     *
     * @return  int
     */ 
    public function GetDuration()
    {
        return $this->duration;
    }

    /**
     * Set durée
     *
     * @param  int  $duration  Durée
     *
     * @return  self
     */ 
    public function SetDuration(int $duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get tableau de PollAnswer
     *
     * @return  array
     */ 
    public function GetAnswers()
    {
        return $this->answers;
    }

    /**
     * Set tableau de PollAnswer
     *
     * @param  array  $answers  Tableau de PollAnswer
     *
     * @return  self
     */ 
    public function SetAnswers(array $answers)
    {
        $this->answers = $answers;

        return $this;
    }
}