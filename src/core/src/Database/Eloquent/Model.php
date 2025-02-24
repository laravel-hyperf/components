<?php

declare(strict_types=1);

namespace LaravelHyperf\Database\Eloquent;

use Hyperf\DbConnection\Model\Model as BaseModel;
use LaravelHyperf\Database\Eloquent\Concerns\HasCallbacks;
use LaravelHyperf\Database\Eloquent\Concerns\HasObservers;
use LaravelHyperf\Router\Contracts\UrlRoutable;

abstract class Model extends BaseModel implements UrlRoutable
{
    use HasCallbacks;
    use HasObservers;

    protected ?string $connection = null;

    public function resolveRouteBinding($value)
    {
        /* @phpstan-ignore-next-line */
        return $this->where($this->getRouteKeyName(), $value)->firstOrFail();
    }
}
