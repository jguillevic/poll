<?php

namespace Helper\Redirection;

use Contract\Redirection\IRedirector;

class Redirector implements IRedirector {
    public function Redirect(string $path) : void {
        header("Location: " . $path, true, 302);
        exit();
    }
}