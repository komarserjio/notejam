<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('edit an other owner\'s pad');
$I->testLogin();
$I->amOnPage('/pads/4/edit');
$I->dontSee('Save', 'input');
