<?php

use App\Core\View\Renderable;
use App\Core\View\TwigRender;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use function DI\autowire;

return [
    Environment::class => static function () {
        $config = [];

        if (env('APP_DEBUG', false) == 'false') {
            $config['cache'] = __DIR__ . '/../.cache/templates';
        }

        return new Environment(new FilesystemLoader(__DIR__ . '/../resources/views'), $config);
    },
    Renderable::class => autowire(TwigRender::class),
];