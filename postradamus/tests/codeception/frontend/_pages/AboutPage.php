<?php

namespace tests\codeception\admin\_pages;

use yii\codeception\BasePage;

/**
 * Represents about page
 * @property \codeception_admin\AcceptanceTester|\codeception_admin\FunctionalTester $actor
 */
class AboutPage extends BasePage
{
    public $route = 'site/about';
}
