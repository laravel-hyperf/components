<?php

declare(strict_types=1);

namespace LaravelHyperf\Queue\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class DeleteWhenMissingModels
{
}
