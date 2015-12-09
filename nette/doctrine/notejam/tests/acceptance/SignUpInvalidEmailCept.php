<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('see user can not sign up with invalid email');
$I->amOnPage('/signup');
$I->fillField('Email', 'abcd');
$I->fillField('Password', 'pass');
$I->fillField('confirm', 'pass');
$I->click('Sign up', ['css' => 'form']);
$I->seeInCurrentUrl('/signup');
$I->see('Please enter a valid email address.');
