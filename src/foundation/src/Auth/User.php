<?php

declare(strict_types=1);

namespace LaravelHyperf\Foundation\Auth;

use LaravelHyperf\Auth\Access\Authorizable;
use LaravelHyperf\Auth\Authenticatable;
use LaravelHyperf\Auth\Contracts\Authenticatable as AuthenticatableContract;
use LaravelHyperf\Auth\Contracts\Authorizable as AuthorizableContract;
use LaravelHyperf\Database\Eloquent\Model;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable;
    use Authorizable;
}
