<?php

namespace app\core;

use app\actions\ErrorAction;
use app\core\exceptions\PageNotFoundException;
use Aura\Router\Exception\RouteNotFound;
use Aura\Router\Map;
use Aura\Router\Route;
use Aura\Router\RouterContainer;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RedBeanPHP\R;

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
    /**
     * @var bool
     */
    private $debug;
    /**
     * @var mixed
     */
    private $action;

    public function __construct(
        ContainerInterface $container,
        ServerRequestInterface $request
    ) {
        $this->container = $container;
        $this->request = $request;
        $this->routerContainer = new RouterContainer();
        $this->debug = $this->container->get('config')['debug'];
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

            R::addDatabase('db', $this->container->get('config')['db']['dsn']);
            R::selectDatabase( 'db' );

            /** @var Authorization $auth */
            $auth = $this->container->get(Authorization::class);
            $auth->authorize($request);

            $route = $this->getMatchingRoute();

            foreach ($route->attributes as $attribute => $value) {
                $request = $request->withAttribute($attribute, $value);
            }

            $this->action = $this->container->get($route->handler);

            return ($this->action)($request);
        } catch (RouteNotFound $e) {
            return $this->container->get(ErrorAction::class)($e, 'Undefined route', 404);
        } catch (PageNotFoundException $e) {
            return $this->container->get(ErrorAction::class)($e, $e->getMessage(), 404);
        } catch (\Throwable $e) {
            return $this->container->get(ErrorAction::class)($e);
        }
    }

    private function getMatchingRoute(): Route
    {
        $matcher = $this->routerContainer->getMatcher();

        if ($route = $matcher->match($this->request)) {
            return $route;
        }

        throw new RouteNotFound('No matching route found');
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

    /**
     * @return bool
     */
    public function isDebug(): bool
    {
        return $this->debug;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }
}
