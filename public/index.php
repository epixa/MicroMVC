<?php

$rootPath = dirname(dirname(__FILE__));
$libPath  = $rootPath . '/library';
$appPath  = $rootPath . '/application';

require_once $libPath . '/Micro/Loader/Autoloader.php';
$loader = new Micro\Loader\Autoloader('Micro', $libPath);
spl_autoload_register(array($loader, 'loadClass'));

require_once $appPath . '/source/Bootstrap.php';
$bootstrap = new App\Bootstrap($appPath);
$bootstrap->bootstrap()->run();