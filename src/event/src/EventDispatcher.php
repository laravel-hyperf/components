<?php

declare(strict_types=1);

namespace SwooleTW\Hyperf\Event;

use Closure;
use Exception;
use Hyperf\AsyncQueue\Driver\DriverFactory as QueueFactory;
use Hyperf\Collection\Arr;
use Hyperf\Context\ApplicationContext;
use Hyperf\Stringable\Str;
use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\StoppableEventInterface;
use Psr\Log\LoggerInterface;
use ReflectionClass;
use SwooleTW\Hyperf\Event\Contracts\EventDispatcherContract;
use SwooleTW\Hyperf\Event\Contracts\ListenerProviderContract;
use SwooleTW\Hyperf\Foundation\Contracts\Queue\ShouldQueue;
use SwooleTW\Hyperf\Support\Traits\ReflectsClosures;

class EventDispatcher implements EventDispatcherContract
{
    use ReflectsClosures;

    /** @var callable */
    protected $queueResolver;

    public function __construct(
        protected ListenerProviderContract $listeners,
        protected ?LoggerInterface $logger = null,
        protected ?ContainerInterface $container = null
    ) {
        if (! $container && ApplicationContext::hasContainer()) {
            $this->container = ApplicationContext::getContainer();
        }
    }

    /**
     * Fire an event and call the listeners.
     */
    public function dispatch(object|string $event, mixed $payload = [], bool $halt = false): object|string
    {
        return $this->invokeListeners($event, $payload, $halt);
    }

    /**
     * Dump the event and listeners to the log.
     */
    protected function dump(mixed $listener, object|string $event): void
    {
        if (! $this->logger) {
            return;
        }

        $eventName = is_string($event) ? $event : get_class($event);
        $listenerName = '[ERROR TYPE]';

        if (is_array($listener)) {
            $listenerName = is_string($listener[0]) ? $listener[0] : get_class($listener[0]);
        } elseif (is_string($listener)) {
            $listenerName = $listener;
        } elseif (is_object($listener)) {
            $listenerName = get_class($listener);
        }

        $this->logger->debug(sprintf('Event %s handled by %s listener.', $eventName, $listenerName));
    }

    /**
     * Register an event listener with the listener provider.
     */
    public function listen(
        array|Closure|QueuedClosure|string $events,
        null|array|Closure|int|QueuedClosure|string $listener = null,
        int $priority = ListenerData::DEFAULT_PRIORITY
    ): void {
        if ($events instanceof Closure) {
            foreach ((array) $this->firstClosureParameterTypes($events) as $event) {
                $this->listeners->on($event, $events, is_int($listener) ? $listener : $priority);
            }

            return;
        }

        if ($events instanceof QueuedClosure) {
            foreach ((array) $this->firstClosureParameterTypes($events->closure) as $event) {
                $this->listeners->on($event, $events->resolve($this->queueResolver), is_int($listener) ? $listener : $priority);
            }

            return;
        }

        if ($listener instanceof QueuedClosure) {
            $listener = $listener->resolve($this->queueResolver);
        }

        foreach ((array) $events as $event) {
            $this->listeners->on($event, $listener, $priority);
        }
    }

    /**
     * Fire an event until the first non-null response is returned.
     */
    public function until(object|string $event, mixed $payload = []): object|string
    {
        return $this->dispatch($event, $payload, true);
    }

    /**
     * Fire an event and call the listeners.
     */
    protected function invokeListeners(object|string $event, mixed $payload, bool $halt = false): object|string
    {
        foreach ($this->getListeners($event) as $listener) {
            $response = $listener($event, $payload);

            $this->dump($listener, $event);

            if ($halt || $response === false || ($event instanceof StoppableEventInterface && $event->isPropagationStopped())) {
                return $event;
            }
        }

        return $event;
    }

    /**
     * Get all of the listeners for a given event name.
     */
    public function getListeners(object|string $eventName): iterable
    {
        return $this->prepareListeners($eventName);
    }

    /**
     * Get the listeners for a given event.
     *
     * @return Closure[]
     */
    protected function prepareListeners(object|string $eventName): array
    {
        $listeners = [];

        foreach ($this->listeners->getListenersForEvent($eventName) as $listener) {
            $listeners[] = $this->makeListener($listener);
        }

        return $listeners;
    }

    /**
     * Create a callable for a class based listener.
     *
     * @param array|string $listener
     */
    protected function makeListener(array|Closure|string $listener): Closure
    {
        if (is_string($listener) || (is_array($listener) && ((isset($listener[0]) && is_string($listener[0])) || is_callable($listener)))) {
            return $this->createClassListener($listener);
        }

        return function ($event, $payload) use ($listener) {
            if (is_array($payload)) {
                return $listener($event, ...array_values($payload));
            }

            return $listener($event, $payload);
        };
    }

    /**
     * Create a class based listener.
     */
    protected function createClassListener(array|string $listener): Closure
    {
        return function (object|string $event, mixed $payload) use ($listener) {
            $callable = $this->createClassCallable($listener);

            if (is_array($payload)) {
                return $callable($event, ...array_values($payload));
            }

            return $callable($event, $payload);
        };
    }

