<?php

declare(strict_types=1);

namespace LaravelHyperf\Tests\Auth\Stub;

use LaravelHyperf\Auth\Access\HandlesAuthorization;

class AccessGateTestPolicyWithCode
{
    use HandlesAuthorization;

    public function view($user)
    {
        if (! $user->isAdmin()) {
            return $this->deny('Not allowed to view as it is not published.', 'unpublished');
        }

        return true;
    }
}
