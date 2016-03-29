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
<div style="background-color:#4878A0; margin-bottom:15px; padding-left:20px; padding-top:12px; padding-bottom: 12px; border-radius: 4px;">
    <img src="<?=Yii::$app->params['imageUrl']?>Instagram_Logo.png" style="max-height:30px" />
</div>
<?php $this->context->before_panel = ob_get_clean(); ?>

<div class="c-list-form">

    <?php $form = ActiveForm::begin(['method' => 'get', 'options' => ['data-persist' => 'garlic', 'data-destroy' => 'false'], 'id' => 'content-form', 'action' => Yii::$app->urlManager->createUrl(['content/' . $source])]); ?>

    <?php echo $form->errorSummary($model); ?>

    <ul class="nav nav-pills">
        <li class="<?php if(!isset($_GET['instagram_search_pill']) || $_GET['instagram_search_pill'] == '#pill_tag') { ?>active<?php } ?>"><a href="#pill_tag" data-toggle="pill" style="padding:6px 19px 6px 19px;">Search by Tag</a></li>
        <li class="<?php if(isset($_GET['instagram_search_pill']) && $_GET['instagram_search_pill'] == '#pill_popular') { ?>active<?php } ?>"><a href="#pill_popular" data-toggle="pill" style="padding:6px 19px 6px 19px">Most Popular</a></li>
        <?php /* ?><li class=""><a href="#pill_recent_pages" data-toggle="pill" style="padding:6px 19px 6px 19px">Recently Used Pages</a></li><?php */ ?>
    </ul>

    <div class="tab-content" style="margin-top:10px">

        <div class="tab-pane<?php if(!isset($_GET['instagram_search_pill']) || $_GET['instagram_search_pill'] == '#pill_tag') { ?> active<?php } ?>" id="pill_tag">
            <?= $form->field($model, 'keywords')->textInput(['maxlength' => 255, 'data-storage' => 'false']) ?>
        </div>

        <div class="tab-pane<?php if(isset($_GET['instagram_search_pill']) && $_GET['instagram_search_pill'] == '#pill_popular') { ?> active<?php } ?>" id="pill_popular">
            <b>Pull the most popular media</b>
        </div>

        <?php /* ?>
        <div class="tab-pane" id="pill_recent_pages">
            <select name="from_page3" id="from_page3" style="width:320px">
            </select>
        </div>
        <?php */ ?>

    </div>

    <p><a href="#" class="show_more_link" id="more_options_<?=$source?>">More Options</a></p>
    <div class="more well well-sm" style="display:none">
        <?= $form->field($model, 'type')->inline()->radioList(['0' => 'All', '1' => 'Images', '2' => 'Videos']) ?>
    </div>

    <input type='hidden' id='instagram_search_pill' name='instagram_search_pill' value='<?php echo (isset($_GET['instagram_search_pill']) ? $_GET['instagram_search_pill'] : '#pill_tag') ?>'>

    <?= $form->field($model, 'hide_used_content')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary', 'id' => 'submit_button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
