<?php


use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;

return [
    'get' => [
        '/' => ['controller' => HomeController::class, 'action' => 'show'],
        '/blog' => ['controller' => HomeController::class, 'action' => 'show'],
        '/register' => ['controller' => AuthController::class, 'action' => 'show'],
        '/login' => ['controller' => AuthController::class, 'action' => 'show'],
    ],
    'post' => [
        '/register' => ['controller' => AuthController::class, 'action' => 'register'],
        '/login' => ['controller' => AuthController::class, 'action' => 'login'],
        '/logout' => ['controller' => AuthController::class, 'action' => 'logout'],
    ],
    'put' => [],
    'delete' => [],
];
