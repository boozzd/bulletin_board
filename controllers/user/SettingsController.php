<?php

namespace app\controllers\user;

use dektrium\user\controllers\SettingsController as BaseSettingsController;
use yii\imagine\Image;
use yii\web\UploadedFile;

class SettingsController extends BaseSettingsController
{
    /**
     * Shows profile settings form.
     * @return string|\yii\web\Response
     */
    public function actionProfile()
    {
        $model = $this->finder->findProfileById(\Yii::$app->user->identity->getId());

        $this->performAjaxValidation($model);

        if ($model->load(\Yii::$app->request->post())) {
            $file = UploadedFile::getInstance($model, 'avatar');
            if($file) {
                $ext = end((explode(".", $file->name)));
                $model->setAttribute('avatar', \Yii::$app->security->generateRandomString().".{$ext}");
                $file->saveAs(\Yii::$app->basePath . '/web/upload/avatar/' . $model->avatar);
                Image::thumbnail( \Yii::$app->basePath . '/web/upload/avatar/' . $model->avatar , 24, 24)
                    ->save(\Yii::$app->basePath . '/web/upload/avatar/tumb_small/' . $model->avatar, ['quality' => 100]);
                Image::thumbnail( \Yii::$app->basePath . '/web/upload/avatar/' . $model->avatar , 230, 230)
                    ->save(\Yii::$app->basePath . '/web/upload/avatar/tumb_big/' . $model->avatar, ['quality' => 100]);
                Image::thumbnail( \Yii::$app->basePath . '/web/upload/avatar/' . $model->avatar , 64, 64)
                    ->save(\Yii::$app->basePath . '/web/upload/avatar/tumb_middle/' . $model->avatar, ['quality' => 100]);

            }else {
                $model->setAttribute('avatar', $model->getOldAttribute('avatar'));
            }
            $model->save();
            \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'Your profile has been updated'));
            return $this->refresh();
        }

        return $this->render('profile', [
            'model' => $model,
        ]);
    }
}