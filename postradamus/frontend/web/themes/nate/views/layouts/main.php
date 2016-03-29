<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\widgets\Alert;

/**
 * @var \yii\web\View $this
 * @var string $content
 */
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <?= \yii\helpers\Html::csrfMetaTags() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <div class="wrap">


        <div class="navbar navbar-inverse" role="navigation" style="background-color:#2f4974">
            <div class="container">
                <div class="navbar-header" style="padding:15px">
                    <a href="/" title="Postradamus" rel="home"><img src="/postradamus/files/postradamus.fw_.png" alt="Postradamus"></a>
                </div>
            </div>
        </div>

        <div class="container" style="padding-top:0">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?php
        foreach(Yii::$app->session->getAllFlashes() as $key => $message) {
            echo '<div class="alert alert-' . $key . '"><a class="close" data-dismiss="alert" href="#">x</a>' . $message . "</div>\n";
        }
        ?>
        <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
        <p class="pull-left">&copy; Postradamus <?= date('Y') ?></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
    <link rel="stylesheet" type="text/css" href="/postradamus/files/jquery.countdown.css">
    <script type="text/javascript" src="/postradamus/files/jquery.plugin.min.js"></script>
    <script type="text/javascript" src="/postradamus/files/jquery.countdown.min.js"></script>
</body>
</html>
<?php $this->endPage() ?>
