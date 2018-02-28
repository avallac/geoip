<?php

namespace AVAllAC\geoip\Service;

use MaxMind\Db\Reader;
use PHPUnit\Framework\TestCase;

class GeoLocationTest extends TestCase
{
    public function testGetByIp()
    {
        $geoReader = new Reader(__DIR__ . '/../../../database/GeoLite2-City_20180206.mmdb');
        $geoLocation = new GeoLocation($geoReader);
        $this->assertSame([
            'lat' => 47.913,
            'lon' => -122.3042,
            'city' => 'Mukilteo',
            'country' => 'United States'
        ], $geoLocation->getByIp('1.2.3.4'));
    }

    public function testGetPrivateIp()
    {
        $geoReader = new Reader(__DIR__ . '/../../../database/GeoLite2-City_20180206.mmdb');
        $geoLocation = new GeoLocation($geoReader);
        $this->assertSame(null, $geoLocation->getByIp('10.2.3.4'));
    }
}
