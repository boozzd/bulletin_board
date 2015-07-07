<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\models\Ads;
use yii\web\Response;
use yii\widgets\ActiveForm;
use dektrium\user\traits\AjaxValidationTrait;
use yii\imagine\Image;
use yii\web\UploadedFile;
use yii\data\Pagination;
/**
 * CountryController implements the CRUD actions for Country model.
 */
class BoardController extends Controller
{
    use AjaxValidationTrait;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    ['allow' => true, 'actions' => ['index'], 'roles' => ['?','@']],
                    ['allow' => true, 'actions' => ['create'], 'roles' => ['@']],
                ]
            ],
        ];
    }

    public function actionIndex()
    {
        $query = Ads::find()
                        ->where(['deleted' => Ads::NO_DELETED])
                        ->orderBy('created_at');
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $pages->setPageSize(20);
        $ads = $query->offset($pages->offset)
                        ->limit($pages->limit)
                        ->all();
        return $this->render('index', [
            'ads' => $ads,
            'pages' => $pages,
        ]);
    }

    public function actionCreate()
    {
        $this->enableCsrfValidation = false;
        $model = new Ads();

        $this->performAjaxValidation($model);

        $model->setAttribute('created_at', time());
        $model->setAttribute('user_id', Yii::$app->user->getId());
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $file = UploadedFile::getInstance($model, 'photo');
            if($file) {
                $ext = end((explode(".", $file->name)));
                $model->setAttribute('photo', \Yii::$app->security->generateRandomString().".{$ext}");
                $file->saveAs(\Yii::$app->basePath . '/web/upload/ads/' . $model->photo);
                Image::thumbnail( \Yii::$app->basePath . '/web/upload/ads/' . $model->photo , 230, 230)
                    ->save(\Yii::$app->basePath . '/web/upload/ads/tumb_big/' . $model->photo, ['quality' => 100]);
                Image::thumbnail( \Yii::$app->basePath . '/web/upload/ads/' . $model->photo , 64, 64)
                    ->save(\Yii::$app->basePath . '/web/upload/ads/tumb_middle/' . $model->photo, ['quality' => 100]);

            }else {
                $model->setAttribute('photo', $model->getOldAttribute('photo'));
            }
            $model->save();
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
}
