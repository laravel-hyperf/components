<?php

declare(strict_types=1);

namespace LaravelHyperf\Tests\Auth\Stub;

use Hyperf\Database\Model\Model;
use LaravelHyperf\Auth\Access\Authorizable;
use LaravelHyperf\Auth\Authenticatable;
use LaravelHyperf\Auth\Contracts\Authenticatable as AuthenticatableContract;
use LaravelHyperf\Auth\Contracts\Authorizable as AuthorizableContract;

class AuthorizableStub extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable;
    use Authorizable;
}
