<?php
namespace app\models;

use app\models\User;
use Yii;

/**
 * Signup form
 */
class ForgotPassword extends \yii\base\Model
{
    public $email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist', 'targetClass' => '\app\models\User', 'message' => 'No user found.'],
        ];
    }

    /**
     * Set new password.
     *
     * @return User|null
     */
    public function resetPassword()
    {
        if ($this->validate()) {
            $user = User::findOne(['email' => $this->email]);
            $password = $this->generatePassword();
            $user->setPassword($password);
            $user->generateAuthKey();
            $user->save();

            $this->sendPassword($user, $password);
            return $user;
        }

        return null;
    }

    /**
     * Generate new password
     *
     * @return string
     */
    protected function generatePassword()
    {
        return substr(md5(time()), 0, 8);
    }

    /**
     * Send new password
     *
     * @return void
     */
    public function sendPassword($user, $password)
    {
        $params = ['user' => $user, 'password' => $password];
        Yii::$app->mailer->compose('password', $params)
                 ->setFrom([Yii::$app->params['supportEmail'] => 'Notejam'])
                 ->setTo($user->email)
                 ->setSubject('New password')
                 ->send();
    }
}


