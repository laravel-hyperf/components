<?php

declare(strict_types=1);

namespace LaravelHyperf\Tests\Foundation\Testing;

use LaravelHyperf\Foundation\Exceptions\Handler as BaseExceptionHandler;
use LaravelHyperf\Http\Request;
use Throwable;

class ExceptionHandler extends BaseExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected array $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->shouldRenderJsonWhen(function (Request $request, Throwable $e) {
            return true;
        });

        $this->reportable(function (Throwable $e) {});
    }
}
