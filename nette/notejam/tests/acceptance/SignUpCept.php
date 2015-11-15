<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('sign up');
$I->amOnPage('/signup');
$I->fillField('Email', 'johnny.doe@example.com');
$I->fillField('Password', 'qwerty');
$I->fillField('confirm', 'qwerty');
$I->click('Sign Up');
$I->see('Sign in');
$I->testLogin('johnny.doe@example.com', 'qwerty');
$I->seeCurrentUrlEquals('/');
$I->see('My pads');
