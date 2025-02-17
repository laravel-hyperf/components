<?php

declare(strict_types=1);

namespace LaravelHyperf\Auth;

use LaravelHyperf\Auth\Contracts\FactoryContract;
use Psr\Container\ContainerInterface;

class UserResolver
{
    public function __invoke(ContainerInterface $container): array
    {
        return $container->get(FactoryContract::class)
            ->userResolver();
    }
}
