<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('sign in');
$I->testLogin();
$I->see("My pads");
