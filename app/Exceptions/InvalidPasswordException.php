<?php


namespace App\Exceptions;


use Throwable;

class InvalidPasswordException extends \Exception
{
    public function __construct($message = "Invalid password", $code = 401, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}