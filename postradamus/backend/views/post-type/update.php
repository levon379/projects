<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\cPostType $model
 */

$this->title = 'Update Post Type: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = 'Settings';
$this->params['breadcrumbs'][] = ['label' => 'Post Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="c-post-type-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

        </div></div>