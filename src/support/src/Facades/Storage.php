<?php

declare(strict_types=1);

namespace LaravelHyperf\Support\Facades;

use Hyperf\Context\ApplicationContext;
use Hyperf\Contract\ConfigInterface;
use LaravelHyperf\Filesystem\Filesystem;
use LaravelHyperf\Filesystem\FilesystemManager;

/**
 * @method static \LaravelHyperf\Filesystem\Contracts\Filesystem drive(string|null $name = null)
 * @method static \LaravelHyperf\Filesystem\Contracts\Filesystem disk(string|null $name = null)
 * @method static \LaravelHyperf\Filesystem\Contracts\Cloud cloud()
 * @method static \LaravelHyperf\Filesystem\Contracts\Filesystem build(array|string $config)
 * @method static \LaravelHyperf\Filesystem\Contracts\Filesystem createLocalDriver(array $config, string $name = 'local')
 * @method static \LaravelHyperf\Filesystem\Contracts\Filesystem createFtpDriver(array $config)
 * @method static \LaravelHyperf\Filesystem\Contracts\Filesystem createSftpDriver(array $config)
 * @method static \LaravelHyperf\Filesystem\Contracts\Cloud createS3Driver(array $config)
 * @method static \LaravelHyperf\Filesystem\Contracts\Cloud createGcsDriver(array $config)
 * @method static \LaravelHyperf\Filesystem\Contracts\Filesystem createScopedDriver(array $config)
 * @method static \LaravelHyperf\Filesystem\FilesystemManager set(string $name, mixed $disk)
 * @method static string getDefaultDriver()
 * @method static string getDefaultCloudDriver()
 * @method static \LaravelHyperf\Filesystem\FilesystemManager forgetDisk(array|string $disk)
 * @method static void purge(string|null $name = null)
 * @method static \LaravelHyperf\Filesystem\FilesystemManager extend(string $driver, \Closure $callback, bool $poolable = false)
 * @method static \LaravelHyperf\Filesystem\FilesystemManager setApplication(\Psr\Container\ContainerInterface $app)
 * @method static \LaravelHyperf\Filesystem\FilesystemManager setReleaseCallback(string $driver, \Closure $callback)
 * @method static \Closure|null getReleaseCallback(string $driver)
 * @method static \LaravelHyperf\Filesystem\FilesystemManager addPoolable(string $driver)
 * @method static \LaravelHyperf\Filesystem\FilesystemManager removePoolable(string $driver)
 * @method static array getPoolables()
 * @method static \LaravelHyperf\Filesystem\FilesystemManager setPoolables(array $poolables)
 * @method static bool exists(string $path)
 * @method static string get(string $path, bool $lock = false)
 * @method static string sharedGet(string $path)
 * @method static void getRequire(string $path)
 * @method static void requireOnce(string $file)
 * @method static string hash(string $path)
 * @method static void clearStatCache(string $path)
 * @method static bool|int put(string $path, resource|string $contents, bool $lock = false)
 * @method static void replace(string $path, string $content)
 * @method static int prepend(string $path, string $data)
 * @method static int append(string $path, string $data)
 * @method static void chmod(string $path, int|null $mode = null)
 * @method static bool delete(array|string $paths)
 * @method static bool move(string $path, string $target)
 * @method static bool copy(string $path, string $target)
 * @method static bool link(string $target, string $link)
 * @method static string name(string $path)
 * @method static string basename(string $path)
 * @method static string dirname(string $path)
 * @method static string extension(string $path)
 * @method static string type(string $path)
 * @method static false|string mimeType(string $path)
 * @method static int size(string $path)
 * @method static int lastModified(string $path)
 * @method static bool isDirectory(string $directory)
 * @method static bool isReadable(string $path)
 * @method static bool isWritable(string $path)
 * @method static bool isFile(string $file)
 * @method static array glob(string $pattern, int $flags = 0)
 * @method static \Symfony\Component\Finder\SplFileInfo[] files(string $directory, bool $hidden = false)
 * @method static \Symfony\Component\Finder\SplFileInfo[] allFiles(string $directory, bool $hidden = false)
 * @method static array directories(string $directory)
 * @method static bool makeDirectory(string $path, int $mode = 0755, bool $recursive = false, bool $force = false)
 * @method static bool moveDirectory(string $from, string $to, bool $overwrite = false)
 * @method static bool copyDirectory(string $directory, string $destination, int|null $options = null)
 * @method static bool deleteDirectory(string $directory, bool $preserve = false)
 * @method static bool deleteDirectories(string $directory)
 * @method static bool cleanDirectory(string $directory)
 * @method static bool windowsOs()
 * @method static void macro(string $name, callable|object $macro)
 * @method static void mixin(object $mixin, bool $replace = true)
 * @method static bool hasMacro(string $name)
 * @method static \LaravelHyperf\Filesystem\FilesystemAdapter assertExists(array|string $path, string|null $content = null)
 * @method static \LaravelHyperf\Filesystem\FilesystemAdapter assertMissing(array|string $path)
 * @method static \LaravelHyperf\Filesystem\FilesystemAdapter assertDirectoryEmpty(string $path)
 * @method static bool missing(string $path)
 * @method static bool fileExists(string $path)
 * @method static bool fileMissing(string $path)
 * @method static bool directoryExists(string $path)
 * @method static bool directoryMissing(string $path)
 * @method static string path(string $path)
 * @method static array|null json(string $path, int $flags = 0)
 * @method static \Psr\Http\Message\ResponseInterface response(string $path, string|null $name = null, array $headers = [], string|null $disposition = 'inline')
 * @method static \Psr\Http\Message\ResponseInterface download(string $path, string|null $name = null, array $headers = [])
 * @method static string|false putFile(\Hyperf\HttpMessage\Upload\UploadedFile|string $path, \Hyperf\HttpMessage\Upload\UploadedFile|array|string|null $file = null, mixed $options = [])
 * @method static string|false putFileAs(\Hyperf\HttpMessage\Upload\UploadedFile|string $path, \Hyperf\HttpMessage\Upload\UploadedFile|array|string|null $file, array|string|null $name = null, mixed $options = [])
 * @method static string getVisibility(string $path)
 * @method static bool setVisibility(string $path, string $visibility)
 * @method static string|false checksum(string $path, array $options = [])
 * @method static null|resource readStream(string $path)
 * @method static null|resource readStreamRange(string $path, int|null $start, int|null $end)
 * @method static bool writeStream(string $path, resource $resource, array $options = [])
 * @method static string url(string $path)
 * @method static bool providesTemporaryUrls()
 * @method static string temporaryUrl(string $path, \DateTimeInterface $expiration, array $options = [])
 * @method static array|string temporaryUploadUrl(string $path, \DateTimeInterface $expiration, array $options = [])
 * @method static array allDirectories(string|null $directory = null)
 * @method static \League\Flysystem\FilesystemOperator getDriver()
 * @method static \League\Flysystem\FilesystemAdapter getAdapter()
 * @method static array getConfig()
 * @method static void buildTemporaryUrlsUsing(\Closure $callback)
 * @method static \LaravelHyperf\Filesystem\FilesystemAdapter|mixed when(null|\Closure|mixed $value = null, null|callable $callback = null, null|callable $default = null, null|\Closure|mixed $value = null)
 * @method static \LaravelHyperf\Filesystem\FilesystemAdapter|mixed unless(null|\Closure|mixed $value = null, null|callable $callback = null, null|callable $default = null, null|\Closure|mixed $value = null)
 * @method static mixed macroCall(string $method, array $parameters)
 * @method static bool has(string $location)
 * @method static string read(string $location)
 * @method static \League\Flysystem\DirectoryListing listContents(string $location, bool $deep = false)
 * @method static int fileSize(string $path)
 * @method static string visibility(string $path)
 * @method static void write(string $location, string $contents, array $config = [])
 * @method static void createDirectory(string $location, array $config = [])
 *
 * @see \LaravelHyperf\Filesystem\FilesystemManager
 */
