<?php
use tests\_pages\SigninPage;

$I = new TestGuy($scenario);
$I->wantTo('ensure that signin works correctly');

$signinPage = SigninPage::openBy($I);

$I->amGoingTo('sign in with empty credentials');
$signinPage->signin('', '');
$I->expectTo('see validations errors');
$I->see('Email cannot be blank.');
$I->see('Password cannot be blank.');

$I->amGoingTo('sign in with wrong credentials');
$signinPage->signin('user@example.com', 'secure');
$I->expectTo('see error message');
$I->see('Incorrect username or password.');

$I->amGoingTo('sign in with correct credentials');
$signinPage->signin('exists@example.com', '123123');
$I->expectTo('see all notes title');
$I->see('All notes');
