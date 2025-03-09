<?php

declare(strict_types=1);

namespace LaravelHyperf\Foundation;

use Hyperf\Di\Annotation\ScanConfig;
use Hyperf\Di\LazyLoader\LazyLoader;
use Hyperf\Di\ScanHandler\PcntlScanHandler;
use Hyperf\Di\ScanHandler\ScanHandlerInterface;
use LaravelHyperf\Foundation\Support\Composer;

class ClassLoader
{
    protected static ?string $proxyFileDirPath = null;

    protected static ?string $configDir = null;

    protected static ?ScanHandlerInterface $handler = null;

    public static function init(?string $proxyFileDirPath = null, ?string $configDir = null, ?ScanHandlerInterface $handler = null): void
    {
        static::setParameters($proxyFileDirPath, $configDir, $handler);

        static::loadClassMap();

        // Initialize Lazy Loader. This will prepend LazyLoader to the top of autoload queue.
        LazyLoader::bootstrap(static::$configDir);
    }

    public static function loadClassMap(): void
    {
        $composerLoader = Composer::getLoader();

        $config = ScanConfig::instance(static::$configDir);
        $composerLoader->addClassMap($config->getClassMap());

        $scanner = new AnnotationScanner($config, static::$handler);
        $composerLoader->addClassMap(
            $scanner->scan($composerLoader->getClassMap(), static::$proxyFileDirPath)
        );
    }

    protected static function setParameters(?string $proxyFileDirPath = null, ?string $configDir = null, ?ScanHandlerInterface $handler = null): void
    {
        static::$proxyFileDirPath = $proxyFileDirPath
            ?? BASE_PATH . '/storage/framework/container/proxy/';

        static::$configDir = $configDir ?? BASE_PATH . '/config/';

        static::$handler = $handler ?? new PcntlScanHandler();
    }
}
