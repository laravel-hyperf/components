<?php

declare(strict_types=1);

namespace LaravelHyperf\Foundation\Http\Middleware;

class TrimStrings extends TransformsRequest
{
    protected function processString(string $value): ?string
    {
        return empty($value) ? $value : trim($value);
    }
}
