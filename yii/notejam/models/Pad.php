<?php
namespace app\models;

use Yii;

/**
 * User model
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 */
class Pad extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'required'],
        ];
    }

    /**
     * @return string the name of the table associated with
     *         this ActiveRecord class.
     */
    public static function tableName()
    {
        return 'pads';
    }

    /**
     * Get user
     *
     * @return app\models\User
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Get notes
     */
    public function getNotes()
    {
        return $this->hasMany(Note::className(), ['pad_id' => 'id']);
    }
}

