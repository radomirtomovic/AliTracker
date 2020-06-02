<?php


namespace App\Exceptions;


use Exception;
use Throwable;

class MethodNotAllowedException extends Exception
{
    public function __construct($message = 'Http method is not allowed', $code = 405, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}