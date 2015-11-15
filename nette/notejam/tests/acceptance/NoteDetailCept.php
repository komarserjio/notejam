<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('see note detail');
$I->testLogin();
$I->amOnPage('/notes/1');
$I->see('Note 1');
$I->see('Lorem ipsum');
