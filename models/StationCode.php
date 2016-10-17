<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "station_code".
 *
 * @property integer $id
 * @property string $code
 * @property string $name
 */
class StationCode extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'station_code';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'name'], 'required'],
            [['code'], 'string', 'max' => 3],
            [['name'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'name' => 'Name',
        ];
    }
	
	public function saveCode($data)
	{
		$res = Yii::$app->db->createCommand()->batchInsert(self::tableName(), ['name', 'code'], $data)->execute();
		return $res;
    }
}
