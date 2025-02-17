<?php

declare(strict_types=1);

namespace LaravelHyperf\Tests\Auth\Stub;

class AccessGateTestStaticClass
{
    public static function foo($user)
    {
        return $user->getAuthIdentifier() === 1;
    }
}
