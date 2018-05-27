<?php

use src\Application;
use Zend\Diactoros\Response\SapiEmitter;

define('APP_DIR', dirname(__DIR__));

require APP_DIR . '/vendor/autoload.php';

$app = new Application();

require APP_DIR . '/app/config/routes.php';

$response = $app->run();

(new SapiEmitter())->emit($response);
