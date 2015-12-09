<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('see user can not set new password with invalid current password');
$I->testLogin();
$I->amOnPage('/settings');
$I->fillField('Current password', 'pls');
$I->fillField('New password', 'pass');
$I->fillField('Confirm', 'pass');
$I->click('Change password');
$I->see('Invalid current password');
