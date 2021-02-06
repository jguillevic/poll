<?php

namespace Contract\Poll;

class PollFilter {
    /**
     * @var bool
     */
    private $onGoing;
    /**
     * @var string
     */
    private $creationDateSort = "";

    /**
     * Get the value of onGoing
     *
     * @return  bool
     */ 
    public function GetOnGoing()
    {
        return $this->onGoing;
    }

    /**
     * Set the value of onGoing
     *
     * @param  bool  $onGoing
     *
     * @return  self
     */ 
    public function SetOnGoing(bool $onGoing)
    {
        $this->onGoing = $onGoing;

        return $this;
    }

    /**
     * Get the value of creationDateSort
     *
     * @return  string
     */ 
    public function GetCreationDateSort()
    {
        return $this->creationDateSort;
    }

    /**
     * Set the value of creationDateSort
     *
     * @param  string  $creationDateSort
     *
     * @return  self
     */ 
    public function SetCreationDateSort(string $creationDateSort)
    {
        $this->creationDateSort = $creationDateSort;

        return $this;
    }
}