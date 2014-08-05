<?php
use tests\_pages\ViewNotePage;

$I = new TestGuy($scenario);
$I->wantTo('ensure that note viewing works correctly');

$user = ['email' => 'exists@example.com', 'password' => '123123'];
$notePage = ViewNotePage::openBy($I, ['id' => 1], $user);

$I->amGoingTo('view note');
$I->expectTo('see note text');
$I->see('Note text');

// @TODO
//$I->amGoingTo('view not my pad');

