<?php
use tests\_pages\DeleteNotePage;

$I = new TestGuy($scenario);
$I->wantTo('ensure that note deletion works correctly');

$user = ['email' => 'exists@example.com', 'password' => '123123'];
$notePage = DeleteNotePage::openBy($I, ['id' => 1], $user);

$I->amGoingTo('delete pad');
$notePage->delete();
$I->expectTo('see success message');
$I->see('Note is successfully deleted');

// @TODO
//$I->amGoingTo('delete not my note');

