<?php

declare(strict_types=1);

namespace LaravelHyperf\Foundation\Bootstrap;

use Hyperf\Collection\Arr;
use Hyperf\Contract\ConfigInterface;
use LaravelHyperf\Foundation\Contracts\Application as ApplicationContract;
use LaravelHyperf\Foundation\Providers\FoundationServiceProvider;
use LaravelHyperf\Foundation\Support\Composer;

class RegisterProviders
{
    /**
     * Register App Providers.
     */
    public function bootstrap(ApplicationContract $app): void
    {
        $providers = [];
        $packagesToIgnore = Composer::getMergedExtra('laravel-hyperf')['dont-discover'] ?? [];

        if (! in_array('*', $packagesToIgnore)) {
            $providers = array_map(
                fn (array $package) => Arr::wrap(($package['laravel-hyperf']['providers'] ?? []) ?? []),
                Composer::getMergedExtra()
            );
            $providers = array_filter(
                $providers,
                fn ($package) => ! in_array($package, $packagesToIgnore),
                ARRAY_FILTER_USE_KEY
            );
            $providers = Arr::flatten($providers);
        }

        $providers = array_unique(
            array_merge(
                $providers,
                $app->get(ConfigInterface::class)->get('app.providers', [])
            )
        );

        // Ensure that FoundationServiceProvider is registered first.
        $foundationKey = array_search(FoundationServiceProvider::class, $providers);
        if ($foundationKey !== false) {
            unset($providers[$foundationKey]);
            array_unshift($providers, FoundationServiceProvider::class);
        }

        foreach ($providers as $providerClass) {
            $app->register($providerClass);
        }
    }
}
