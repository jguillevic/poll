<?php

namespace Helper\Render;

use Contract\Render\IRenderer;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Twig\TwigFunction;
use Helper\Route\RouteHelper;
use Helper\User\UserSession;

class Renderer implements IRenderer {
    /**
     * @var FilesystemLoader
     */
    private $loader;

    public function __construct() {
        $this->loader = new FilesystemLoader(join(DIRECTORY_SEPARATOR,[ __DIR__, '..', '..', 'Template' ]));
    }

    public function Render(string $fileName, array $args = []) : string {
        $twig = new Environment($this->loader);
        $function = new TwigFunction('GetRoute', function (string $code) 
        { 
            $routeHelper = new RouteHelper();
            return $routeHelper->GetRoute($code);
        });
        $twig->addFunction($function);
        $function = new TwigFunction('IsLogin', function () 
        { 
            $userSession = new UserSession();
            return $userSession->IsLogin();
        });
        $twig->addFunction($function);
        return $twig->render($fileName, $args);
    }
}