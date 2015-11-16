<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('create a pad without required fields');
$I->testLogin();
$I->amOnPage('/pads/create');
$I->click('Save');
$I->dontSee('Example pad');
$I->seeInCurrentUrl('/pads/create');
$I->see('Name is required');
