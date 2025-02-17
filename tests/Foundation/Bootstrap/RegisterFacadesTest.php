<?php

declare(strict_types=1);

namespace LaravelHyperf\Tests\Foundation\Bootstrap;

use Hyperf\Contract\ConfigInterface;
use LaravelHyperf\Foundation\Bootstrap\RegisterFacades;
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
            ['registerAlias']
        );
        $bootstrapper->expects($this->once())
            ->method('registerAlias')
            ->with('FooClass', 'FooAlias');

        $bootstrapper->bootstrap($app);
    }
}
