<?php

declare(strict_types=1);

namespace LaravelHyperf\Telescope\Watchers;

use Hyperf\Database\Model\Model;
use LaravelHyperf\Notifications\AnonymousNotifiable;
use LaravelHyperf\Notifications\Events\NotificationSent;
use LaravelHyperf\Queue\Contracts\ShouldQueue;
use LaravelHyperf\Telescope\ExtractTags;
use LaravelHyperf\Telescope\FormatModel;
use LaravelHyperf\Telescope\IncomingEntry;
use LaravelHyperf\Telescope\Telescope;
use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

class NotificationWatcher extends Watcher
{
    /**
     * Register the watcher.
     */
    public function register(ContainerInterface $app): void
    {
        $app->get(EventDispatcherInterface::class)
            ->listen(NotificationSent::class, [$this, 'recordNotification']);
    }

    /**
     * Record a new notification message was sent.
     */
    public function recordNotification(NotificationSent $event): void
    {
        if (! Telescope::isRecording()) {
            return;
        }

        Telescope::recordNotification(IncomingEntry::make([
            'notification' => get_class($event->notification),
            'queued' => in_array(ShouldQueue::class, class_implements($event->notification)),
            'notifiable' => $this->formatNotifiable($event->notifiable),
            'channel' => $event->channel,
            'response' => $event->response,
        ])->tags($this->tags($event)));
    }

    /**
     * Extract the tags for the given event.
     */
    private function tags(NotificationSent $event): array
    {
        return array_merge([
            $this->formatNotifiable($event->notifiable),
        ], ExtractTags::from($event->notification));
    }

    /**
     * Format the given notifiable into a tag.
     */
    private function formatNotifiable(mixed $notifiable): string
    {
        if ($notifiable instanceof Model) {
            return FormatModel::given($notifiable);
        }
        if ($notifiable instanceof AnonymousNotifiable) {
            $routes = array_map(function ($route) {
                return is_array($route) ? implode(',', $route) : $route;
            }, $notifiable->routes);

            return 'Anonymous:' . implode(',', $routes);
        }

        return get_class($notifiable);
    }
}
