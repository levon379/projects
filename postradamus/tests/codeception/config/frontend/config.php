<?php
$params = array_merge(
    require(__DIR__ . '/../../../../frontend/config/params.php'),
    require(__DIR__ . '/../../../../frontend/config/params-local.php')
);
/**
 * Application configuration for all app test types
 */
return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__) . '../../../../frontend/',
    'controllerNamespace' => 'frontend\controllers',
    'params' => $params,
];