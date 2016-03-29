<?php
use tests\codeception\admin\AcceptanceTester;
use tests\codeception\admin\_pages\AboutPage;

$I = new AcceptanceTester($scenario);
$I->wantTo('ensure that about works');
AboutPage::openBy($I);
$I->see('About', 'h1');
