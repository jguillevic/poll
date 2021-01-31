<?php

namespace Contract\User\Test;

use Contract\User\IUserSession;

class IUserSessionMock implements IUserSession {
    /**
     * @var bool
     */
    private $isLogin;

    public function __construct() {
        $this->isLogin = false;
    }

    public function IsLogin() : bool {
        return $this->isLogin;
    }

    public function Login(string $login) : void {
        $this->isLogin = true;
    }
}