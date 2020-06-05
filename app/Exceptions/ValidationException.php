<?php


namespace App\Exceptions;


use Exception;
use Throwable;

class ValidationException extends Exception
{
    private array $errors;

    public function __construct(array $errors = [], $message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->errors = $errors;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}