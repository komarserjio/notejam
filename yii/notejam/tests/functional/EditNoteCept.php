<?php
use tests\_pages\EditNotePage;

$I = new TestGuy($scenario);
$I->wantTo('ensure that edit note works correctly');

$user = ['email' => 'exists@example.com', 'password' => '123123'];
$notePage = EditNotePage::openBy($I, ['id' => 1], $user);

$I->amGoingTo('edit note');
$newName = 'new note name';
$newText = 'new pad text';
$notePage->edit($newName, $newText);
$I->expectTo('see success message');
$I->see('Note is successfully updated');
$I->expectTo('see new name and new text');
$I->see($newName);
$I->see($newText);

$I->amGoingTo('edit note with blank fields');
$notePage = EditNotePage::openBy($I, ['id' => 1], $user);
$notePage->edit('', '');
$I->expectTo('see validation errors');
$I->see('Name cannot be blank');
$I->see('Text cannot be blank');

// @TODO
//$I->amGoingTo('edit not my note');
