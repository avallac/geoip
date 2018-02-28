<?php

namespace AVAllAC\geoip\Provider;

use AVAllAC\geoip\Controller\GeoController;
use AVAllAC\geoip\Controller\StatusController;
use AVAllAC\geoip\Service\CacheManager;
use AVAllAC\geoip\Service\GeoLocation;
use AVAllAC\geoip\Service\MicroTime;
use PHPUnit\Framework\TestCase;
use Pimple\Container;

class ControllersProviderTest extends TestCase
{
    public function testRegister()
    {
        $pimple = new Container();
        $pimple['microTime'] =  $this->createMock(MicroTime::class);
        $pimple['cacheManager'] =  $this->createMock(CacheManager::class);
        $pimple['geoLocation'] =  $this->createMock(GeoLocation::class);
        $pimple['config'] = ['cacheLifeTime' => 10];
        $cp = new ControllersProvider();
        $cp->register($pimple);
        $this->assertInstanceOf(StatusController::class, $pimple['statusController']);
        $this->assertInstanceOf(GeoController::class, $pimple['geoController']);
    }
}