<?php

namespace app\models;

use dektrium\user\models\Profile as BaseProfile;
use yii\web\UploadedFile;

class Profile extends BaseProfile
{
    public function rules()
    {
        return [
            'bioString' => ['bio', 'string'],
            'publicEmailPattern' => ['public_email', 'email'],
            'websiteUrl' => ['website', 'url'],
            'nameLength' => ['name', 'string', 'max' => 255],
            'avatar' => ['avatar', 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            'publicEmailLength' => ['public_email', 'string', 'max' => 255],
            'locationLength' => ['location', 'string', 'max' => 255],
            'websiteLength' => ['website', 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name'           => \Yii::t('user', 'Name'),
            'public_email'   => \Yii::t('user', 'Email (public)'),
            'avatar'         => \Yii::t('user', 'Avatar'),
            'location'       => \Yii::t('user', 'Location'),
            'website'        => \Yii::t('user', 'Website'),
            'bio'            => \Yii::t('user', 'Bio'),
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            // if ($this->isAttributeChanged('gravatar_email')) {
            //     $this->setAttribute('gravatar_id', md5(strtolower($this->getAttribute('gravatar_email'))));
            // }
            return true;
        }

        return false;
    }
}