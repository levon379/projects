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
<div style="background-color:white; margin-bottom:15px; padding-left:20px; padding-top:12px; padding-bottom: 12px; border-radius: 4px;">
    <a href="http://www.reddit.com" target="blank"><img src="<?=Yii::$app->params['imageUrl']?>Reddit-Logo.png" style="max-height:30px" /></a>
</div>
<?php $this->context->before_panel = ob_get_clean(); ?>

<div class="c-list-form">

    <?php $form = ActiveForm::begin(['method' => 'get', 'id' => 'content-form', 'options' => ['data-persist' => 'garlic', 'data-destroy' => 'false'], 'action' => Yii::$app->urlManager->createUrl(['content/' . $source])]); ?>

    <?php echo $form->errorSummary($model); ?>

    <?= $form->field($model, 'keywords')->textInput(['maxlength' => 255, 'data-storage' => 'false']) ?>
    <p> -- or -- </p>
    <?= $form->field($model, 'type')->radioList(['hot' => 'Hot', 'new' => 'New', 'rising' => 'Rising', 'controversial' => 'Controversial', 'top' => 'Top', 'gilded' => 'Gilded']) ?>

    <p><a href="#" class="show_more_link" id="more_options_<?=$source?>">More Options</a></p>
    <div class="more well well-sm" style="display:none">
    <?= $form->field($model, 'subreddit')->hiddenInput(['id' => 'subreddit']); ?>

    <?= $form->field($model, 'large_images')->checkbox() ?>
    </div>

    <?= $form->field($model, 'hide_used_content')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary', 'id' => 'submit_button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
