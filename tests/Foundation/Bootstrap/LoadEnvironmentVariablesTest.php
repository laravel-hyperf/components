<?php

declare(strict_types=1);

namespace LaravelHyperf\Tests\Foundation\Bootstrap;

use LaravelHyperf\Foundation\Bootstrap\LoadEnvironmentVariables;
use LaravelHyperf\Tests\Foundation\Concerns\HasMockedApplication;
use LaravelHyperf\Tests\TestCase;
use Mockery;

/**
 * @internal
 * @coversNothing
 */
class LoadEnvironmentVariablesTest extends TestCase
{
    use HasMockedApplication;

    public function testBoot()
    {
        $app = $this->getApplication(
            [],
            dirname(__DIR__) . '/fixtures/hyperf'
        );

        $mock = Mockery::mock(LoadEnvironmentVariables::class)
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();
        $mock->shouldReceive('loadDotenv')
            ->with($app)
            ->once();

        $mock->bootstrap($app);
    }
}
