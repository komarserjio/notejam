<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('delete other owner\'s pad');
$I->testLogin();
$I->amOnPage('/pads/4/delete');
$I->dontSee('Yes, I want to delete this pad');
