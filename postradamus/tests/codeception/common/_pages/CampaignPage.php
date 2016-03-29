<?php

namespace tests\codeception\common\_pages;

use yii\codeception\BasePage;

/**
 * Represents loging page
 * @property \codeception_admin\AcceptanceTester|\codeception_admin\FunctionalTester|\codeception_app\AcceptanceTester|\codeception_app\FunctionalTester $actor
 */
class CampaignPage extends BasePage
{
    public $route = 'campaign/index';
}
