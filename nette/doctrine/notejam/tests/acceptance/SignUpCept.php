<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('see user can successfully sign up');
$I->amOnPage('/signup');
$I->fillField('Email', 'test@example.com');
$I->fillField('Password', 'qwerty');
$I->fillField('confirm', 'qwerty');
$I->click('Sign up', ['css' => 'form']);
$I->seeInCurrentUrl('/signin');
$I->see('Thank you for registration. Now you can sign in');
$I->testLogin('test@example.com', 'qwerty');
$I->seeCurrentUrlEquals('/');
$I->see('My pads');
