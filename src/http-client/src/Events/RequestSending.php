<?php

declare(strict_types=1);

namespace LaravelHyperf\HttpClient\Events;

use LaravelHyperf\HttpClient\Request;

class RequestSending
{
    /**
     * Create a new event instance.
     */
    public function __construct(public Request $request)
    {
    }
}
