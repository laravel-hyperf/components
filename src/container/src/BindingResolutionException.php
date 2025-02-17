<?php

declare(strict_types=1);

namespace LaravelHyperf\Container;

use Exception;
use Psr\Container\ContainerExceptionInterface;

class BindingResolutionException extends Exception implements ContainerExceptionInterface
{
}
