<?php

declare(strict_types=1);

namespace LaravelHyperf\Support\Facades;

use LaravelHyperf\Foundation\Console\Contracts\Kernel as KernelContract;
use LaravelHyperf\Foundation\Console\Scheduling\Schedule;

/**
 * @method static void bootstrap()
 * @method static void schedule(\LaravelHyperf\Foundation\Console\Scheduling\Schedule $schedule)
 * @method static void commands()
 * @method static \Hyperf\Command\ClosureCommand command(string $signature, \Closure $callback)
 * @method static void load(array|string $paths)
 * @method static \LaravelHyperf\Foundation\Console\Contracts\Kernel addCommands(array $commands)
 * @method static \LaravelHyperf\Foundation\Console\Contracts\Kernel addCommandPaths(array $paths)
 * @method static \LaravelHyperf\Foundation\Console\Contracts\Kernel addCommandRoutePaths(array $paths)
 * @method static array getLoadedPaths()
 * @method static void registerCommand(string $command)
 * @method static void call(string $command, array $parameters = [], \Symfony\Component\Console\Output\OutputInterface|null $outputBuffer = null)
 * @method static array all()
 * @method static string output()
 * @method static void setArtisan(\LaravelHyperf\Foundation\Console\Contracts\Application $artisan)
 * @method static \LaravelHyperf\Foundation\Console\Contracts\Application getArtisan()
 *
 * @see \LaravelHyperf\Foundation\Console\Contracts\Kernel
 */
class Artisan extends Facade
{
    protected static function getFacadeAccessor()
    {
        return KernelContract::class;
    }
}
