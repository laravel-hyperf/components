<?php

declare(strict_types=1);

namespace LaravelHyperf\Queue\Connectors;

use LaravelHyperf\Queue\Contracts\Queue;

interface ConnectorInterface
{
    /**
     * Establish a queue connection.
     */
    public function connect(array $config): Queue;
}
