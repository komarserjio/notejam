<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('see notes can be viewed successfully');
$I->amOnPage('/');
$I->seeInCurrentUrl('/signin');
$I->testLogin();
$I->seeCurrentUrlEquals('/');
$I->see('My pads');
