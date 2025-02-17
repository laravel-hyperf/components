<?php

declare(strict_types=1);

namespace LaravelHyperf\Mail\Contracts;

use DateInterval;
use DateTimeInterface;
use LaravelHyperf\Mail\Contracts\Mailable as MailableContract;

interface MailQueue
{
    /**
     * Queue a new e-mail message for sending.
     */
    public function queue(array|MailableContract|string $view, ?string $queue = null): mixed;

    /**
     * Queue a new e-mail message for sending after (n) seconds.
     */
    public function later(DateInterval|DateTimeInterface|int $delay, array|MailableContract|string $view, ?string $queue = null): mixed;
}
