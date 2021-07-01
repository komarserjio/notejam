<?php
namespace tests\_pages;

use yii\codeception\BasePage;

class SignupPage extends BasePage
{
    public $route = 'user/signup';

    /**
     * @param string $email
     * @param string $password
     * @param string $passwordConfirmation
     */
    public function signup($email, $password, $passwordConfirmation)
    {
        $this->guy->fillField('input[name="SignupForm[email]"]', $email);
        $this->guy->fillField('input[name="SignupForm[password]"]', $password);
        $this->guy->fillField(
            'input[name="SignupForm[passwordConfirmation]"]', $passwordConfirmation
        );
        $this->guy->click('button[type=submit]');
    }
}

