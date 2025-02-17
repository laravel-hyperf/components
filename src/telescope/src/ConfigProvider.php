<?php

declare(strict_types=1);

namespace LaravelHyperf\Telescope;

use LaravelHyperf\Telescope\Aspects\GuzzleHttpClientAspect;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'aspects' => [
                GuzzleHttpClientAspect::class,
            ],
        ];
    }
}
