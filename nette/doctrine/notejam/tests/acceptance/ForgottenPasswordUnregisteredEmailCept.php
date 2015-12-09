<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('see user can not successfully get new password with unregistered email');
$I->amOnPage('/forgot-password');
$I->fillField('Email', 'invalid@example.com');
$I->click('Get new password');
$I->see("User with given email doesn't exist");
