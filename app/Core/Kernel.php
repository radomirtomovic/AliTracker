<?php


namespace App\Core;


use App\Core\Config\Config;
use App\Core\Routing\Dispatcher;
use App\Core\Error\Handler;
use App\Core\Routing\ResponseHandler;
use App\Http\Controllers\Controller;
use DI\ContainerBuilder;
use Exception;
use Psr\Container\ContainerInterface;
use ReflectionMethod;
use RuntimeException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\Capsule\Manager as Capsule;

use Throwable;

class Kernel
{
    /**
     * @var array
     */
    private array $config;

    /**
     * @var ContainerInterface|null
     */
    private ?ContainerInterface $container = null;

    public function __construct($dependencies)
    {
        $this->config = $this->loadDependencies($dependencies);
    }

    /**
     * @param Request $request
     * @return ContainerInterface
     * @throws Exception
     */
    public function buildContainer(Request $request): ContainerInterface
    {
        if ($this->container !== null) {
            return $this->container;
        }

        $builder = new ContainerBuilder();
        $builder->addDefinitions(array_merge([Request::class => $request], $this->config));
        $builder->useAutowiring(true);

        $this->container = $builder->build();


        $capsule = new Capsule;
        $config = $this->container->get(Config::class);
        $connection = $config->get('database.connections.' . $config->get('database.default'));
        $capsule->addConnection($connection);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
        return $this->container;
    }

    public function handle(): Response
    {
        $request = Request::createFromGlobals();

        $dispatcher = new Dispatcher($this->combineRoutes());

        try {
            ['_route' => $route, 'parameters' => $parameters] = $dispatcher->match($request->getMethod(), $request->getPathInfo());


            $container = $this->buildContainer($request);
            // Create new instance of Controller
            /** @var Controller $instance */
            $instance = $container->get($route['controller']);
            $reflex = new ReflectionMethod($instance, $route['action']);
            $response = $reflex->invokeArgs($instance, $parameters);
            $responseHandler = new ResponseHandler($response, $container);
            return $responseHandler->handle();
        } catch (Throwable $e) {
            return (new Handler($request))->handle($e);
        }
    }


    private function combineRoutes(): array
    {
        $files = scandir(__DIR__ . '/../../routes');

        $routes = [];

        foreach ($files as $file) {
            if (!preg_match('#\.php$#', $file)) {
                continue;
            }

            $r = require __DIR__ . '/../../routes/' . $file;
            $arrayKeys = array_keys($r);
            foreach ($arrayKeys as $key) {
                if (!isset($routes[$key])) {
                    $routes[$key] = [];
                }
                $routes[$key] = array_merge($routes[$key], $r[$key]);
            }
        }

        return $routes;
    }

    private function loadDependencies($dependencies): array
    {
        if (is_string($dependencies) && file_exists($dependencies)) {
            if (is_file($dependencies)) {
                return require $dependencies;
            }

            if (is_dir($dependencies)) {
                $deps = [];
                $files = scandir($dependencies);

                foreach ($files as $file) {
                    if (!preg_match('#\.php$#', $file)) {
                        continue;
                    }
                    $dep = require $dependencies . DIRECTORY_SEPARATOR . $file;

                    $deps = array_merge($deps, $dep);
                }
                return $deps;
            }
        }

        if (is_array($dependencies)) {
            return $dependencies;
        }

        throw new RuntimeException('Config must be array or string');
    }
}