<?php

use src\Application;
use Zend\Diactoros\Response\SapiEmitter;

define('APP_DIR', dirname(__DIR__));
define('DS', DIRECTORY_SEPARATOR);

require APP_DIR . '/vendor/autoload.php';

/** @var \Zend\ServiceManager\ServiceLocatorInterface  $container */
$container = require APP_DIR . '/app/config/container.php';

/** @var Application $app */
$app = $container->get(Application::class);

require APP_DIR . '/app/config/routes.php';

$response = $app->run();

(new SapiEmitter())->emit($response);
