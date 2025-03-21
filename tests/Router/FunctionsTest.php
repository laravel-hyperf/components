<?php

declare(strict_types=1);

namespace LaravelHyperf\Tests\Router;

use Hyperf\Context\ApplicationContext;
use Hyperf\Contract\ContainerInterface;
use LaravelHyperf\Router\Contracts\UrlGenerator as UrlGeneratorContract;
use LaravelHyperf\Tests\TestCase;
use Mockery;
use Mockery\MockInterface;

use function LaravelHyperf\Router\route;
use function LaravelHyperf\Router\secure_url;
use function LaravelHyperf\Router\url;

/**
 * @internal
 * @coversNothing
 */
class FunctionsTest extends TestCase
{
    public function testRoute()
    {
        $urlGenerator = $this->mockUrlGenerator();

        $urlGenerator->shouldReceive('route')
            ->with('foo', ['bar'], true, 'http')
            ->andReturn('foo-bar');

        $urlGenerator->shouldReceive('route')
            ->with('foo', ['bar'], true, 'baz')
            ->andReturn('foo-bar-baz');

        $this->assertEquals('foo-bar', route('foo', ['bar']));
        $this->assertEquals('foo-bar-baz', route('foo', ['bar'], true, 'baz'));
    }

    public function testUrl()
    {
        $urlGenerator = $this->mockUrlGenerator();

        $urlGenerator->shouldReceive('to')
            ->with('foo', ['bar'], true)
            ->andReturn('foo-bar');

        $this->assertEquals('foo-bar', url('foo', ['bar'], true));
    }

    public function testSecureUrl()
    {
        $urlGenerator = $this->mockUrlGenerator();

        $urlGenerator->shouldReceive('secure')
            ->with('foo', ['bar'])
            ->andReturn('foo-bar');

        $this->assertEquals('foo-bar', secure_url('foo', ['bar']));
    }

    /**
     * @return MockInterface|UrlGenerator
     */
    private function mockUrlGenerator(): UrlGeneratorContract
    {
        /** @var ContainerInterface|MockInterface */
        $container = Mockery::mock(ContainerInterface::class);
        $urlGenerator = Mockery::mock(UrlGeneratorContract::class);

        $container->shouldReceive('get')
            ->with(UrlGeneratorContract::class)
            ->andReturn($urlGenerator);

        ApplicationContext::setContainer($container);

        return $urlGenerator;
    }
}
