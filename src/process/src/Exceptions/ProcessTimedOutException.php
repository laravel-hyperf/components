<?php

declare(strict_types=1);

namespace LaravelHyperf\Process\Exceptions;

use LaravelHyperf\Process\Contracts\ProcessResult;
use Symfony\Component\Process\Exception\ProcessTimedOutException as SymfonyTimeoutException;
use Symfony\Component\Process\Exception\RuntimeException;

class ProcessTimedOutException extends RuntimeException
{
    /**
     * The process result instance.
     */
    public ProcessResult $result;

    /**
     * Create a new exception instance.
     */
    public function __construct(SymfonyTimeoutException $original, ProcessResult $result)
    {
        $this->result = $result;

        parent::__construct($original->getMessage(), $original->getCode(), $original);
    }
}
