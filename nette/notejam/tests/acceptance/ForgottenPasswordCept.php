<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('see user can successfully get new password');
$I->amOnPage('/forgot-password');
$I->fillField('Email', 'john.doe@example.com');
$I->click('Get new password');
$I->see('Sign in');