    /**
     * Create a callable based listener.
     */
    protected function createClassCallable(array|string $listener): callable
    {
        [$class, $method] = is_array($listener)
                            ? $listener
                            : $this->parseClassCallable($listener);

        if (! method_exists($class, $method)) {
            $method = '__invoke';
        }

        if ($this->handlerShouldBeQueued($class)) {
            return $this->createQueuedHandlerCallable($class, $method);
        }

        $listener = is_string($class) ? $this->container->get($class) : $class;

        return [$listener, $method];
    }

    /**
     * Parse the class listener into class and method.
     */
    protected function parseClassCallable(string $listener): array
    {
        return Str::parseCallback($listener, 'handle');
    }

    /**
     * Register an event and payload to be fired later.
     */
    public function push(string $event, mixed $payload = []): void
    {
        $this->listen($event . '_pushed', function () use ($event, $payload) {
            $this->dispatch($event, $payload);
        });
    }

    /**
     * Flush a set of pushed events.
     */
    public function flush(string $event): void
    {
        $this->dispatch($event . '_pushed');
    }

    /**
     * Forget all of the pushed listeners.
     */
    public function forgetPushed(): void
    {
        foreach ($this->listeners->all() as $key => $_) {
            if (str_ends_with($key, '_pushed')) {
                $this->forget($key);
            }
        }
    }

    /**
     * Remove a set of listeners from the dispatcher.
     */
    public function forget(string $event): void
    {
        $this->listeners->forget($event);
    }

    /**
     * Determine if a given event has listeners.
     */
    public function hasListeners(string $eventName): bool
    {
        return $this->listeners->has($eventName);
    }

    /**
     * Determine if the given event has any wildcard listeners.
     */
    public function hasWildcardListeners(string $eventName): bool
    {
        return $this->listeners->hasWildcard($eventName);
    }

    /**
     * Get the queue implementation from the resolver.
     */
    protected function resolveQueue(): QueueFactory
    {
        return call_user_func($this->queueResolver);
    }

    /**
     * Set the queue resolver implementation.
     *
     * @return $this
     */
    public function setQueueResolver(callable $resolver): static
    {
        $this->queueResolver = $resolver;

        return $this;
    }

    /**
     * Determine if the event handler should be queued.
     */
    protected function handlerShouldBeQueued(object|string $class): bool
    {
        try {
            if (is_string($class)) {
                return (new ReflectionClass($class))->implementsInterface(ShouldQueue::class);
            }

            return $class instanceof ShouldQueue;
        } catch (Exception) {
            return false;
        }
    }

    /**
     * Create a callable for putting an event handler on the queue.
     */
    protected function createQueuedHandlerCallable(object|string $class, string $method): Closure
    {
        return function () use ($class, $method) {
            $arguments = array_map(function ($a) {
                return is_object($a) ? clone $a : $a;
            }, func_get_args());

            if ($this->handlerWantsToBeQueued($class, $arguments)) {
                $this->queueHandler($class, $method, $arguments);
            }
        };
    }

    /**
     * Determine if the event handler wants to be queued.
     */
    protected function handlerWantsToBeQueued(object|string $class, array $arguments): bool
    {
        $instance = is_string($class) ? $this->container->get($class) : $class;

        if (method_exists($instance, 'shouldQueue')) {
            return $instance->shouldQueue($arguments[0]);
        }

        return true;
    }

    /**
     * Queue the handler execution.
     */
    protected function queueHandler(object|string $class, string $method, array $arguments): void
    {
        [$listener, $job] = $this->createListenerAndJob($class, $method, $arguments);

        $connection = $this->resolveQueue()->get(method_exists($listener, 'viaConnection')
            ? $listener->viaConnection(...$arguments)
            : $listener->connection ?? 'default');

        $delay = method_exists($listener, 'withDelay')
            ? $listener->withDelay(...$arguments)
            : $listener->delay ?? 0;

        $connection->push($job, $delay);
    }

    /**
     * Create a listener and job for the queued listener.
     */
    protected function createListenerAndJob(object|string $class, string $method, array $arguments): array
    {
        $listener = is_string($class) ? (new ReflectionClass($class))->newInstanceWithoutConstructor() : $class;

        return [$listener, $this->propagateListenerOptions(
            $listener,
            new CallQueuedListener($class, $method, $arguments)
        )];
    }

    /**
     * Propagate the listener options to the job.
     *
     * @return CallQueuedListener
     */
    protected function propagateListenerOptions(mixed $listener, CallQueuedListener $job): mixed
    {
        return tap($job, function ($job) use ($listener) {
            $job->setMaxAttempts($listener->maxAttempts ?? 0);
        });
    }

    /**
     * Register an event subscriber with the dispatcher.
     */
    public function subscribe(object|string $subscriber): void
    {
        $subscriber = $this->resolveSubscriber($subscriber);

        $events = $subscriber->subscribe($this);

        if (is_array($events)) {
            foreach ($events as $event => $listeners) {
                foreach (Arr::wrap($listeners) as $listener) {
                    if (is_string($listener) && method_exists($subscriber, $listener)) {
                        $this->listen($event, [get_class($subscriber), $listener]);

                        continue;
                    }

                    $this->listen($event, $listener);
                }
            }
        }
    }

    /**
     * Gets the raw, unprepared listeners.
     */
    public function getRawListeners(): array
    {
        return $this->listeners->all();
    }

    /**
     * Resolve the subscriber instance.
     *
     * @return object
     */
    protected function resolveSubscriber(object|string $subscriber): mixed
    {
        if (is_string($subscriber)) {
            return $this->container->get($subscriber);
        }

        return $subscriber;
    }
}
