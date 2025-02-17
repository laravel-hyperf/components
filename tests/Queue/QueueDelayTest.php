<?php

declare(strict_types=1);

namespace LaravelHyperf\Tests\Queue;

use Hyperf\Context\ApplicationContext;
use Hyperf\Di\Container;
use Hyperf\Di\Definition\DefinitionSource;
use LaravelHyperf\Bus\Contracts\Dispatcher;
use LaravelHyperf\Bus\PendingDispatch;
use LaravelHyperf\Bus\Queueable;
use LaravelHyperf\Queue\Contracts\ShouldQueue;
use Mockery;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
class QueueDelayTest extends TestCase
{
    public function testQueueDelay()
    {
        $this->mockContainer();

        new PendingDispatch($job = new TestJob());

        $this->assertEquals(60, $job->delay);
    }

    public function testQueueWithoutDelay()
    {
        $this->mockContainer();

        $job = new TestJob();

        dispatch($job->withoutDelay());

        $this->assertEquals(0, $job->delay);
    }

    public function testPendingDispatchWithoutDelay()
    {
        $this->mockContainer();

        $job = new TestJob();

        dispatch($job)->withoutDelay();

        $this->assertEquals(0, $job->delay);
    }

    protected function mockContainer(): void
    {
        $event = Mockery::mock(Dispatcher::class);
        $event->shouldReceive('dispatch');
        $container = new Container(
            new DefinitionSource([
                Dispatcher::class => fn () => $event,
            ])
        );

        ApplicationContext::setContainer($container);
    }
}

class TestJob implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
        $this->delay(60);
    }
}
