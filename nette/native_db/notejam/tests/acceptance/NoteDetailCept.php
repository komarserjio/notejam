<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('see note can be viewed successfully');
$I->testLogin();
$I->amOnPage('/notes/1');
$I->see('Note 1');
$I->see('Lorem ipsum');
