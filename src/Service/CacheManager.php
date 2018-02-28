<?php declare(strict_types=1);

namespace AVAllAC\geoip\Service;

class CacheManager
{
    protected $storage = [];
    protected $microTime;
    protected $debug;

    public function __construct(MicroTime $microTime)
    {
        $this->microTime = $microTime;
    }

    public function get(string $key) : ?string
    {
        if (isset($this->storage[$key])) {
            if ($this->storage[$key]['expiredAt'] > $this->microTime->get()) {
                return $this->storage[$key]['data'];
            }
        }
        return null;
    }

    public function store(string $key, string $data, int $lifeTime) : void
    {
        $this->storage[$key] = [
            'expiredAt' => $this->microTime->get() + $lifeTime,
            'data' => $data
        ];
    }

    public function getSize() : int
    {
        return sizeof($this->storage);
    }

    public function clean() : void
    {
        $now = $this->microTime->get();
        foreach ($this->storage as $key => $data) {
            if ($data['expiredAt'] < $now) {
                unset($this->storage[$key]);
            }
        }
    }
}
