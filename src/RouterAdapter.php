<?php

namespace src;

use Aura\Router\Route;
use Aura\Router\RouterContainer;
use Psr\Http\Message\ServerRequestInterface;

class RouterAdapter
{
    private $routerContainer;

    public function __construct(RouterContainer $aura)
    {
        $this->routerContainer = $aura;
    }

    public function match(ServerRequestInterface $request): Route
    {
        $matcher = $this->routerContainer->getMatcher();
        if ($route = $matcher->match($request)) {
            return $route;
        }

        throw new \LogicException('No matching route found');
    }
}
