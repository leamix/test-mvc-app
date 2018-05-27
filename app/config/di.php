<?php

use Psr\Container\ContainerInterface;
use src\Application;
use src\ApplicationUser;
use Zend\Diactoros\ServerRequestFactory;

return [
    'definitions' => [
        'abstract_factories' => [
            Zend\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory::class,
        ],
        'factories' => [
            Application::class => function (ContainerInterface $container) {
                return new Application(
                    $container,
                    $container->get(ApplicationUser::class),
                    ServerRequestFactory::fromGlobals()
                );
            },
            PDO::class => function (ContainerInterface $container) {
                $dsn = $container->get('config')['db']['dsn'];

                return new PDO($dsn);
            },
            ApplicationUser::class => function () {
                return new ApplicationUser();
            }
        ],
    ],
];
