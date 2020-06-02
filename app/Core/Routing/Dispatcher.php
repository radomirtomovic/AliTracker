<?php


namespace App\Core\Routing;


use App\Exceptions\InvalidRouteException;
use App\Exceptions\MethodNotAllowedException;
use App\Exceptions\RouteNotFoundException;

class Dispatcher
{
    /**
     * @var array
     */
    private array $routes;


    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    /**
     * @param string $method
     * @param string $path
     * @return mixed
     * @throws InvalidRouteException
     * @throws MethodNotAllowedException
     * @throws RouteNotFoundException
     */
    public function match(string $method, string $path)
    {
        $method = strtolower($method);
        if(!isset($this->routes[$method])) {
            throw new MethodNotAllowedException();
        }

        $routes = $this->routes[$method];



        foreach ($routes as $regex => $values) {
            $status = preg_match("~^{$regex}/?$~", $path, $parameters);

            if ($status === -1) {
                throw new InvalidRouteException();
            }

            if ($status) {
                array_shift($parameters);
                return [
                    'parameters' => $parameters,
                    '_route' => $values
                ];
            }
        }
        throw new RouteNotFoundException();
    }

}
