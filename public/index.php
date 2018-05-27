<?php

use src\RouterAdapter;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\SapiEmitter;
use Zend\Diactoros\ServerRequestFactory;

require dirname(__DIR__) . '/vendor/autoload.php';

$request = ServerRequestFactory::fromGlobals();

$routeContainer = new Aura\Router\RouterContainer();
$routes = $routeContainer->getMap();

require dirname(__DIR__) . '/app/config/routes.php';

$router = new RouterAdapter($routeContainer);

try {
    $result = $router->match($request);
    foreach ($result->attributes as $attribute => $value) {
        $request = $request->withAttribute($attribute, $value);
    }
    $handlerClass = $result->handler;
    $action = new $handlerClass();
    $response = $action($request);
} catch (\LogicException $e){
    $response = new HtmlResponse('Undefined page', 404);
}

(new SapiEmitter())->emit($response);
