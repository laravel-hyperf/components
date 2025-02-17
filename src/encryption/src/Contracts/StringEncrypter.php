<?php

declare(strict_types=1);

namespace LaravelHyperf\Encryption\Contracts;

interface StringEncrypter
{
    /**
     * Encrypt a string without serialization.
     *
     * @throws \LaravelHyperf\Encryption\Exceptions\EncryptException
     */
    public function encryptString(string $value): string;

    /**
     * Decrypt the given string without unserialization.
     *
     * @throws \LaravelHyperf\Encryption\Exceptions\DecryptException
     */
    public function decryptString(string $payload): string;
}
