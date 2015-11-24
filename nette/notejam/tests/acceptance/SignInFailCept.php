<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('see user can not sign in without required fields');
$I->amOnPage('/signin');
$I->see('Sign in');
$I->fillField("Email", '');
$I->fillField("Password", '');
$I->click('Sign in', ['css' => 'form.sign-in']);
$I->see('Email is required');
$I->see('Password is required');
