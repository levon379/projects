<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\cPostType;
use common\models\cList;

$this->params['help']['message'] = 'This page allows a convenient way to search for content in an existing list you have built and copy that content to another list.';
$this->params['help']['modal_body'] = '<iframe width="853" height="480" id="youtube-video" src="//www.youtube.com/embed/mfoYcpxAyLg" frameborder="0" allowfullscreen></iframe>';

unset($this->params['breadcrumbs']);
$this->params['breadcrumbs'][] = ['label' => 'Content'];
$this->params['breadcrumbs'][] = 'Find in Existing List';

/**
 * @var yii\web\View $this
 * @var common\models\cListSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>
<?php ob_start(); ?>
<div style="background-color:#8DEC00; margin-bottom:15px; padding-left:20px; padding-top:12px; padding-bottom: 12px; border-radius: 4px;">
    <img src="<?=Yii::$app->params['imageUrl']?>Existing_List_Logo.png" style="max-height:30px" />
</div>
<?php $this->context->before_panel = ob_get_clean(); ?>

<div class="c-list-search">

    <?php $form = ActiveForm::begin(['method' => 'get', 'id' => 'content-form', 'options' => ['data-persist' => 'garlic', 'data-destroy' => 'false'], 'action' => Yii::$app->urlManager->createUrl(['content/' . $source])]); ?>

    <?php
    $lists['Not Ready'] = yii\helpers\ArrayHelper::map(cList::findNotReady()->orderBy('name')->all(), 'id', 'name_with_count_and_dates');
    $lists['Ready'] = yii\helpers\ArrayHelper::map(cList::findReady()->orderBy('name')->all(), 'id', 'name_with_count_and_dates');
    $lists['Sending'] = yii\helpers\ArrayHelper::map(cList::findSending()->orderBy('name')->all(), 'id', 'name_with_count_and_dates');
    $lists['Sent'] = yii\helpers\ArrayHelper::map(cList::findSent()->orderBy('name')->all(), 'id', 'name_with_count_and_dates');
    ?>
    <?= $form->field($model, 'list_id')->dropDownList($lists, ['id' => 'list_id', 'data-storage' => 'false', 'prompt' => '-- (Optional) --']); ?>

    <p><a href="#" class="show_more_link">More Options</a></p>
    <div class="more well well-sm" id="more_options_<?=$source?>" style="display:none">
    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'text') ?>

    <?= $form->field($model, 'post_type_id')->dropDownList(ArrayHelper::map(cPostType::find()->all(), 'id', 'name'), ['prompt' => '-- Which type of posts? (Optional) --']); ?>

    <?= $form->field($model, 'scheduled')->inline()->radioList([1 => 'Yes', 2 => 'No', 0 => 'Both']) ?>

    <?= $form->field($model, 'is_link_post')->inline()->radioList([1 => 'Yes', 0 => 'No', 2 => 'Both']) ?>
    </div>

    <?php // echo $form->field($model, 'created_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary', 'id' => 'submit_button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
