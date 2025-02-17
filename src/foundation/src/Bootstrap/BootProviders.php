<?php

declare(strict_types=1);

namespace LaravelHyperf\Foundation\Bootstrap;

use LaravelHyperf\Foundation\Contracts\Application as ApplicationContract;

class BootProviders
{
    /**
     * Register App Providers.
     */
    public function bootstrap(ApplicationContract $app): void
    {
        $app->boot();
    }
}
