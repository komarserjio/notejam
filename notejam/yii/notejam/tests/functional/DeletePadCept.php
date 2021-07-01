<?php
use tests\_pages\DeletePadPage;

$I = new TestGuy($scenario);
$I->wantTo('ensure that pad deletion works correctly');

$user = ['email' => 'exists@example.com', 'password' => '123123'];
$padPage = DeletePadPage::openBy($I, ['id' => 1], $user);

$I->amGoingTo('delete pad');
$padPage->delete();
$I->expectTo('see success message');
$I->see('Pad is successfully deleted');

// @TODO
//$I->amGoingTo('delete not my pad');
