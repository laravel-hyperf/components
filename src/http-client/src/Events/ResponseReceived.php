<?php

declare(strict_types=1);

namespace LaravelHyperf\HttpClient\Events;

use LaravelHyperf\HttpClient\Request;
use LaravelHyperf\HttpClient\Response;

class ResponseReceived
{
    /**
     * Create a new event instance.
     */
    public function __construct(
        public Request $request,
        public Response $response
    ) {
    }
}
