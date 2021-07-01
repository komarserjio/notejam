<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('see user can successfully set new password');
$I->testLogin();
$I->amOnPage('/settings');
$I->fillField('Current password', 'pass');
$I->fillField('New Password', 'qwerty');
$I->fillField('Confirm New Password', 'qwerty');
$I->click('Change Password');
$I->see('Account settings');
