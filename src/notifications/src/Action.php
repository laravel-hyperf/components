<?php

declare(strict_types=1);

namespace LaravelHyperf\Notifications;

class Action
{
    /**
     * Create a new action instance.
     */
    public function __construct(
        public string $text,
        public string $url
    ) {
    }
}
