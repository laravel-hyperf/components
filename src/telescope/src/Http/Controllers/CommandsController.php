<?php

declare(strict_types=1);

namespace LaravelHyperf\Telescope\Http\Controllers;

use LaravelHyperf\Telescope\EntryType;
use LaravelHyperf\Telescope\Watchers\CommandWatcher;

class CommandsController extends EntryController
{
    /**
     * The entry type for the controller.
     */
    protected function entryType(): string
    {
        return EntryType::COMMAND;
    }

    /**
     * The watcher class for the controller.
     */
    protected function watcher(): string
    {
        return CommandWatcher::class;
    }
}
