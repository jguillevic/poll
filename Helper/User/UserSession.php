<?php

namespace Helper\User;

use Contract\User\IUserSession;
use Model\User\User;

class UserSession implements IUserSession {
    public function IsLogin() : bool {
        return array_key_exists("user_id", $_SESSION);
    }

    public function Login(User $user) : void {
        $_SESSION["user_id"] = $user->GetId();
        $_SESSION["user_login"] = $user->GetLogin();
    }

    public function Logout() : bool {
        return session_destroy();
    }

    public function GetUser() : User {
        $user = new User();
        $user->SetId($_SESSION["user_id"]);
        $user->SetLogin($_SESSION["user_login"]);
        return $user;
    }
}