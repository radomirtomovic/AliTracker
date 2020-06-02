<?php


use App\Http\Controllers\HomeController;
use \App\Http\Controllers\RegisterController;

return [
    'get' => [
        '/' => ['controller' => HomeController::class, 'action' => 'show'],
        '/blog' => ['controller' => HomeController::class, 'action' => 'show'],
        '/register' => ['controller' => RegisterController::class, 'action' => 'show']
    ],
    'post' => [],
    'put' => [],
    'delete' => [],
];
