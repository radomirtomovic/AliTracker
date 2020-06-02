<?php

namespace App\Core\View;

use RuntimeException;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class View
{
    private string $view;
    private array $data;
    private ?Renderable $renderable = null;
//    private static ?Environment $twigEnv = null;
//
//    public const DIR = __DIR__ . '/../../../views';
//    public const CACHE = __DIR__ . '/../../../.cache';

    public function __construct(string $view, array $data)
    {
//        if (!static::$twigEnv) {
//            $twigLoaded = new FilesystemLoader(static::DIR);
//            static::$twigEnv = new Environment($twigLoaded, [
//                'cache' => static::CACHE
//            ]);
//        }
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