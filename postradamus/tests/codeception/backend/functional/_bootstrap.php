<?php
ini_set('memory_limit', '512M');
new yii\web\Application(require(dirname(dirname(__DIR__)) . '/config/backend/functional.php'));
