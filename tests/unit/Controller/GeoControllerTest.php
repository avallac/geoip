<?php

namespace AVAllAC\geoip\Controller;

use AVAllAC\geoip\Service\CacheManager;
use AVAllAC\geoip\Service\GeoLocation;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class GeoControllerTest extends TestCase
{
    public function testIp2geoCache()
    {
        $ip = '1.2.3.4';
        $geoLocation = $this->createMock(GeoLocation::class);
        $cacheManager = $this->createMock(CacheManager::class);
        $cacheManager->method('get')->with($ip)->willReturn('jsonData');
        $statusController = new GeoController($cacheManager, $geoLocation, 10);
        $request = $this->createMock(ServerRequestInterface::class);
        $request->method('getQueryParams')->willReturn(['ip' => $ip]);
        $this->assertEquals('jsonData', $statusController->ip2geo($request));
    }

    /**
     * @expectedException \Symfony\Component\Routing\Exception\InvalidParameterException
     */
    public function testIp2geoInvalidIp()
    {
        $ip = '256.2.3.4';
        $geoLocation = $this->createMock(GeoLocation::class);
        $cacheManager = $this->createMock(CacheManager::class);
        $statusController = new GeoController($cacheManager, $geoLocation, 10);
        $request = $this->createMock(ServerRequestInterface::class);
        $request->method('getQueryParams')->willReturn(['ip' => $ip]);
        $this->assertEquals('jsonData', $statusController->ip2geo($request));
    }

    /**
     * @expectedException \Symfony\Component\Routing\Exception\ResourceNotFoundException
     */
    public function testIp2geoIpNotFound()
    {
        $ip = '1.2.3.4';
        $geoLocation = $this->createMock(GeoLocation::class);
        $cacheManager = $this->createMock(CacheManager::class);
        $statusController = new GeoController($cacheManager, $geoLocation, 10);
        $request = $this->createMock(ServerRequestInterface::class);
        $request->method('getQueryParams')->willReturn(['ip' => $ip]);
        $this->assertEquals('jsonData', $statusController->ip2geo($request));
    }

    public function testIp2geoIpLocation()
    {
        $ip = '1.2.3.4';
        $geoLocation = $this->createMock(GeoLocation::class);
        $geoLocation->method('getByIp')->with($ip)->willReturn(['data']);
        $cacheManager = $this->createMock(CacheManager::class);
        $statusController = new GeoController($cacheManager, $geoLocation, 10);
        $request = $this->createMock(ServerRequestInterface::class);
        $request->method('getQueryParams')->willReturn(['ip' => $ip]);
        $this->assertEquals('["data"]', $statusController->ip2geo($request));
    }
}