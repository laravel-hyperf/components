<?php

declare(strict_types=1);

namespace LaravelHyperf\Session;

use Hyperf\Contract\SessionInterface;
use LaravelHyperf\Session\Contracts\Factory;
use LaravelHyperf\Session\Contracts\Session as SessionContract;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => [
                Factory::class => SessionManager::class,
                SessionContract::class => StoreFactory::class,
                SessionInterface::class => AdapterFactory::class,
            ],
            'publish' => [
                [
                    'id' => 'config',
                    'description' => 'The configuration file of session.',
                    'source' => __DIR__ . '/../publish/session.php',
                    'destination' => BASE_PATH . '/config/autoload/session.php',
                ],
            ],
        ];
    }
}
