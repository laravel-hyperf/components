<?php

declare(strict_types=1);

namespace LaravelHyperf\Tests\Notifications;

use Hyperf\Config\Config;
use Hyperf\Contract\ConfigInterface;
use Hyperf\Di\Container;
use Hyperf\Di\Definition\DefinitionSource;
use LaravelHyperf\Bus\Contracts\Dispatcher as BusDispatcherContract;
use LaravelHyperf\Bus\Queueable;
use LaravelHyperf\Context\ApplicationContext;
use LaravelHyperf\Notifications\ChannelManager;
use LaravelHyperf\Notifications\Channels\MailChannel;
use LaravelHyperf\Notifications\Events\NotificationSending;
use LaravelHyperf\Notifications\Events\NotificationSent;
use LaravelHyperf\Notifications\Notifiable;
use LaravelHyperf\Notifications\Notification;
use LaravelHyperf\Notifications\NotificationPoolProxy;
use LaravelHyperf\Notifications\SendQueuedNotifications;
use LaravelHyperf\Queue\Contracts\ShouldQueue;
use Mockery as m;
use PHPUnit\Framework\TestCase;
use Psr\EventDispatcher\EventDispatcherInterface;

/**
 * @internal
 * @coversNothing
 */
class NotificationChannelManagerTest extends TestCase
{
    protected function tearDown(): void
    {
        m::close();
    }

    public function testGetDefaultChannel()
    {
        $container = $this->getContainer();
        $container->set(MailChannel::class, m::mock(MailChannel::class));

        $manager = new ChannelManager($container);

        $this->assertInstanceOf(MailChannel::class, $manager->channel());
    }

    public function testGetCustomChannelWithPool()
    {
        $container = $this->getContainer();
        $container->set(MailChannel::class, m::mock(MailChannel::class));

        $manager = new ChannelManager($container);
        $manager->extend('test', function () {
            return m::mock('customChannel');
        }, true);

        $this->assertInstanceOf(NotificationPoolProxy::class, $manager->channel('test'));
    }

    public function testNotificationCanBeDispatchedToDriver()
    {
        $container = $this->getContainer();

        $events = $container->get(EventDispatcherInterface::class);

        $manager = m::mock(ChannelManager::class . '[driver]', [$container]);
        $manager->shouldReceive('driver')->andReturn($driver = m::mock());
        $driver->shouldReceive('send')->once();
        $events->shouldReceive('dispatch')->with(m::type(NotificationSending::class))->once();
        $events->shouldReceive('dispatch')->with(m::type(NotificationSent::class))->once();

        $manager->send(new NotificationChannelManagerTestNotifiable(), new NotificationChannelManagerTestNotification());
    }

    public function testNotificationNotSentOnHalt()
    {
        $container = $this->getContainer();

        $events = $container->get(EventDispatcherInterface::class);
        $manager = m::mock(ChannelManager::class . '[driver]', [$container]);
        $events->shouldReceive('dispatch')->once()->with(m::type(NotificationSending::class));
        $manager->shouldReceive('driver')->once()->andReturn($driver = m::mock());
        $driver->shouldReceive('send')->once();
        $events->shouldReceive('dispatch')->once()->with(m::type(NotificationSent::class));

        $manager->send([new NotificationChannelManagerTestNotifiable()], new NotificationChannelManagerTestNotificationWithTwoChannels());
    }

    public function testNotificationNotSentWhenCancelled()
    {
        $container = $this->getContainer();

        $events = $container->get(EventDispatcherInterface::class);
        $manager = m::mock(ChannelManager::class . '[driver]', [$container]);
        $events->shouldReceive('dispatch')->with(m::type(NotificationSending::class));
        $manager->shouldNotReceive('driver');
        $events->shouldNotReceive('dispatch');

        $manager->send([new NotificationChannelManagerTestNotifiable()], new NotificationChannelManagerTestCancelledNotification());
    }

    public function testNotificationSentWhenNotCancelled()
    {
        $container = $this->getContainer();

        $events = $container->get(EventDispatcherInterface::class);
        $manager = m::mock(ChannelManager::class . '[driver]', [$container]);
        $events->shouldReceive('dispatch')->with(m::type(NotificationSending::class));
        $manager->shouldReceive('driver')->once()->andReturn($driver = m::mock());
        $driver->shouldReceive('send')->once();
        $events->shouldReceive('dispatch')->once()->with(m::type(NotificationSent::class));

        $manager->send([new NotificationChannelManagerTestNotifiable()], new NotificationChannelManagerTestNotCancelledNotification());
    }

    public function testNotificationCanBeQueued()
    {
        $container = $this->getContainer();
        $container->get(BusDispatcherContract::class)
            ->shouldReceive('dispatch')
            ->with(m::type(SendQueuedNotifications::class));

        $manager = m::mock(ChannelManager::class . '[driver]', [$container]);

        $manager->send([new NotificationChannelManagerTestNotifiable()], new NotificationChannelManagerTestQueuedNotification());
    }

    protected function getContainer(): Container
    {
        $container = new Container(
            new DefinitionSource([
                ConfigInterface::class => fn () => new Config([]),
                BusDispatcherContract::class => fn () => m::mock(BusDispatcherContract::class),
                EventDispatcherInterface::class => fn () => m::mock(EventDispatcherInterface::class),
            ])
        );

        ApplicationContext::setContainer($container);

        return $container;
    }
}

class NotificationChannelManagerTestNotifiable
{
    use Notifiable;
}

class NotificationChannelManagerTestNotification extends Notification
{
    public function via()
    {
        return ['test'];
    }

    public function message()
    {
        return $this->line('test')->action('Text', 'url');
    }
}

class NotificationChannelManagerTestNotificationWithTwoChannels extends Notification
{
    public static bool $shouldSend = true;

    public function via()
    {
        return ['test', 'test2'];
    }

    public function message()
    {
        return $this->line('test')->action('Text', 'url');
    }

    public function shouldSend($notifiable, $channel): bool
    {
        if (static::$shouldSend) {
            static::$shouldSend = false;
            return true;
        }

        return false;
    }
}

class NotificationChannelManagerTestCancelledNotification extends Notification
{
    public function via()
    {
        return ['test'];
    }

    public function message()
    {
        return $this->line('test')->action('Text', 'url');
    }

    public function shouldSend($notifiable, $channel)
    {
        return false;
    }
}

class NotificationChannelManagerTestNotCancelledNotification extends Notification
{
    public function via()
    {
        return ['test'];
    }

    public function message()
    {
        return $this->line('test')->action('Text', 'url');
    }

    public function shouldSend($notifiable, $channel)
    {
        return true;
    }
}

class NotificationChannelManagerTestQueuedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function via()
    {
        return ['test'];
    }

    public function message()
    {
        return $this->line('test')->action('Text', 'url');
    }
}
