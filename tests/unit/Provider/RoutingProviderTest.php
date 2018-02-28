<?php

namespace AVAllAC\geoip\Provider;

use AVAllAC\geoip\Controller\GeoController;
use AVAllAC\geoip\Controller\StatusController;
use PHPUnit\Framework\TestCase;
use Pimple\Container;
use Symfony\Component\Routing\Matcher\UrlMatcher;

class RoutingProviderTest extends TestCase
{
    public function testRegister()
    {
        $pimple = new Container();
        $pimple['geoController'] = $this->createMock(GeoController::class);
        $pimple['statusController'] = $this->createMock(StatusController::class);
        $rp = new RoutingProvider();
        $rp->register($pimple);
        $this->assertInstanceOf(UrlMatcher::class, $pimple['router']);
    }
}