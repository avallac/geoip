<?php declare(strict_types=1);

namespace AVAllAC\geoip\Provider;

use AVAllAC\geoip\Service\MicroTime;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class MicroTimeProvider implements ServiceProviderInterface
{
    public function register(Container $pimple) : void
    {
        $pimple['microTime'] = new MicroTime();
    }
}