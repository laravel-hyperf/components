<?php

declare(strict_types=1);

namespace LaravelHyperf\Http\Exceptions;

/**
 * Thrown when an UPLOAD_ERR_CANT_WRITE error occurred with UploadedFile.
 */
class CannotWriteFileException extends FileException
{
}
