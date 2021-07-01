<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('see note can be successfully deleted');
$I->testLogin();
$I->amOnPage('/notes/1/delete');
$I->click('Yes, I want to delete this note');
$I->dontSee('Note 1');
