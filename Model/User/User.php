<?php

namespace Model\User;

/**
 * Contient les données de l'utilisateur.
 */
class User {
    /**
     * @var int Identifiant de l'utilisateur.
     */
    private $id;

    /**
     * @var string Login de l'utilisateur.
     */
    private $login;

    /**
     * @var string Adresse électronique de l'utilisateur.
     */
    private $email;

    /**
     * Get identifiant de l'utilisateur.
     *
     * @return  int
     */ 
    public function GetId() : int
    {
        return $this->id;
    }

    /**
     * Set identifiant de l'utilisateur.
     *
     * @param  int  $id  Identifiant de l'utilisateur.
     *
     * @return  self
     */ 
    public function SetId(int $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get login de l'utilisateur.
     *
     * @return  string
     */ 
    public function GetLogin() : string
    {
        return $this->login;
    }

    /**
     * Set login de l'utilisateur.
     *
     * @param  string  $login  Login de l'utilisateur.
     *
     * @return  self
     */ 
    public function SetLogin(string $login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get adresse électronique de l'utilisateur.
     *
     * @return  string
     */ 
    public function GetEmail()
    {
        return $this->email;
    }

    /**
     * Set adresse électronique de l'utilisateur.
     *
     * @param  string  $email  Adresse électronique de l'utilisateur.
     *
     * @return  self
     */ 
    public function SetEmail(string $email)
    {
        $this->email = $email;

        return $this;
    }
}