<?php

namespace App\Core\Config;


interface Config
{
    public function get(string $key);
}