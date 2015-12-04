<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('see pad can be successfully edited');
$I->testLogin();
$I->amOnPage('/pads/1/edit');
$I->fillField('Name', 'Pad 1 - edited');
$I->click('Save');
$I->see('Pad 1 - edited');
