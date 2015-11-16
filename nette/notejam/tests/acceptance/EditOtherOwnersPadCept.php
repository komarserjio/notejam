<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('see pad can not be edited by not an owner');
$I->testLogin();
$I->amOnPage('/pads/4/edit');
$I->dontSee('Save', 'input');
