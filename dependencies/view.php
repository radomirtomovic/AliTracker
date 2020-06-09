<?php

use App\Core\Config\Config;
use App\Core\Http\Session;
use App\Core\View\Renderable;
use App\Core\View\TwigRender;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use function DI\autowire;

return [
    Environment::class => static function (ContainerInterface $container) {
        $config = [];

        if (env('APP_DEBUG', false) == 'false') {
            $config['cache'] = __DIR__ . '/../.cache/templates';
        }

        $env = new Environment(new FilesystemLoader(__DIR__ . '/../resources/views'), $config);


        $session = $container->get(Session::class);

        $env->addGlobal('session', $session);
        $env->addGlobal('container', $container);
        $env->addGlobal('request', $container->get(Request::class));
        $env->addGlobal('config', $container->get(Config::class));
        $env->addGlobal('user', $session->get('user'));
        $env->addGlobal('isLoggedIn', $session->get('isLoggedIn'));

        return $env;
    },
    Renderable::class => autowire(TwigRender::class),
];