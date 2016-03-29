<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

raoul2000\bootswatch\BootswatchAsset::$theme = 'cerulean';
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
    <style>
        body {
            /*padding-top: 55px;*/
            /* Required padding for .navbar-fixed-top. Remove if using .navbar-static-top. Change if height of navigation changes. */
        }

        @media screen and (min-width: 768px) {
            #categoryFormModal .modal-dialog  {width:600px;  top:-35px;  outline: none;}
            #swot-modal .modal-dialog  {width:850px;  top:-35px;  outline: none;}
        }

    </style>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    $logo = '<img src="/images/efox-logo1-small.png" style="margin-top:-5px;">';
    $menuItemsApp = [];
    NavBar::begin([
        'brandLabel' => $logo . '',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-default navbar-fixed-top',
        ],
    ]);

    if (Yii::$app->user->isGuest) {
        $menuItems = [
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'About', 'url' => ['/site/about']],
            ['label' => 'Contact', 'url' => ['/site/contact']],
        ];
        $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems[] = ['label' => 'Dashboard', 'url' => ['/dashboard/index']];
        $menuItemsApp[] = ['label' => 'Profile', 'url' => ['/profile/view']];
        $menuItemsApp[] =
            [
            'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
            'url' => ['/site/logout'],
            'linkOptions' => ['data-method' => 'post']
        ];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => $menuItems,
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItemsApp,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?php
        $home = ['label' => Yii::t('yii', 'Home'), 'url' => Yii::$app->homeUrl,];
        if (!Yii::$app->user->isGuest) {
            //$home = ['label' => Yii::t('yii', 'Dashboard'), 'url' => 'dashboard/index',];
        }
        echo Breadcrumbs::widget([
            'homeLink' => $home,
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; EverFox.com <?= date('Y') ?></p>
    </div>
</footer>

<?php
$js = <<< JS
    /* To initialize BS3 tooltips set this below */
    $(function () {
        $("[data-toggle='tooltip']").tooltip();
    });;
    /* To initialize BS3 popovers set this below */
    $(function () {
        $("[data-toggle='popover']").popover();
    });
JS;
    // Register tooltip/popover initialization javascript
    $this->registerJs($js);
?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
