<?php


namespace App\Core\Config;


interface Loader
{
    public function load(): array;
}