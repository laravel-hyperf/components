<?php

declare(strict_types=1);

namespace LaravelHyperf\Mail\Contracts;

use LaravelHyperf\Mail\Attachment;

interface Attachable
{
    /**
     * Get an attachment instance for this entity.
     */
    public function toMailAttachment(): Attachment;
}
