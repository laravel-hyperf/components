<?php

declare(strict_types=1);

namespace LaravelHyperf\Support\Contracts;

interface Htmlable
{
    /**
     * Get content as a string of HTML.
     */
    public function toHtml(): string;
}
