<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('see user can not sign in with invalid password');
$I->testLogin('john.doe@example.com', 'pls');
$I->see('Invalid password');
