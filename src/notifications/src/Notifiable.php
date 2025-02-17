<?php

declare(strict_types=1);

namespace LaravelHyperf\Notifications;

trait Notifiable
{
    use HasDatabaseNotifications;
    use RoutesNotifications;
}
