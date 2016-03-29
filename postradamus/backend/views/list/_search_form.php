<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\cPostType;

/**
 * @var yii\web\View $this
 * @var common\models\cListSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="c-list-search">

    <?php $form = ActiveForm::begin([
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'post_type_id')->dropDownList(ArrayHelper::map(cPostType::find()->all(), 'id', 'name'), ['prompt' => '-- Which type of posts? (Optional) --']); ?>

    <?= $form->field($model, 'scheduled')->inline()->radioList([1 => 'Yes', 2 => 'No', 0 => 'Both']) ?>

    <div style="display:none" id="search_options">
        <?= $form->field($model, 'name') ?>

        <?= $form->field($model, 'text') ?>
    </div>
    <a href="#" onclick="document.getElementById('search_options').style.display='block';">More Search Options</a>

    <?php // echo $form->field($model, 'created_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
