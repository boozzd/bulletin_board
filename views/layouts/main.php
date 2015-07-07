<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\asset\AppAsset;
use app\models\User;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $content string */
// User::checkAuthUserRole('admin');
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>

<?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => 'Bulletin Board',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => [
                    ['label' => 'Register', 'url' => ['/user/registration/register'], 'visible' => Yii::$app->user->isGuest],
                    Yii::$app->user->isGuest ?
                        ['label' => 'Sign in', 'url' => ['/user/security/login']] :
                        [
                            'label' => Yii::$app->user->identity->username ,
                            'items' => [
                                ['label' => 'Profile', 'url' => '/user/profile'],
                                ['label' => 'Settings', 'url' => '/user/settings'],
                                User::checkAuthUserRole('admin') ?
                                    ['label' => 'Users settings', 'url' => '/user/admin'] : '',
                                '<li role="separator" class="divider"></li>',
                                ['label' => 'Sign out',
                                    'url' => ['/user/security/logout'],
                                    'linkOptions' => ['data-method' => 'post']
                                ],
                            ]
                        ]
                ],
            ]);
            NavBar::end();
        ?>

        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; Bulletin Board <?= date('Y') ?></p>
            <p class="pull-left">&nbsp;</p>
            <p class="pull-left"><a href="<?= Url::toRoute('/site/about') ?>">About</a></p>
            <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>
    <div class="alert alert-success fixed-alert-success">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <strong>Success!</strong> <span class="text"></span>
    </div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
