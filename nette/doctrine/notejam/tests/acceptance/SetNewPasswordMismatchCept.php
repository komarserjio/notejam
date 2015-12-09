<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('see user can not set new password without confirming new password');
$I->testLogin();
$I->amOnPage('/settings');
$I->fillField('Current password', 'pass');
$I->fillField('New password', 'pls');
$I->fillField('Confirm', 'pass');
$I->click('Change password');
$I->see('New passwords must match');
