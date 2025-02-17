<?php

declare(strict_types=1);

namespace LaravelHyperf\Queue;

use LaravelHyperf\Foundation\Exceptions\Contracts\ExceptionHandler as ExceptionHandlerContract;
use LaravelHyperf\Queue\Contracts\Factory as QueueManager;
use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

class WorkerFactory
{
    public function __invoke(ContainerInterface $container): Worker
    {
        return new Worker(
            $container->get(QueueManager::class),
            $container->get(EventDispatcherInterface::class),
            $container->get(ExceptionHandlerContract::class),
            fn () => false,
        );
    }
}
