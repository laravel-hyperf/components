<?php

declare(strict_types=1);

namespace LaravelHyperf\Tests\Foundation\Bootstrap;

use Hyperf\Di\MethodDefinitionCollector;
use Hyperf\Di\MethodDefinitionCollectorInterface;
use LaravelHyperf\Foundation\Bootstrap\BootProviders;
use LaravelHyperf\Support\ServiceProvider;
use LaravelHyperf\Tests\Foundation\Concerns\HasMockedApplication;
use LaravelHyperf\Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class BootProvidersTest extends TestCase
{
    use HasMockedApplication;

    public function testBoot()
    {
        $app = $this->getApplication([
            MethodDefinitionCollectorInterface::class => MethodDefinitionCollector::class,
        ]);
        $app->register(ApplicationBasicServiceProviderStub::class);

        (new BootProviders())->bootstrap($app);

        $this->assertSame('bar', $app->get('foo'));
    }
}

class ApplicationBasicServiceProviderStub extends ServiceProvider
{
    public function boot()
    {
        $this->app->bind('foo', fn () => 'bar');
    }
}
