<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log".
 *
 * @property integer $id
 * @property integer $uid
 * @property string $train_no
 * @property integer $ctime
 */
class Log extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'uid', 'train_no', 'ctime'], 'required'],
            [['id', 'uid', 'ctime'], 'integer'],
            [['train_no'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'train_no' => 'Train No',
            'ctime' => 'Ctime',
        ];
    }
	
	public function saveLog($data)
	{
		$res = Yii::$app->db->createCommand()->batchInsert(self::tableName(), ['uid', 'train_no', 'ctime'], $data)->execute();
    }
}
