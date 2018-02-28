<?php

namespace AVAllAC\geoip\Service;

use PHPUnit\Framework\TestCase;

class CacheManagerTest extends TestCase
{
    public function testStorage()
    {
        $microTime = $this->createMock(MicroTime::class);
        $microTime->method('get')->willReturn(10000);
        $cacheManager = new CacheManager($microTime, 10);
        $cacheManager->store('key', 'data', 10);
        $this->assertEquals('data', $cacheManager->get('key'));
    }

    public function testCacheMiss()
    {
        $microTime = $this->createMock(MicroTime::class);
        $microTime->method('get')->willReturn(10000);
        $cacheManager = new CacheManager($microTime);
        $cacheManager->store('key', 'data', 10);
        $this->assertEquals(null, $cacheManager->get('key2'));
    }

    public function testExpire()
    {
        $microTime = $this->createMock(MicroTime::class);
        $microTime->method('get')->will($this->onConsecutiveCalls(10000, 100000));
        $cacheManager = new CacheManager($microTime);
        $cacheManager->store('key', 'data', 10);
        $this->assertEquals(null, $cacheManager->get('key'));
    }

    public function testSize()
    {
        $microTime = $this->createMock(MicroTime::class);
        $microTime->method('get')->willReturn(1000);
        $cacheManager = new CacheManager($microTime);
        $cacheManager->store('key1', 'data', 10);
        $cacheManager->store('key2', 'data', 10);
        $this->assertEquals(2, $cacheManager->getSize());
    }

    public function testClean()
    {
        $microTime = $this->createMock(MicroTime::class);
        $microTime->method('get')->will($this->onConsecutiveCalls(10000, 100000));
        $cacheManager = new CacheManager($microTime);
        $cacheManager->store('key1', 'data', 10);
        $cacheManager->clean();
        $this->assertEquals(0, $cacheManager->getSize());
    }

}
