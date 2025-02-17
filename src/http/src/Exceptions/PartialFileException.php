<?php

declare(strict_types=1);

namespace LaravelHyperf\Http\Exceptions;

/**
 * Thrown when an UPLOAD_ERR_PARTIAL error occurred with UploadedFile.
 */
class PartialFileException extends FileException
{
}
