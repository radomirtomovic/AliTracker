<?php
ini_set('display_errors', true);
session_start();

use App\Core\Kernel;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$response = (new Kernel(__DIR__ . '/../dependencies'))
    ->handle();

$response->send();
