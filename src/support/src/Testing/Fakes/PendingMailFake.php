<?php

declare(strict_types=1);

namespace LaravelHyperf\Support\Testing\Fakes;

use LaravelHyperf\Mail\Contracts\Mailable;
use LaravelHyperf\Mail\PendingMail;
use LaravelHyperf\Mail\SentMessage;

class PendingMailFake extends PendingMail
{
    /**
     * Send a new mailable message instance.
     */
    public function send(Mailable $mailable): ?SentMessage
    {
        $this->mailer->send($this->fill($mailable));

        return null;
    }

    /**
     * Send a new mailable message instance synchronously.
     */
    public function sendNow(Mailable $mailable): ?SentMessage
    {
        return $this->send($mailable);
    }
}
