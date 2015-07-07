<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Request;
use app\models\Rating;
use yii\widgets\ActiveForm;
use app\models\User;

class RatingController extends Controller
{
     /**
     * Lists all Country models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->request->isAjax) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $id = (int)Yii::$app->request->post('id', null);
            $rate = (double)Yii::$app->request->post('rate', null);
            if(!Yii::$app->user->isGuest && $id && $rate) {
            
                $rate_arr = ['Rating' => [
                    'user_id' => $id,
                    'sender_id' => Yii::$app->user->getId(),
                    'created_at' => time(),
                    'rate' => $rate,
                ]];
                
                $rating = Rating::findOne(['user_id' => $id, 'sender_id' => Yii::$app->user->getId()]);
                if(!$rating) {
                    $rating = new Rating();
                }

                if($rating->load($rate_arr) && $rating->validate()) {
                    $rating->save();
                    $user = User::findOne($id);
                    $count = count($user->rating) ;
                    $sum = 0;
                    foreach($user->rating as $r) {
                        $sum += $r->rate;
                    }
                    $user->rate = round($sum / $count, 1);
                    $epsilon = 0.001;
                    $tmp = $user->rate - $user->rate % 10;
                    if($tmp - 0.5 < $epsilon) {
                        $tmp = 0.5;
                    }elseif($tmp > 0.5) {
                        $tmp = 1;
                    }else {
                        $tmp = 0;
                    }
                    $user->rate = ($user->rate % 10) + $tmp;
                    $user->scenario = 'rate';
                    $user->save();
                    return ['status' => 1, 'rate' => $user->rate];
                }else {
                    $errors = ActiveForm::validate($rating);
                    return ['status' => 0, 'error' => $errors];
                }
            }
            return ['status' => 0, 'erorrs' => ['You have no access or incorrect data!']];
        }
    }
}