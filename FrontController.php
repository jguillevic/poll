<?php

use Controller\Home\HomeController;
use Controller\Poll\PollController;
use Controller\User\UserController;
use Controller\Error\ErrorController;
use DAL\User\UserDA;
use DAL\Poll\PollDA;
use Helper\User\UserSession;
use Helper\Route\RouteHelper;
use Helper\Render\Renderer;
use Helper\Redirection\Redirector;
use Helper\Request\RequestInfoProvider;

class FrontController {

    public function Run() : void {
        $request_uri = strtolower("/" . trim(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH), "/"));

        $routeHelper = new RouteHelper();

        switch ($request_uri) {
            case $routeHelper->GetRoute("HomeDisplay"):
                $controller = new HomeController(new PollDA(), new Renderer());
                $controller->Display();
                break;
            case $routeHelper->GetRoute("UserLogin"):
                $controller = new UserController(new UserDA(), new UserSession(), new Renderer(), new Redirector(), new RequestInfoProvider());
                $controller->Login();
                break;
            case $routeHelper->GetRoute("UserLogout"):
                $controller = new UserController(new UserDA(), new UserSession(), new Renderer(), new Redirector(), new RequestInfoProvider());
                $controller->Logout();
                break;
            case $routeHelper->GetRoute("UserAdd"):
                $controller = new UserController(new UserDA(), new UserSession(), new Renderer(), new Redirector(), new RequestInfoProvider());
                $controller->Add();
                break;
            case $routeHelper->GetRoute("PollAdd"):
                $controller = new PollController(new PollDA(), new UserSession(), new Renderer(), new Redirector(), new RequestInfoProvider());
                $controller->Add();
                break;
            default:
                $controller = new ErrorController(new Renderer());
                $controller->Display404Error();
                break;
        }
    }
}