<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('see user can successfully set new password');
$I->testLogin();
$I->amOnPage('/settings');
$I->fillField('Current password', 'pass');
$I->fillField('New password', 'qwerty');
$I->fillField('Confirm', 'qwerty');
$I->click('Change password');
$I->see('Account settings');
