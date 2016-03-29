<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\models\cList $model
 * @var yii\widgets\ActiveForm $form
 */

$this->params['help']['message'] = 'Search any RSS or Atom feed for content for your Facebook page!';
$this->params['help']['modal_body'] = '<iframe width="853" height="480" src="//www.youtube.com/embed/ZOA__KJ5LLQ" id="youtube-video" frameborder="0" allowfullscreen></iframe>';

?>
<?php ob_start(); ?>
<div style="background-color:#F4B73F; margin-bottom:15px; padding-left:20px; padding-top:12px; padding-bottom: 12px; border-radius: 4px;">
    <img src="<?=Yii::$app->params['imageUrl']?>Feed_Logo.png" style="max-height:30px" />
</div>
<?php $this->context->before_panel = ob_get_clean(); ?>

<div class="c-list-form">

    <?php $form = ActiveForm::begin(['method' => 'get', 'id' => 'content-form', 'options' => ['data-persist' => 'garlic', 'data-destroy' => 'false'], 'action' => Yii::$app->urlManager->createUrl(['content/' . $source])]); ?>

    <?php echo $form->errorSummary($model); ?>

    <ul class="nav nav-pills">
        <li class="<?php if(!isset($model->feed_search_pill) || $model->feed_search_pill == '#pill_feed2') { ?>active<?php } ?>"><a href="#pill_feed2" data-toggle="pill" style="padding:6px 19px 6px 19px;">Search Feeds</a></li>
        <li class="<?php if(isset($model->feed_search_pill) && $model->feed_search_pill == '#pill_feed1') { ?>active<?php } ?>"><a href="#pill_feed1" data-toggle="pill" style="padding:6px 19px 6px 19px">Specific Feed URL</a></li>
        <li class="<?php if(isset($model->feed_search_pill) && $model->feed_search_pill == '#pill_feed3') { ?>active<?php } ?>"><a href="#pill_feed3" data-toggle="pill" style="padding:6px 19px 6px 19px">Saved Feeds</a></li>
    </ul>

    <div class="tab-content" style="margin-top:10px">

        <div class="tab-pane<?php if(!isset($model->feed_search_pill) || $model->feed_search_pill == '#pill_feed2') { ?> active<?php } ?>" id="pill_feed2">
            <div style="margin-bottom:5px">
                <?php echo Html::activeHiddenInput($model, 'feed2', ['id' => 'feed2']); ?>
            </div>
        </div>

        <div class="tab-pane<?php if(isset($model->feed_search_pill) && $model->feed_search_pill == '#pill_feed1') { ?> active<?php } ?>" id="pill_feed1">
            <?= $form->field($model, 'feed1')->label(false)->textInput(['maxlength' => 255, 'data-storage' => 'false', 'placeholder' => 'Enter a feed URL starting with http://']) ?>
        </div>

        <div class="tab-pane<?php if(isset($model->feed_search_pill) && $model->feed_search_pill == '#pill_feed3') { ?> active<?php } ?>" id="pill_feed3">
            <?= $form->field($model, 'feed3')->label(false)->listBox(\yii\helpers\ArrayHelper::map(\common\models\cSavedSearch::find()->andWhere(['origin_type' => \common\models\cListPost::ORIGIN_FEED])->orderBy('name')->all(), 'search_value', 'name'), ['prompt' => '', 'multiple' => 'multiple', 'class' => 'select2']) ?>
        </div>

    </div>
    <?php echo Html::activeHiddenInput($model, 'feed_search_pill'); ?>

    <?= $form->field($model, 'hide_used_content')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary', 'id' => 'submit_button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
