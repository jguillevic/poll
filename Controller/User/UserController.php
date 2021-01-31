<?php

namespace Controller\User;

use Model\User\User;
use Controller\User\LoginInfo;
use Contract\User\IUserDA;
use Contract\User\IUserSession;
use Contract\Render\IRenderer;
use Contract\Redirection\IRedirector;
use Contract\Request\IRequestInfoProvider;
use Helper\Route\RouteHelper;
use Resources\Message\User\UserMessage;

class UserController {
    /**
     * @var IUserDA
     */
    private $da;

    /**
     * @var IUserSession
     */
    private $session;

    /**
     * @var IRenderer En charge du rendu de la page
     */
    private $renderer;

    /**
     * @var IRedirector
     */
    private $redirector;

    /**
     * @var IRequestInfoProvider
     */
    private $rip;

    /**
     * @var RouteHelper
     */
    private $rh;

    const LoginMaxLength = 100;
    const EmailMaxLength = 100;
    const PasswordMaxLength = 100;

    /**
     * @param IUserDA $da Fournisseur de données pour les utilisateurs
     * @param IUserSession $session Gère la session pour l'utilisateur
     * @param IRenderer $renderer En charge du rendu de la page
     * @param IRedirector $redirector
     * @param IRequestInfoProvider $rip
     */
    function __construct(IUserDA $da, IUserSession $session, IRenderer $renderer, IRedirector $redirector, IRequestInfoProvider $rip) {
        $this->da = $da;
        $this->session = $session;
        $this->renderer = $renderer;
        $this->redirector = $redirector;
        $this->rip = $rip;
        $this->rh = new RouteHelper();
    }

    public function Login() : void {
        if ($this->session->IsLogin())
            $this->redirector->Redirect($this->rh->GetRoute("HomeDisplay"));

        if ($this->rip->IsGet()) {
            $loginInfo = new LoginInfo();
            $loginInfo->SetLogin("");
            $loginInfo->SetPassword("");
            $loginInfo->SetErrors([ "login" => [], "password" => [] ]);
        } else if ($this->rip->IsPost()) {
            $loginInfo = UserController::AttemptLogin($this->rip->GetSubmitData());

            if ($this->session->IsLogin())
                $this->redirector->Redirect($this->rh->GetRoute("HomeDisplay"));
        } else {
            $this->redirector->Redirect($this->rh->GetRoute("HomeDisplay"));
        }

        echo $this->renderer->Render(join(DIRECTORY_SEPARATOR,[ "User", "Login.twig" ])
        , [ 
            "login" => $loginInfo->GetLogin()
            , "password" => $loginInfo->GetPassword()
            , "errors" => $loginInfo->GetErrors()
            ]);
    }

    /**
     * Tentative de connexion.
     * 
     * @param array Infos réceptionnées.
     * @return LoginInfo Infos d'identification.
     */
    public function AttemptLogin(array $data) : LoginInfo {
        $loginInfo = new LoginInfo();

        $errors = [ "login" => [], "password" => [] ];

        $loginInfo->SetLogin(self::GetLogin($data));
        $loginInfo->SetPassword(self::GetPassword($data));
            
        if (empty($loginInfo->GetLogin())) {
            $errors["login"][] = UserMessage::$LoginEmpty;
        }
        if (empty($loginInfo->GetPassword())) {
            $errors["password"][] = UserMessage::$PasswordEmpty;
        }

        if (count($errors["login"]) == 0 && count($errors["password"]) == 0) {
            $isLoginExists = $this->da->IsLoginExists($loginInfo->GetLogin());
            if (!$isLoginExists) {
                $errors["login"][] = UserMessage::$LoginIncorrect;
            // Dans le cas où l'identifiant existe.
            } else {
                $hash = $this->da->GetHash($loginInfo->GetLogin());
                if (!password_verify($loginInfo->GetPassword(), $hash)) {
                    $errors["password"][] = UserMessage::$PasswordIncorrect;
                } else {
                    $user = $this->da->GetUser($loginInfo->GetLogin());
                    $this->session->Login($user);
                }
            }
        }

        $loginInfo->SetErrors($errors);

        return $loginInfo;
    }

