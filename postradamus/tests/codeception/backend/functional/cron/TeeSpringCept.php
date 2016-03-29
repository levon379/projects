<?php

use tests\codeception\backend\FunctionalTester;
use tests\codeception\common\_pages\cron\TeeSpring;

$I = new FunctionalTester($scenario);
$I->wantTo('ensure cron/tee-spring page loads');

$page = TeeSpring::openBy($I);

$I->expectTo('see "success" text');
$I->see('success');
/*
$I->amGoingTo('try to login with wrong credentials');
$I->expectTo('see validations errors');
$loginPage->login('admin', 'wrong');
$I->expectTo('see validations errors');
$I->see('Incorrect username or password.', '.help-block');

$I->amGoingTo('try to login with correct credentials');
$loginPage->login('erau', 'password_0');
$I->expectTo('see that user is logged');
$I->seeLink('Logout (erau)');
$I->dontSeeLink('Login');
$I->dontSeeLink('Signup');
*/