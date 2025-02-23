<?php

declare(strict_types=1);

namespace LaravelHyperf\Router\Exceptions;

use LaravelHyperf\HttpMessage\Exceptions\HttpException;

class InvalidSignatureException extends HttpException
{
    /**
     * Create a new exception instance.
     */
    public function __construct()
    {
        parent::__construct(403, 'Invalid signature.');
    }
}
