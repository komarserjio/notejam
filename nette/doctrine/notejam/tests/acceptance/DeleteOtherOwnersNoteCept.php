<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('see note can not be deleted by not an owner');
$I->testLogin();
$I->amOnPage('/notes/5/delete');
$I->dontSee('Yes, I want to delete this note');
