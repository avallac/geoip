<?php declare(strict_types=1);

namespace AVAllAC\geoip\Controller;

use AVAllAC\geoip\Service\CacheManager;
use AVAllAC\geoip\Service\GeoLocation;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\Routing\Exception\InvalidParameterException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class GeoController
{
    private $cacheManager;
    private $geoLocation;
    private $cacheLifeTime;

    public function __construct(CacheManager $cacheManager, GeoLocation $geoLocation, int $cacheLifeTime)
    {
        $this->cacheManager = $cacheManager;
        $this->geoLocation = $geoLocation;
        $this->cacheLifeTime = $cacheLifeTime;
    }

    public function ip2geo(ServerRequestInterface $request) : string
    {
        $ip = $request->getQueryParams()['ip'] ?? '';
        if (!filter_var($ip, FILTER_VALIDATE_IP)) {
            throw new InvalidParameterException('Invalid IP address.');
        }
        if ($cacheResult = $this->cacheManager->get($ip)) {
            return $cacheResult;
        } else {
            if ($result = $this->geoLocation->getByIp($ip)) {
                $jsonResult = json_encode($result);
                $this->cacheManager->store($ip, $jsonResult, $this->cacheLifeTime);
                return $jsonResult;
            } else {
                throw new ResourceNotFoundException();
            }
        }
    }
}