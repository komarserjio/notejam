<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('see user can not set new password without required fields');
$I->testLogin();
$I->amOnPage('/settings');
$I->fillField('Current password', '');
$I->fillField('New Password', '');
$I->fillField('Confirm New Password', '');
$I->click('Change Password');
$I->see('Current password is required');
$I->see('New password is required');
