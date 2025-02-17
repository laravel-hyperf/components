<?php

declare(strict_types=1);

namespace LaravelHyperf\Http;

use Hyperf\HttpMessage\Server\Chunk\Chunkable;

class StreamOutput
{
    public function __construct(
        protected Chunkable $chunkable
    ) {
    }

    public function write(string $content): bool
    {
        return $this->chunkable->write($content);
    }
}
