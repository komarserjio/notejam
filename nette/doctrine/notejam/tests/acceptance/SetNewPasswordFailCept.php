<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('see user can not set new password without required fields');
$I->testLogin();
$I->amOnPage('/settings');
$I->fillField('Current password', '');
$I->fillField('New password', '');
$I->fillField('Confirm', '');
$I->click('Change password');
$I->see('Current password is required');
$I->see('New password is required');
