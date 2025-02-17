<?php

declare(strict_types=1);

namespace LaravelHyperf\Bus;

use LaravelHyperf\Bus\Contracts\BatchRepository;
use LaravelHyperf\Bus\Contracts\Dispatcher as DispatcherContract;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => [
                DispatcherContract::class => DispatcherFactory::class,
                BatchRepository::class => DatabaseBatchRepository::class,
                DatabaseBatchRepository::class => DatabaseBatchRepositoryFactory::class,
            ],
        ];
    }
}
