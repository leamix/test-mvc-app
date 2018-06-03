<?php

use Zend\ServiceManager\ServiceManager;

$config = require __DIR__ . '/config.php';
$di = require __DIR__ . '/di.php';

return new ServiceManager($di);
