<?php
use tests\_pages\CreatePadPage;

$I = new TestGuy($scenario);
$I->wantTo('ensure that pad creation works correctly');

$user = ['email' => 'exists@example.com', 'password' => '123123'];
$padPage = CreatePadPage::openBy($I, [], $user);

$I->amGoingTo('create pad');
$padPage->create('new pad');
$I->expectTo('see success message');
$I->see('Pad is successfully created');

$I->amGoingTo('create pad with blank name');
$padPage = CreatePadPage::openBy($I, [], $user);
$padPage->create('');
$I->expectTo('see validation error');
$I->see('Name cannot be blank');
