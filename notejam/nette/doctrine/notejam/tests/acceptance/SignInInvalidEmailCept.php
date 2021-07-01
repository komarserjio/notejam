<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('see user can not sign in with invalid email');
$I->testLogin('invalid@example.com', 'pass');
$I->see("User 'invalid@example.com' not found.");
