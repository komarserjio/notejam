<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('see note can not be edited by not an owner');
$I->testLogin();
$I->amOnPage('/notes/5/edit');
$I->dontSee('Save', 'input');
