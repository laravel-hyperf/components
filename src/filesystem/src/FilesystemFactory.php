<?php

declare(strict_types=1);

namespace LaravelHyperf\Filesystem;

use LaravelHyperf\Filesystem\Contracts\Factory as FactoryContract;
use LaravelHyperf\Filesystem\Contracts\Filesystem as FilesystemContract;
use Psr\Container\ContainerInterface;

class FilesystemFactory
{
    public function __invoke(ContainerInterface $container): FilesystemContract
    {
        return $container->get(FactoryContract::class)
            ->disk();
    }
}
