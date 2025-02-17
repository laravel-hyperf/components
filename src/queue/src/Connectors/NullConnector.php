<?php

declare(strict_types=1);

namespace LaravelHyperf\Queue\Connectors;

use LaravelHyperf\Queue\Contracts\Queue;
use LaravelHyperf\Queue\NullQueue;

class NullConnector implements ConnectorInterface
{
    /**
     * Establish a queue connection.
     */
    public function connect(array $config): Queue
    {
        return new NullQueue();
    }
}
