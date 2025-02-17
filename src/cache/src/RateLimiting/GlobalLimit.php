<?php

declare(strict_types=1);

namespace LaravelHyperf\Cache\RateLimiting;

class GlobalLimit extends Limit
{
    /**
     * Create a new limit instance.
     */
    public function __construct(int $maxAttempts, int $decayMinutes = 1)
    {
        parent::__construct('', $maxAttempts, $decayMinutes);
    }
}
