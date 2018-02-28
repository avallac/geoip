<?php

namespace AVAllAC\geoip\Provider;

use AVAllAC\geoip\Service\GeoLocation;
use MaxMind\Db\Reader;
use PHPUnit\Framework\TestCase;
use Pimple\Container;

class GeoLocationProviderTest extends TestCase
{
    public function testRegister()
    {
        $pimple = new Container();
        $reader = $this->createMock(Reader::class);
        $glp = new GeoLocationProvider($reader);
        $glp->register($pimple);
        $this->assertInstanceOf(GeoLocation::class, $pimple['geoLocation']);
    }
}