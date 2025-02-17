<?php

declare(strict_types=1);

namespace LaravelHyperf\Telescope\Contracts;

interface ClearableRepository
{
    /**
     * Clear all of the entries.
     */
    public function clear(): void;
}
