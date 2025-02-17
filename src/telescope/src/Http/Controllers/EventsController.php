<?php

declare(strict_types=1);

namespace LaravelHyperf\Telescope\Http\Controllers;

use LaravelHyperf\Telescope\EntryType;
use LaravelHyperf\Telescope\Watchers\EventWatcher;

class EventsController extends EntryController
{
    /**
     * The entry type for the controller.
     */
    protected function entryType(): string
    {
        return EntryType::EVENT;
    }

    /**
     * The watcher class for the controller.
     */
    protected function watcher(): string
    {
        return EventWatcher::class;
    }
}
