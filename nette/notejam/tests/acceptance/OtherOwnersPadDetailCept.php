<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('see pad can not be viewed by not an owner');
$I->testLogin();
$I->amOnPage('/pads/4');
$I->dontSee('Other Pad');
