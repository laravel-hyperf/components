<?php

declare(strict_types=1);

namespace LaravelHyperf\JWT\Contracts;

interface ProviderContract
{
    public function encode(array $payload): string;

    public function decode(string $token): array;
}
