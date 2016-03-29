<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\components\importers\Youtube;

/**
 * @var yii\web\View $this
 * @var common\models\cList $model
 * @var yii\widgets\ActiveForm $form
 */

$search = new Youtube();

?>
<?php ob_start(); ?>
<div style="background-color:#B90000; margin-bottom:15px; padding-left:20px; padding-top:12px; padding-bottom: 12px; border-radius: 4px;">
    <img src="<?=Yii::$app->params['imageUrl']?>Youtube_Logo.png" style="max-height:30px" />
</div>
<?php $this->context->before_panel = ob_get_clean(); ?>

<div class="c-list-form">

    <?php $form = ActiveForm::begin(['method' => 'get', 'id' => 'content-form', 'options' => ['data-persist' => 'garlic', 'data-destroy' => 'false'], 'action' => Yii::$app->urlManager->createUrl(['content/' . $source])]); ?>

    <?php echo $form->errorSummary($model); ?>

    <?= $form->field($model, 'keywords')->textInput(['maxlength' => 255, 'data-storage' => 'false']) ?>

    <p><a href="#" class="show_more_link" id="more_options_<?=$source?>">More Options</a></p>
    <div class="more well well-sm" style="display:none">

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'category')->dropDownList($search->getCategories(), ['prompt' => 'Any']); ?>
                <?= $form->field($model, 'duration')->dropDownList(['any' => 'Any', 'long' => 'Long', 'medium' => 'Medium', 'short' => 'Short']); ?>
                <?= $form->field($model, 'definition')->dropDownList(['any' => 'Any', 'high' => 'High', 'standard' => 'Standard']); ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'type')->dropDownList(['any' => 'Any', 'episode' => 'Episode', 'movie' => 'Movie']); ?>
                <?= $form->field($model, 'order')->dropDownList(['date' => 'Newest', 'rating' => 'Highest Rated', 'relevance' => 'Most Relevant', 'viewCount' => 'Highest View Count']); ?>
                <?= $form->field($model, 'safe_search')->dropDownList([$model::SAFE_SEARCH_MODERATE => 'Moderate', $model::SAFE_SEARCH_STRICT => 'Strict', $model::SAFE_SEARCH_NONE => 'None']) ?>
            </div>
        </div>

    </div>
    <?= $form->field($model, 'hide_used_content')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary', 'id' => 'submit_button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>