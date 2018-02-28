<?php

namespace AVAllAC\geoip\Controller;

use AVAllAC\geoip\Service\CacheManager;
use AVAllAC\geoip\Service\MicroTime;
use PHPUnit\Framework\TestCase;

class StatusControllerTest extends TestCase
{
    public function testStatus()
    {
        $microTime = $this->createMock(MicroTime::class);
        $microTime->method('getInitTime')->willReturn(1000);
        $microTime->method('get')->willReturn(2000);
        $cacheManager = $this->createMock(CacheManager::class);
        $cacheManager->method('getSize')->willReturn(10);
        $statusController = new StatusController($cacheManager, $microTime);
        $this->assertEquals('{"storageSize":10,"uptime":1000}', $statusController->status());
    }
}