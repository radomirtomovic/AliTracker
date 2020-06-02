<?php

namespace App\Core\View;

use RuntimeException;

class View
{
    private string $view;
    private array $data;
    private ?Renderable $renderable = null;

    public function __construct(string $view, array $data)
    {
        $this->view = $view;
        $this->data = $data;
    }

    public function setRenderable(Renderable $renderable) {
        $this->renderable = $renderable;
    }

    public function getContent()
    {
        if(!$this->renderable) {
            throw new RuntimeException('Renderable is not defined');
        }
        return $this->renderable->render($this->view, $this->data);
    }

}