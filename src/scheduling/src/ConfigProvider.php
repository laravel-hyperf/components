<?php

declare(strict_types=1);

namespace LaravelHyperf\Scheduling;

use LaravelHyperf\Scheduling\Console\ScheduleClearCacheCommand;
use LaravelHyperf\Scheduling\Console\ScheduleInterruptCommand;
use LaravelHyperf\Scheduling\Console\ScheduleListCommand;
use LaravelHyperf\Scheduling\Console\ScheduleRunCommand;
use LaravelHyperf\Scheduling\Console\ScheduleTestCommand;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'commands' => [
                ScheduleListCommand::class,
                ScheduleRunCommand::class,
                ScheduleInterruptCommand::class,
                ScheduleClearCacheCommand::class,
                ScheduleTestCommand::class,
            ],
        ];
    }
}
