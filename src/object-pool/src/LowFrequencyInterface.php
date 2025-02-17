<?php

declare(strict_types=1);

namespace LaravelHyperf\ObjectPool;

interface LowFrequencyInterface
{
    public function __construct(?ObjectPool $pool = null);

    public function isLowFrequency(): bool;
}
