<?php

use app\core\Application;
use app\core\ApplicationUser;
use app\core\Hydrator;
use app\core\Pagination;
use app\core\Settings;
use app\core\View;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\ServerRequestFactory;

return [
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
                $container->get(ServerRequestInterface::class),
                $container->get(Settings::class)
            );
        },
        View::class => function (ContainerInterface $container) {
            return new View(
                $container->get(Settings::class)->get('viewPath'),
                $container
            );
        },
        Settings::class => function () use ($config) {
            return new Settings($config);
        },
    ],
    'invokables' => [
        ApplicationUser::class,
        Hydrator::class,
        Pagination::class,
    ],
];
