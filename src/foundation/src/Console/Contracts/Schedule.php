<?php

declare(strict_types=1);

namespace LaravelHyperf\Foundation\Console\Contracts;

use Hyperf\Crontab\Crontab;

interface Schedule
{
    public function command(string $command, array $arguments = []): Crontab;

    public function call(mixed $callable): Crontab;

    public function getCrontabs(): array;
}
