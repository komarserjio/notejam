<?php
use tests\_pages\ViewPadPage;

$I = new TestGuy($scenario);
$I->wantTo('ensure that pad viewing works correctly');

$user = ['email' => 'exists@example.com', 'password' => '123123'];
$padPage = ViewPadPage::openBy($I, ['id' => 1], $user);

$I->amGoingTo('view pad');
$I->expectTo('see pad name');
$I->see('Pad name (1)');

// @TODO
//$I->amGoingTo('view not my pad');

