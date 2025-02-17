<?php

declare(strict_types=1);

namespace LaravelHyperf\Tests\Router;

use LaravelHyperf\Router\RouteFileCollector;
use LaravelHyperf\Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class RouteFileCollectorTest extends TestCase
{
    public function testSetRouteFiles()
    {
        $collector = new RouteFileCollector($routes = ['a-route']);

        $this->assertSame($routes, $collector->getRouteFiles());

        $collector->setRouteFiles($routes = ['b-route']);

        $this->assertSame($routes, $collector->getRouteFiles());
    }

    public function testAddRouteFiles()
    {
        $collector = new RouteFileCollector(['a-route']);

        $collector->addRouteFile('b-route');

        $this->assertSame(['a-route', 'b-route'], $collector->getRouteFiles());
    }
}
