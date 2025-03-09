<?php

declare(strict_types=1);

namespace LaravelHyperf\Cache;

use LaravelHyperf\Cache\Console\ClearCommand;
use LaravelHyperf\Cache\Contracts\Factory;
use LaravelHyperf\Cache\Contracts\Store;
use LaravelHyperf\Cache\Listeners\CreateSwooleTable;
use LaravelHyperf\Cache\Listeners\CreateTimer;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => [
                Factory::class => CacheManager::class,
                Store::class => fn ($container) => $container->get(CacheManager::class)->driver(),
            ],
            'listeners' => [
                CreateSwooleTable::class,
                CreateTimer::class,
            ],
            'commands' => [
                ClearCommand::class,
            ],
            'publish' => [
                [
                    'id' => 'config',
                    'description' => 'The config for cache.',
                    'source' => __DIR__ . '/../publish/cache.php',
                    'destination' => BASE_PATH . '/config/autoload/cache.php',
                ],
            ],
        ];
    }
}
