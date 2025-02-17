<?php

declare(strict_types=1);

namespace LaravelHyperf\Support\Facades;

use LaravelHyperf\Notifications\AnonymousNotifiable;
use LaravelHyperf\Notifications\Contracts\Dispatcher as NotificationDispatcher;
use LaravelHyperf\Support\Testing\Fakes\NotificationFake;

use function Hyperf\Tappable\tap;

/**
 * @method static void send(\Hyperf\Collection\Collection|array|mixed $notifiables, mixed $notification)
 * @method static void sendNow(\Hyperf\Collection\Collection|array|mixed $notifiables, mixed $notification, array|null $channels = null)
 * @method static mixed channel(string|null $name = null)
 * @method static string getDefaultDriver()
 * @method static string deliversVia()
 * @method static void deliverVia(string $channel)
 * @method static \LaravelHyperf\Notifications\ChannelManager locale(string $locale)
 * @method static mixed driver(string|null $driver = null)
 * @method static \LaravelHyperf\Notifications\ChannelManager extend(string $driver, \Closure $callback)
 * @method static array getDrivers()
 * @method static \Psr\Container\ContainerInterface getContainer()
 * @method static \LaravelHyperf\Notifications\ChannelManager setContainer(\Psr\Container\ContainerInterface $container)
 * @method static \LaravelHyperf\Notifications\ChannelManager forgetDrivers()
 * @method static void assertSentOnDemand(string|\Closure $notification, callable|null $callback = null)
 * @method static void assertSentTo(mixed $notifiable, string|\Closure $notification, callable|null $callback = null)
 * @method static void assertSentOnDemandTimes(string $notification, int $times = 1)
 * @method static void assertSentToTimes(mixed $notifiable, string $notification, int $times = 1)
 * @method static void assertNotSentTo(mixed $notifiable, string|\Closure $notification, callable|null $callback = null)
 * @method static void assertNothingSent()
 * @method static void assertNothingSentTo(mixed $notifiable)
 * @method static void assertSentTimes(string $notification, int $expectedCount)
 * @method static void assertCount(int $expectedCount)
 * @method static \Hyperf\Collection\Collection sent(mixed $notifiable, string $notification, callable|null $callback = null)
 * @method static bool hasSent(mixed $notifiable, string $notification)
 * @method static array sentNotifications()
 *
 * @see \LaravelHyperf\Notifications\ChannelManager
 * @see \LaravelHyperf\Support\Testing\Fakes\NotificationFake
 */
class Notification extends Facade
{
    /**
     * Replace the bound instance with a fake.
     */
    public static function fake(): NotificationFake
    {
        return tap(new NotificationFake(), function ($fake) {
            static::swap($fake);
        });
    }

    /**
     * Begin sending a notification to an anonymous notifiable on the given channels.
     */
    public static function routes(array $channels): AnonymousNotifiable
    {
        $notifiable = new AnonymousNotifiable();

        foreach ($channels as $channel => $route) {
            $notifiable->route($channel, $route);
        }

        return $notifiable;
    }

    /**
     * Begin sending a notification to an anonymous notifiable.
     */
    public static function route(string $channel, mixed $route): AnonymousNotifiable
    {
        return (new AnonymousNotifiable())->route($channel, $route);
    }

    protected static function getFacadeAccessor()
    {
        return NotificationDispatcher::class;
    }
}
