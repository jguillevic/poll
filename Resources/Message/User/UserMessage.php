<?php

namespace Resources\Message\User;

class UserMessage {
    /**
     * @var string
    */
    public static $LoginEmpty = "La saisie de l'identifiant est obligatoire.";
    /**
     * @var string
     */
    public static $EmailEmpty = "La saisie de l'adresse électronique est obligatoire.";
    /**
     * @var string
     */
    public static $PasswordEmpty = "La saisie du mot de passe est obligatoire.";
    /**
     * @var string
     */
    public static $LoginIncorrect = "L'identifiant n'existe pas.";
    /**
     * @var string
     */
    public static $PasswordIncorrect = "Le mot de passe est incorrect.";
    /**
     * @var string
     */
    public static $LoginAlreadyUsed = "L'identifiant est déjà utilisé. Veuillez en saisir un autre.";
    /**
     * @var string
     */
    public static $EmailAlreadyUsed = "L'adresse électronique est déjà utilisée. Veuillez en saisir une autre.";
    /**
     * @var string
     */
    public static $LoginTooLong = "L'identifiant est trop long (%d caractères max).";
    /**
     * @var string
     */
    public static $EmailTooLong = "L'adresse électronique est trop longue (%d caractères max).";
    /**
     * @var string
     */
    public static $PasswordTooLong = "Le mot de passe est trop long (%d caractères max).";
        /**
     * @var string
     */
    public static $TechnicalErrorOnUserAdd = "Erreur technique au cours de l'ajout de l'utilisateur.";
}