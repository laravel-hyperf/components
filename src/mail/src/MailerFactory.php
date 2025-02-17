<?php

declare(strict_types=1);

namespace LaravelHyperf\Mail;

use LaravelHyperf\Mail\Contracts\Factory;
use LaravelHyperf\Mail\Contracts\Mailer as MailerContract;

class MailerFactory
{
    public function __construct(
        protected Factory $manager
    ) {
    }

    public function __invoke(): MailerContract
    {
        return $this->manager->mailer();
    }
}
