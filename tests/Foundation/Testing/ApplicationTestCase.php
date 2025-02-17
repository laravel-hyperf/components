<?php

declare(strict_types=1);

namespace LaravelHyperf\Tests\Foundation\Testing;

use Hyperf\Context\ApplicationContext;
use Hyperf\Coordinator\Constants;
use Hyperf\Coordinator\CoordinatorManager;
use Hyperf\Di\ClassLoader;
use Hyperf\Support\Filesystem\Filesystem;
use LaravelHyperf\Foundation\Application;
use LaravelHyperf\Foundation\Console\Contracts\Kernel as KernelContract;
use LaravelHyperf\Foundation\Console\Kernel as ConsoleKernel;
use LaravelHyperf\Foundation\Contracts\Application as ApplicationContract;
use LaravelHyperf\Foundation\Testing\TestCase;
use LaravelHyperf\Foundation\Testing\TestScanHandler;
use Swoole\Timer;

/**
 * @internal
 * @coversNothing
 */
class ApplicationTestCase extends TestCase
{
    protected static $hasBootstrappedApplication = false;

    protected function setUp(): void
    {
        if (! static::$hasBootstrappedApplication) {
            $this->bootstrapApplication();
            static::$hasBootstrappedApplication = true;
        }

        $this->afterApplicationCreated(function () {
            Timer::clearAll();
            CoordinatorManager::until(Constants::WORKER_EXIT)->resume();
        });

        parent::setUp();
    }

    protected function bootstrapApplication(): void
    {
        ! defined('BASE_PATH') && define('BASE_PATH', dirname(__DIR__, 3) . '/tests/Foundation/fixtures/hyperf');
        ! defined('SWOOLE_HOOK_FLAGS') && define('SWOOLE_HOOK_FLAGS', SWOOLE_HOOK_ALL);

        $this->generateComposerLock();

        ClassLoader::init(null, null, new TestScanHandler());
    }

    protected function createApplication(): ApplicationContract
    {
        $app = new Application();
        $app->define(KernelContract::class, ConsoleKernel::class);

        ApplicationContext::setContainer($app);

        return $app;
    }

    protected function generateComposerLock(): void
    {
        $content = [
            'packages' => [
                [
                    'name' => 'hyperf-testing',
                    'extra' => [
                        'hyperf' => [
                            'config' => BootstrapConfigProvider::get(),
                        ],
                    ],
                ],
            ],
            'packages-dev' => [],
        ];

        (new Filesystem())->replace(
            BASE_PATH . '/composer.lock',
            json_encode($content, JSON_PRETTY_PRINT)
        );
    }
}