    /**
     * Récupère la variable "login" dans $data.
     * Si la variable n'existe pas, "" est retourné.
     * 
     * @param array Infos réceptionnées.
     * @return string Identifiant de l'utilisateur.
     */
    public static function GetLogin(array $data) : string {
        if (!array_key_exists("login", $data)) {
            return "";
        } else {
            return $data["login"];
        }
    }

    /**
     * Récupère la variable "email" dans $data.
     * Si la variable n'existe pas, "" est retourné.
     * 
     * @param array Infos réceptionnées.
     * @return string Adresse électronique de l'utilisateur.
     */
    public static function GetEmail(array $data) : string {
        if (!array_key_exists("email", $data)) {
            return "";
        } else {
            return $data["email"];
        }
    }

    /**
     * Récupère la variable "password" dans $data.
     * Si la variable n'existe pas, "" est retourné.
     * 
     * @param array Infos réceptionnées.
     * @return string Mot de passe de l'utilisateur.
     */
    public static function GetPassword(array $data) : string {
        if (!array_key_exists("password", $data)) {
            return "";
        } else {
            return $data["password"];
        }
    }

    public function Logout() : void {
        if (!$this->session->IsLogin())
            $this->redirector->Redirect($this->rh->GetRoute("HomeDisplay"));

        $this->session->Logout();

        $this->redirector->Redirect($this->rh->GetRoute("HomeDisplay"));
    }

    public function Add() : void {
        if ($this->session->IsLogin())
            $this->redirector->Redirect($this->rh->GetRoute("HomeDisplay"));

        $errors = [ "login" => [], "email" => [], "password" => [], "technical" => [] ];

        if ($this->rip->IsGet()) {
            $login = "";
            $email = "";
            $password = "";
        } else if ($this->rip->IsPost()) {
            $data = $this->rip->GetSubmitData();
            $login = self::GetLogin($data);
            $email = self::GetEmail($data);
            $password = self::GetPassword($data);

            if (empty($login)) {
                $errors["login"][] = UserMessage::$LoginEmpty;
            } else if (strlen($login) > self::LoginMaxLength) {
                $errors["login"][] = sprintf(UserMessage::$LoginTooLong, self::LoginMaxLength);
            } else if ($this->da->IsLoginExists($login)) {
                $errors["login"][] = UserMessage::$LoginAlreadyUsed;
            }

            if (empty($email)) {
                $errors["email"][] = UserMessage::$EmailEmpty;
            } else if (strlen($email) > self::EmailMaxLength) {
                $errors["email"][] = sprintf(UserMessage::$EmailTooLong, self::EmailMaxLength);
            } else if ($this->da->IsEmailExists($email)) {
                $errors["email"][] = UserMessage::$EmailAlreadyUsed;
            }

            if (empty($password)) {
                $errors["password"][] = UserMessage::$PasswordEmpty;
            } else if (strlen($password) > self::PasswordMaxLength) {
                $errors["password"][] = sprintf(UserMessage::$PasswordTooLong, self::PasswordMaxLength);;
            }

            // S'il n'y a pas eu d'erreurs.
            if (count($errors["login"]) == 0 
                && count($errors["email"]) == 0 
                && count($errors["password"]) == 0) {

                $user = new User();
                $user->SetLogin($login);
                $user->SetEmail($email);
                $hash = password_hash($password, PASSWORD_DEFAULT);

                if ($this->da->AddUser($user, $hash)) {
                    $this->redirector->Redirect($this->rh->GetRoute("UserLogin"));
                } else {
                    $errors["technical"][] = UserMessage::$TechnicalErrorOnUserAdd;
                }
            }
        } else {
            $this->redirector->Redirect($this->rh->GetRoute("HomeDisplay"));
        }

        echo $this->renderer->Render(join(DIRECTORY_SEPARATOR,[ "User", "Add.twig" ])
        , [ 
            "login" => $login
            , "email" => $email
            , "password" => $password
            , "errors" => $errors
            ]);
    }
}