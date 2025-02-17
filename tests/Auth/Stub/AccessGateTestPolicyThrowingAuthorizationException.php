<?php

declare(strict_types=1);

namespace LaravelHyperf\Tests\Auth\Stub;

use LaravelHyperf\Auth\Access\AuthorizationException;

class AccessGateTestPolicyThrowingAuthorizationException
{
    public function create()
    {
        throw new AuthorizationException('Not allowed.', 'some_code');
    }
}
