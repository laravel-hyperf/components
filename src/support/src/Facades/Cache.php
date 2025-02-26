<?php

declare(strict_types=1);

namespace LaravelHyperf\Support\Facades;

use LaravelHyperf\Cache\Contracts\Factory;
use LaravelHyperf\Cache\Contracts\Store;
use LaravelHyperf\Cache\Repository;

/**
 * @method static \LaravelHyperf\Cache\Contracts\Repository store(string|null $name = null)
 * @method static \LaravelHyperf\Cache\Contracts\Repository driver(string|null $driver = null)
 * @method static \LaravelHyperf\Cache\Repository repository(\LaravelHyperf\Cache\Contracts\Store $store)
 * @method static void refreshEventDispatcher()
 * @method static string getDefaultDriver()
 * @method static void setDefaultDriver(string $name)
 * @method static \LaravelHyperf\Cache\CacheManager forgetDriver(array|string|null $name = null)
 * @method static void purge(string|null $name = null)
 * @method static \LaravelHyperf\Cache\CacheManager extend(string $driver, \Closure $callback)
 * @method static \LaravelHyperf\Cache\CacheManager setApplication(\Psr\Container\ContainerInterface $app)
 * @method static mixed pull(string $key, \Closure|mixed $default = null)
 * @method static bool put(array|string $key, mixed $value, \DateInterval|\DateTimeInterface|int|null $ttl = null)
 * @method static bool add(string $key, mixed $value, \DateInterval|\DateTimeInterface|int|null $ttl = null)
 * @method static int|bool increment(string $key, int $value = 1)
 * @method static int|bool decrement(string $key, int $value = 1)
 * @method static bool forever(string $key, mixed $value)
 * @method static mixed remember(string $key, \DateInterval|\DateTimeInterface|int|null $ttl, \Closure $callback)
 * @method static mixed sear(string $key, \Closure $callback)
 * @method static mixed rememberForever(string $key, \Closure $callback)
 * @method static bool forget(string $key)
 * @method static \LaravelHyperf\Cache\Contracts\Store getStore()
 * @method static mixed get(string $key, mixed $default = null)
 * @method static bool set(string $key, mixed $value, null|int|\DateInterval $ttl = null)
 * @method static bool delete(string $key)
 * @method static bool clear()
 * @method static iterable getMultiple(iterable $keys, mixed $default = null)
 * @method static bool setMultiple(iterable $values, null|int|\DateInterval $ttl = null)
 * @method static bool deleteMultiple(iterable $keys)
 * @method static bool has(string $key)
 * @method static \LaravelHyperf\Cache\TaggedCache tags(mixed $names)
 * @method static array many(array $keys)
 * @method static bool putMany(array $values, int $seconds)
 * @method static bool flush()
 * @method static string getPrefix()
 *
 * @see \LaravelHyperf\Cache\CacheManager
 *
 * @mixin \LaravelHyperf\Cache\Repository
 */
class Cache extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Factory::class;
    }
}
