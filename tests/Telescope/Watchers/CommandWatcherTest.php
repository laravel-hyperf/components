<?php

declare(strict_types=1);

namespace LaravelHyperf\Tests\Telescope\Watchers;

use Hyperf\Contract\ConfigInterface;
use LaravelHyperf\Foundation\Console\Command;
use LaravelHyperf\Foundation\Console\Contracts\Kernel as KernelContract;
use LaravelHyperf\Telescope\EntryType;
use LaravelHyperf\Telescope\Watchers\CommandWatcher;
use LaravelHyperf\Tests\Telescope\FeatureTestCase;

/**
 * @internal
 * @coversNothing
 */
class CommandWatcherTest extends FeatureTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->app->get(ConfigInterface::class)
            ->set('telescope.watchers', [
                CommandWatcher::class => true,
            ]);

        $this->startTelescope();
    }

    public function testCommandWatcherRegisterEntry()
    {
        $this->app->get(KernelContract::class)
            ->registerCommand(MyCommand::class);

        $this->app->get(KernelContract::class)
            ->call('telescope:test-command');

        $entry = $this->loadTelescopeEntries()->first();

        $this->assertSame(EntryType::COMMAND, $entry->type);
        $this->assertSame('telescope:test-command', $entry->content['command']);
        $this->assertSame(0, $entry->content['exit_code']);
    }
}

class MyCommand extends Command
{
    protected ?string $signature = 'telescope:test-command';

    public function handle()
    {
    }
}
