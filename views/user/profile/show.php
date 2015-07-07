<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;
use yii\helpers\Url;
use kartik\rating\StarRating;
use app\models\User;

/**
 * @var \yii\web\View $this
 * @var \dektrium\user\models\Profile $profile
 */

$this->title = empty($profile->name) ? Html::encode($profile->user->username) : Html::encode($profile->name);
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="row">
            <div class="col-sm-6 col-md-2">
                <img src="<?= ($profile->avatar) ? '/upload/avatar/tumb_big/'.$profile->avatar : 'http://placehold.it/230x230' ?>" alt="" class="img-rounded img-responsive" />
            </div>
            <div class="col-sm-6 col-md-10">
                <h4><?= $this->title ?></h4>
                <ul style="padding: 0; list-style: none outside none;">
                    <?php if (!empty($profile->location)): ?>
                        <li><i class="glyphicon glyphicon-map-marker text-muted"></i> <?= Html::encode($profile->location) ?></li>
                    <?php endif; ?>
                    <?php if (!empty($profile->website)): ?>
                        <li><i class="glyphicon glyphicon-globe text-muted"></i> <?= Html::a(Html::encode($profile->website), Html::encode($profile->website)) ?></li>
                    <?php endif; ?>
                    <?php if (!empty($profile->public_email)): ?>
                        <li><i class="glyphicon glyphicon-envelope text-muted"></i> <?= Html::a(Html::encode($profile->public_email), 'mailto:' . Html::encode($profile->public_email)) ?></li>
                    <?php endif; ?>
                    <li><i class="glyphicon glyphicon-time text-muted"></i> <?= Yii::t('user', 'Joined on {0, date}', $profile->user->created_at) ?></li>
                </ul>
                <?php if (!empty($profile->bio)): ?>
                    <p><?= Html::encode($profile->bio) ?></p>
                <?php endif; ?>
                <div class="rating-contain">
                    <input type="number" id="rating_id" value="<?= $profile->user->rate ?>" data-id="<?= $profile->user->id ?>" data-readonly="<?= ($profile->user->checkRateChange() && !Yii::$app->user->isGuest) ? 'false' : 'true' ?>" data-access="<?= (Yii::$app->user->isGuest) ? 0 : 1 ?>">
                    <div class="popover fade bottom in" id="popover-rating">
                        <div class="arrow" style="left: 50%;"></div>
                        <div class="popover-content">
                            <p>You are already set rate.</p>
                            <a href="javascript:void(0)">Do you want change it?</a>
                        </div>
                    </div>
                </div>

                <div class="comments-container">
                    <h3>Comments</h3>

                    <?php foreach($comments as $comment):?>
                        <div class="media comment">
                            <div class="media-left">
                                <a href="<?= Url::toRoute(['/user/profile/show', 'id' => $comment->sender->id]) ?>">
                                    <img class="media-object" src="<?= ($comment->sender->profile->avatar) ? '/upload/avatar/tumb_middle/'.$comment->sender->profile->avatar : 'http://placehold.it/64x64' ?>" alt="<?= $comment->sender->profile->name ?>">
                                </a>
                            </div>
                            <div class="media-body">
                                <div class="comment-title row">
                                    <div class="col-sm-6 col-md-6">
                                        <a href="<?= Url::toRoute(['/user/profile/show', 'id' => $comment->sender->id]) ?>" class="author"><?= ($comment->sender->profile->name) ? $comment->sender->profile->name : $comment->sender->username ?></a>
                                    </div>
                                    <div class="col-sm-6 col-md-6 text-right">
                                        <span class="date-time"><?= Yii::$app->formatter->format($comment->created_at, 'relativeTime') ?></span>
                                    </div>
                                </div>
                                <p><?= Html::encode($comment->text)?></p>
                            </div>
                        </div>
                    <?php endforeach;?>

                    <?php echo LinkPager::widget([
                                'pagination' => $pages,
                            ]);
                    ?>
                    <?php if(!Yii::$app->user->isGuest):?>
                        <h3>New comment</h3>
                        <div class="new-comment media">
                            <div class="media-left">
                                <img class="media-object" src="<?= ($user->profile->avatar) ? '/upload/avatar/tumb_middle/'.$user->profile->avatar : 'http://placehold.it/64x64' ?>" alt="<?= $user->profile->name ?>" >
                            </div>
                            <div class="media-body">
                                <?php $form = ActiveForm::begin([
                                    'enableAjaxValidation'   => true,
                                    'enableClientValidation' => true,
                                ]); ?>
                                    <div class="form-group">
                                        <?= $form->field($model, 'text')->textarea(['rows' => 4])->label(false) ?>
                                    </div>
                                    <div class="form-group">
                                        <?= Html::submitButton('Send', ['class' => 'btn btn-success']) ?>
                                    </div>
                                <?php ActiveForm::end(); ?>
                            </div>
                        </div>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>
</div>
