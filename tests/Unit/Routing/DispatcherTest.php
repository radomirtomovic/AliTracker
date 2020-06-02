<?php


namespace App\Tests\Routing;


use App\Core\Routing\Dispatcher;
use App\Exceptions\InvalidRouteException;
use App\Exceptions\MethodNotAllowedException;
use App\Exceptions\RouteNotFoundException;
use App\Tests\TestCase;

class DispatcherTest extends TestCase
{
    public function test_match_output()
    {
        $dispatcher = new Dispatcher([
            'get' => [
                '/' => ['controller' => 'HomeController', 'action' => 'test']
            ]
        ]);

        $output = $dispatcher->match('get', '/');


        $this->assertIsArray($output);

    }

    public function test_match_finds_route()
    {
        $dispatcher = new Dispatcher([
            'get' => [
                '/' => ['controller' => 'HomeController', 'action' => 'test']
            ]
        ]);

        $output = $dispatcher->match('get', '/');

        $this->assertArrayHasKey('parameters', $output);
        $this->assertArrayHasKey('_route', $output);
        $this->assertIsArray($output['parameters']);
        $this->assertEmpty($output['parameters']);

        $this->assertIsArray($output['_route']);
        $this->assertCount(2, $output['_route']);
        $this->assertArrayHasKey('controller', $output['_route']);
        $this->assertArrayHasKey('action', $output['_route']);
        $this->assertSame('HomeController', $output['_route']['controller']);
        $this->assertSame('test', $output['_route']['action']);
    }

    public function test_route_not_found()
    {
        $this->expectException(RouteNotFoundException::class);
        $dispatcher = new Dispatcher([
            'get' => [
                '/' => ['controller' => 'HomeController', 'action' => 'test']
            ]
        ]);

        $dispatcher->match('get', '/not-found');
    }

    public function test_method_not_allowed()
    {
        $this->expectException(MethodNotAllowedException::class);

        $dispatcher = new Dispatcher([
            'get' => [
                '/' => ['controller' => 'HomeController', 'action' => 'test']
            ]
        ]);

        $dispatcher->match('post', '/not-found');
    }

}