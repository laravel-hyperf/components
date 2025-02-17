<?php

declare(strict_types=1);

namespace LaravelHyperf\JWT;

use LaravelHyperf\JWT\Contracts\BlacklistContract;
use LaravelHyperf\JWT\Contracts\ManagerContract;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => [
                BlacklistContract::class => BlacklistFactory::class,
                ManagerContract::class => JWTManager::class,
            ],
            'publish' => [
                [
                    'id' => 'config',
                    'description' => 'The config for jwt.',
                    'source' => __DIR__ . '/../publish/jwt.php',
                    'destination' => BASE_PATH . '/config/autoload/jwt.php',
                ],
            ],
        ];
    }
}