class Storage extends Facade
{
    /**
     * Replace the given disk with a local testing disk.
     *
     * @return \LaravelHyperf\Filesystem\Contracts\Filesystem
     */
    public static function fake(?string $disk = null, array $config = [])
    {
        $disk = $disk ?: ApplicationContext::getContainer()
            ->get(ConfigInterface::class)
            ->get('filesystems.default');

        $root = storage_path('framework/testing/disks/' . $disk);

        (new Filesystem())->cleanDirectory($root);

        static::set($disk, $fake = static::createLocalDriver(array_merge($config, [
            'root' => $root,
        ])));

        return tap($fake)->buildTemporaryUrlsUsing(function ($path, $expiration) {
            return URL::to($path . '?expiration=' . $expiration->getTimestamp());
        });
    }

    /**
     * Replace the given disk with a persistent local testing disk.
     *
     * @return \LaravelHyperf\Filesystem\Contracts\Filesystem
     */
    public static function persistentFake(?string $disk = null, array $config = [])
    {
        $disk = $disk ?: ApplicationContext::getContainer()
            ->get(ConfigInterface::class)
            ->get('filesystems.default');

        static::set($disk, $fake = static::createLocalDriver(array_merge($config, [
            'root' => storage_path('framework/testing/disks/' . $disk),
        ])));

        return $fake;
    }

    protected static function getFacadeAccessor()
    {
        return FilesystemManager::class;
    }
}
