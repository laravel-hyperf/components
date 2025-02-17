<?php

declare(strict_types=1);

namespace LaravelHyperf\Notifications;

use LaravelHyperf\Notifications\Contracts\Dispatcher as NotificationDispatcher;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => [
                NotificationDispatcher::class => ChannelManager::class,
            ],
            'publish' => [
                [
                    'id' => 'resources',
                    'description' => 'The resources for notifications.',
                    'source' => __DIR__ . '/../publish/resources/views/',
                    'destination' => BASE_PATH . '/storage/view/notifications/',
                ],
            ],
        ];
    }
}
