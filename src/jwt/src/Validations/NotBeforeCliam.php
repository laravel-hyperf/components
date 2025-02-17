<?php

declare(strict_types=1);

namespace LaravelHyperf\JWT\Validations;

use Carbon\Carbon;
use LaravelHyperf\JWT\Exceptions\TokenInvalidException;

class NotBeforeCliam extends AbstractValidation
{
    public function validate(array $payload): void
    {
        if (! $nbf = ($payload['nbf'] ?? null)) {
            return;
        }

        if ($this->timestamp($nbf)->subSeconds($this->config['leeway'] ?? 0) > Carbon::now()) {
            throw new TokenInvalidException('Not Before (nbf) timestamp cannot be in the future');
        }
    }
}
