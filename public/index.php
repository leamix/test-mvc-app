<?php

use src\Application;
use Zend\Diactoros\Response\SapiEmitter;

require dirname(__DIR__) . '/vendor/autoload.php';

$app = new Application();

require dirname(__DIR__) . '/app/config/routes.php';

$response = $app->run();

(new SapiEmitter())->emit($response);
