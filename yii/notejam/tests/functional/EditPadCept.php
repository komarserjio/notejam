<?php
use tests\_pages\EditPadPage;

$I = new TestGuy($scenario);
$I->wantTo('ensure that edit pad works correctly');

$user = ['email' => 'exists@example.com', 'password' => '123123'];
$padPage = EditPadPage::openBy($I, ['id' => 1], $user);

$I->amGoingTo('edit pad');
$newName = 'new pad name';
$padPage->edit($newName);
$I->expectTo('see success message');
$I->see('Pad is successfully updated');
$I->expectTo('see new name');
$I->see($newName);

$I->amGoingTo('edit pad with blank name');
$padPage = EditPadPage::openBy($I, ['id' => 1], $user);
$padPage->edit('');
$I->expectTo('see validation error');
$I->see('Name cannot be blank');

// @TODO
//$I->amGoingTo('edit not my pad');
