<?php


use App\Http\Controllers\HomeController;

return [
    'get' => [
        '/' => ['controller' => HomeController::class, 'action' => 'hello'],
        '/blog' => ['controller' => HomeController::class, 'action' => 'hello'],
    ],
    'post' => [],
    'put' => [],
    'delete' => [],
];
