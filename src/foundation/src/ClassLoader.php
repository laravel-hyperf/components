<?php

declare(strict_types=1);

namespace LaravelHyperf\Foundation;

use Dotenv\Dotenv;
use Dotenv\Repository\Adapter;
use Dotenv\Repository\RepositoryBuilder;
use Hyperf\Di\Annotation\ScanConfig;
use Hyperf\Di\Annotation\Scanner;
use Hyperf\Di\LazyLoader\LazyLoader;
use Hyperf\Di\ScanHandler\PcntlScanHandler;
use Hyperf\Di\ScanHandler\ScanHandlerInterface;
use Hyperf\Support\DotenvManager;
use LaravelHyperf\Foundation\Support\Composer;

class ClassLoader
{
    public static function init(?string $proxyFileDirPath = null, ?string $configDir = null, ?ScanHandlerInterface $handler = null): void
    {
        if (! $proxyFileDirPath) {
            // This dir is the default proxy file dir path of Laravel Hyperf
            $proxyFileDirPath = BASE_PATH . '/storage/framework/container/proxy/';
        }

        if (! $configDir) {
            // This dir is the default config file dir path of Laravel Hyperf
            $configDir = BASE_PATH . '/config/';
        }

        if (! $handler) {
            $handler = new PcntlScanHandler();
        }

        $composerLoader = Composer::getLoader();

        if (file_exists(BASE_PATH . '/.env')) {
            DotenvManager::load([BASE_PATH]);
        }

        // Scan by ScanConfig to generate the reflection class map
        $config = ScanConfig::instance($configDir);
        $composerLoader->addClassMap($config->getClassMap());

        $scanner = new Scanner($config, $handler);
        $composerLoader->addClassMap(
            $scanner->scan($composerLoader->getClassMap(), $proxyFileDirPath)
        );

        // Initialize Lazy Loader. This will prepend LazyLoader to the top of autoload queue.
        LazyLoader::bootstrap($configDir);
    }

    /**
     * @see DotenvManager::load()
     * @deprecated use DotenvManager instead
     */
    protected static function loadDotenv(): void
    {
        $repository = RepositoryBuilder::createWithNoAdapters()
            ->addAdapter(Adapter\PutenvAdapter::class)
            ->immutable()
            ->make();

        Dotenv::create($repository, [BASE_PATH])->load();
    }
}
