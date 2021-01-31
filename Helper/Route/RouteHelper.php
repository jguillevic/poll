<?php

namespace Helper\Route;

class RouteHelper {
    /**
     * @var array Routes.
     */
    private $routes;

    public function __construct() {
        $this->routes = [];
        $this->routes["PollAdd"] = "/poll/add";
        $this->routes["UserLogin"] = "/user/login";
        $this->routes["UserLogout"] = "/user/logout";
        $this->routes["UserAdd"] = "/user/add";
        $this->routes["HomeDisplay"] = "/";
    }

    public function GetRoute(string $code) : string {
        if (array_key_exists($code, $this->routes))
            return $this->routes[$code];
        else
            return "/";
    }
}