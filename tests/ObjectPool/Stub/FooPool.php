<?php

declare(strict_types=1);

namespace LaravelHyperf\Tests\ObjectPool\Stub;

use LaravelHyperf\ObjectPool\ObjectPool;
use stdClass;

class FooPool extends ObjectPool
{
    protected function createObject(): object
    {
        return new stdClass();
    }
}
