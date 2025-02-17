<?php

declare(strict_types=1);

namespace LaravelHyperf\Support\Facades;

use LaravelHyperf\Broadcasting\Contracts\Factory as BroadcastingFactoryContract;

/**
 * @method static void routes(array|null $attributes = null)
 * @method static void userRoutes(array|null $attributes = null)
 * @method static void channelRoutes(array|null $attributes = null)
 * @method static string|null socket(\Hyperf\HttpServer\Contract\RequestInterface|null $request = null)
 * @method static \LaravelHyperf\Broadcasting\AnonymousEvent on(\LaravelHyperf\Broadcasting\Channel|array|string $channels)
 * @method static \LaravelHyperf\Broadcasting\AnonymousEvent private(string $channel)
 * @method static \LaravelHyperf\Broadcasting\AnonymousEvent presence(string $channel)
 * @method static \LaravelHyperf\Broadcasting\PendingBroadcast event(mixed|null $event = null)
 * @method static void queue(mixed $event)
 * @method static \LaravelHyperf\Broadcasting\Contracts\Broadcaster connection(string|null $driver = null)
 * @method static \LaravelHyperf\Broadcasting\Contracts\Broadcaster driver(string|null $name = null)
 * @method static \Pusher\Pusher pusher(array $config)
 * @method static \Ably\AblyRest ably(array $config)
 * @method static string getDefaultDriver()
 * @method static void setDefaultDriver(string $name)
 * @method static void purge(string|null $name = null)
 * @method static \LaravelHyperf\Broadcasting\BroadcastManager extend(string $driver, \Closure $callback)
 * @method static \Psr\Container\ContainerInterface getApplication()
 * @method static \LaravelHyperf\Broadcasting\BroadcastManager setApplication(\Psr\Container\ContainerInterface $app)
 * @method static \LaravelHyperf\Broadcasting\BroadcastManager forgetDrivers()
 * @method static mixed auth(\Hyperf\HttpServer\Contract\RequestInterface $request)
 * @method static mixed validAuthenticationResponse(\Hyperf\HttpServer\Contract\RequestInterface $request, mixed $result)
 * @method static void broadcast(array $channels, string $event, array $payload = [])
 * @method static array|null resolveAuthenticatedUser(\Hyperf\HttpServer\Contract\RequestInterface $request)
 * @method static void resolveAuthenticatedUserUsing(\Closure $callback)
 * @method static \LaravelHyperf\Broadcasting\Broadcasters\Broadcaster channel(\Illuminate\Contracts\Broadcasting\HasBroadcastChannel|string $channel, callable|string $callback, array $options = [])
 * @method static \Hyperf\Collection\Collection getChannels()
 *
 * @see \LaravelHyperf\Broadcasting\BroadcastManager
 * @see \LaravelHyperf\Broadcasting\Broadcasters\Broadcaster
 */
class Broadcast extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return BroadcastingFactoryContract::class;
    }
}
