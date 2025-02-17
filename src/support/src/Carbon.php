<?php

declare(strict_types=1);

namespace LaravelHyperf\Support;

use Carbon\Carbon as BaseCarbon;
use Carbon\CarbonImmutable as BaseCarbonImmutable;
use Hyperf\Conditionable\Conditionable;
use LaravelHyperf\Support\Traits\Dumpable;

class Carbon extends BaseCarbon
{
    use Conditionable;
    use Dumpable;

    public static function setTestNow(mixed $testNow = null): void
    {
        BaseCarbon::setTestNow($testNow);
        BaseCarbonImmutable::setTestNow($testNow);
    }
}
