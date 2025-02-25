<?php

declare(strict_types=1);

namespace LaravelHyperf\Support\Facades;

use LaravelHyperf\Router\Router;

/**
 * @method static void addServer(string $serverName, callable $callback)
 * @method static void group(void $prefix, callable|string $source, array $options = [])
 * @method static void addGroup(void $prefix, callable|string $source, array $options = [])
 * @method static void getRouter()
 * @method static void addRoute(string|string[] $httpMethod, string $route, array|string $handler, array $options = [])
 * @method static void get(string $route, array|string $handler, array $options = [])
 * @method static void post(string $route, array|string $handler, array $options = [])
 * @method static void put(string $route, array|string $handler, array $options = [])
 * @method static void delete(string $route, array|string $handler, array $options = [])
 * @method static void patch(string $route, array|string $handler, array $options = [])
 * @method static void head(string $route, array|string $handler, array $options = [])
 * @method static array getData()
 * @method static \FastRoute\RouteParser getRouteParser()
 *
 * @see \LaravelHyperf\Router\Router
 */
class Route extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Router::class;
    }
}
