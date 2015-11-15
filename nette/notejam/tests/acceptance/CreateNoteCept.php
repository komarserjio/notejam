<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('create a note');
$I->testLogin();
$I->amOnPage('/notes/create');
$I->fillField('Name', 'Example note');
$I->fillField('Text', 'Lorem ipsum');
$I->selectOption('Pad', 1);
$I->click('Save');
$I->see('Example note');
