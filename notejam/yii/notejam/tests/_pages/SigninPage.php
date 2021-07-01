<?php
namespace tests\_pages;

use yii\codeception\BasePage;

class SigninPage extends BasePage
{
    public $route = 'user/signin';

    /**
     * @param string $email
     * @param string $password
     */
    public function signin($email, $password)
    {
        $this->guy->fillField('input[name="SigninForm[email]"]', $email);
        $this->guy->fillField('input[name="SigninForm[password]"]', $password);
        $this->guy->click('button[type=submit]');
        //$this->guy->submitForm('form', array('SigninForm' => array(
             //'email' => $email,
             //'password' => $password,
        //)));
    }
}
