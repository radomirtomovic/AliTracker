<?php


namespace App\Core\Http;


interface Session
{
    public function get(string $key, $default = null);
    public function set(string $key, $value);
    public function regenerate();

}