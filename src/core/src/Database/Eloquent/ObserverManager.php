<?php

declare(strict_types=1);

namespace LaravelHyperf\Database\Eloquent;

use Hyperf\Collection\Arr;
use Hyperf\Database\Model\Events;
use Hyperf\Database\Model\Events\Event;
use Hyperf\Database\Model\Model;
use InvalidArgumentException;
use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

class ObserverManager
{
    /**
     * The model events that should be registered.
     */
    protected const MODEL_EVENTS = [
        'booting' => Events\Booting::class,
        'booted' => Events\Booted::class,
        'retrieved' => Events\Retrieved::class,
        'creating' => Events\Creating::class,
        'created' => Events\Created::class,
        'updating' => Events\Updating::class,
        'updated' => Events\Updated::class,
        'saving' => Events\Saving::class,
        'saved' => Events\Saved::class,
        'deleting' => Events\Deleting::class,
        'deleted' => Events\Deleted::class,
        'restoring' => Events\Restoring::class,
        'restored' => Events\Restored::class,
        'forceDeleting' => Events\ForceDeleting::class,
        'forceDeleted' => Events\ForceDeleted::class,
    ];

    /**
     * Indicates if the manager has been bootstrapped.
     */
    protected array $bootstrappedEvents = [];

    /**
     * Observers that have been registered.
     */
    protected array $observers = [];

    public function __construct(
        protected ContainerInterface $container,
        protected EventDispatcherInterface $dispatcher
    ) {
    }

    public function bootstrapEvent(string $eventClass): void
    {
        if ($this->bootstrappedEvents[$eventClass] ?? false) {
            return;
        }

        /* @phpstan-ignore-next-line */
        $this->dispatcher->listen(
            $eventClass,
            [$this, 'handleEvent']
        );

        $this->bootstrappedEvents[$eventClass] = true;
    }

    /**
     * Register a single observer with the model.
     */
    public function register(string $modelClass, object|string $observer): void
    {
        if (! class_exists($modelClass)) {
            throw new InvalidArgumentException('Unable to find model class: ' . $modelClass);
        }

        if (! is_subclass_of($modelClass, Model::class)) {
            throw new InvalidArgumentException("Model class must extends `{$modelClass}`");
        }

        $observerClass = $this->resolveObserverClassName($observer);
        foreach (static::MODEL_EVENTS as $event => $eventClass) {
            if (! method_exists($observer, $event)) {
                continue;
            }

            $this->bootstrapEvent($eventClass);
            $this->observers[$modelClass][$event][$observerClass] = $this->container
                ->get($observerClass);
        }
    }

    /**
     * Get observers by the model and event.
     */
    public function getObservers(string $modelClass, ?string $event = null): array
    {
        if (is_string($event)) {
            return array_values($this->observers[$modelClass][$event] ?? []);
        }

        return Arr::flatten($this->observers[$modelClass] ?? []);
    }

    /**
     * Get the model events that should be registered.
     */
    public function getModelEvents(): array
    {
        return array_values(static::MODEL_EVENTS);
    }

    /**
     * Execute observers from the given model event.
     */
    public function handleEvent(Event $event): void
    {
        $model = $event->getModel();
        $observers = $this->getObservers(
            get_class($event->getModel()),
            $method = $event->getMethod()
        );

        foreach ($observers as $observer) {
            $observer->{$method}($model);
        }
    }

    /**
     * Resolve the observer's class name from an object or string.
     *
     * @throws InvalidArgumentException
     */
    private function resolveObserverClassName(object|string $class): string
    {
        if (is_object($class)) {
            return get_class($class);
        }

        if (class_exists($class)) {
            return $class;
        }

        throw new InvalidArgumentException('Unable to find observer: ' . $class);
    }
}
