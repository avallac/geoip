<?php declare(strict_types=1);

namespace AVAllAC\geoip\Service;

use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;

class Kernel
{
    private $router;

    public function __construct(UrlMatcherInterface $router)
    {
        $this->router = $router;
    }

    public function handle(ServerRequestInterface $request) : string
    {
        $params = ['request' => $request];
        $route = $request->getUri()->getPath();
        $matched = $this->router->match($route);
        $params = array_merge($params, $matched);
        unset($params['_controller']);
        unset($params['_route']);
        return \call_user_func_array($matched['_controller'], $params);
    }
}