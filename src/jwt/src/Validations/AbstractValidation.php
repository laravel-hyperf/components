<?php

declare(strict_types=1);

namespace LaravelHyperf\JWT\Validations;

use Carbon\Carbon;
use LaravelHyperf\JWT\Contracts\ValidationContract;

abstract class AbstractValidation implements ValidationContract
{
    public function __construct(
        protected array $config = []
    ) {
    }

    abstract public function validate(array $payload): void;

    protected function timestamp(int $timestamp): Carbon
    {
        return Carbon::createFromTimestamp($timestamp);
    }
}
