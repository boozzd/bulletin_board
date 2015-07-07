<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\User;

class Rating extends ActiveRecord
{
    public function rules()
    {
        return [
            ['rate','required'],
            ['user_id', 'required'],
            ['sender_id', 'required'],
            ['rate', 'double', 'min' => 0, 'max' => 5],
            ['created_at', 'integer'],
        ];
    }

    public static function tableName()
    {
        return 'rating';
    }

    /**
     * @return \yii\db\ActiveQueryInterface
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQueryInterface
     */
    public function getSender()
    {
        return $this->hasOne(User::className(), ['id' => 'sender_id']);
    }
}