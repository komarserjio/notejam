<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('see user can successfully sign in');
$I->testLogin();
$I->see("My pads");
