<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('delete pad');
//$I->amOnPage('/pads/5/delete');
//$I->seeResponseCodeIs(404); // This will work only in production mode
$I->testLogin();
$I->amOnPage('/pads/1/delete');
$I->click('Yes, I want to delete this pad');
$I->dontSee('Pad 1');
