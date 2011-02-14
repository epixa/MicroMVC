<?php

$rootPath = dirname(dirname(__FILE__));
$appPath  = $rootPath . '/application';

set_include_path(implode(PATH_SEPARATOR, array(
    $rootPath . '/library',
    get_include_path()
)));

require_once $appPath . '/source/Bootstrap.php';
$bootstrap = new App\Bootstrap($appPath);
$bootstrap->bootstrap()->run();