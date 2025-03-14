<?php

declare(strict_types=1);

namespace LaravelHyperf\Tests\Scheduling;

use LaravelHyperf\Container\Container;
use LaravelHyperf\Queue\Contracts\ShouldQueue;
use LaravelHyperf\Scheduling\Contracts\EventMutex;
use LaravelHyperf\Scheduling\Contracts\SchedulingMutex;
use LaravelHyperf\Scheduling\Schedule;
use LaravelHyperf\Tests\Foundation\Concerns\HasMockedApplication;
use Mockery as m;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
class ScheduleTest extends TestCase
{
    use HasMockedApplication;

    protected Container $container;

    protected EventMutex&MockInterface $eventMutex;

    protected MockInterface&SchedulingMutex $schedulingMutex;

    protected function setUp(): void
    {
        parent::setUp();

        $this->container = $this->getApplication();
        Container::setInstance($this->container);
        $this->eventMutex = m::mock(EventMutex::class);
        $this->container->instance(EventMutex::class, $this->eventMutex);
        $this->schedulingMutex = m::mock(SchedulingMutex::class);
        $this->container->instance(SchedulingMutex::class, $this->schedulingMutex);
    }

    #[DataProvider('jobHonoursDisplayNameIfMethodExistsProvider')]
    public function testJobHonoursDisplayNameIfMethodExists(object $job, string $jobName): void
    {
        $schedule = new Schedule();
        $scheduledJob = $schedule->job($job);
        self::assertSame($jobName, $scheduledJob->description);
        self::assertFalse($this->container->resolved(JobToTestWithSchedule::class));
    }

    public static function jobHonoursDisplayNameIfMethodExistsProvider(): array
    {
        $job = new class implements ShouldQueue {
            public function displayName(): string
            {
                return 'testJob-123';
            }
        };

        return [
            [new JobToTestWithSchedule(), JobToTestWithSchedule::class],
            [$job, 'testJob-123'],
        ];
    }

    public function testJobIsNotInstantiatedIfSuppliedAsClassname(): void
    {
        $schedule = new Schedule();
        $scheduledJob = $schedule->job(JobToTestWithSchedule::class);
        self::assertSame(JobToTestWithSchedule::class, $scheduledJob->description);
        self::assertFalse($this->container->resolved(JobToTestWithSchedule::class));
    }
}

class JobToTestWithSchedule implements ShouldQueue
{
}
