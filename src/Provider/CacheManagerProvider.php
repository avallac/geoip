<?php declare(strict_types=1);

namespace AVAllAC\geoip\Provider;

use AVAllAC\geoip\Service\CacheManager;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class CacheManagerProvider implements ServiceProviderInterface
{
    public function register(Container $pimple) : void
    {
        $pimple['cacheManager'] = function () use ($pimple) {
            return new CacheManager(
                $pimple['microTime']
            );
        };
    }
}
