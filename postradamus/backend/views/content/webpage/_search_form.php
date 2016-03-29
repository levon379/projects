<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\models\cList $model
 * @var yii\widgets\ActiveForm $form
 */
?>
<?php ob_start(); ?>
<div style="background-color:#EC4100; margin-bottom:15px; padding-left:20px; padding-top:12px; padding-bottom: 12px; border-radius: 4px;">
    <img src="<?=Yii::$app->params['imageUrl']?>Webpage_Logo.png" style="max-height:30px" />
</div>
<?php $this->context->before_panel = ob_get_clean(); ?>
<div class="note note-info padding-xs-vr"><h4>What is this?</h4> This search tool allows you to pull images from any web page. Simply go to a web site in your web browser such as Yahoo images, Google images, etc and copy the URL in your address bar to the field below to pull images from it, which you can then save to your lists.</div>


<div class="c-list-form">

    <?php $form = ActiveForm::begin(['method' => 'get', 'id' => 'content-form', 'options' => ['data-persist' => 'garlic', 'data-destroy' => 'false'], 'action' => Yii::$app->urlManager->createUrl(['content/' . $source])]); ?>

    <?php echo $form->errorSummary($model); ?>

    <?= $form->field($model, 'webpage_url')->textInput(['maxlength' => 1000, 'data-storage' => 'false', 'placeholder' => 'http://']); ?>
    <div class="alert alert-info" role="alert"><strong>Tip:</strong> Try a Yahoo! images web page like <i>http://images.search.yahoo.com/search/images;_ylt=AwrTcXXTLpJTfDYAHdWLuLkF?p=cat&ei=utf-8&fr=sfp-img&fr2=&y=Search</i></div>

    <?= $form->field($model, 'hide_used_content')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Get Images', ['class' => 'btn btn-primary', 'id' => 'submit_button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
