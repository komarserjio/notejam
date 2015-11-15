<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('set new password');
$I->testLogin();
$I->amOnPage('/settings');
$I->fillField('Current password', 'pass');
$I->fillField('New password', 'qwerty');
$I->fillField('Confirm new password', 'qwerty');
$I->click('Save');
$I->see('Account settings');
