<?php

declare(strict_types=1);

namespace LaravelHyperf\Session;

use Hyperf\Contract\SessionInterface;
use LaravelHyperf\Session\Contracts\Session as SessionContract;
use Psr\Container\ContainerInterface;

class AdapterFactory
{
    public function __invoke(ContainerInterface $container): SessionInterface
    {
        return new SessionAdapter(
            $container->get(SessionContract::class)
        );
    }
}
