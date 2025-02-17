<?php

declare(strict_types=1);

namespace LaravelHyperf\Support\Facades;

use LaravelHyperf\Encryption\Contracts\Encrypter as EncrypterContract;
use LaravelHyperf\Encryption\Encrypter;

/**
 * @method static bool supported(string $key, string $cipher)
 * @method static string generateKey(string $cipher)
 * @method static string encrypt(mixed $value, bool $serialize = true)
 * @method static string encryptString(string $value)
 * @method static mixed decrypt(string $payload, bool $unserialize = true)
 * @method static string decryptString(string $payload)
 * @method static string getKey()
 *
 * @see Encrypter
 */
class Crypt extends Facade
{
    protected static function getFacadeAccessor()
    {
        return EncrypterContract::class;
    }
}
