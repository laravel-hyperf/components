<?php

declare(strict_types=1);

namespace LaravelHyperf\Telescope\Watchers;

use LaravelHyperf\Scheduling\CallbackEvent;
use LaravelHyperf\Scheduling\Events;
use LaravelHyperf\Telescope\Contracts\EntriesRepository;
use LaravelHyperf\Telescope\IncomingEntry;
use LaravelHyperf\Telescope\Telescope;
use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

class ScheduleWatcher extends Watcher
{
    /**
     * The entries repository.
     */
    protected ?EntriesRepository $entriesRepository = null;

    /**
     * The application instance.
     */
    protected ?ContainerInterface $app = null;

    /**
     * Register the watcher.
     */
    public function register(ContainerInterface $app): void
    {
        if (! in_array($_SERVER['argv'][1] ?? null, ['crontab:run', 'schedule:run'])) {
            return;
        }

        $this->app = $app;

        $this->entriesRepository = $app->get(EntriesRepository::class);

        Telescope::startRecording();

        $app->get(EventDispatcherInterface::class)
            ->listen([
                Events\ScheduledTaskStarting::class,
                Events\ScheduledTaskFinished::class,
                Events\ScheduledTaskFailed::class,
            ], [$this, 'recordCommand']);
    }

    /**
     * Record a scheduled command was executed.
     */
    public function recordCommand(object $event): void
    {
        if ($event instanceof Events\ScheduledTaskStarting) {
            Telescope::startRecording();
            return;
        }

        if (! Telescope::isRecording()) {
            return;
        }

        $task = $event->task;

        Telescope::recordScheduledCommand(IncomingEntry::make([
            'command' => $task instanceof CallbackEvent ? 'Closure' : $task->command,
            'description' => $task->description,
            'expression' => $task->expression,
            'timezone' => $task->timezone,
            'user' => $task->user,
            'output' => $task->getOutput($this->app),
        ]));

        Telescope::store($this->entriesRepository);
    }
}
