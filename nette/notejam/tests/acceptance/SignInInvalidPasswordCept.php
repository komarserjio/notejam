<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('sign in with invalid password');
$I->testLogin('john.doe@example.com', 'pls');
$I->see('Invalid password');
