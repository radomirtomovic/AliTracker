<?php


use App\Http\Controllers\HomeController;
use \App\Http\Controllers\RegisterController;
use \App\Http\Controllers\LogInController;

return [
    'get' => [
        '/' => ['controller' => HomeController::class, 'action' => 'show'],
        '/blog' => ['controller' => HomeController::class, 'action' => 'show'],
        '/register' => ['controller' => RegisterController::class, 'action' => 'show'],
        '/login' => ['controller' => LogInController::class, 'action' => 'show'],
    ],
    'post' => [
        '/register' => ['controller' => RegisterController::class, 'action' => 'register'],
        '/login' => ['controller' => LogInController::class, 'action' => 'login'],
    ],
    'put' => [],
    'delete' => [],
];
