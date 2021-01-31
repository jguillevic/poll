<?php

namespace Contract\User;

use Model\User\User;

interface IUserDA {
    /**
     * Est-ce que l'identifiant est présent parmi la liste des identifiants existants.
     * 
     * @param string $login Identifiant dont l'existance est à vérifier
     * @return bool true s'il existe false sinon
     */
    public function IsLoginExists(string $login) : bool;

    /**
     * Est-ce que l'adresse électronique est déjà utilisée.
     * 
     * @param string $email Adresse électronique dont l'existance est à vérifier
     * @return bool true si elle existe false sinon
     */
    public function IsEmailExists(string $email) : bool;

    /**
     * Retourne le mot de passe hashé associé à l'identifiant en paramètre.
     * 
     * @param string $login Identifiant de l'utilisateur
     * @return string Mot de passe hashé associé
     */
    public function GetHash(string $login) : string;

    /**
     * Retourne l'utilisateur associé au mot de passe en paramètre.
     * 
     * @param string $login Identifiant de l'utilisateur
     * @return User Utilisateur associé
     */
    public function GetUser(string $login) : User;

    /**
     * Ajoute l'utilisateur.
     * 
     * @param User $user Informations sur l'utilisateur sauf le mot de passe
     * @param string $hash Mot de passe hashé
     * @return bool true si l'ajout est un succès, false sinon
     */
    public function AddUser(User $user, string $hash) : bool;
}