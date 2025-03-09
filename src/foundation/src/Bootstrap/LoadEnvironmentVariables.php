<?php

declare(strict_types=1);

namespace LaravelHyperf\Foundation\Bootstrap;

use Hyperf\Support\DotenvManager;
use LaravelHyperf\Foundation\Contracts\Application as ApplicationContract;

class LoadEnvironmentVariables
{
    /**
     * Register App Providers.
     */
    public function bootstrap(ApplicationContract $app): void
    {
        // Hyperf doesn't support customizing the .env file path.
        if (! file_exists($app->basePath('.env'))) {
            return;
        }

        $this->loadDotenv($app);
    }

    protected function loadDotenv(ApplicationContract $app): void
    {
        DotenvManager::load([$app->basePath()]);
    }
}
