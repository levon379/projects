<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\cUser */

$this->title = 'Update Profile';
//$this->params['breadcrumbs'][] = ['label' => 'Profile', 'url' => ['update']];
//$this->params['breadcrumbs'][] = 'Update';
$this->params['breadcrumbs'][] = 'Update Profile';
?>
    <div class="c-user-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

        </div>
    </div>