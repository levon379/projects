<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\cPostType $model
 */

$this->title = 'New Post Type';
$this->params['breadcrumbs'][] = 'Settings';
$this->params['breadcrumbs'][] = ['label' => 'Post Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="c-post-type-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

       </div></div>