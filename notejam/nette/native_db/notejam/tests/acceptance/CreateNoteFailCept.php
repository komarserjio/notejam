<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('see note can not be created without required fields');
$I->testLogin();
$I->amOnPage('/notes/create');
$I->click('Save');
$I->seeInCurrentUrl('/notes/create');
$I->see('Name is required');
$I->see('Text is required');
