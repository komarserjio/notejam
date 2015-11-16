<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('sign in with invalid email');
$I->testLogin('invalid@example.com', 'pass');
$I->see("Unknown user");
