<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('see user can not sign up without confirming password');
$I->amOnPage('/signup');
$I->fillField('Email', 'test@example.com');
$I->fillField('Password', 'pass');
$I->fillField('confirm', 'pls');
$I->click('Sign up', ['css' => 'form']);
$I->seeInCurrentUrl('/signup');
$I->see('Passwords must match');
