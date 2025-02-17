<?php

declare(strict_types=1);

namespace LaravelHyperf\Queue;

use LaravelHyperf\Bus\Dispatchable;
use LaravelHyperf\Bus\Queueable as QueueableByBus;

trait Queueable
{
    use Dispatchable;
    use InteractsWithQueue;
    use QueueableByBus;
    use SerializesModels;
}
