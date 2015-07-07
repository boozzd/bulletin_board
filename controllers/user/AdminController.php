<?php
namespace app\controllers\user;

use dektrium\user\controllers\AdminController as BaseAdminController;
use yii\helpers\Url;
use yii\web\UploadedFile;
use Yii;
use yii\imagine\Image;

class AdminController extends BaseAdminController
{
    public function actionUpdateProfile($id)
    {
        Url::remember('', 'actions-redirect');
        $user    = $this->findModel($id);
        $profile = $user->profile;
        
        $this->performAjaxValidation($profile);

        if($profile->load(Yii::$app->request->post())) {
            $file = UploadedFile::getInstance($profile, 'avatar');
            if($file) {
                $ext = end((explode(".", $file->name)));
                $profile->setAttribute('avatar', \Yii::$app->security->generateRandomString().".{$ext}");
                $file->saveAs(\Yii::$app->basePath . '/web/upload/avatar/' . $profile->avatar);
                Image::thumbnail( \Yii::$app->basePath . '/web/upload/avatar/' . $profile->avatar , 24, 24)
                    ->save(\Yii::$app->basePath . '/web/upload/avatar/tumb_small/' . $profile->avatar, ['quality' => 100]);
                Image::thumbnail( \Yii::$app->basePath . '/web/upload/avatar/' . $profile->avatar , 230, 230)
                    ->save(\Yii::$app->basePath . '/web/upload/avatar/tumb_big/' . $profile->avatar, ['quality' => 100]);
                Image::thumbnail( \Yii::$app->basePath . '/web/upload/avatar/' . $model->avatar , 64, 64)
                    ->save(\Yii::$app->basePath . '/web/upload/avatar/tumb_middle/' . $model->avatar, ['quality' => 100]);
            }else {
                $profile->setAttribute('avatar', $profile->getOldAttribute('avatar'));
            }
            $profile->save();
            Yii::$app->getSession()->setFlash('success', Yii::t('user', 'Profile details have been updated'));
            return $this->refresh();
        }
        return $this->render('_profile', [
            'user'    => $user,
            'profile' => $profile,
        ]);
    }
}