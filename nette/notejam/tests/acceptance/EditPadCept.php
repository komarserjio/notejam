<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('edit pad');
//$I->amOnPage('/pads/5/edit');
//$I->seeResponseCodeIs(404); // This will work only in production mode
$I->testLogin();
$I->amOnPage('/pads/1/edit');
$I->fillField('Name', 'Pad 1 - edited');
$I->click('Save');
$I->see('Pad 1 - edited');
