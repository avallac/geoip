<?php declare(strict_types=1);

namespace AVAllAC\geoip\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class RoutingProvider implements ServiceProviderInterface
{
    public function register(Container $pimple) : void
    {
        $pimple['router'] = function () use ($pimple) {
            $routes = new RouteCollection();
            $route = new Route('/ip2geo', ['_controller' => [$pimple['geoController'], 'ip2geo']]);
            $routes->add('ip2geo', $route);
            $route = new Route('/status', ['_controller' => [$pimple['statusController'], 'status']]);
            $routes->add('status', $route);
            return new UrlMatcher($routes, new RequestContext('/'));
        };
    }
}