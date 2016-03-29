<?php

use tests\codeception\backend\AcceptanceTester;
use tests\codeception\common\_pages\CampaignPage;
use tests\codeception\common\_pages\LoginPage;

$I = new AcceptanceTester($scenario);
$I->wantTo('ensure campaign page loads');

$loginPage = LoginPage::openBy($I);

//Log us in
$I->amGoingTo('try to login with correct credentials');
$loginPage->login('erau', 'password_0');
$I->expectTo('see that user is logged');
$I->seeLink('Logout (erau)');
$I->dontSeeLink('Login');
$I->dontSeeLink('Signup');

$campaignPage = CampaignPage::openBy($I);

//page loaded?
$I->amGoingTo('see if the page loaded correctly');
$I->expectTo('see "Showing" text');
$I->see('Showing', '.summary');
$I->expectTo('see "Active" filter is selected.');
$I->see('Active', '.active');

//test sorting
$I->amGoingTo('confirm that sorting by status works fine');
$I->click('Status', '//a[@data-sort="status"]');
$I->expectTo('see a "status sort icon"');
$I->see('Status', '//a[@data-sort="-status"]');
$I->seeInCurrentUrl('sort=status');
$I->click('Status', '//a[@data-sort="-status"]');
$I->expectTo('see a "status sort icon flipped"');
$I->see('Status', '//a[@data-sort="status"]');
$I->seeInCurrentUrl('sort=-status');

//test paging
$I->amGoingTo('confirm that paging works fine');
$I->click('3', '//a[@data-page="2"]');
$I->expectTo('see the url has changed correctly"');
$I->seeElement('//li[@class="active"]/a[@data-page="2"]');
$I->expectTo('see the url has changed correctly"');
$I->seeInCurrentUrl('page=3');

//test limit button
$I->amGoingTo('confirm qty limit works right');
$I->click('10', '//li[@role="presentation"]/a');
$I->expectTo('see the Showing 1-10 results');
$I->see('Showing 1-10', '.summary');

$I->click('100', '//li[@role="presentation"]/a');
$I->expectTo('see the Showing 1-100 results');
$I->see('Showing 1-100', '.summary');

//test filters
$I->amGoingTo('click active filter which will de-select active filter');
$I->click('Active');
$I->expectTo('see Active has been unselected now.');
$I->dontSee('Active', '.active');

$I->amGoingTo('click highest selling filter');
$I->click('Highest Selling');
$I->expectTo('see Highest Selling has been selected now.');
$I->see('Highest Selling', '.active');
$I->amGoingTo('click highest selling filter which will de-select highest selling filter');
$I->click('Highest Selling');
$I->expectTo('see Highest Selling has been de-selected now.');
$I->dontSee('Highest Selling', '.active');

$I->amGoingTo('click 1+ sales filter');
$I->click('1+ Sales');
$I->expectTo('see 1+ Sales has been selected now.');
$I->see('1+ Sales', '.active');
$I->amGoingTo('click 1+ sales filter which will de-select 1+ sales filter');
$I->click('1+ Sales');
$I->expectTo('see 1+ Sales has been de-selected now.');
$I->dontSee('1+ Sales', '.active');

$I->amGoingTo('click latest added filter');
$I->click('Latest Added');
$I->expectTo('see Latest Added has been selected now.');
$I->see('Latest Added', '.active');
$I->amGoingTo('click latest added filter which will de-select latest added filter');
$I->click('Latest Added');
$I->expectTo('see Latest Added has been de-selected now.');
$I->dontSee('Latest Added', '.active');

//test reset button
$I->amGoingTo('click reset button');
$I->click('Reset');
$I->expectTo('see page has reset');
$I->seeElement('//li[@class="active"]/a[@data-page="0"]'); //on correct page of paging elements
$I->cantSeeInCurrentUrl('&'); //no extra parameters in url
$I->see('Active', '//li[@class="active"]/a');
//$I->see('Highest Selling', '//li[@class="active"]/a');
//$I->see('1+ Sales', '//li[@class="active"]/a');
