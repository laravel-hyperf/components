<?php

declare(strict_types=1);

namespace LaravelHyperf\Http;

use Hyperf\HttpServer\CoreMiddleware as HyperfCoreMiddleware;
use LaravelHyperf\Http\Contracts\RequestContract;
use LaravelHyperf\Http\Contracts\ResponseContract;
use Psr\Http\Message\ServerRequestInterface;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => [
                RequestContract::class => Request::class,
                ResponseContract::class => Response::class,
                ServerRequestInterface::class => Request::class,
                HyperfCoreMiddleware::class => CoreMiddleware::class,
            ],
        ];
    }
}
