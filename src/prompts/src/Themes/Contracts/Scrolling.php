<?php

declare(strict_types=1);

namespace LaravelHyperf\Prompts\Themes\Contracts;

interface Scrolling
{
    /**
     * The number of lines to reserve outside of the scrollable area.
     */
    public function reservedLines(): int;
}
