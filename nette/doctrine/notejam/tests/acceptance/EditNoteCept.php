<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('see note can be successfully edited');
$I->testLogin();
$I->amOnPage('/notes/1/edit');
$I->fillField('Name', 'Note 1 - edited');
$I->fillField('Text', 'Lorem ipsum - edited');
$I->selectOption('Pad', 1);
$I->click('Save');
$I->see('Note 1 - edited');
$I->amOnPage('/pads/1');
$I->see('Note 1 - edited');
