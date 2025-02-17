<?php

declare(strict_types=1);

namespace LaravelHyperf\Tests\Event\Hyperf;

use LaravelHyperf\Event\ListenerProvider;
use LaravelHyperf\Tests\Event\Hyperf\Event\Alpha;
use LaravelHyperf\Tests\Event\Hyperf\Event\Beta;
use LaravelHyperf\Tests\Event\Hyperf\Listener\AlphaListener;
use LaravelHyperf\Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class ListenerProviderTest extends TestCase
{
    public function testListenNotExistEvent()
    {
        $provider = new ListenerProvider();
        $provider->on(Alpha::class, [new AlphaListener(), 'process']);
        $provider->on('NotExistEvent', [new AlphaListener(), 'process']);

        $it = $provider->getListenersForEvent(new Alpha());
        [$class, $method] = $it->current();
        $this->assertInstanceOf(AlphaListener::class, $class);
        $this->assertSame('process', $method);
        $this->assertNull($it->next());

        $it = $provider->getListenersForEvent(new Beta());
        $this->assertNull($it->current());
    }
}
