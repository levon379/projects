<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\cConnectionPinterest $model
 */

$this->title = 'Pinterest Connection';
$this->params['breadcrumbs'][] = ['label' => 'Settings'];
$this->params['breadcrumbs'][] = ['label' => 'Connections'];
$this->params['breadcrumbs'][] = 'Pinterest Connection';

$this->params['help']['message'] = "Establishes a connection between Postradamus and your Pinterest account.";
$this->params['help']['modal_body'] = '<iframe id="youtube-video" width="853" height="480" src="//www.youtube.com/embed/aqqpdnnGp_w" frameborder="0" allowfullscreen></iframe>';

?>
        <div class="c-connection-pinterest-update">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>