<?php

declare(strict_types=1);

namespace LaravelHyperf\Queue\Contracts;

interface Factory
{
    /**
     * Resolve a queue connection instance.
     */
    public function connection(?string $name = null): Queue;
}
