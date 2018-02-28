<?php declare(strict_types=1);

namespace AVAllAC\geoip\Controller;

use AVAllAC\geoip\Service\CacheManager;
use AVAllAC\geoip\Service\MicroTime;

class StatusController
{
    private $cacheManager;
    private $microTime;

    public function __construct(CacheManager $cacheManager, MicroTime $microTime)
    {
        $this->cacheManager = $cacheManager;
        $this->microTime = $microTime;
    }

    public function status() : string
    {
        return json_encode([
            'storageSize' => $this->cacheManager->getSize(),
            'uptime' => $this->microTime->get() - $this->microTime->getInitTime()
        ]);
    }
}
