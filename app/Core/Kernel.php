<?php


namespace App\Core;


use App\Core\Config\Config;
use App\Core\Http\Session;
use App\Core\Http\DefaultSession;
use App\Core\Http\SessionStarter;
use App\Core\Routing\Dispatcher;
use App\Core\Error\Handler;
use App\Core\Routing\ResponseHandler;
use App\Http\Controllers\Controller;
use DI\ContainerBuilder;
use Exception;
use Illuminate\Database\DatabaseManager;
use Psr\Container\ContainerInterface;
use ReflectionMethod;
use RuntimeException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\Capsule\Manager as Capsule;

use Throwable;
use function DI\autowire;

class Kernel
{
    /**
     * @var array
     */
    private array $config;

    private ?string $init;

    /**
     * @var ContainerInterface|null
     */
    private ?ContainerInterface $container = null;

    public function __construct($dependencies, ?string $init = null)
    {
        $this->config = $this->loadDependencies($dependencies);
        $this->init = $init;
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
        $builder->addDefinitions(array_merge($this->coreDependencies($request), $this->config));
        $builder->useAutowiring(true);

        $this->container = $builder->build();

        $capsule = new Capsule;
        $config = $this->container->get(Config::class);
        $connection = $config->get('database.connections.' . $config->get('database.default'));
        $capsule->addConnection($connection);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
        $this->container->set(DatabaseManager::class, $capsule->getDatabaseManager());
        return $this->container;
    }


    public function handle(): Response
    {
        $request = $this->checkJson(Request::createFromGlobals());

        $dispatcher = new Dispatcher($this->combineRoutes());

        try {
            ['_route' => $route, 'parameters' => $parameters] = $dispatcher->match($request->getMethod(), $request->getPathInfo());


            $container = $this->buildContainer($request);

            if ($this->init !== null && class_exists($this->init)) {
                $initClassInstance = $container->get($this->init);

                if (!$initClassInstance instanceof Init) {
                    throw new RuntimeException('class is not instance of Init interface');
                }

                $initClassInstance->init();
            }

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

    private function coreDependencies(Request $request): array
    {
        return [
            Request::class => $request,
            SessionStarter::class => autowire(DefaultSession::class),
            Session::class => autowire(DefaultSession::class),
        ];
    }

    /**
     * @param Request $request
     * @return Request
     * @throws \JsonException
     */
    private function checkJson(Request $request): Request
    {
        if (strpos($request->headers->get('Content-Type'), 'application/json') === 0) {
            $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
            foreach ($data as $key => $value) {
                $request->request->set($key, $value);
            }
        }

        return $request;
    }
}