<?php declare(strict_types=1);

namespace AVAllAC\geoip\Provider;

use AVAllAC\geoip\Service\GeoLocation;
use MaxMind\Db\Reader;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class GeoLocationProvider implements ServiceProviderInterface
{
    protected $reader;

    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
    }

    public function register(Container $pimple) : void
    {
        $pimple['geoLocation'] = function () {
            return new GeoLocation($this->reader);
        };
    }
}