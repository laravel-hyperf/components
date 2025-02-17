<?php

declare(strict_types=1);

namespace LaravelHyperf\Config;

use Hyperf\Contract\ConfigInterface;
use LaravelHyperf\Config\Contracts\Repository as ConfigContract;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => [
                ConfigContract::class => ConfigFactory::class,
                ConfigInterface::class => ConfigFactory::class,
            ],
        ];
    }
}
