<?php


namespace App\Exceptions;


use Exception;
use Throwable;

class InvalidRouteException extends Exception
{
    public function __construct($message = "Invalid route", $code = 400, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}