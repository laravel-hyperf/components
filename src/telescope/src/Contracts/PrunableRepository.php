<?php

declare(strict_types=1);

namespace LaravelHyperf\Telescope\Contracts;

use DateTimeInterface;

interface PrunableRepository
{
    /**
     * Prune all of the entries older than the given date.
     */
    public function prune(DateTimeInterface $before, bool $keepExceptions): int;
}
