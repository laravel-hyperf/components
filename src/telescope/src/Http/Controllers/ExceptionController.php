<?php

declare(strict_types=1);

namespace LaravelHyperf\Telescope\Http\Controllers;

use LaravelHyperf\Http\Request;
use LaravelHyperf\Support\Carbon;
use LaravelHyperf\Telescope\Contracts\EntriesRepository;
use LaravelHyperf\Telescope\EntryType;
use LaravelHyperf\Telescope\EntryUpdate;
use LaravelHyperf\Telescope\Storage\EntryQueryOptions;
use LaravelHyperf\Telescope\Watchers\ExceptionWatcher;

class ExceptionController extends EntryController
{
    /**
     * The entry type for the controller.
     */
    protected function entryType(): string
    {
        return EntryType::EXCEPTION;
    }

    /**
     * The watcher class for the controller.
     */
    protected function watcher(): string
    {
        return ExceptionWatcher::class;
    }

    /**
     * Update an entry with the given ID.
     */
    public function update(EntriesRepository $storage, Request $request, string $id): array
    {
        $entry = $storage->find($id);

        if ($request->input('resolved_at') === 'now') {
            $update = new EntryUpdate($entry->id, $entry->type, [
                'resolved_at' => Carbon::now()->toDateTimeString(),
            ]);

            $storage->update(collect([$update]));

            // Reload entry
            $entry = $storage->find($id);
        }

        return [
            'entry' => $entry,
            'batch' => $storage->get(null, EntryQueryOptions::forBatchId($entry->batchId)->limit(-1)),
        ];
    }
}
