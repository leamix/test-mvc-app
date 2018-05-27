<?php

use Zend\ServiceManager\ServiceManager;

$config = require __DIR__ . '/config.php';
$di = require __DIR__ . '/di.php';

$container = new ServiceManager($di['definitions']);

$container->setService('config', $config);

return $container;
