<?php

declare(strict_types=1);

namespace LaravelHyperf\Support\Facades;

use LaravelHyperf\Hashing\Contracts\Hasher;

/**
 * @method static \LaravelHyperf\Hashing\BcryptHasher createBcryptDriver()
 * @method static \LaravelHyperf\Hashing\ArgonHasher createArgonDriver()
 * @method static \LaravelHyperf\Hashing\Argon2IdHasher createArgon2idDriver()
 * @method static array info(string $hashedValue)
 * @method static string make(string $value, array $options = [])
 * @method static bool check(string $value, string|null $hashedValue, array $options = [])
 * @method static bool needsRehash(string $hashedValue, array $options = [])
 * @method static bool isHashed(string $value)
 * @method static string getDefaultDriver()
 * @method static mixed driver(string|null $driver = null)
 * @method static \LaravelHyperf\Hashing\HashManager extend(string $driver, \Closure $callback)
 * @method static array getDrivers()
 * @method static \Psr\Container\ContainerInterface getContainer()
 * @method static \LaravelHyperf\Hashing\HashManager setContainer(\Psr\Container\ContainerInterface $container)
 * @method static \LaravelHyperf\Hashing\HashManager forgetDrivers()
 *
 * @see \LaravelHyperf\Hashing\HashManager
 */
class Hash extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Hasher::class;
    }
}
