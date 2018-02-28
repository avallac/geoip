GeoIP [![Build Status](https://img.shields.io/travis/avallac/geoip.svg)](https://travis-ci.org/avallac/geoip)
==============

[![Latest Stable Version](https://img.shields.io/packagist/v/avallac/geoip.svg)](https://packagist.org/packages/avallac/geoip)
[![codecov.io](https://codecov.io/github/avallac/geoip/coverage.svg?branch=master)](https://codecov.io/github/avallac/geoip?branch=master)


Описание
--------
Демон, написанный на react-PHP, для определения географической принадлежности IP адреса.

Особенности:
 * Кеширование запроса для ускорения работы сервис
 
Установка
---------
1. Запустите ```composer create-project avallac/geoip```
2. При необходимости отредактируйте geoip/etc/config.yml:
```
listenPort: Номер слушающего порта
cacheTimeOut: Срок жизни кэшированных записей. В секундах.
cleanTimer: Интервал очистки старых записей. В секундах.
```
3. Запустите ```php ./geoip/bin/geo_ip_server.php```

Методы
-------------
1. GET /ip2geo?ip=x.x.x.x в ответ возвращать JSON с широтой, долготой и названиями страны и города на английском языке.
2. GET /status в ответ возвращать JSON с временем с момента запуска сервиса, в секундах, и количеством записей в кеше.