<?php

namespace Contract\Poll;

interface IPollDA {
    /**
     * 
     * 
     * @param array $polls Sondages à ajouter
     * @return bool true si succès, false sinon
     */
    public function Add(array $polls) : bool;
}