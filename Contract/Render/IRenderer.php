<?php

namespace Contract\Render;

interface IRenderer {
    public function Render(string $fileName, array $args = []) : string;
}