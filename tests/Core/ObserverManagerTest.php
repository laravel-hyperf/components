<?php

declare(strict_types=1);

namespace LaravelHyperf\Tests\Core;

use Hyperf\Database\Model\Events\Created;
use Hyperf\Database\Model\Model;
use InvalidArgumentException;
use LaravelHyperf\Database\Eloquent\ObserverManager;
use LaravelHyperf\Tests\TestCase;
use Mockery as m;
use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

/**
 * @internal
 * @coversNothing
 */
class ObserverManagerTest extends TestCase
{
    public function testRegisterWithInvalidModel()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Unable to find model class: InvalidModel');

        $this->getObserverManager()
            ->register('InvalidModel', 'Observer');
    }

    public function testRegisterWithInvalidObserver()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Unable to find observer: Observer');

        $this->getObserverManager()
            ->register(User::class, 'Observer');
    }

    public function testRegister()
    {
        $container = m::mock(ContainerInterface::class);
        $container->shouldReceive('get')
            ->with(UserObserver::class)
            ->once()
            ->andReturn($userObserver = new UserObserver());

        $dispatcher = m::mock(EventDispatcherInterface::class);
        $dispatcher->shouldReceive('listen')
            ->once()
            ->with(Created::class, m::type('callable'));

        $manager = $this->getObserverManager($container, $dispatcher);
        $manager->register(User::class, UserObserver::class);

        $this->assertSame(
            [$userObserver],
            $manager->getObservers(User::class)
        );

        $this->assertSame(
            [],
            $manager->getObservers(User::class, 'updated')
        );
    }

    public function testHandleEvents()
    {
        $container = m::mock(ContainerInterface::class);
        $container->shouldReceive('get')
            ->with(UserObserver::class)
            ->once()
            ->andReturn($userObserver = new UserObserver());

        $dispatcher = m::mock(EventDispatcherInterface::class);
        $dispatcher->shouldReceive('listen')
            ->once()
            ->with(Created::class, m::type('callable'));

        $manager = $this->getObserverManager($container, $dispatcher);
        $manager->register(User::class, UserObserver::class);
        $manager->handleEvent(new Created(new User()));

        $this->assertTrue($userObserver->called);
    }

    protected function getObserverManager(?ContainerInterface $container = null, ?EventDispatcherInterface $dispatcher = null): ObserverManager
    {
        return new ObserverManager(
            $container ?? m::mock(ContainerInterface::class),
            $dispatcher ?? m::mock(EventDispatcherInterface::class)
        );
    }
}

class User extends Model
{
}

class UserObserver
{
    public bool $called = false;

    public function created(User $user)
    {
        $this->called = true;
    }
}
