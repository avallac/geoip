<?php

namespace AVAllAC\geoip\Provider;

use AVAllAC\geoip\Service\Kernel;
use PHPUnit\Framework\TestCase;
use Pimple\Container;
use Symfony\Component\Routing\Matcher\UrlMatcher;

class KernelProviderTest extends TestCase
{
    public function testRegister()
    {
        $pimple = new Container();
        $pimple['router'] =  $this->createMock(UrlMatcher::class);
        $kp = new KernelProvider();
        $kp->register($pimple);
        $this->assertInstanceOf(Kernel::class, $pimple['kernel']);
    }
}