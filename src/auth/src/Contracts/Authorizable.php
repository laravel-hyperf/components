<?php

declare(strict_types=1);

namespace LaravelHyperf\Auth\Contracts;

interface Authorizable
{
    /**
     * Determine if the entity has a given ability.
     */
    public function can(iterable|string $abilities, mixed $arguments = []): bool;
}
