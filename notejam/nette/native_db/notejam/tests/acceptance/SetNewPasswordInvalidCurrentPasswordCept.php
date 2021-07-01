<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('see user can not set new password with invalid current password');
$I->testLogin();
$I->amOnPage('/settings');
$I->fillField('Current password', 'pls');
$I->fillField('New Password', 'pass');
$I->fillField('Confirm New Password', 'pass');
$I->click('Change Password');
$I->see('Invalid current password');
