<?php

namespace Controller\User;

class LoginInfo {
    /**
     * @var string Identifiant de l'utilisateur.
     */
    private $login;
    /**
     * @var string Mot de passe de l'utilisateur.
     */
    private $password;
    /**
     * @var array Tableaux des erreurs rencontrées au cours du processus d'authentification.
     */
    private $errors;

    /**
     * Get identifiant de l'utilisateur.
     *
     * @return  string
     */ 
    public function GetLogin()
    {
        return $this->login;
    }

    /**
     * Set identifiant de l'utilisateur.
     *
     * @param  string  $login  Identifiant de l'utilisateur.
     *
     * @return  self
     */ 
    public function SetLogin(string $login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get mot de passe de l'utilisateur.
     *
     * @return  string
     */ 
    public function GetPassword()
    {
        return $this->password;
    }

    /**
     * Set mot de passe de l'utilisateur.
     *
     * @param  string  $password  Mot de passe de l'utilisateur.
     *
     * @return  self
     */ 
    public function SetPassword(string $password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get tableaux des erreurs rencontrées au cours du processus d'authentification.
     *
     * @return  array
     */ 
    public function GetErrors()
    {
        return $this->errors;
    }

    /**
     * Set tableaux des erreurs rencontrées au cours du processus d'authentification.
     *
     * @param  array  $errors  Tableaux des erreurs rencontrées au cours du processus d'authentification.
     *
     * @return  self
     */ 
    public function SetErrors(array $errors)
    {
        $this->errors = $errors;

        return $this;
    }
}