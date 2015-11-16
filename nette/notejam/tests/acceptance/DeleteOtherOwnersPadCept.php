<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('see pad can not be deleted by not an owner');
$I->testLogin();
$I->amOnPage('/pads/4/delete');
$I->dontSee('Yes, I want to delete this pad');
