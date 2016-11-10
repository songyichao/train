<?php

namespace app\models;

use Yii;
use yii\db\Query;

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
			[['id', 'hid', 'train_no', 'ctime'], 'required'],
			[['id', 'hid', 'ctime'], 'integer'],
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
			'hid' => 'Hid',
			'train_no' => 'Train No',
			'ctime' => 'Ctime',
		];
	}
	
	public function saveLog($data)
	{
		$res = Yii::$app->db->createCommand()->batchInsert(self::tableName(), ['hid', 'train_no', 'buy_status', 'call_status', 'ctime'], $data)->execute();
	}
	
	public function getLog($hid)
	{
		$res = (new Query())
			->select(['*'])
			->from(self::tableName())
			->where(['hid' => $hid])
			->all(self::getDb());
		return $res;
	}
}
