<?php

declare(strict_types=1);

namespace LaravelHyperf\Queue;

use Laravel\SerializableClosure\SerializableClosure;
use LaravelHyperf\Queue\Console\ClearCommand;
use LaravelHyperf\Queue\Console\FlushFailedCommand;
use LaravelHyperf\Queue\Console\ForgetFailedCommand;
use LaravelHyperf\Queue\Console\ListenCommand;
use LaravelHyperf\Queue\Console\ListFailedCommand;
use LaravelHyperf\Queue\Console\MonitorCommand;
use LaravelHyperf\Queue\Console\PruneBatchesCommand;
use LaravelHyperf\Queue\Console\PruneFailedJobsCommand;
use LaravelHyperf\Queue\Console\RestartCommand;
use LaravelHyperf\Queue\Console\RetryBatchCommand;
use LaravelHyperf\Queue\Console\RetryCommand;
use LaravelHyperf\Queue\Console\WorkCommand;
use LaravelHyperf\Queue\Contracts\Factory as FactoryContract;
use LaravelHyperf\Queue\Contracts\Queue;
use LaravelHyperf\Queue\Failed\FailedJobProviderFactory;
use LaravelHyperf\Queue\Failed\FailedJobProviderInterface;
use Psr\Container\ContainerInterface;

class ConfigProvider
{
    public function __invoke(): array
    {
        $this->configureSerializableClosureUses();

        return [
            'dependencies' => [
                FactoryContract::class => QueueManager::class,
                Queue::class => fn (ContainerInterface $container) => $container->get(FactoryContract::class)->connection(),
                FailedJobProviderInterface::class => FailedJobProviderFactory::class,
                Listener::class => fn (ContainerInterface $container) => new Listener($this->getBasePath($container)),
                Worker::class => WorkerFactory::class,
            ],
            'commands' => [
                WorkCommand::class,
                ClearCommand::class,
                FlushFailedCommand::class,
                ForgetFailedCommand::class,
                ListFailedCommand::class,
                ListenCommand::class,
                MonitorCommand::class,
                PruneBatchesCommand::class,
                PruneFailedJobsCommand::class,
                RestartCommand::class,
                RetryBatchCommand::class,
                RetryCommand::class,
            ],
            'publish' => [
                [
                    'id' => 'config',
                    'description' => 'The configuration file of queue.',
                    'source' => __DIR__ . '/../publish/queue.php',
                    'destination' => BASE_PATH . '/config/autoload/queue.php',
                ],
            ],
        ];
    }

    /**
     * Configure serializable closures uses.
     */
    protected function configureSerializableClosureUses(): void
    {
        SerializableClosure::transformUseVariablesUsing(function ($data) {
            foreach ($data as $key => $value) {
                /* @phpstan-ignore-next-line */
                $data[$key] = $this->getSerializedPropertyValue($value);
            }

            return $data;
        });

        SerializableClosure::resolveUseVariablesUsing(function ($data) {
            foreach ($data as $key => $value) {
                /* @phpstan-ignore-next-line */
                $data[$key] = $this->getRestoredPropertyValue($value);
            }

            return $data;
        });
    }

    protected function getBasePath(ContainerInterface $container): string
    {
        return method_exists($container, 'basePath')
            ? $container->basePath()
            : BASE_PATH;
    }
}
