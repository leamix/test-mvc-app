<?php

use app\core\Application;
use app\core\ApplicationUser;
use app\core\Hydrator;
use app\core\Pagination;
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
            Pagination::class => function (ContainerInterface $container) {
                return new Pagination(
                    $container->get('config')['pageSize'],
                    $container->get(ServerRequestInterface::class)
                );
            },
        ],
        'invokables' => [
            ApplicationUser::class,
            Hydrator::class,
        ],
    ],
];
