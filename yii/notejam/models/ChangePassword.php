<?php
namespace app\models;

use app\models\User;
use Yii;
use yii\base\Model;

/**
 * Signup form
 */
class ChangePassword extends Model
{
    public $currentPassword;
    public $password;
    public $passwordConfirmation;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['currentPassword', 'required'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['passwordConfirmation', 'compare', 'compareAttribute' => 'password', 'message' => "Passwords don't match"],
        ];
    }

    /**
     * Signs user up
     *
     * @param User $user
     * @return User|null the saved model or null if saving fails
     */
    public function changePassword($user)
    {
        if ($this->validate()) {
            if ($user->validatePassword($this->currentPassword)) {
                $user->setPassword($this->password);
                $user->generateAuthKey();
                if ($user->save()) {
                    return $user;
                }
            } else {
                $this->addError(
                    'currentPassword', 'Current password is incorrect'
                );
            }
        }

        return null;
    }
}

