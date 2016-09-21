<?php

namespace app\models;

use Yii;

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
            [['uid', 'statr_station', 'end_station', 'train_no', 'seat_type'], 'required'],
            [['uid'], 'integer'],
            [['statr_station', 'end_station'], 'string', 'max' => 3],
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
            'statr_station' => 'Statr Station',
            'end_station' => 'End Station',
            'train_no' => 'Train No',
            'seat_type' => 'Seat Type',
        ];
    }
}
