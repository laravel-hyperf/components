<?php

declare(strict_types=1);

namespace LaravelHyperf\Foundation\Events;

class LocaleUpdated
{
    /**
     * Create a new event instance.
     */
    public function __construct(public string $locale)
    {
    }
}
