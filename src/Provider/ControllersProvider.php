<?php declare(strict_types=1);

namespace AVAllAC\geoip\Provider;

use AVAllAC\geoip\Controller\GeoController;
use AVAllAC\geoip\Controller\StatusController;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ControllersProvider implements ServiceProviderInterface
{
    public function register(Container $pimple) : void
    {
        $pimple['statusController'] = function () use ($pimple) {
            return new StatusController($pimple['cacheManager'], $pimple['microTime']);
        };

        $pimple['geoController'] = function () use ($pimple) {
            return new GeoController(
                $pimple['cacheManager'],
                $pimple['geoLocation'],
                $pimple['config']['cacheLifeTime']
            );
        };
    }
}