<?php

namespace tests\codeception\common\_pages\cron;

use yii\codeception\BasePage;

/**
 * Represents loging page
 * @property \codeception_admin\AcceptanceTester|\codeception_admin\FunctionalTester|\codeception_app\AcceptanceTester|\codeception_app\FunctionalTester $actor
 */
class TeeSpring extends BasePage
{
    public $route = 'cron/tee-spring';
}
