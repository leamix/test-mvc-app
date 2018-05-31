<?php

use app\core\Application;
use app\core\ApplicationUser;
use app\core\DbManager;
use app\core\Hydrator;
use app\core\View;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\ServerRequestFactory;

return [
    'definitions' => [
        'abstract_factories' => [
            Zend\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory::class,
        ],
        'factories' => [
            ServerRequestInterface::class => function () {
                return ServerRequestFactory::fromGlobals();
            },
            Application::class => function (ContainerInterface $container) {
                return new Application(
                    $container,
                    $container->get(ServerRequestInterface::class)
                );
            },
            View::class => function (ContainerInterface $container) {
                return new View(
                    $container->get('config')['viewPath'],
                    $container
                );
            },
        ],
        'invokables' => [
            ApplicationUser::class,
            Hydrator::class,
        ],
    ],
];
