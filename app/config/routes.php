<?php

use app\actions;

/**
 * @var $app \src\Application
 */

$routes = $app->getRouterContainerMap();

$routes->get(
    'index',
    '/',
    actions\IndexAction::class
);

$routes->get(
    'tasks',
    '/tasks/{page}',
    actions\IndexAction::class
)
    ->tokens(['page' => '\d+']);

$routes->get(
    'login',
    '/login',
    actions\LoginAction::class
);

$routes->get(
    'task-create',
    '/tasks/create',
    actions\TaskCreateAction::class
)
    ->allows(['GET', 'POST']);

$routes->route(
    'task-edit',
    '/tasks/update/{id}',
    actions\TaskUpdateAction::class
)
    ->tokens(['id' => '\d+'])
    ->allows(['GET', 'POST']);

$routes->get(
    'task-view',
    '/tasks/{id}',
    actions\TaskViewAction::class
)
    ->tokens(['id' => '\d+']);
