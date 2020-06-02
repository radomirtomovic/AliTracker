<?php


namespace App\Core\Routing;


use App\Core\View\Renderable;
use App\Core\View\View;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

class ResponseHandler
{
    /**
     * @var string|array|object|bool|float|int
     */
    private $response;
    /**
     * @var ContainerInterface
     */
    private ContainerInterface $container;

    /**
     * ResponseHandler constructor.
     * @param $response
     * @param ContainerInterface $container
     */
    public function __construct($response, ContainerInterface $container)
    {
        $this->response = $response;
        $this->container = $container;
    }

    /**
     * @return Response
     * @throws \JsonException
     */
    public function handle():Response
    {
        if($this->response instanceof Response)
        {
            return $this->response;
        }


        $status = 200;
        $headers = [];
        $response = '';

        if($this->response === null) {
            $status = Response::HTTP_NO_CONTENT;
        }

        if(is_array($this->response) || is_object($this->response)) {
            $response = json_encode($this->response, JSON_THROW_ON_ERROR, 512);
        }

        if(is_string($this->response)) {
            $response = $this->response;
        }

        if($this->response instanceof View) {
            $this->response->setRenderable($this->container->get(Renderable::class));
            $response = $this->response->getContent();
        }

        return new Response($response, $status, $headers);
    }

}