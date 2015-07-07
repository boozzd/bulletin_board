<?php

namespace app\models;

use Yii;
use dektrium\user\models\User as BaseUser;
use app\models\Comments;
use app\models\Rating;
class User extends BaseUser
{
    /** @inheritdoc */
    public function scenarios()
    {
        return [
            'register' => ['username', 'email', 'password'],
            'connect'  => ['username', 'email'],
            'create'   => ['username', 'email', 'password'],
            'update'   => ['username', 'email', 'password'],
            'settings' => ['username', 'email', 'password'],
            'rate'     => ['rate'],
        ];
    }

    /** @inheritdoc */
    public function rules()
    {
        return [
            // username rules
            'usernameRequired' => ['username', 'required', 'on' => ['register', 'connect', 'create', 'update']],
            'usernameMatch' => ['username', 'match', 'pattern' => '/^[-a-zA-Z0-9_\.@]+$/'],
            'usernameLength' => ['username', 'string', 'min' => 3, 'max' => 25],
            'usernameUnique' => ['username', 'unique'],
            'usernameTrim' => ['username', 'trim'],

            // email rules
            'emailRequired' => ['email', 'required', 'on' => ['register', 'connect', 'create', 'update']],
            'emailPattern' => ['email', 'email'],
            'emailLength' => ['email', 'string', 'max' => 255],
            'emailUnique' => ['email', 'unique'],
            'emailTrim' => ['email', 'trim'],

            // password rules
            'passwordRequired' => ['password', 'required', 'on' => ['register']],
            'passwordLength' => ['password', 'string', 'min' => 6, 'on' => ['register', 'create']],

            //rate rules
            'rateLength' => ['rate', 'double', 'min' => 0, 'max' => 5, 'on' => ['rate']],
        ];
    }

    public static function assignRole($event)
    {
        $user_id=$event->sender->id;
        $auth = \Yii::$app->authManager;
        $role = $auth->getRole('user');
        $auth->assign($role, $user_id);
    }

    public function getComments()
    {
        return $this->hasMany(Comments::className(), ['user_id' => 'id']);
    }

    public function getRating()
    {
        return $this->hasMany(Rating::className(), ['user_id' => 'id']);
    }

    public function checkRateChange()
    {
        $rating = Rating::findOne(['user_id' => $this->id, 'sender_id' => Yii::$app->user->getId()]);
        return !$rating;
    }
    /**
     * Check does user have this role
     * @param  string $role name of role
     * @return boolean       
     */
    public static function checkAuthUserRole($role)
    {
        $roles = Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId());
        $roles_tmp = array_map(function($r){return $r->name;}, $roles);
        return in_array($role, $roles_tmp);
    }
}