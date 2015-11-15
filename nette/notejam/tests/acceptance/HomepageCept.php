<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('see homepage');
$I->amOnPage('/');
$I->seeCurrentUrlEquals('/signin');
$I->testLogin();
$I->amOnPage('/');
$I->see('My pads');
