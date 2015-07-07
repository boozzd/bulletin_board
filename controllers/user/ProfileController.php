<?php

namespace app\controllers\user;

use Yii;
use dektrium\user\controllers\ProfileController as BaseProfileController;
use app\models\Comments;
use app\models\User;
use yii\data\Pagination;
use dektrium\user\traits\AjaxValidationTrait;

class ProfileController extends BaseProfileController
{
    use AjaxValidationTrait;
    /**
     * Shows user's profile.
     * @param  integer $id
     * @return \yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionShow($id)
    {
        $this->enableCsrfValidation = false;
        $profile = $this->finder->findProfileById($id);

        if ($profile === null) {
            throw new NotFoundHttpException;
        }

        $query = Comments::find()
                        ->where(['deleted' => Comments::NO_DELETED, 'user_id' => $id])
                        ->orderBy('created_at');
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $pages->setPageSize(10);
        $comments = $query->offset($pages->offset)
                        ->limit($pages->limit)
                        ->all();

        $model = new Comments();

        $this->performAjaxValidation($model);

        $user = User::findOne(Yii::$app->user->getId());

        if ($model->load(Yii::$app->request->post())) {
            $model->created_at = time();
            $model->user_id = $profile->user->getId();
            $model->sender_id = Yii::$app->user->getId();
            $model->save();
            return $this->refresh();
        } else {
            return $this->render('show', [
                'profile' => $profile,
                'model' => $model,
                'user' => $user,
                'comments' => $comments,
                'pages' => $pages,
            ]);
        }

        return $this->render('show', [
            'profile' => $profile,
        ]);
    }
}