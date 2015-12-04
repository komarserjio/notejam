<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('see user can not successfully get new password with invalid email');
$I->amOnPage('/forgot-password');
$I->fillField('Email', 'invalid');
$I->click('Get new password');
$I->see('Invalid email');
