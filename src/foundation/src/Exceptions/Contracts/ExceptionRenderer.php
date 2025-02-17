<?php

declare(strict_types=1);

namespace LaravelHyperf\Foundation\Exceptions\Contracts;

use Throwable;

interface ExceptionRenderer
{
    /**
     * Renders the given exception as HTML.
     */
    public function render(Throwable $throwable): string;
}
