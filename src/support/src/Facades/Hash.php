<?php

declare(strict_types=1);

namespace LaravelHyperf\Support\Facades;

use LaravelHyperf\Hashing\Contracts\Hasher;
use LaravelHyperf\Hashing\HashManager;

/**
 * @method static array info(string $hashedValue)
 * @method static string make(string $value, array $options = [])
 * @method static bool check(string $value, ?string $hashedValue, array $options = [])
 * @method static bool needsRehash(string $hashedValue, array $options = [])
 * @method static bool isHashed(string $value)
 * @method static string getDefaultDriver()
 *
 * @see HashManager
 */
class Hash extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Hasher::class;
    }
}
