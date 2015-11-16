<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('see pad can be successfully created');
$I->testLogin();
$I->amOnPage('/pads/create');
$I->fillField('Name', 'Example pad');
$I->click('Save');
$I->see('Example pad');
