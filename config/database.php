<?php
return [
    'default' => 'mysql',
    'connections' => [
        'mysql' => [
            'driver'    => 'mysql',
            'host'      => env('DATABASE_HOST', 'localhost'),
            'database'  => env('DATABASE_NAME', 'alitracker'),
            'username'  => env('DATABASE_USER', 'root'),
            'password'  => env('DATABASE_PASSWORD', ''),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]
    ],
];