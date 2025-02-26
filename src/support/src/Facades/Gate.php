<?php

declare(strict_types=1);

namespace LaravelHyperf\Support\Facades;

use LaravelHyperf\Auth\Contracts\Gate as GateContract;

/**
 * @method static bool has(array|string $ability)
 * @method static \LaravelHyperf\Auth\Access\Response allowIf(\Closure|\LaravelHyperf\Auth\Access\Response|bool $condition, string|null $message = null, string|null $code = null)
 * @method static \LaravelHyperf\Auth\Access\Response denyIf(\Closure|\LaravelHyperf\Auth\Access\Response|bool $condition, string|null $message = null, string|null $code = null)
 * @method static \LaravelHyperf\Auth\Access\Gate define(string $ability, callable|array|string $callback)
 * @method static \LaravelHyperf\Auth\Access\Gate resource(string $name, string $class, array|null $abilities = null)
 * @method static \LaravelHyperf\Auth\Access\Gate policy(string $class, string $policy)
 * @method static \LaravelHyperf\Auth\Access\Gate before(callable $callback)
 * @method static \LaravelHyperf\Auth\Access\Gate after(callable $callback)
 * @method static bool allows(string $ability, mixed $arguments = [])
 * @method static bool denies(string $ability, mixed $arguments = [])
 * @method static bool check(\Traversable|array|string $abilities, mixed $arguments = [])
 * @method static bool any(\Traversable|array|string $abilities, mixed $arguments = [])
 * @method static bool none(\Traversable|array|string $abilities, mixed $arguments = [])
 * @method static \LaravelHyperf\Auth\Access\Response authorize(string $ability, mixed $arguments = [])
 * @method static \LaravelHyperf\Auth\Access\Response inspect(string $ability, mixed $arguments = [])
 * @method static mixed raw(string $ability, mixed $arguments = [])
 * @method static mixed|void getPolicyFor(object|string $class)
 * @method static mixed resolvePolicy(string $class)
 * @method static \LaravelHyperf\Auth\Access\Gate forUser(\LaravelHyperf\Auth\Contracts\Authenticatable|null $user)
 * @method static array abilities()
 * @method static array policies()
 * @method static \LaravelHyperf\Auth\Access\Gate defaultDenialResponse(\LaravelHyperf\Auth\Access\Response $response)
 * @method static \LaravelHyperf\Auth\Access\Response denyWithStatus(int $status, string|null $message = null, string|int|null $code = null)
 * @method static \LaravelHyperf\Auth\Access\Response denyAsNotFound(string|null $message = null, string|int|null $code = null)
 *
 * @see \LaravelHyperf\Auth\Access\Gate
 */
class Gate extends Facade
{
    protected static function getFacadeAccessor()
    {
        return GateContract::class;
    }
}
