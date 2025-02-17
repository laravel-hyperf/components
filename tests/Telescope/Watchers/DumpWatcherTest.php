<?php

declare(strict_types=1);

namespace LaravelHyperf\Tests\Telescope\Watchers;

use Hyperf\Contract\ConfigInterface;
use LaravelHyperf\Telescope\EntryType;
use LaravelHyperf\Telescope\Watchers\DumpWatcher;
use LaravelHyperf\Tests\Telescope\FeatureTestCase;

/**
 * @internal
 * @coversNothing
 */
class DumpWatcherTest extends FeatureTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->app->get(ConfigInterface::class)
            ->set('telescope.watchers', [
                DumpWatcher::class => true,
            ]);

        $this->startTelescope();
    }

    public function testDumpWatcherRegisterEntry()
    {
        dump($var = 'Telescopes are better than binoculars');

        $entry = $this->loadTelescopeEntries()->first();

        $this->assertSame(EntryType::DUMP, $entry->type);
        $this->assertStringContainsString($var, $entry->content['dump']);
    }
}
