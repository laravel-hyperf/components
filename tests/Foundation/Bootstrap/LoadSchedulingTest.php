<?php

declare(strict_types=1);

namespace LaravelHyperf\Tests\Foundation\Bootstrap;

use Exception;
use Hyperf\Contract\ConfigInterface;
use Hyperf\Crontab\Crontab;
use Hyperf\Crontab\CrontabManager;
use Hyperf\Crontab\Parser;
use LaravelHyperf\Foundation\Bootstrap\LoadScheduling;
use LaravelHyperf\Foundation\Console\Contracts\Kernel as KernelContract;
use LaravelHyperf\Foundation\Console\Contracts\Schedule as ScheduleContract;
use LaravelHyperf\Foundation\Console\Scheduling\Schedule;
use LaravelHyperf\Tests\Foundation\Concerns\HasMockedApplication;
use LaravelHyperf\Tests\TestCase;
use Mockery as m;

/**
 * @internal
 * @coversNothing
 */
class LoadSchedulingTest extends TestCase
{
    use HasMockedApplication;

    public function testSkipWhenKernelIsNotBound()
    {
        $app = $this->getApplication([
            ConfigInterface::class => fn () => throw new Exception('Should not be called'),
        ]);

        (new LoadScheduling())->bootstrap($app);

        $this->assertTrue(true);
    }

    public function testRegisterCrontabs()
    {
        $config = m::mock(ConfigInterface::class);
        $config->shouldReceive('get')
            ->with('app.env')
            ->once()
            ->andReturn('testing');
        $config->shouldReceive('set')
            ->with('crontab.enable', true)
            ->once();

        $parser = m::mock(Parser::class);
        $parser->shouldReceive('isValid')
            ->with('* * * * *')
            ->once()
            ->andReturn(true);

        $crontabManager = m::mock(CrontabManager::class);
        $crontabManager->shouldReceive('register')
            ->with($crontab = $this->getCrontab())
            ->once();

        $schedule = m::mock(Schedule::class);
        $schedule->shouldReceive('getCrontabs')
            ->once()
            ->andReturn([$crontab]);

        $kernel = m::mock(KernelContract::class);
        $kernel->shouldReceive('schedule')
            ->with($schedule)
            ->once();

        $app = $this->getApplication([
            ConfigInterface::class => fn () => $config,
            CrontabManager::class => fn () => $crontabManager,
            Parser::class => fn () => $parser,
            KernelContract::class => fn () => $kernel,
            ScheduleContract::class => fn () => $schedule,
        ]);

        (new LoadScheduling())->bootstrap($app);
    }

    protected function getCrontab(bool $isEnable = true, string $name = 'test-command', string $rule = '* * * * *'): Crontab
    {
        $crontab = m::mock(Crontab::class);
        $crontab->shouldReceive('isEnable')
            ->once()
            ->andReturn($isEnable);
        $crontab->shouldReceive('runsInEnvironment')
            ->once()
            ->with('testing')
            ->andReturn(true);
        $crontab->shouldReceive('getName')
            ->once()
            ->andReturn($name);
        $crontab->shouldReceive('getRule')
            ->once()
            ->andReturn($rule);
        $crontab->shouldReceive('getCallback')
            ->once()
            ->andReturn(fn () => 'callback');

        return $crontab;
    }
}
