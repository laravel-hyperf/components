<?php

declare(strict_types=1);

namespace LaravelHyperf\Filesystem\Contracts;

interface Factory
{
    /**
     * Get a filesystem implementation.
     */
    public function disk(?string $name = null): Filesystem;
}
