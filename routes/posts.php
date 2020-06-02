<?php
return [
    'get' => [
        'posts' => ['controller' => 'HomeController', 'action' => 'index'],
        'posts\/\d+' => ['controller' => 'HomeController', 'action' => 'get'],
    ],
    'post' => [
        'objava' => ['controller' => 'HomeController', 'action' => 'create']
    ],
    'delete' => [],
];
