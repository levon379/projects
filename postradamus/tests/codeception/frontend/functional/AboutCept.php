<?php
use tests\codeception\admin\FunctionalTester;
use tests\codeception\admin\_pages\AboutPage;

$I = new FunctionalTester($scenario);
$I->wantTo('ensure that about works');
AboutPage::openBy($I);
$I->see('About', 'h1');
