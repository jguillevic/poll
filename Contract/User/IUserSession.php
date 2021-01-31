<?php

namespace Contract\User;

use Model\User\User;

interface IUserSession {
    /**
     * 
     * 
     * @return bool
     */
    public function IsLogin() : bool;

    /**
     * 
     * @param User $user
     */
    public function Login(User $user) : void;

    /**
     * @return bool
     */
    public function Logout() : bool;

    /**
     * @return User
     */
    public function GetUser() : User;
}
