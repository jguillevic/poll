<?php

namespace Controller\Home;

use Contract\Render\IRenderer;

class HomeController {
    /**
     * @var Environment
     */
    private $twig;

    /**
     * @var IRenderer En charge du rendu de la page.
     */
    private $renderer;

    public function __construct(IRenderer $renderer) {
        $this->renderer = $renderer;
    }

    public function Display() : void {
        echo $this->renderer->Render(join(DIRECTORY_SEPARATOR,[ "Home", "Display.twig" ]));
    }
}