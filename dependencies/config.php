<?php

use App\Core\Config\Config;
use App\Core\Config\Configuration;
use App\Core\Config\DirectoryLoader;
use App\Core\Config\Loader;
use function DI\autowire;

return [
    Loader::class => fn() => new DirectoryLoader(__DIR__ . '/../config'),
    Config::class => autowire(Configuration::class),
];
