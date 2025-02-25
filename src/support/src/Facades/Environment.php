<?php

declare(strict_types=1);

namespace LaravelHyperf\Support\Facades;

use LaravelHyperf\Support\Environment as Accessor;

/**
 * @method static string|null get()
 * @method static \LaravelHyperf\Support\Environment set(string $env)
 * @method static \LaravelHyperf\Support\Environment setDebug(bool $debug)
 * @method static bool is(string|string[] ...$environments)
 * @method static bool isDebug()
 * @method static void macro(string $name, callable|object $macro)
 * @method static void mixin(object $mixin, bool $replace = true)
 * @method static bool hasMacro(string $name)
 * @method static bool isTesting()
 * @method static bool isLocal()
 * @method static bool isDevelop()
 * @method static bool isProduction()
 *
 * @see \LaravelHyperf\Support\Environment
 */
class Environment extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Accessor::class;
    }
}
