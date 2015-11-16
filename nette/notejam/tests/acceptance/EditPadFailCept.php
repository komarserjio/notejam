<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('see pad cannot be edited without required fields');
$I->testLogin();
$I->amOnPage('/pads/1/edit');
$I->fillField('Name', '');
$I->click('Save');
$I->seeInCurrentUrl('/pads/1/edit');
$I->see('Name is required');
