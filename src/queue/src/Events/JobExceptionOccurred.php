<?php

declare(strict_types=1);

namespace LaravelHyperf\Queue\Events;

use LaravelHyperf\Queue\Contracts\Job;
use Throwable;

class JobExceptionOccurred
{
    /**
     * Create a new event instance.
     */
    public function __construct(
        public string $connectionName,
        public Job $job,
        public Throwable $exception
    ) {
    }
}
