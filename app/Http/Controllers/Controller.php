<?php


namespace App\Http\Controllers;


use App\Core\View\View;
use Symfony\Component\HttpFoundation\Response;

abstract class Controller
{
    protected function response($data = '', int $statusCode = Response::HTTP_OK, array $headers = [])
    {
        if(!isset($headers['Content-Type'])) {
            $headers['Content-Type'] = 'application/json';
        }

        if(strtolower($headers['Content-Type']) === 'application/json') {
            $data = json_encode($data, JSON_THROW_ON_ERROR, 512);
        }
        return new Response($data, $statusCode, $headers);
    }


    protected function created($data = '', array $headers = [])
    {
        return $this->response($data, Response::HTTP_CREATED, $headers);
    }

    protected function ok($data = '', array $headers = [])
    {
        return $this->response($data, Response::HTTP_OK, $headers);
    }

    protected function noContent(array $headers)
    {
        return $this->response('', Response::HTTP_NO_CONTENT, $headers);
    }

    protected function view(string $view, array $data = [], int $statusCode = Response::HTTP_OK, array $headers = [])
    {
        return new View($view, $data);
//        $headers['Content-Type'] = 'text/html';
//
//        $view = new View($view);
//
//        return $this->response($view->getContent($data), $statusCode, $headers);
    }
}