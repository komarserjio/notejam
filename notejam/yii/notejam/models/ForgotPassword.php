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
     * Set new password
     *
     * @return User
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
        return Yii::$app->security->generateRandomString(8);
    }

    /**
     * Send new password
     * @param User $user
     * @param string $password
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


