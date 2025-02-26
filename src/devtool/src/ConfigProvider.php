<?php

declare(strict_types=1);

namespace LaravelHyperf\Devtool;

use Hyperf\Devtool\Generator\GeneratorCommand;
use LaravelHyperf\Devtool\Commands\EventListCommand;
use LaravelHyperf\Devtool\Commands\WatchCommand;
use LaravelHyperf\Devtool\Generator\BatchesTableCommand;
use LaravelHyperf\Devtool\Generator\ChannelCommand;
use LaravelHyperf\Devtool\Generator\ComponentCommand;
use LaravelHyperf\Devtool\Generator\ConsoleCommand;
use LaravelHyperf\Devtool\Generator\EventCommand;
use LaravelHyperf\Devtool\Generator\FactoryCommand;
use LaravelHyperf\Devtool\Generator\JobCommand;
use LaravelHyperf\Devtool\Generator\ListenerCommand;
use LaravelHyperf\Devtool\Generator\ModelCommand;
use LaravelHyperf\Devtool\Generator\NotificationTableCommand;
use LaravelHyperf\Devtool\Generator\ObserverCommand;
use LaravelHyperf\Devtool\Generator\ProviderCommand;
use LaravelHyperf\Devtool\Generator\QueueFailedTableCommand;
use LaravelHyperf\Devtool\Generator\QueueTableCommand;
use LaravelHyperf\Devtool\Generator\RequestCommand;
use LaravelHyperf\Devtool\Generator\RuleCommand;
use LaravelHyperf\Devtool\Generator\SeederCommand;
use LaravelHyperf\Devtool\Generator\SessionTableCommand;
use LaravelHyperf\Devtool\Generator\TestCommand;

class ConfigProvider
{
    public function __invoke(): array
    {
        if (! class_exists(GeneratorCommand::class)) {
            return [];
        }

        return [
            'commands' => [
                WatchCommand::class,
                ProviderCommand::class,
                EventCommand::class,
                ListenerCommand::class,
                ComponentCommand::class,
                TestCommand::class,
                SessionTableCommand::class,
                RuleCommand::class,
                ConsoleCommand::class,
                ModelCommand::class,
                FactoryCommand::class,
                SeederCommand::class,
                EventListCommand::class,
                RequestCommand::class,
                NotificationTableCommand::class,
                BatchesTableCommand::class,
                QueueTableCommand::class,
                QueueFailedTableCommand::class,
                JobCommand::class,
                ChannelCommand::class,
                ObserverCommand::class,
            ],
        ];
    }
}
