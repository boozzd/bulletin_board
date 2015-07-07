<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'Bulletin Board';
?>
<div>

    <div class="row">
        <div class="board-head-left">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <?php if(!Yii::$app->user->isGuest): ?>
            <div class="board-head-right">
                <a href="<?= Url::toRoute('board/create') ?>" class="btn btn-success btn-block">
                    Add ad
                </a>
            </div>
        <?php endif; ?>
    </div>
    
    
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1 board">
            <?php foreach($ads as $ad):?>
                <div class="media">
                  <div class="media-left media-top">
                      <img class="media-object" src="<?= ($ad->photo) ? '/upload/ads/tumb_middle/'.$ad->photo : 'http://placehold.it/64x64' ?>" alt="<?= $ad->subject ?>">
                  </div>
                  <div class="media-body">
                    <h4 class="media-heading">
                        <strong><?= $ad->subject ?></strong>
                    </h4>
                    <p><?= Html::encode($ad->body) ?></p>
                    <div class="media-footer clearfix">
                        <a href="<?= URL::toRoute(['user/profile/show', 'id' => $ad->user->id]) ?>" class="author"><?= Html::encode( ($ad->user->profile->name) ? $ad->user->profile->name : $ad->user->username) ?></a>
                        <span class="time"><?= Yii::$app->formatter->format($ad->created_at, 'relativeTime') ?></span>
                    </div>
                  </div>
                </div>
            <?php endforeach;;?>
        </div>
    </div>
    <div class="row text-center">
        <?php echo LinkPager::widget([
                    'pagination' => $pages,
                ]);
        ?>
    </div>
</div>
