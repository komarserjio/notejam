<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('see user can successfully sign up');
$I->amOnPage('/signup');
$I->fillField('Email', 'test@example.com');
$I->fillField('Password', 'qwerty');
$I->fillField('confirm', 'qwerty');
$I->click('Sign Up');
$I->seeInCurrentUrl('/signin');
$I->see('User is successfully created. Now you can sign in.');
$I->testLogin('test@example.com', 'qwerty');
$I->seeCurrentUrlEquals('/');
$I->see('My pads');
