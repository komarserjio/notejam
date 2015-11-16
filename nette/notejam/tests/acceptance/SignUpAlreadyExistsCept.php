<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('see user can not sign up with already registered email');
$I->amOnPage('/signup');
$I->fillField('Email', 'john.doe@example.com');
$I->fillField('Password', 'pass');
$I->fillField('confirm', 'pass');
$I->click('Sign Up');
$I->seeInCurrentUrl('/signup');
$I->see('User with given email already registered');
