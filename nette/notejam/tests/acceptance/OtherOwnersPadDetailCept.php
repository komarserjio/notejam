<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('see other owner\'s pad detail');
$I->testLogin();
$I->amOnPage('/pads/4');
$I->dontSee('Other Pad');
