<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('see user can not sign up without required fields');
$I->amOnPage('/signup');
$I->fillField('Email', '');
$I->fillField('Password', '');
$I->fillField('confirm', '');
$I->click('Sign Up');
$I->seeInCurrentUrl('/signup');
$I->see('Email is required');
$I->see('Password is required');
