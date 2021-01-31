<?php

namespace Model\Poll;

class PollAnswer {
    /**
     * @var int Identifiant
     */
    private $id;
    /**
     * @var string Libellé
     */
    private $label;

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
     * Get libellé
     *
     * @return  string
     */ 
    public function GetLabel()
    {
        return $this->label;
    }

    /**
     * Set libellé
     *
     * @param  string  $label  Libellé
     *
     * @return  self
     */ 
    public function SetLabel(string $label)
    {
        $this->label = $label;

        return $this;
    }
}