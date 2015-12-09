<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('see note can not be viewed by not an owner');
$I->testLogin();
$I->amOnPage('/notes/5');
$I->dontSee('Other Note');
$I->dontSee('Lorem ipsum');
