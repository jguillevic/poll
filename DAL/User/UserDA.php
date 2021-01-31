<?php

namespace DAL\User;

use Model\User\User;
use Contract\User\IUserDA;
use DAL\Tools\DBConnection;

class UserDA implements IUserDA {
    /**
     * @var DBConnection
     */
    private $connect;

    public function __construct(DBConnection $connect = null) {
        if ($connect == null) {
            $this->connect = new DBConnection();
        } else {
            $this->connect = $connect;
        }
    }

    public function IsLoginExists(string $login) : bool {
        $query = "SELECT COUNT(1) AS count FROM users WHERE login = :login;";

        $result = true;

        try {
            if ($this->connect->BeginTransac()) {
                $count = $this->connect->FetchAll(
                    $query
                    , [ ":login" => $login ]
                )[0]["count"];

                if ($count > 0) {
                    $result = true;
                } else {
                    $result = false;
                }

                $this->connect->CommitTransac();
            }
        } catch (Exception $e) {
            $this->connect->RollBackTransac();
        }

        return $result;
    }

    /**
     * Est-ce que l'adresse électronique est déjà utilisée.
     * 
     * @param string $email Adresse électronique dont l'existance est à vérifier
     * @return bool true si elle existe false sinon
     */
    public function IsEmailExists(string $email) : bool {
        $query = "SELECT COUNT(1) AS count FROM users WHERE email = :email;";

        $result = true;

        try {
            if ($this->connect->BeginTransac()) {
                $count = $this->connect->FetchAll(
                    $query
                    , [ ":email" => $email ]
                )[0]["count"];

                if ($count > 0) {
                    $result = true;
                } else {
                    $result = false;
                }

                $this->connect->CommitTransac();
            }
        } catch (Exception $e) {
            $this->connect->RollBackTransac();
        }

        return $result;
    }

    public function GetHash(string $login) : string {
        $query = "SELECT hash FROM users WHERE login = :login;";

        $hash = "";

        try {
            if ($this->connect->BeginTransac()) {
                $hash = $this->connect->FetchAll($query, [ ":login" => $login ])[0]["hash"];

                $this->connect->CommitTransac();
            }
        } catch (Exception $e) {
            $this->connect->RollBackTransac();
        }

        return $hash;
    }

    /**
     * Retourne l'utilisateur associé au mot de passe en paramètre.
     * 
     * @param string $login Identifiant de l'utilisateur
     * @return User Utilisateur associé
     */
    public function GetUser(string $login) : User {
        $query = "SELECT id, login, email FROM users WHERE login = :login;";

        $user = new User();

        try {
            if ($this->connect->BeginTransac()) {
                $result = $this->connect->FetchAll($query, [ ":login" => $login ]);

                $this->connect->CommitTransac();

                if (count($result) > 0) {
                    $user->SetId($result[0]["id"]);
                    $user->SetLogin($result[0]["login"]);
                    $user->SetLogin($result[0]["email"]);
                }
            }
        } catch (Exception $e) {
            $this->connect->RollBackTransac();
        }

        return $user;
    }

    /**
     * Ajoute l'utilisateur.
     * 
     * @param User $user Informations sur l'utilisateur sauf le mot de passe
     * @param string $hash Mot de passe hashé
     * @return bool true si l'ajout est un succès, false sinon
     */
    public function AddUser(User $user, string $hash) : bool {
        $query = "INSERT INTO users (login, email, hash) VALUES (:login, :email, :hash);";

        $result = false;

        try {
            if ($this->connect->BeginTransac()) {
                $result = $this->connect->Execute(
                    $query
                    , [ 
                        ":login" => $user->GetLogin() 
                        , ":email" => $user->GetEmail()
                        , ":hash" => $hash
                    ]);

                if ($result)
                    $this->connect->CommitTransac();
            }
        } catch (Exception $e) {
            $this->connect->RollBackTransac();
        }

        return $result;
    }
}