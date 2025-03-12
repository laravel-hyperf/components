<?php

declare(strict_types=1);

namespace LaravelHyperf\Support\Facades;

use Closure;
use LaravelHyperf\Process\Factory;

use function Hyperf\Tappable\tap;

/**
 * @method static \LaravelHyperf\Process\PendingProcess command(array|string $command)
 * @method static \LaravelHyperf\Process\PendingProcess path(string $path)
 * @method static \LaravelHyperf\Process\PendingProcess timeout(int $timeout)
 * @method static \LaravelHyperf\Process\PendingProcess idleTimeout(int $timeout)
 * @method static \LaravelHyperf\Process\PendingProcess forever()
 * @method static \LaravelHyperf\Process\PendingProcess env(array $environment)
 * @method static \LaravelHyperf\Process\PendingProcess input(\Traversable|resource|string|int|float|bool|null $input)
 * @method static \LaravelHyperf\Process\PendingProcess quietly()
 * @method static \LaravelHyperf\Process\PendingProcess tty(bool $tty = true)
 * @method static \LaravelHyperf\Process\PendingProcess options(array $options)
 * @method static \LaravelHyperf\Process\Contracts\ProcessResult run(array|string|null $command = null, callable|null $output = null)
 * @method static \LaravelHyperf\Process\InvokedProcess start(array|string|null $command = null, callable|null $output = null)
 * @method static bool supportsTty()
 * @method static \LaravelHyperf\Process\PendingProcess withFakeHandlers(array $fakeHandlers)
 * @method static \LaravelHyperf\Process\PendingProcess|mixed when(\Closure|mixed|null $value = null, callable|null $callback = null, callable|null $default = null)
 * @method static \LaravelHyperf\Process\PendingProcess|mixed unless(\Closure|mixed|null $value = null, callable|null $callback = null, callable|null $default = null)
 * @method static \LaravelHyperf\Process\FakeProcessResult result(array|string $output = '', array|string $errorOutput = '', int $exitCode = 0)
 * @method static \LaravelHyperf\Process\FakeProcessDescription describe()
 * @method static \LaravelHyperf\Process\FakeProcessSequence sequence(array $processes = [])
 * @method static bool isRecording()
 * @method static \LaravelHyperf\Process\Factory recordIfRecording(\LaravelHyperf\Process\PendingProcess $process, \LaravelHyperf\Process\Contracts\ProcessResult $result)
 * @method static \LaravelHyperf\Process\Factory record(\LaravelHyperf\Process\PendingProcess $process, \LaravelHyperf\Process\Contracts\ProcessResult $result)
 * @method static \LaravelHyperf\Process\Factory preventStrayProcesses(bool $prevent = true)
 * @method static bool preventingStrayProcesses()
 * @method static \LaravelHyperf\Process\Factory assertRan(\Closure|string $callback)
 * @method static \LaravelHyperf\Process\Factory assertRanTimes(\Closure|string $callback, int $times = 1)
 * @method static \LaravelHyperf\Process\Factory assertNotRan(\Closure|string $callback)
 * @method static \LaravelHyperf\Process\Factory assertDidntRun(\Closure|string $callback)
 * @method static \LaravelHyperf\Process\Factory assertNothingRan()
 * @method static \LaravelHyperf\Process\Pool pool(callable $callback)
 * @method static \LaravelHyperf\Process\Contracts\ProcessResult pipe(callable|array $callback, callable|null $output = null)
 * @method static \LaravelHyperf\Process\ProcessPoolResults concurrently(callable $callback, callable|null $output = null)
 * @method static \LaravelHyperf\Process\PendingProcess newPendingProcess()
 * @method static void macro(string $name, object|callable $macro)
 * @method static void mixin(object $mixin, bool $replace = true)
 * @method static bool hasMacro(string $name)
 * @method static void flushMacros()
 * @method static mixed macroCall(string $method, array $parameters)
 *
 * @see \LaravelHyperf\Process\PendingProcess
 * @see \LaravelHyperf\Process\Factory
 */
class Process extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor()
    {
        return Factory::class;
    }

    /**
     * Indicate that the process factory should fake processes.
     */
    public static function fake(null|array|Closure $callback = null): Factory
    {
        return tap(static::getFacadeRoot(), function ($fake) use ($callback) {
            static::swap($fake->fake($callback));
        });
    }
}
