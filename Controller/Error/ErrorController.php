<?php

namespace Controller\Error;

use Contract\Render\IRenderer;

class ErrorController {
    /**
     * @var IRenderer En charge du rendu de la page.
     */
    private $renderer;

    public function __construct(IRenderer $renderer) {
        $this->renderer = $renderer;
    }
    
    public function Display404Error() : void {
        header('HTTP/1.0 404 Not Found');
        echo $this->renderer->Render(join(DIRECTORY_SEPARATOR,[ "Error", "Display404Error.twig" ]));
    }
}