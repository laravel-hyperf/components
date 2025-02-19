<?php

declare(strict_types=1);

namespace LaravelHyperf\HttpClient\Events;

use LaravelHyperf\HttpClient\ConnectionException;
use LaravelHyperf\HttpClient\Request;

class ConnectionFailed
{
    /**
     * Create a new event instance.
     */
    public function __construct(
        public Request $request,
        public ConnectionException $exception
    ) {
    }
}
