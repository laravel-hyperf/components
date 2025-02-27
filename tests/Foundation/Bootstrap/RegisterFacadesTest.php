<?php

declare(strict_types=1);

namespace LaravelHyperf\Tests\Foundation\Bootstrap;

use Hyperf\Contract\ConfigInterface;
use LaravelHyperf\Foundation\Bootstrap\RegisterFacades;
use LaravelHyperf\Foundation\Support\Composer;
use LaravelHyperf\Tests\Foundation\Concerns\HasMockedApplication;
use LaravelHyperf\Tests\TestCase;
use Mockery as m;

/**
 * @internal
 * @coversNothing
 */
class RegisterFacadesTest extends TestCase
{
    use HasMockedApplication;

    public function testRegisterAliases()
    {
        $config = m::mock(ConfigInterface::class);
        $config->shouldReceive('get')
            ->with('app.aliases', [])
            ->once()
            ->andReturn([
                'FooAlias' => 'FooClass',
            ]);

        $app = $this->getApplication([
            ConfigInterface::class => fn () => $config,
        ]);

        $bootstrapper = $this->createPartialMock(
            RegisterFacades::class,
            ['registerAliases']
        );

        $bootstrapper->expects($this->once())
            ->method('registerAliases')
            ->with([
                'FooAlias' => 'FooClass',
                'TestAlias' => 'TestClass',
            ]);

        Composer::setBasePath(dirname(__DIR__) . '/fixtures/hyperf1');

        $bootstrapper->bootstrap($app);
    }
}
