<?php

declare(strict_types=1);

namespace LaravelHyperf\Tests\Auth\Stub;

use LaravelHyperf\Auth\Access\Response;

class AccessGateTestPolicyWithDeniedResponseObject
{
    public function create()
    {
        return Response::deny('Not allowed.', 'some_code');
    }
}
