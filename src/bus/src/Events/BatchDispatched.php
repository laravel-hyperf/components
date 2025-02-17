<?php

declare(strict_types=1);

namespace LaravelHyperf\Bus\Events;

use LaravelHyperf\Bus\Batch;

class BatchDispatched
{
    public function __construct(
        public Batch $batch
    ) {
    }
}
