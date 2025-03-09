<?php

declare(strict_types=1);

namespace LaravelHyperf\Foundation;

use Hyperf\Di\Annotation\Scanner as HyperfScanner;

class AnnotationScanner extends HyperfScanner
{
    protected string $path = BASE_PATH . '/storage/framework/container/scan.cache';
}
