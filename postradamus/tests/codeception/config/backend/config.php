<?php
$params = array_merge(
    require(__DIR__ . '/../../../../backend/config/params.php'),
    require(__DIR__ . '/../../../../backend/config/params-local.php')
);
/**
 * Application configuration for all app test types
 */
return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__) . '../../../../backend/',
    'controllerNamespace' => 'backend\controllers',
    'params' => $params,
];