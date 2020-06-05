<?php


namespace App\Core\Error;


use App\Exceptions\MethodNotAllowedException;
use App\Exceptions\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler
{
    /**
     * @var Request
     */
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function handle(Throwable $e)
    {
        if($e instanceof MethodNotAllowedException) {
            if (strtolower($this->request->headers->get('Accept')) === 'application/json') {
                return new JsonResponse([
                    'message' => $e->getMessage(),
                ], Response::HTTP_METHOD_NOT_ALLOWED);
            }

            return new Response($e->getMessage(), Response::HTTP_METHOD_NOT_ALLOWED);
        }

        if ($e instanceof ValidationException) {
            if (strtolower($this->request->headers->get('Accept')) === 'application/json') {
                return new JsonResponse([
                    'message' => $e->getMessage(),
                    'errors' => $e->getErrors(),
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            return new Response($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        return new Response($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}