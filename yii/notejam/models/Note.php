<?php
namespace app\models;

use Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;

/**
 * User model
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $pad_id
 * @property string $name
 * @property string $text
 */
class Note extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'required'],
            ['text', 'required'],
            ['pad_id', 'safe'],
        ];
    }

    public function behaviors()
    {
      return [
          [
              'class' => TimestampBehavior::className(),
              'createdAtAttribute' => 'created_at',
              'updatedAtAttribute' => 'updated_at',
              'value' => new Expression('datetime("now")'),
          ],
      ];
    }


    /**
     * @return string the name of the table associated with
     *         this ActiveRecord class.
     */
    public static function tableName()
    {
        return 'notes';
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
     * Get pad
     *
     * @return app\models\Pad
     */
    public function getPad()
    {
        return $this->hasOne(Pad::className(), ['id' => 'pad_id']);
    }
}


