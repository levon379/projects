<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\cConnectionFacebook $model
 */

$this->title = 'Facebook Connection';
$this->params['breadcrumbs'][] = ['label' => 'Settings'];
$this->params['breadcrumbs'][] = ['label' => 'Connections'];
$this->params['breadcrumbs'][] = 'Facebook Connection';
$this->params['help']['message'] = 'Connect your own Facebook App with Postradamus.';
$this->params['help']['modal_body'] = '<iframe width="853" height="480" src="https://www.youtube.com/embed/lixLYm-7zeo?rel=0" id="youtube-video" frameborder="0" allowfullscreen></iframe>';

?>

        <div class="c-connection-facebook-update">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>