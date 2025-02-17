<?php

declare(strict_types=1);

namespace LaravelHyperf\Notifications;

use LaravelHyperf\ObjectPool\PoolProxy;

class NotificationPoolProxy extends PoolProxy
{
    /**
     * Send the given notification..
     */
    public function send(mixed $notifiable, Notification $notification)
    {
        return $this->__call(__FUNCTION__, func_get_args());
    }
}
