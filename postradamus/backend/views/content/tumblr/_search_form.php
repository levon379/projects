<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\models\cList $model
 * @var yii\widgets\ActiveForm $form
 */
?>
<?php ob_start(); ?>
<div style="background-color:#35465d; margin-bottom:15px; padding-left:20px; padding-top:12px; padding-bottom: 12px; border-radius: 4px;">
    <img src="<?=Yii::$app->params['imageUrl']?>tumblr_logo.jpg" style="max-height:30px" />
</div>
<?php $this->context->before_panel = ob_get_clean(); ?>

<div class="c-list-form">

    <?php $form = ActiveForm::begin(['method' => 'get', 'id' => 'content-form', 'options' => ['data-persist' => 'garlic', 'data-destroy' => 'false'], 'action' => Yii::$app->urlManager->createUrl(['content/' . $source])]); ?>

    <?php echo $form->errorSummary($model); ?>

    <?= $form->field($model, 'keywords')->textInput(['maxlength' => 255, 'data-storage' => 'false']) ?>

    <?= $form->field($model, 'hide_used_content')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary', 'id' => 'submit_button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
