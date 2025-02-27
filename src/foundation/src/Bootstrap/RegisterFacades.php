<?php

declare(strict_types=1);

namespace LaravelHyperf\Foundation\Bootstrap;

use Hyperf\Collection\Arr;
use Hyperf\Contract\ConfigInterface;
use LaravelHyperf\Foundation\Contracts\Application as ApplicationContract;
use LaravelHyperf\Foundation\Support\Composer;
use LaravelHyperf\Support\Facades\Facade;
use Throwable;

class RegisterFacades
{
    /**
     * Load Class Aliases.
     */
    public function bootstrap(ApplicationContract $app): void
    {
        Facade::clearResolvedInstances();

        $composerAliases = [];
        try {
            $composerAliases = Arr::wrap(Composer::getJsonContent()['extra']['laravel-hyperf']['aliases']) ?? [];
        } catch (Throwable $e) {
            // do nothing
        }

        $configAliases = $app->get(ConfigInterface::class)
            ->get('app.aliases', []);
        $aliases = array_merge($composerAliases, $configAliases);

        $this->registerAliases($aliases);
    }

    protected function registerAliases(array $aliases): void
    {
        foreach ($aliases as $alias => $class) {
            if (class_exists($alias)) {
                continue;
            }

            class_alias($class, $alias);
        }
    }
}
