<?php

declare(strict_types=1);

namespace LaravelHyperf\Support\Facades;

use Hyperf\Crontab\Crontab;
use LaravelHyperf\Foundation\Console\Contracts\Schedule as ScheduleContract;

/**
 * @method static Crontab command(string $command, array $arguments = [])
 * @method static Crontab call(mixed $callable)
 * @method static array getCrontabs()
 *
 * @see ScheduleContract
 */
class Schedule extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ScheduleContract::class;
    }
}
