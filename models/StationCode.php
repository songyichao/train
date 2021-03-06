<?php

namespace app\models;

use Yii;
use yii\db\Query;

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
	
	/**
	 * @param $data
	 * @return int
	 */
	public function saveCode($data)
	{
		$res = Yii::$app->db->createCommand()->batchInsert(self::tableName(), ['name', 'code'], $data)->execute();
		return $res;
	}
	
	/**
	 * @param $data
	 * @return array
	 */
	public function getCode($data)
	{
		$res = (new Query())
			->select(['*'])
			->from(self::tableName())
			->where(['name' => $data])
			->all();
		return $res;
	}
	
	/**
	 * @return array
	 * @internal param $data
	 */
	public function getAllCode($flag = true)
	{
		$res = (new Query())
			->select(['*'])
			->from(self::tableName())
			->all();
		foreach ($res as $item) {
			if ($flag) {
				$station_arr[$item['code']] = $item['name'];
			} else {
				$station_arr[$item['name']] = $item['code'];
			}
		}
		return $station_arr;
	}
}
