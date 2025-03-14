<?php

declare(strict_types=1);

namespace LaravelHyperf\Scheduling\Console;

use Hyperf\Command\Command;
use LaravelHyperf\Cache\Contracts\Factory as CacheFactory;
use LaravelHyperf\Support\Facades\Date;
use LaravelHyperf\Support\Traits\HasLaravelStyleCommand;

class ScheduleInterruptCommand extends Command
{
    use HasLaravelStyleCommand;

    /**
     * The console signature name.
     */
    protected ?string $signature = 'schedule:interrupt
        {--minutes : Time in minutes to interrupt the schedule (default: 60)}
    ';

    /**
     * The console command description.
     */
    protected string $description = 'Interrupt the current schedule run';

    /**
     * Create a new schedule interrupt command.
     *
     * @param CacheFactory $cache the cache store implementation
     */
    public function __construct(
        protected CacheFactory $cache
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        /* @phpstan-ignore-next-line */
        $this->cache->put(
            'illuminate:schedule:interrupt',
            true,
            Date::now()->addMinutes($this->option('minutes') ?? 60)
        );

        $this->info('Broadcasting schedule interrupt signal.');
    }
}
