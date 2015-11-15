<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('see homepage');
$I->amOnPage('/');
$I->seeInCurrentUrl('/signin');
$I->testLogin();
$I->seeCurrentUrlEquals('/');
$I->see('My pads');
