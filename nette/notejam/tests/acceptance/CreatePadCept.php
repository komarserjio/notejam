<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('create a pad');
$I->testLogin();
$I->amOnPage('/pads/create');
$I->fillField('Name', 'Example pad');
$I->click('Save');
$I->see('Example pad');
