<?php

namespace app\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "user_help".
 *
 * @property integer $id
 * @property integer $uid
 * @property string $statr_station
 * @property string $end_station
 * @property string $train_no
 * @property string $seat_type
 */
class UserHelp extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'user_help';
	}
	
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['uid', 'stat_station', 'end_station', 'go_time'], 'required'],
			[['uid'], 'integer'],
			[['train_no', 'seat_type'], 'string', 'max' => 11],
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
			'stat_station' => 'Stat Station',
			'end_station' => 'End Station',
			'train_no' => 'Train No',
			'seat_type' => 'Seat Type',
		];
	}
	
	public function getUserHelp()
	{
		$a = self::tableName() . ' as a';
		$b = UserInfo::tableName() . ' as b';
		$res = (new Query())
			->select(['uid', 'stat_station', 'end_station', 'train_no', 'seat_type', 'go_time', 'phone'])
			->from($a)
			->leftJoin($b, 'b.id = a.uid')
			->where('go_time >= :go_time and status = 1', [':go_time' => time()])
			->all();
		return $res;
	}
	
	public function changeStatus($user_id)
	{
		$user = Yii::$app->db->createCommand()->update(self::tableName(), ['status' => 0], ['uid' => $user_id])->execute();
		return $user;
	}
}
