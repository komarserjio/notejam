<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('sign up with passwords that don\'t match');
$I->amOnPage('/signup');
$I->fillField('Email', 'test@example.com');
$I->fillField('Password', 'pass');
$I->fillField('confirm', 'pls');
$I->click('Sign Up');
$I->seeInCurrentUrl('/signup');
$I->see('Passwords must match');
