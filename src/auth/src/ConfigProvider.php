<?php

declare(strict_types=1);

namespace LaravelHyperf\Auth;

use LaravelHyperf\Auth\Access\GateFactory;
use LaravelHyperf\Auth\Contracts\Authenticatable;
use LaravelHyperf\Auth\Contracts\FactoryContract;
use LaravelHyperf\Auth\Contracts\Gate as GateContract;
use LaravelHyperf\Auth\Contracts\Guard;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => [
                FactoryContract::class => AuthManager::class,
                Authenticatable::class => UserResolver::class,
                Guard::class => fn ($container) => $container->get(FactoryContract::class)->guard(),
                GateContract::class => GateFactory::class,
            ],
            'publish' => [
                [
                    'id' => 'config',
                    'description' => 'The config for auth.',
                    'source' => __DIR__ . '/../publish/auth.php',
                    'destination' => BASE_PATH . '/config/autoload/auth.php',
                ],
            ],
        ];
    }
}
