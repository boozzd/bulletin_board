<?php

namespace app\models;

use Yii;
use app\models\User;

/**
 * This is model class for table "comments"
 *
 * @property string 
 */
class Comments extends \yii\db\ActiveRecord
{

    const IS_DELETED = 1;
    const NO_DELETED = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['text','required'],
            ['user_id', 'required'],
            ['sender_id', 'required'],
            ['text', 'string', 'length' => [1]],
            ['deleted', 'boolean']
        ];
    }

    /** @inheritdoc */
    public function attributeLabels()
    {
        return [
            'text'          => \Yii::t('app', 'Message text'),
        ];
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