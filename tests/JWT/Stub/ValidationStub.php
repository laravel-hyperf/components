<?php

declare(strict_types=1);

namespace LaravelHyperf\Tests\JWT\Stub;

use LaravelHyperf\JWT\Validations\AbstractValidation;

class ValidationStub extends AbstractValidation
{
    public function validate(array $payload): void
    {
    }
}
