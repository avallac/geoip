<?php

namespace AVAllAC\geoip\Provider;

use AVAllAC\geoip\Service\CacheManager;
use AVAllAC\geoip\Service\MicroTime;
use PHPUnit\Framework\TestCase;
use Pimple\Container;

class CacheManagerProviderTest extends TestCase
{
    public function testRegister()
    {
        $pimple = new Container();
        $pimple['microTime'] =  $this->createMock(MicroTime::class);
        $cmp = new CacheManagerProvider();
        $cmp->register($pimple);
        $this->assertInstanceOf(CacheManager::class, $pimple['cacheManager']);
    }
}