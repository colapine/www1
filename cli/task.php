<?php

/**
 *  路径分隔符, 缩写
 */
define('DS', DIRECTORY_SEPARATOR);

/**
 * 应用的根目录
 */
define('APPLICATION_PATH', realpath(__DIR__ . '/..'));

$app = new \Yaf\Application(APPLICATION_PATH . '/conf/application.ini');

$app->bootstrap();

$app->getDispatcher()->dispatch(new \Yaf\Request\Simple());
