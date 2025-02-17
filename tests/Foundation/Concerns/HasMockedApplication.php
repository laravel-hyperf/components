<?php

declare(strict_types=1);

namespace LaravelHyperf\Tests\Foundation\Concerns;

use LaravelHyperf\Container\DefinitionSource;
use LaravelHyperf\Foundation\Application;

trait HasMockedApplication
{
    protected function getApplication(array $definitionSources = [], string $basePath = 'base_path'): Application
    {
        return new Application(
            new DefinitionSource($definitionSources),
            $basePath
        );
    }
}
