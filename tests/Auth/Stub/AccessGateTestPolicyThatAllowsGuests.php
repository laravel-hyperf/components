<?php

declare(strict_types=1);

namespace LaravelHyperf\Tests\Auth\Stub;

use LaravelHyperf\Auth\Contracts\Authenticatable;

class AccessGateTestPolicyThatAllowsGuests
{
    public function before(?Authenticatable $user)
    {
        $_SERVER['__hyperf.testBefore'] = true;
    }

    public function edit(?Authenticatable $user, AccessGateTestDummy $dummy)
    {
        return true;
    }

    public function update($user, AccessGateTestDummy $dummy)
    {
        return true;
    }
}
