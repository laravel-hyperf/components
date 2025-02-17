<?php

declare(strict_types=1);

namespace LaravelHyperf\Foundation;

use Hyperf\Context\ApplicationContext as HyperfApplicationContext;
use LaravelHyperf\Container\Contracts\Container as ContainerContract;
use TypeError;

class ApplicationContext extends HyperfApplicationContext
{
    /**
     * @throws TypeError
     */
    public static function getContainer(): ContainerContract
    {
        /* @phpstan-ignore-next-line */
        return self::$container;
    }
}
