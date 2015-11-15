<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('renew forgotten password');
$I->amOnPage('/forgot-password');
$I->fillField('Email', 'john.doe@example.com');
$I->click('Get new password');
$I->see('Sign in');
