<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('set new password with invalid current password');
$I->testLogin();
$I->amOnPage('/settings');
$I->fillField('Current password', 'pass');
$I->fillField('New Password', 'pls');
$I->fillField('Confirm New Password', 'pass');
$I->click('Change Password');
$I->see('New passwords must match');
