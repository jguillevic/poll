<?php

namespace Controller\Home;

use Contract\Render\IRenderer;
use Contract\Poll\IPollDA;
use Contract\Poll\PollFilter;

class HomeController {
    /**
     * @var IPollDA
     */
    private $pollDA;

    /**
     * @var IRenderer En charge du rendu de la page.
     */
    private $renderer;

    public function __construct(IPollDA $pollDA, IRenderer $renderer) {
        $this->pollDA = $pollDA;
        $this->renderer = $renderer;
    }

    public function Display() : void {
        $filter = new PollFilter();
        $filter->SetCreationDateSort("DESC");
        $recentPolls = $this->pollDA->Get($filter);

        $filter = new PollFilter();
        $filter->SetCreationDateSort("ASC");
        $filter->SetOnGoing(true);
        $nearEndPolls = $this->pollDA->Get($filter);

        echo $this->renderer->Render(join(DIRECTORY_SEPARATOR,[ "Home", "Display.twig" ]), [ "recentPolls" => $recentPolls, "nearEndPolls" => $nearEndPolls ]);
    }
}