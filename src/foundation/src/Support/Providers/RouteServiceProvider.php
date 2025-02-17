<?php

declare(strict_types=1);

namespace LaravelHyperf\Foundation\Support\Providers;

use LaravelHyperf\Router\RouteFileCollector;
use LaravelHyperf\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The route files for the application.
     */
    protected array $routes = [
    ];

    public function boot(): void
    {
        $this->app->get(RouteFileCollector::class)
            ->addRouteFiles($this->routes);
    }
}
