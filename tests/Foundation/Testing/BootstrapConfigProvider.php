<?php

declare(strict_types=1);

namespace LaravelHyperf\Tests\Foundation\Testing;

class BootstrapConfigProvider
{
    protected static $configProviders = [
        \Hyperf\Command\ConfigProvider::class,
        \Hyperf\Database\SQLite\ConfigProvider::class,
        \Hyperf\DbConnection\ConfigProvider::class,
        \Hyperf\Di\ConfigProvider::class,
        \Hyperf\Dispatcher\ConfigProvider::class,
        \Hyperf\Engine\ConfigProvider::class,
        \Hyperf\Event\ConfigProvider::class,
        \Hyperf\ExceptionHandler\ConfigProvider::class,
        \Hyperf\Framework\ConfigProvider::class,
        \Hyperf\HttpMessage\ConfigProvider::class,
        \Hyperf\HttpServer\ConfigProvider::class,
        \Hyperf\Memory\ConfigProvider::class,
        \Hyperf\ModelListener\ConfigProvider::class,
        \Hyperf\Paginator\ConfigProvider::class,
        \Hyperf\Pool\ConfigProvider::class,
        \Hyperf\Process\ConfigProvider::class,
        \Hyperf\Redis\ConfigProvider::class,
        \Hyperf\Serializer\ConfigProvider::class,
        \Hyperf\Server\ConfigProvider::class,
        \Hyperf\Signal\ConfigProvider::class,
        \Hyperf\Translation\ConfigProvider::class,
        \Hyperf\Validation\ConfigProvider::class,
        \LaravelHyperf\ConfigProvider::class,
        \LaravelHyperf\Auth\ConfigProvider::class,
        \LaravelHyperf\Broadcasting\ConfigProvider::class,
        \LaravelHyperf\Bus\ConfigProvider::class,
        \LaravelHyperf\Cache\ConfigProvider::class,
        \LaravelHyperf\Cookie\ConfigProvider::class,
        \LaravelHyperf\Config\ConfigProvider::class,
        \LaravelHyperf\Dispatcher\ConfigProvider::class,
        \LaravelHyperf\Encryption\ConfigProvider::class,
        \LaravelHyperf\Event\ConfigProvider::class,
        \LaravelHyperf\Foundation\ConfigProvider::class,
        \LaravelHyperf\Hashing\ConfigProvider::class,
        \LaravelHyperf\Http\ConfigProvider::class,
        \LaravelHyperf\JWT\ConfigProvider::class,
        \LaravelHyperf\Log\ConfigProvider::class,
        \LaravelHyperf\Mail\ConfigProvider::class,
        \LaravelHyperf\Notifications\ConfigProvider::class,
        \LaravelHyperf\Queue\ConfigProvider::class,
        \LaravelHyperf\Router\ConfigProvider::class,
        \LaravelHyperf\Scheduling\ConfigProvider::class,
        \LaravelHyperf\Session\ConfigProvider::class,
    ];

    public static function get(): array
    {
        if (class_exists($devtoolClass = \Hyperf\Devtool\ConfigProvider::class)) {
            return array_merge(self::$configProviders, [$devtoolClass]);
        }

        return self::$configProviders;
    }
}
