<?php

declare(strict_types=1);

namespace LaravelHyperf\Support\Facades;

use LaravelHyperf\Mail\Contracts\Factory as MailFactoryContract;
use LaravelHyperf\Support\Testing\Fakes\MailFake;

/**
 * @method static \LaravelHyperf\Mail\Contracts\Mailer mailer(string|null $name = null)
 * @method static \LaravelHyperf\Mail\Contracts\Mailer driver(string|null $driver = null)
 * @method static \Symfony\Component\Mailer\Transport\TransportInterface createSymfonyTransport(array $config, string|null $poolName = null)
 * @method static string getDefaultDriver()
 * @method static void setDefaultDriver(string $name)
 * @method static void purge(string|null $name = null)
 * @method static \LaravelHyperf\Mail\MailManager extend(string $driver, \Closure $callback, bool $poolable = false)
 * @method static \Psr\Container\ContainerInterface getApplication()
 * @method static \LaravelHyperf\Mail\MailManager setApplication(\Psr\Container\ContainerInterface $app)
 * @method static \LaravelHyperf\Mail\MailManager forgetMailers()
 * @method static \LaravelHyperf\Mail\MailManager setReleaseCallback(string $driver, \Closure $callback)
 * @method static \Closure|null getReleaseCallback(string $driver)
 * @method static \LaravelHyperf\Mail\MailManager addPoolable(string $driver)
 * @method static \LaravelHyperf\Mail\MailManager removePoolable(string $driver)
 * @method static array getPoolables()
 * @method static \LaravelHyperf\Mail\MailManager setPoolables(array $poolables)
 * @method static \LaravelHyperf\Mail\PendingMail to(mixed $users)
 * @method static \LaravelHyperf\Mail\PendingMail bcc(mixed $users)
 * @method static \LaravelHyperf\Mail\SentMessage|null raw(string $text, mixed $callback)
 * @method static \LaravelHyperf\Mail\SentMessage|null send(\LaravelHyperf\Mail\Contracts\Mailable|array|string $view, array $data = [], \Closure|string|null $callback = null)
 * @method static \LaravelHyperf\Mail\SentMessage|null sendNow(\LaravelHyperf\Mail\Contracts\Mailable|array|string $mailable, array $data = [], \Closure|string|null $callback = null)
 * @method static void assertSent(\Closure|string $mailable, callable|array|string|int|null $callback = null)
 * @method static void assertNotOutgoing(\Closure|string $mailable, callable|null $callback = null)
 * @method static void assertNotSent(\Closure|string $mailable, callable|array|string|null $callback = null)
 * @method static void assertNothingOutgoing()
 * @method static void assertNothingSent()
 * @method static void assertQueued(\Closure|string $mailable, callable|array|string|int|null $callback = null)
 * @method static void assertNotQueued(\Closure|string $mailable, callable|array|string|null $callback = null)
 * @method static void assertNothingQueued()
 * @method static void assertSentCount(int $count)
 * @method static void assertQueuedCount(int $count)
 * @method static void assertOutgoingCount(int $count)
 * @method static \Hyperf\Collection\Collection sent(\Closure|string $mailable, callable|null $callback = null)
 * @method static bool hasSent(string $mailable)
 * @method static \Hyperf\Collection\Collection queued(\Closure|string $mailable, callable|null $callback = null)
 * @method static bool hasQueued(string $mailable)
 * @method static \LaravelHyperf\Mail\PendingMail cc(mixed $users)
 * @method static mixed queue(\LaravelHyperf\Mail\Contracts\Mailable|array|string $view, string|null $queue = null)
 * @method static mixed later(\DateInterval|\DateTimeInterface|int $delay, \LaravelHyperf\Mail\Contracts\Mailable|array|string $view, string|null $queue = null)
 *
 * @see \LaravelHyperf\Mail\MailManager
 * @see \LaravelHyperf\Support\Testing\Fakes\MailFake
 */
class Mail extends Facade
{
    /**
     * Replace the bound instance with a fake.
     */
    public static function fake(): MailFake
    {
        $actualMailManager = static::isFake()
            ? static::getFacadeRoot()->manager
            : static::getFacadeRoot();

        return tap(new MailFake($actualMailManager), function ($fake) {
            static::swap($fake);
        });
    }

    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor()
    {
        return MailFactoryContract::class;
    }
}
