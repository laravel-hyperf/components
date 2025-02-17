<?php

declare(strict_types=1);

namespace LaravelHyperf\JWT\Contracts;

interface ValidationContract
{
    public function validate(array $payload): void;
}
