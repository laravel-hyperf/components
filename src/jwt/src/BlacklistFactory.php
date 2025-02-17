<?php

declare(strict_types=1);

namespace LaravelHyperf\JWT;

use Hyperf\Contract\ConfigInterface;
use LaravelHyperf\Cache\Contracts\Factory as CacheManager;
use LaravelHyperf\JWT\Contracts\BlacklistContract;
use LaravelHyperf\JWT\Storage\TaggedCache;
use Psr\Container\ContainerInterface;

class BlacklistFactory
{
    public function __invoke(ContainerInterface $container): BlacklistContract
    {
        $config = $container->get(ConfigInterface::class);

        $storageClass = $config->get('jwt.providers.storage');
        $storage = match ($storageClass) {
            TaggedCache::class => new TaggedCache($container->get(CacheManager::class)->driver()),
            default => $container->get($storageClass),
        };

        return new Blacklist(
            $storage,
            (int) $config->get('jwt.blacklist_grace_period', 0),
            (int) $config->get('jwt.blacklist_refresh_ttl', 20160)
        );
    }
}
