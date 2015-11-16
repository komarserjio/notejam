<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('delete other user\'s note');
$I->testLogin();
$I->amOnPage('/notes/5/delete');
$I->dontSee('Yes, I want to delete this note');
