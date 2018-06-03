<?php

namespace app\core;

use app\actions\ErrorAction;
use app\core\exceptions\PageNotFoundException;
use app\core\exceptions\UnauthorizedException;
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
     * @var mixed
     */
    private $action;
    /**
     * @var Settings
     */
    private $settings;

    public function __construct(
        ContainerInterface $container,
        ServerRequestInterface $request,
        Settings $settings
    ) {
        $this->container = $container;
        $this->request = $request;
        $this->routerContainer = new RouterContainer();
        $this->settings = $settings;
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

            R::addDatabase('db', $this->settings->dbDsn);
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
        } catch (UnauthorizedException $e) {
            return $this->container->get(ErrorAction::class)($e, $e->getMessage(), 403);
        } catch (\Throwable $e) {
            return $this->container->get(ErrorAction::class)($e);
        }
    }

    private function getMatchingRoute(): Route
    {
        $matcher = $this->routerContainer->getMatcher();
        $route = $matcher->match($this->request);

        if (!$route) {
            throw new RouteNotFound('No matching route found');
        }

        if ($route->auth && !($route->auth)($this->container->get(ApplicationUser::class))) {
            throw new UnauthorizedException();
        }

        return $route;
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
        return $this->settings->isDebug;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }
}
