<?php

namespace app\tests\unit;

class TestCase extends \yii\codeception\TestCase
{
    use \Codeception\Specify;
    public $appConfig = '@tests/codeception/config/backend/unit.php';
}
