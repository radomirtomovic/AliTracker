<?php


namespace App\Core\Error;


use App\Exceptions\MethodNotAllowedException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler
{
    public function __construct($request)
    {
    }

    public function handle(Throwable $e)
    {

//        if($e instanceof MethodNotAllowedException) {
//
//        }
        return new Response($e->getMessage(), $e->getCode() === 0 ? 500 : $e->getCode());
    }
}