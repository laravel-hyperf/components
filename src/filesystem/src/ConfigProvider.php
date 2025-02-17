<?php

declare(strict_types=1);

namespace LaravelHyperf\Filesystem;

use LaravelHyperf\Filesystem\Contracts\Cloud as CloudContract;
use LaravelHyperf\Filesystem\Contracts\Factory as FactoryContract;
use LaravelHyperf\Filesystem\Contracts\Filesystem as FilesystemContract;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => [
                CloudContract::class => CloudStorageFactory::class,
                FactoryContract::class => FilesystemManager::class,
                FilesystemContract::class => FilesystemFactory::class,
            ],
            'publish' => [
                [
                    'id' => 'config',
                    'description' => 'The config for filesystem.',
                    'source' => __DIR__ . '/../publish/filesystems.php',
                    'destination' => BASE_PATH . '/config/autoload/filesystems.php',
                ],
            ],
        ];
    }
}
