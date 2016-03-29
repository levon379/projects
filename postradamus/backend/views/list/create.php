<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\cList $model
 */

$this->title = 'New List';
$this->params['breadcrumbs'][] = ['label' => 'Lists', 'url' => ['not-ready']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="c-list-create">

    <?= $this->render('_create_form', [
        'model' => $model,
    ]) ?>

</div>
</div>
    </div>