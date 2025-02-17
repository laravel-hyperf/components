<?php

declare(strict_types=1);

namespace LaravelHyperf\Tests\JWT\Stub;

use LaravelHyperf\JWT\Providers\Provider;

class ProviderStub extends Provider
{
    protected function isAsymmetric(): bool
    {
        return false;
    }
}
