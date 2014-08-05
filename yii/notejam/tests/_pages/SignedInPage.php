<?php
namespace tests\_pages;

use yii\codeception\BasePage;

abstract class SignedInPage extends BasePage
{
    public static function openBy($I, $params = [], $user = [])
    {
        $page = new static($I);
        // force sign out
        self::signout($I);
        if ($user) {
            $signinPage = SigninPage::openBy($I);
            $signinPage->signin($user['email'], $user['password']);
        }
        $I->amOnPage($page->getUrl($params));

        return $page;
    }

    public static function signout($I)
    {
        $I->amOnPage(\Yii::$app->getUrlManager()->createUrl(['user/signout']));
    }
}





