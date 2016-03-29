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
<div style="background-color:#cb2028; margin-bottom:15px; padding-left:20px; padding-top:12px; padding-bottom: 12px; border-radius: 4px;">
    <img src="<?=Yii::$app->params['imageUrl']?>Pinterest_Logo_White.png" style="max-height:30px" />
</div>
<?php $this->context->before_panel = ob_get_clean(); ?>

<div class="c-list-form">

    <?php $form = ActiveForm::begin(['method' => 'get', 'id' => 'content-form', 'options' => ['data-persist' => 'garlic', 'data-destroy' => 'false'], 'action' => Yii::$app->urlManager->createUrl(['content/' . $source])]); ?>

    <?php echo $form->errorSummary($model); ?>

    <?= $form->field($model, 'keywords')->textInput(['maxlength' => 255, 'data-storage' => 'false']) ?>
    <?php if(!empty($tags)) { ?>
        <b>Additional Keyword Ideas</b><br />
    <?php foreach($tags as $tag) { ?>
    <a href="<?php echo Yii::$app->urlManager->createUrl(['content/pinterest', 'PinterestSearchForm[results]' => $model->results, 'PinterestSearchForm[hide_used_content]' => $model->hide_used_content, 'PinterestSearchForm[keywords]' => $tag]); ?>"><?=trim(str_replace($model->keywords, '', $tag))?></a> |
    <?php } ?>
    <?php } ?>

    <?= $form->field($model, 'results')->hint('The more results you want the longer it will take for the search to complete.')->radioList(['100' => '100', '250' => '250', '500' => '500', '1000' => '1000']); ?>

    <?= $form->field($model, 'hide_used_content')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary', 'id' => 'submit_button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
