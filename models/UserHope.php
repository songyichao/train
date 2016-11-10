<?php

namespace app\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "user_help".
 *
 * @property integer $id
 * @property integer $uid
 * @property string $stat_station
 * @property string $end_station
 * @property string $train_no
 * @property string go_time
 * @property string $seat_type
 * @property string $status
 */
class UserHope extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'user_hope';
	}
	
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['stat_station', 'end_station', 'go_time'], 'required'],
			[['train_no', 'seat_type'], 'string', 'max' => 11],
			[['stat_station', 'end_station'], 'validateStation'],
			[['go_time'], 'validateTime'],
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
	
	public function validateStation($attribute, $params)
	{
		$station = [$this->stat_station, $this->end_station];
		$res = (new StationCode())->getCode($station);
		if (count($res) !== count($station) || $this->stat_station === $this->end_station) {
			$this->addError($attribute, '站点不存在或站点不合法');
		}
	}
	
	public function validateTime($attribute, $params)
	{
		if (strtotime(date('Y-m-d')) > strtotime($this->go_time)) {
			$this->addError($attribute, '出发日期不合法');
		}
	}
	
	/**
	 * @return array
	 */
	public function getUserHope()
	{
		$a = self::tableName() . ' as a';
		$b = User::tableName() . ' as b';
		$res = (new Query())
			->select(['a.id as hid', 'uid', 'stat_station', 'end_station', 'train_no', 'seat_type', 'go_time', 'phone'])
			->from($a)
			->leftJoin($b, 'b.id = a.uid')
			->where('go_time >= :go_time and status = 1', [':go_time' => time()])
			->all();
		return $res;
	}
	
	/**
	 * @param $user_id
	 * @return int
	 */
	public function changeStatus($user_id)
	{
		$user = Yii::$app->db->createCommand()->update(self::tableName(), ['status' => 0], ['uid' => $user_id])->execute();
		return $user;
	}
	
	public function saveHope($data)
	{
		$station = [$data['stat_station'], $data['end_station']];
		$res = (new StationCode())->getCode($station);
		$save_data['uid'] = Yii::$app->getUser()->id;
		foreach ($res as $re) {
			if ($data['stat_station'] === $re['name']) {
				$save_data['stat_station'] = $re['code'];
			}
			if ($data['end_station'] === $re['name']) {
				$save_data['end_station'] = $re['code'];
			}
		}
		$save_data['go_time'] = strtotime($data['go_time']);
		$save_data['train_no'] = $data['train_no'] ?? '';
		$save_data['seat_type'] = !empty($data['seat_type']) ? Yii::$app->params['seat_type'][$data['seat_type']] : '';
		$save_data['status'] = 1;
		return Yii::$app->db->createCommand()->insert(self::tableName(), $save_data)->execute();
	}
	
	public function showHope()
	{
		$a = self::tableName() . ' as a';
		$b = User::tableName() . ' as b';
		$res = (new Query())
			->select(['a.id as hid', 'username', 'stat_station', 'end_station', 'train_no', 'seat_type', 'go_time', 'phone'])
			->from($a)
			->leftJoin($b, 'b.id = a.uid')
			->where('go_time >= :go_time and status = 1', [':go_time' => strtotime(date('Y-m-d'))])
			->all();
		return $res;
	}
	
	public function getHope($uid)
	{
		$hid = (new Query())
			->select(['*'])
			->from(self::tableName())
			->where(['uid' => $uid])
			->all(self::getDb());
		return $hid;
	}
}
