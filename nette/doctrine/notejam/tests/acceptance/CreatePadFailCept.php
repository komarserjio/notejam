<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('see pad can not be created without required fields');
$I->testLogin();
$I->amOnPage('/pads/create');
$I->click('Save');
$I->dontSee('Example pad');
$I->seeInCurrentUrl('/pads/create');
$I->see('Name is required');
