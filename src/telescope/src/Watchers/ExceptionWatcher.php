<?php

declare(strict_types=1);

namespace LaravelHyperf\Telescope\Watchers;

use Hyperf\Collection\Arr;
use Hyperf\Collection\Collection;
use LaravelHyperf\Log\Events\MessageLogged;
use LaravelHyperf\Telescope\ExceptionContext;
use LaravelHyperf\Telescope\ExtractTags;
use LaravelHyperf\Telescope\IncomingExceptionEntry;
use LaravelHyperf\Telescope\Telescope;
use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Throwable;

class ExceptionWatcher extends Watcher
{
    /**
     * Register the watcher.
     */
    public function register(ContainerInterface $app): void
    {
        $app->get(EventDispatcherInterface::class)
            ->listen(MessageLogged::class, [$this, 'recordException']);
    }

    /**
     * Record an exception was logged.
     */
    public function recordException(MessageLogged $event): void
    {
        if (! Telescope::isRecording() || $this->shouldIgnore($event)) {
            return;
        }

        $exception = $event->context['exception'];

        $trace = Collection::make($exception->getTrace())->map(function ($item) {
            return Arr::only($item, ['file', 'line']);
        })->toArray();

        Telescope::recordException(
            IncomingExceptionEntry::make($exception, [
                'class' => get_class($exception),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'message' => $exception->getMessage(),
                'context' => transform(Arr::except($event->context, ['exception', 'telescope']), function ($context) {
                    return ! empty($context) ? $context : null;
                }),
                'trace' => $trace,
                'line_preview' => ExceptionContext::get($exception),
            ])->tags($this->tags($event))
        );
    }

    /**
     * Extract the tags for the given event.
     */
    protected function tags(MessageLogged $event): array
    {
        return array_merge(
            ExtractTags::from($event->context['exception']),
            $event->context['telescope'] ?? []
        );
    }

    /**
     * Determine if the event should be ignored.
     */
    private function shouldIgnore(mixed $event): bool
    {
        return ! isset($event->context['exception'])
            || ! $event->context['exception'] instanceof Throwable;
    }
}
