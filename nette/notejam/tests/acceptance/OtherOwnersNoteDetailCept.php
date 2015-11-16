<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('see other owner\'s note detail');
$I->testLogin();
$I->amOnPage('/notes/5');
$I->dontSee('Other Note');
$I->dontSee('Lorem ipsum');
