<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('see pad can be viewed');
$I->testLogin();
$I->amOnPage('/pads/1');
$I->see('Pad 1');
$I->see('Note 2'); // Note 2 belongs to Pad 1
