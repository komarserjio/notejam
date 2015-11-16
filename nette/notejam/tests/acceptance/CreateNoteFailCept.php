<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('create a note without required fields');
$I->testLogin();
$I->amOnPage('/notes/create');
$I->click('Save');
$I->seeInCurrentUrl('/notes/create');
$I->see('Name is required');
$I->see('Text is required');
