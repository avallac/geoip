<?php declare(strict_types=1);

namespace AVAllAC\geoip\Provider;

use AVAllAC\geoip\Service\Kernel;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class KernelProvider implements ServiceProviderInterface
{
    public function register(Container $pimple) : void
    {
        $pimple['kernel'] = function () use ($pimple) {
            return new Kernel($pimple['router']);
        };
    }
}
