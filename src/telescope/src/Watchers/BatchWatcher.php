<?php

declare(strict_types=1);

namespace LaravelHyperf\Telescope\Watchers;

use LaravelHyperf\Bus\Events\BatchDispatched;
use LaravelHyperf\Telescope\IncomingEntry;
use LaravelHyperf\Telescope\Telescope;
use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

class BatchWatcher extends Watcher
{
    /**
     * Register the watcher.
     */
    public function register(ContainerInterface $app): void
    {
        $app->get(EventDispatcherInterface::class)
            ->listen(BatchDispatched::class, [$this, 'recordBatch']);
    }

    /**
     * Record a job being created.
     */
    public function recordBatch(BatchDispatched $event): ?IncomingEntry
    {
        if (! Telescope::isRecording()) {
            return null;
        }

        $content = array_merge($event->batch->toArray(), [
            'queue' => $event->batch->options['queue'] ?? 'default',
            'connection' => $event->batch->options['connection'] ?? 'default',
            'allowsFailures' => $event->batch->allowsFailures(),
        ]);

        Telescope::recordBatch(
            $entry = IncomingEntry::make(
                $content,
                $event->batch->id
            )->withFamilyHash($event->batch->id)
        );

        return $entry;
    }
}
