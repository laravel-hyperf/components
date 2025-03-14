<?php

declare(strict_types=1);

namespace LaravelHyperf\Foundation;

use Hyperf\Contract\ApplicationInterface;
use Hyperf\Coordinator\Listener\ResumeExitCoordinatorListener;
use Hyperf\ExceptionHandler\Listener\ErrorExceptionHandler;
use LaravelHyperf\Foundation\Console\ApplicationFactory;
use LaravelHyperf\Foundation\Console\Commands\ServerReloadCommand;
use LaravelHyperf\Foundation\Console\Commands\VendorPublishCommand;
use LaravelHyperf\Foundation\Exceptions\Contracts\ExceptionHandler as ExceptionHandlerContract;
use LaravelHyperf\Foundation\Exceptions\Handler as ExceptionHandler;
use LaravelHyperf\Foundation\Listeners\ReloadDotenvAndConfig;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => [
                ApplicationInterface::class => ApplicationFactory::class,
                ExceptionHandlerContract::class => ExceptionHandler::class,
            ],
            'listeners' => [
                ErrorExceptionHandler::class,
                ResumeExitCoordinatorListener::class,
                ReloadDotenvAndConfig::class,
            ],
            'commands' => [
                ServerReloadCommand::class,
                VendorPublishCommand::class,
            ],
            'publish' => [
                [
                    'id' => 'config',
                    'description' => 'The configuration file of foundation.',
                    'source' => __DIR__ . '/../publish/app.php',
                    'destination' => BASE_PATH . '/config/autoload/app.php',
                ],
            ],
        ];
    }
}
