<?php

declare(strict_types=1);

namespace LaravelHyperf\Tests\Queue;

use LaravelHyperf\Bus\Contracts\BatchRepository;
use LaravelHyperf\Bus\DatabaseBatchRepository;
use LaravelHyperf\Queue\Console\PruneBatchesCommand;
use LaravelHyperf\Tests\Foundation\Testing\ApplicationTestCase;
use Mockery as m;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;

/**
 * @internal
 * @coversNothing
 */
class PruneBatchesCommandTest extends ApplicationTestCase
{
    protected function tearDown(): void
    {
        m::close();

        parent::tearDown();
    }

    public function testAllowPruningAllUnfinishedBatches()
    {
        $repo = m::mock(DatabaseBatchRepository::class);
        $repo->shouldReceive('prune')->once();
        $repo->shouldReceive('pruneUnfinished')->once();

        $this->app->set(BatchRepository::class, $repo);

        $command = new PruneBatchesCommand();

        $command->run(new ArrayInput(['--unfinished' => 0]), new NullOutput());
    }

    public function testAllowPruningAllCancelledBatches()
    {
        $repo = m::mock(DatabaseBatchRepository::class);
        $repo->shouldReceive('prune')->once();
        $repo->shouldReceive('pruneCancelled')->once();

        $this->app->set(BatchRepository::class, $repo);

        $command = new PruneBatchesCommand();

        $command->run(new ArrayInput(['--cancelled' => 0]), new NullOutput());

        $repo->shouldHaveReceived('pruneCancelled')->once();
    }
}
