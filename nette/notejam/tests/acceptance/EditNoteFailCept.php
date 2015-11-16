<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('edit a note without required fields');
$I->testLogin();
$I->amOnPage('/notes/1/edit');
$I->fillField('Name', '');
$I->fillField('Text', '');
$I->click('Save');
$I->seeInCurrentUrl('/notes/1/edit');
$I->see('Name is required');
$I->see('Text is required');
