<?php

namespace src;

use Aura\Router\Map;
use Aura\Router\Route;
use Aura\Router\RouterContainer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\ServerRequestFactory;

final class Application
{
    /**
     * @var RouterContainer
     */
    private $routerContainer;
    /**
     * @var ServerRequestInterface
     */
    private $request;

    public function __construct(ServerRequestInterface $request = null)
    {
        if (null === $request) {
            $this->request = ServerRequestFactory::fromGlobals();
        }

        $this->routerContainer = new RouterContainer();
    }

    public function getRequest(): ServerRequestInterface
    {
        return $this->request;
    }

    public function getRouterContainerMap(): Map
    {
        return $this->routerContainer->getMap();
    }

    public function run(): ResponseInterface
    {
        try {
            $request = $this->request;
            $route = $this->getMatchingRoute();

            foreach ($route->attributes as $attribute => $value) {
                $request = $request->withAttribute($attribute, $value);
            }

            $handlerClass = $route->handler;
            $action = new $handlerClass();

            return $action($request);
        } catch (\LogicException $e){
            return new HtmlResponse('Undefined page', 404);
        } catch (\Throwable $e){
            return new HtmlResponse('Site error', 500);
        }
    }

    private function getMatchingRoute(): Route
    {
        $matcher = $this->routerContainer->getMatcher();

        if ($route = $matcher->match($this->request)) {
            return $route;
        }

        throw new \LogicException('No matching route found');
    }
}
