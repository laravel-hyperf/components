<?php

declare(strict_types=1);

namespace LaravelHyperf\Database\Eloquent\Concerns;

use LaravelHyperf\Context\ApplicationContext;
use LaravelHyperf\Database\Eloquent\ModelListener;
use RuntimeException;

trait HasCallbacks
{
    /**
     * Register event callback for the model.
     *
     * @throws RuntimeException
     */
    public static function registerCallback(string $event, callable $callback): void
    {
        ApplicationContext::getContainer()
            ->get(ModelListener::class)
            ->register(new static(), $event, $callback); /* @phpstan-ignore-line */
    }
}
