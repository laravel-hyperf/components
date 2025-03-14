<?php

declare(strict_types=1);

namespace LaravelHyperf\Scheduling\Contracts;

interface CacheAware
{
    /**
     * Specify the cache store that should be used.
     */
    public function useStore(string $store): static;
}
