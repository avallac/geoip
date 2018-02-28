<?php

namespace AVAllAC\geoip\Provider;

use AVAllAC\geoip\Service\MicroTime;
use PHPUnit\Framework\TestCase;
use Pimple\Container;

class MicroTimeProviderTest extends TestCase
{
    public function testRegister()
    {
        $pimple = new Container();
        $mtp = new MicroTimeProvider();
        $mtp->register($pimple);
        $this->assertInstanceOf(MicroTime::class, $pimple['microTime']);
    }
}