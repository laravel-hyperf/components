<?php

declare(strict_types=1);

namespace LaravelHyperf\Support\Facades;

use LaravelHyperf\HttpClient\Factory;

/**
 * @method static \LaravelHyperf\HttpClient\Factory globalMiddleware(callable $middleware)
 * @method static \LaravelHyperf\HttpClient\Factory globalRequestMiddleware(callable $middleware)
 * @method static \LaravelHyperf\HttpClient\Factory globalResponseMiddleware(callable $middleware)
 * @method static \LaravelHyperf\HttpClient\Factory globalOptions(\Closure|array $options)
 * @method static \GuzzleHttp\Promise\PromiseInterface response(\GuzzleHttp\Promise\PromiseInterface|\LaravelHyperf\HttpClient\Response|callable|array|string|int|null $body = null, int $status = 200, array $headers = [])
 * @method static \Closure failedConnection(string|null $message = null)
 * @method static \LaravelHyperf\HttpClient\ResponseSequence sequence(array $responses = [])
 * @method static \LaravelHyperf\HttpClient\Factory fake(callable|array|null $callback = null)
 * @method static \LaravelHyperf\HttpClient\ResponseSequence fakeSequence(string $url = '*')
 * @method static \LaravelHyperf\HttpClient\Factory stubUrl(string $url, \GuzzleHttp\Promise\PromiseInterface|\LaravelHyperf\HttpClient\Response|callable|array|string|int $callback)
 * @method static \LaravelHyperf\HttpClient\Factory preventStrayRequests(bool $prevent = true)
 * @method static bool preventingStrayRequests()
 * @method static \LaravelHyperf\HttpClient\Factory allowStrayRequests()
 * @method static void recordRequestResponsePair(\LaravelHyperf\HttpClient\Request $request, \LaravelHyperf\HttpClient\Response|null $response)
 * @method static void assertSent(callable $callback)
 * @method static void assertSentInOrder(array $callbacks)
 * @method static void assertNotSent(callable $callback)
 * @method static void assertNothingSent()
 * @method static void assertSentCount(int $count)
 * @method static void assertSequencesAreEmpty()
 * @method static \LaravelHyperf\Support\Collection recorded(callable|null $callback = null)
 * @method static \LaravelHyperf\HttpClient\PendingRequest createPendingRequest()
 * @method static \Psr\EventDispatcher\EventDispatcherInterface|null getDispatcher()
 * @method static array getGlobalMiddleware()
 * @method static \LaravelHyperf\HttpClient\Factory registerConnection(string $name, array $config = [])
 * @method static \GuzzleHttp\ClientInterface getClient(string|null $connection, \GuzzleHttp\HandlerStack $handlerStack, array|null $config = null)
 * @method static \GuzzleHttp\ClientInterface createClient(\GuzzleHttp\HandlerStack $handlerStack)
 * @method static array getConfig(string $name)
 * @method static array getConnectionConfigs()
 * @method static array getConnectionConfig(string $name)
 * @method static \LaravelHyperf\HttpClient\Factory setConnectionConfig(string $name, array $config)
 * @method static \LaravelHyperf\HttpClient\Factory setReleaseCallback(string $driver, \Closure $callback)
 * @method static \Closure|null getReleaseCallback(string $driver)
 * @method static \LaravelHyperf\HttpClient\Factory addPoolable(string $driver)
 * @method static \LaravelHyperf\HttpClient\Factory removePoolable(string $driver)
 * @method static array getPoolables()
 * @method static \LaravelHyperf\HttpClient\Factory setPoolables(array $poolables)
 * @method static mixed macroCall(string $method, array $parameters)
 * @method static void macro(string $name, callable|object $macro)
 * @method static void mixin(object $mixin, bool $replace = true)
 * @method static bool hasMacro(string $name)
 * @method static \LaravelHyperf\HttpClient\PendingRequest baseUrl(string $url)
 * @method static \LaravelHyperf\HttpClient\PendingRequest withBody(\Psr\Http\Message\StreamInterface|string $content, string $contentType = 'application/json')
 * @method static \LaravelHyperf\HttpClient\PendingRequest asJson()
 * @method static \LaravelHyperf\HttpClient\PendingRequest asForm()
 * @method static \LaravelHyperf\HttpClient\PendingRequest attach(array|string $name, resource|string $contents = '', string|null $filename = null, array $headers = [])
 * @method static \LaravelHyperf\HttpClient\PendingRequest asMultipart()
 * @method static \LaravelHyperf\HttpClient\PendingRequest bodyFormat(string $format)
 * @method static \LaravelHyperf\HttpClient\PendingRequest withQueryParameters(array $parameters)
 * @method static \LaravelHyperf\HttpClient\PendingRequest contentType(string $contentType)
 * @method static \LaravelHyperf\HttpClient\PendingRequest acceptJson()
 * @method static \LaravelHyperf\HttpClient\PendingRequest accept(string $contentType)
 * @method static \LaravelHyperf\HttpClient\PendingRequest withHeaders(array $headers)
 * @method static \LaravelHyperf\HttpClient\PendingRequest withHeader(string $name, mixed $value)
 * @method static \LaravelHyperf\HttpClient\PendingRequest replaceHeaders(array $headers)
 * @method static \LaravelHyperf\HttpClient\PendingRequest withBasicAuth(string $username, string $password)
 * @method static \LaravelHyperf\HttpClient\PendingRequest withDigestAuth(string $username, string $password)
 * @method static \LaravelHyperf\HttpClient\PendingRequest withToken(string $token, string $type = 'Bearer')
 * @method static \LaravelHyperf\HttpClient\PendingRequest withUserAgent(string|bool $userAgent)
 * @method static \LaravelHyperf\HttpClient\PendingRequest withUrlParameters(array $parameters = [])
 * @method static \LaravelHyperf\HttpClient\PendingRequest withCookies(array $cookies, string $domain)
 * @method static \LaravelHyperf\HttpClient\PendingRequest maxRedirects(int $max)
 * @method static \LaravelHyperf\HttpClient\PendingRequest withoutRedirecting()
 * @method static \LaravelHyperf\HttpClient\PendingRequest withoutVerifying()
 * @method static \LaravelHyperf\HttpClient\PendingRequest sink(resource|string $to)
 * @method static void timeout(int|float $seconds)
 * @method static \LaravelHyperf\HttpClient\PendingRequest connectTimeout(int|float $seconds)
 * @method static \LaravelHyperf\HttpClient\PendingRequest retry(array|int $times, \Closure|int $sleepMilliseconds = 0, callable|null $when = null, bool $throw = true)
 * @method static \LaravelHyperf\HttpClient\PendingRequest withOptions(array $options)
 * @method static \LaravelHyperf\HttpClient\PendingRequest withMiddleware(callable $middleware)
 * @method static \LaravelHyperf\HttpClient\PendingRequest withRequestMiddleware(callable $middleware)
 * @method static \LaravelHyperf\HttpClient\PendingRequest withResponseMiddleware(callable $middleware)
 * @method static \LaravelHyperf\HttpClient\PendingRequest beforeSending(callable $callback)
 * @method static \LaravelHyperf\HttpClient\PendingRequest throw(callable|null $callback = null)
 * @method static \LaravelHyperf\HttpClient\PendingRequest throwIf(callable|bool $condition)
 * @method static \LaravelHyperf\HttpClient\PendingRequest throwUnless(callable|bool $condition)
 * @method static \LaravelHyperf\HttpClient\PendingRequest dump()
 * @method static \LaravelHyperf\HttpClient\PendingRequest dd()
 * @method static \GuzzleHttp\Promise\PromiseInterface|\LaravelHyperf\HttpClient\Response get(string $url, \JsonSerializable|array|string|null $query = null)
 * @method static \GuzzleHttp\Promise\PromiseInterface|\LaravelHyperf\HttpClient\Response head(string $url, array|string|null $query = null)
 * @method static \GuzzleHttp\Promise\PromiseInterface|\LaravelHyperf\HttpClient\Response post(string $url, \JsonSerializable|array $data = [])
 * @method static \GuzzleHttp\Promise\PromiseInterface|\LaravelHyperf\HttpClient\Response patch(string $url, array $data = [])
 * @method static \GuzzleHttp\Promise\PromiseInterface|\LaravelHyperf\HttpClient\Response put(string $url, array $data = [])
 * @method static \GuzzleHttp\Promise\PromiseInterface|\LaravelHyperf\HttpClient\Response delete(string $url, array $data = [])
 * @method static \GuzzleHttp\Promise\PromiseInterface|\LaravelHyperf\HttpClient\Response send(string $method, string $url, array $options = [])
 * @method static \GuzzleHttp\ClientInterface buildClient()
 * @method static \GuzzleHttp\HandlerStack buildHandlerStack()
 * @method static \GuzzleHttp\HandlerStack pushHandlers(\GuzzleHttp\HandlerStack $handlerStack)
 * @method static \Closure buildBeforeSendingHandler()
 * @method static \Closure buildRecorderHandler()
 * @method static \Closure buildStubHandler()
 * @method static \Psr\Http\Message\RequestInterface runBeforeSendingCallbacks(\Psr\Http\Message\RequestInterface $request, array $options)
 * @method static array mergeOptions(void ...$options)
 * @method static \LaravelHyperf\HttpClient\PendingRequest stub(\LaravelHyperf\Support\Collection|callable $callback)
 * @method static \LaravelHyperf\HttpClient\PendingRequest async(bool $async = true)
 * @method static \GuzzleHttp\Promise\PromiseInterface|null getPromise()
 * @method static \LaravelHyperf\HttpClient\PendingRequest setClient(\GuzzleHttp\ClientInterface $client)
 * @method static \LaravelHyperf\HttpClient\PendingRequest setHandler(callable $handler)
 * @method static array getOptions()
 * @method static \LaravelHyperf\HttpClient\PendingRequest connection(string $connection, array|null $config = null)
 * @method static string|null getConnection()
 * @method static \LaravelHyperf\HttpClient\PendingRequest|mixed when(null|\Closure|mixed $value = null, null|callable $callback = null, null|callable $default = null, null|\Closure|mixed $value = null)
 * @method static \LaravelHyperf\HttpClient\PendingRequest|mixed unless(null|\Closure|mixed $value = null, null|callable $callback = null, null|callable $default = null, null|\Closure|mixed $value = null)
 *
 * @see \LaravelHyperf\HttpClient\Factory
 */
class Http extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Factory::class;
    }
}
