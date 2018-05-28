<?php

namespace app\core;

use Aura\Router\Map;
use Aura\Router\Route;
use Aura\Router\RouterContainer;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;

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
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(
        ContainerInterface $container,
        ServerRequestInterface $request
    ) {
        $this->container = $container;
        $this->request = $request;
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
            /** @var Authorization $auth */
            $auth = $this->container->get(Authorization::class);
            $auth->authorize($request);

            $route = $this->getMatchingRoute();

            foreach ($route->attributes as $attribute => $value) {
                $request = $request->withAttribute($attribute, $value);
            }

            $action = $this->container->get($route->handler);

            return $action($request);
        } catch (\LogicException $e) {
            return new HtmlResponse('Undefined page', 404);
        } catch (\Throwable $e) {
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

    /**
     * @return ApplicationUser
     */
    public function getUser(): ApplicationUser
    {
        return $this->container->get(ApplicationUser::class);
    }

    /**
     * @return ContainerInterface
     */
    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }
}
