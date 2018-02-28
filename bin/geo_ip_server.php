<?php declare(strict_types=1);

use Psr\Http\Message\ServerRequestInterface;
use React\EventLoop\Factory;
use React\Http\Response;
use React\Http\Server;

require __DIR__ . '/../vendor/autoload.php';

$pimple = new Pimple\Container();
$pimple['config'] = \Symfony\Component\Yaml\Yaml::parseFile(__DIR__ . '/../etc/config.yml');
$pimple->register(new \AVAllAC\geoip\Provider\RoutingProvider());
$pimple->register(new \AVAllAC\geoip\Provider\CacheManagerProvider());
$geoReader = new \MaxMind\Db\Reader(__DIR__ . '/../database/city.mmdb');
$pimple->register(new \AVAllAC\geoip\Provider\GeoLocationProvider($geoReader));
$pimple->register(new \AVAllAC\geoip\Provider\KernelProvider());
$pimple->register(new \AVAllAC\geoip\Provider\MicroTimeProvider());
$pimple->register(new \AVAllAC\geoip\Provider\RoutingProvider());
$pimple->register(new \AVAllAC\geoip\Provider\ControllersProvider());

$loop = Factory::create();
$server = new Server(function (ServerRequestInterface $request) use ($pimple) {
    try {
        $response = $pimple['kernel']->handle($request);
        return new Response(200, ['Content-Type' => 'application/json'], $response);
    } catch (\Symfony\Component\Routing\Exception\ResourceNotFoundException $e) {
        return new Response(404, ['Content-Type' => 'text/plain'], $e->getMessage());
    } catch (\Symfony\Component\Routing\Exception\InvalidParameterException $e) {
        return new Response(400, ['Content-Type' => 'text/plain'], $e->getMessage());
    } catch (\Throwable $e) {
        print ($e->getMessage() . "\n");
        throw $e;
    }
});

if ($pimple['config']['cleanTimer'] > 0) {
    $loop->addPeriodicTimer($pimple['config']['cleanTimer'], function () use ($pimple) {
        $pimple['cacheManager']->clean();
    });
}

$socket = new \React\Socket\Server('0.0.0.0:' . $pimple['config']['listenPort'], $loop);
$server->listen($socket);
print 'Listening on ' . str_replace('tcp:', 'http:', $socket->getAddress()) . PHP_EOL;
if (!$pimple['config']['debug']) {
    $child_pid = pcntl_fork();
    if ($child_pid) {
        exit();
    }
    print "My pid: " . getmypid() . PHP_EOL;
    posix_setsid();
    fclose(STDIN);
    fclose(STDOUT);
    fclose(STDERR);
}
$loop->run();
