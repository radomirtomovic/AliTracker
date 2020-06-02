<?php


namespace App\Exceptions;


use Throwable;

class RouteNotFoundException extends \Exception
{
    public function __construct($message = "Page not fount", $code = 404, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}