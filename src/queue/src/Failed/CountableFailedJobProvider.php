<?php

declare(strict_types=1);

namespace LaravelHyperf\Queue\Failed;

interface CountableFailedJobProvider
{
    /**
     * Count the failed jobs.
     */
    public function count(?string $connection = null, ?string $queue = null): int;
}
