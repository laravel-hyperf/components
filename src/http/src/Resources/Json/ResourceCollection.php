<?php

declare(strict_types=1);

namespace LaravelHyperf\Http\Resources\Json;

use Hyperf\Resource\Json\ResourceCollection as BaseResourceCollection;
use LaravelHyperf\Http\Resources\Concerns\CollectsResources;

class ResourceCollection extends BaseResourceCollection
{
    use CollectsResources;
}
