<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('delete pad');
$I->testLogin();
$I->amOnPage('/pads/1/delete');
$I->click('Yes, I want to delete this pad');
$I->dontSee('Pad 1');
