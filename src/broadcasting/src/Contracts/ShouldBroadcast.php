<?php

declare(strict_types=1);

namespace LaravelHyperf\Broadcasting\Contracts;

use LaravelHyperf\Broadcasting\Channel;

interface ShouldBroadcast
{
    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel[]|string[]
     */
    public function broadcastOn(): array;
}
