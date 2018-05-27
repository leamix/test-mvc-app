<?php

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use src\Application;
use src\ApplicationUser;
use src\DbManager;
use src\View;
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
            DbManager::class => function (ContainerInterface $container) {
                $dsn = $container->get('config')['db']['dsn'];

                return new DbManager($dsn);
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
        ]
    ],
];
