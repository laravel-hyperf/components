<?php

declare(strict_types=1);

namespace LaravelHyperf\Filesystem;

use LaravelHyperf\Filesystem\Contracts\Cloud as CloudContract;
use LaravelHyperf\Filesystem\Contracts\Factory as FactoryContract;
use Psr\Container\ContainerInterface;

class CloudStorageFactory
{
    public function __invoke(ContainerInterface $container): CloudContract
    {
        return $container->get(FactoryContract::class)
            ->cloud(CloudContract::class);
    }
}
