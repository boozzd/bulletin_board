<?php

namespace app\models;

use Yii;
use app\models\User;
use yii\db\ActiveRecord;

class Ads extends ActiveRecord
{

    const IS_DELETED = 1;
    const NO_DELETED = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ads';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['body','required'],
            ['user_id', 'required'],
            ['body', 'string', 'length' => [10, 500]],
            ['deleted', 'boolean'],
            ['created_at', 'integer'],
            ['subject', 'string', 'length' => [2, 100]],
            ['subject', 'required'],
            ['photo', 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, gif, jpeg', 'maxSize' => 1024*1024*2],
        ];
    }

    /** @inheritdoc */
    public function attributeLabels()
    {
        return [
            'body'          => Yii::t('app', 'Ad text'),
            'subject'       => Yii::t('app', 'Subject'),
            'photo'         => Yii::t('app', 'Photo'),
        ];
    }

    /**
     * @return \yii\db\ActiveQueryInterface
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}