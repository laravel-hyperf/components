<?php

declare(strict_types=1);

namespace LaravelHyperf\Session;

use LaravelHyperf\Session\Contracts\Factory;
use LaravelHyperf\Session\Contracts\Session as SessionContract;
use Psr\Container\ContainerInterface;

class StoreFactory
{
    public function __invoke(ContainerInterface $container): SessionContract
    {
        return $container->get(Factory::class)
            ->driver();
    }
}
