<?php

declare(strict_types=1);

namespace LaravelHyperf\Support\Facades;

use LaravelHyperf\JWT\Contracts\ManagerContract;
use LaravelHyperf\JWT\JWTManager;
use LaravelHyperf\JWT\Providers\Lcobucci;

/**
 * @method static string encode(array $payload)
 * @method static array decode(string $token, bool $validate = true, bool $checkBlacklist = true)
 * @method static string refresh(string $token, bool $forceForever = false)
 * @method static bool invalidate(string $token, bool $forceForever = false)
 * @method static Lcobucci createLcobucciDriver()
 * @method static string getDefaultDriver()
 *
 * @see JWTManager
 */
class JWT extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ManagerContract::class;
    }
}
