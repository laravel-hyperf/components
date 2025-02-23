<?php

declare(strict_types=1);

namespace LaravelHyperf\Support\Facades;

use Closure;
use DateInterval;
use DateTimeInterface;
use Hyperf\HttpServer\Contract\RequestInterface;
use LaravelHyperf\Router\UrlGenerator;

/**
 * @method static string route(string $name, array $parameters = [], string $server = 'http')
 * @method static string to(string $path, array $extra = [], ?bool $secure = null)
 * @method static string query(string $path, array $query = [], array $extra = [], ?bool $secure = null)
 * @method static string secure(string $path, array $extra = [])
 * @method static string asset(string $path, ?bool $secure = null)
 * @method static string secureAsset(string $path)
 * @method static string assetFrom(string $root, string $path, ?bool $secure = null)
 * @method static string formatScheme(?bool $secure = null)
 * @method static string signedRoute(BackedEnum|string $name, array $parameters = [], null|DateInterval|DateTimeInterface|int $expiration = null, bool $absolute = true, string $server = 'http')
 * @method static string temporarySignedRoute(BackedEnum|string $name, DateInterval|DateTimeInterface|int $expiration, array $parameters = [], bool $absolute = true, string $server = 'http')
 * @method static bool hasValidSignature(RequestInterface $request, bool $absolute = true)
 * @method static bool hasValidRelativeSignature(RequestInterface $request, array $ignoreQuery = [])
 * @method static bool hasCorrectSignature(RequestInterface $request, bool $absolute = true, array $ignoreQuery = [])
 * @method static bool signatureHasNotExpired(RequestInterface $request)
 * @method static string full()
 * @method static string current()
 * @method static string previous($fallback = false)
 * @method static string previousPath($fallback = false)
 * @method static string format(string $root, string $path)
 * @method static bool isValidUrl(string $path)
 * @method static static formatHostUsing(Closure $callback)
 * @method static static formatPathUsing(Closure $callback)
 * @method static static setSignedKey(?string $signedKey = null)
 *
 * @see UrlGenerator
 */
class URL extends Facade
{
    protected static function getFacadeAccessor()
    {
        return UrlGenerator::class;
    }
}
