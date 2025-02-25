<?php

declare(strict_types=1);

namespace LaravelHyperf\Support\Facades;

use LaravelHyperf\Auth\AuthManager;
use LaravelHyperf\Auth\Contracts\Guard;

/**
 * @method static \LaravelHyperf\Auth\Contracts\Guard|\LaravelHyperf\Auth\Contracts\StatefulGuard guard(string|null $name = null)
 * @method static \LaravelHyperf\Auth\Guards\SessionGuard createSessionDriver(string $name, array $config)
 * @method static \LaravelHyperf\Auth\Guards\JwtGuard createJwtDriver(string $name, array $config)
 * @method static \LaravelHyperf\Auth\AuthManager extend(string $driver, \Closure $callback)
 * @method static \LaravelHyperf\Auth\AuthManager provider(string $name, \Closure $callback)
 * @method static string getDefaultDriver()
 * @method static void shouldUse(string|null $name)
 * @method static void setDefaultDriver(string $name)
 * @method static \Closure userResolver()
 * @method static \LaravelHyperf\Auth\AuthManager resolveUsersUsing(\Closure $userResolver)
 * @method static array getGuards()
 * @method static \LaravelHyperf\Auth\AuthManager setApplication(\Psr\Container\ContainerInterface $app)
 * @method static \LaravelHyperf\Auth\Contracts\UserProvider|null createUserProvider(string|null $provider = null)
 * @method static string getDefaultUserProvider()
 * @method static bool check()
 * @method static bool guest()
 * @method static \LaravelHyperf\Auth\Contracts\Authenticatable|null user()
 * @method static string|int|null id()
 * @method static bool validate(array $credentials = [])
 * @method static void setUser(\LaravelHyperf\Auth\Contracts\Authenticatable $user)
 * @method static bool attempt(array $credentials = [])
 * @method static bool once(array $credentials = [])
 * @method static void login(\LaravelHyperf\Auth\Contracts\Authenticatable $user)
 * @method static \LaravelHyperf\Auth\Contracts\Authenticatable|bool loginUsingId(mixed $id)
 * @method static \LaravelHyperf\Auth\Contracts\Authenticatable|bool onceUsingId(mixed $id)
 * @method static void logout()
 *
 * @see \LaravelHyperf\Auth\AuthManager
 * @see \LaravelHyperf\Auth\Contracts\Guard
 * @see \LaravelHyperf\Auth\Contracts\StatefulGuard
 */
class Auth extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return AuthManager::class;
    }
}
