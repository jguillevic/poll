<?php

namespace Contract\Redirection;

interface IRedirector {
    public function Redirect(string $path) : void;
}