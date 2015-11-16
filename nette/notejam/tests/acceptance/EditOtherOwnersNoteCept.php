<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('edit an other owner\'s note');
$I->testLogin();
$I->amOnPage('/notes/5/edit');
$I->dontSee('Save', 'input');
