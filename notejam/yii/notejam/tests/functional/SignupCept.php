<?php
use tests\_pages\SignupPage;

$I = new TestGuy($scenario);
$I->wantTo('ensure that signup works correctly');

$signupPage = SignupPage::openBy($I);

$I->amGoingTo('sign up coreectly');
$signupPage->signup('user@example.com', 'password', 'password');
$I->expectTo('see success message');
$I->see('Now you can sign in.');

$I->amGoingTo('sign up with empty fields');
$signupPage = SignupPage::openBy($I);
$signupPage->signup('', '', '');
$I->expectTo('see validations errors');
$I->see('Email cannot be blank.');
$I->see('Password cannot be blank.');

$I->amGoingTo('sign up with different passwords');
$signupPage = SignupPage::openBy($I);
$signupPage->signup('user2@example.com', 'password', 'pa$$word');
$I->expectTo('see password validations errors');
$I->see("Passwords don't match");

$I->amGoingTo('sign up with invalid email');
$signupPage = SignupPage::openBy($I);
$signupPage->signup('invalid@mail', 'password', 'password');
$I->expectTo('see email validations error');
$I->see("Email is not a valid email address");

$I->amGoingTo('sign up with already used email');
$signupPage = SignupPage::openBy($I);
$signupPage->signup('exists@example.com', 'password', 'password');
$I->expectTo('see email validations error');
$I->see("This email address has already been taken");
