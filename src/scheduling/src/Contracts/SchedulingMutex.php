<?php

declare(strict_types=1);

namespace LaravelHyperf\Scheduling\Contracts;

use DateTimeInterface;
use LaravelHyperf\Scheduling\Event;

interface SchedulingMutex
{
    /**
     * Attempt to obtain a scheduling mutex for the given event.
     */
    public function create(Event $event, DateTimeInterface $time): bool;

    /**
     * Determine if a scheduling mutex exists for the given event.
     */
    public function exists(Event $event, DateTimeInterface $time): bool;
}
