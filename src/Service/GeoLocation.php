<?php declare(strict_types=1);

namespace AVAllAC\geoip\Service;

use MaxMind\Db\Reader;

class GeoLocation
{
    protected $geoReader;

    public function __construct(Reader $reader)
    {
        $this->geoReader = $reader;
    }

    public function getByIp($ip) : ?array
    {
        $record = $this->geoReader->get($ip);
        if ($record) {
            return [
                'lat' => $record['location']['latitude'],
                'lon' => $record['location']['longitude'],
                'city' => $record['city']['names']['en'],
                'country' => $record['country']['names']['en']
            ];
        }
        return null;
    }
}