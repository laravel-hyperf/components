<?php

declare(strict_types=1);

namespace LaravelHyperf\Support\Facades;

use LaravelHyperf\Foundation\Console\Contracts\Schedule as ScheduleContract;

/**
 * @method static \Hyperf\Crontab\Crontab command(string $command, array $arguments = [])
 * @method static \Hyperf\Crontab\Crontab call(mixed $callable)
 * @method static array getCrontabs()
 *
 * @see \LaravelHyperf\Foundation\Console\Contracts\Schedule
 */
class Schedule extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ScheduleContract::class;
    }
}
