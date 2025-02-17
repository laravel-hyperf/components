<?php

declare(strict_types=1);

namespace LaravelHyperf\Foundation\Providers;

use Hyperf\Validation\Contract\ValidatesWhenResolved;
use LaravelHyperf\Support\ServiceProvider;

class FormRequestServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        $this->app->resolving(ValidatesWhenResolved::class, function (ValidatesWhenResolved $request) {
            $request->validateResolved();
        });
    }
}
