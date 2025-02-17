<?php

declare(strict_types=1);

namespace LaravelHyperf\Tests\Telescope\Watchers;

use Hyperf\Contract\ConfigInterface;
use LaravelHyperf\Notifications\AnonymousNotifiable;
use LaravelHyperf\Notifications\Events\NotificationSent;
use LaravelHyperf\Notifications\Notification;
use LaravelHyperf\Telescope\EntryType;
use LaravelHyperf\Telescope\Watchers\NotificationWatcher;
use LaravelHyperf\Tests\Telescope\FeatureTestCase;
use Psr\EventDispatcher\EventDispatcherInterface;

/**
 * @internal
 * @coversNothing
 */
class NotificationWatcherTest extends FeatureTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->app->get(ConfigInterface::class)
            ->set('telescope.watchers', [
                NotificationWatcher::class => true,
            ]);

        $this->startTelescope();
    }

    public function testNotificationWatcherRegistersEntry()
    {
        $notifiable = new AnonymousNotifiable();
        $notifiable->routes = ['route1', 'route2'];
        $event = new NotificationSent(
            $notifiable,
            new Notification(),
            'channel',
            'response'
        );

        $this->app->get(EventDispatcherInterface::class)
            ->dispatch($event);

        $entry = $this->loadTelescopeEntries()->first();

        $this->assertSame(EntryType::NOTIFICATION, $entry->type);
        $this->assertSame(Notification::class, $entry->content['notification']);
        $this->assertFalse($entry->content['queued']);
        $this->assertSame($entry->content['notifiable'], 'Anonymous:route1,route2');
        $this->assertSame('channel', $entry->content['channel']);
        $this->assertSame('response', $entry->content['response']);
    }
}
