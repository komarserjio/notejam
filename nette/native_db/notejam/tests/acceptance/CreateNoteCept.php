<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('see note can be successfully created');
$I->testLogin();
$I->amOnPage('/notes/create');
$I->fillField('Name', 'Example note');
$I->fillField('Text', 'Lorem ipsum');
$I->selectOption('Pad', 1);
$I->click('Save');
$I->see('Example note');
