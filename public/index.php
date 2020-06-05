<?php

use App\Core\Kernel;
use App\Initializer;

require_once __DIR__ . '/../helper.php';
require_once __DIR__ . '/../vendor/autoload.php';


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

(new Kernel(__DIR__ . '/../dependencies', Initializer::class))
    ->handle()
    ->send();





