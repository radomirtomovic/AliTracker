<?php


namespace App\Core\View;


interface Renderable
{
    public function render(string $view, array $data = []): string;
}