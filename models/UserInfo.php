<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_info".
 *
 * @property integer $id
 * @property string $username
 * @property integer $phono
 */
class UserInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'phone'], 'required'],
            [['phone'], 'string', 'mac' => 11],
            [['username'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'phone' => 'Phone',
        ];
    }
    
}
