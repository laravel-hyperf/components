<?php

declare(strict_types=1);

namespace LaravelHyperf\Scheduling\Events;

use LaravelHyperf\Scheduling\Event;

class ScheduledTaskSkipped
{
    /**
     * Create a new event instance.
     */
    public function __construct(
        public Event $task,
    ) {
    }
}
