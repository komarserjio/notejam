<?php
use tests\_pages\CreateNotePage;

$I = new TestGuy($scenario);
$I->wantTo('ensure that note creation works correctly');

$user = ['email' => 'exists@example.com', 'password' => '123123'];
$notePage = CreateNotePage::openBy($I, [], $user);

$I->amGoingTo('create note');
$notePage->create('new note', 'note text');
$I->expectTo('see success message');
$I->see('Note is successfully created');

$I->amGoingTo('create note with blank fields');
$notePage = CreateNotePage::openBy($I, [], $user);
$notePage->create('', '');
$I->expectTo('see validation errors');
$I->see('Name cannot be blank');
$I->see('Text cannot be blank');

$I->amGoingTo('create note by anonymous');
$notePage->signout($I);
$I->amOnPage(\Yii::$app->getUrlManager()->createUrl(['note/create']));
$I->expectTo('be redirected to signin page');
$I->seeInCurrentUrl('/signin');

// @TODO add note not in my pad
// $I->amGoingTo('create note by anonymous');
