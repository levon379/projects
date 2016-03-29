<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use backend\components\importers\TwitterList;

/**
 * @var yii\web\View $this
 * @var common\models\cList $model
 * @var yii\widgets\ActiveForm $form
 */

$this->registerCss('
    .alert { padding: 8px; }
');

?>
<?php ob_start(); ?>
<div style="background-color:#36B9FF; margin-bottom:15px; padding-left:20px; padding-top:12px; padding-bottom: 12px; border-radius: 4px;">
    <img src="<?=Yii::$app->params['imageUrl']?>Twitter_Logo.png" style="max-height:30px" />
</div>
<?php $this->context->before_panel = ob_get_clean(); ?>

<div class="c-list-form">

    <ul class="nav nav-pills">
        <li class="<?php if(Yii::$app->request->getQueryParam('r') == 'content/twitter-search') { ?>active<?php } ?>"><a href="<?=Yii::$app->urlManager->createUrl('content/twitter-search')?>" style="padding:6px 19px 6px 19px;">Search</a></li>
        <li class="<?php if(Yii::$app->request->getQueryParam('r') == 'content/twitter-timeline') { ?>active<?php } ?>"><a href="<?=Yii::$app->urlManager->createUrl('content/twitter-timeline')?>" style="padding:6px 19px 6px 19px">My Timeline</a></li>
        <li class="<?php if(Yii::$app->request->getQueryParam('r') == 'content/twitter-list') { ?>active<?php } ?>"><a href="<?=Yii::$app->urlManager->createUrl('content/twitter-list')?>" style="padding:6px 19px 6px 19px">My Lists</a></li>
    </ul>

    <div class="tab-content" style="margin-top:10px">

        <?php if(Yii::$app->request->getQueryParam('r') == 'content/twitter-search') { ?>
            <div class="tab-pane active" id="pill_search">
                <?php $form = ActiveForm::begin(['method' => 'get', 'id' => 'search-form', 'options' => ['data-persist' => 'garlic', 'data-destroy' => 'false'], 'action' => Yii::$app->urlManager->createUrl(['content/twitter-search'])]); ?>

                <?php echo $form->errorSummary($model); ?>

                <?= $form->field($model, 'keywords')->textInput(['maxlength' => 255, 'data-storage' => 'false']) ?>
                <div class="alert alert-info" role="alert" style="margin-bottom:1px"><strong>Tip:</strong> You can use <a href="#" data-toggle="modal" data-target="#myModal" style="text-decoration:underline; font-weight: bold">search operators</a>.</div>

                <div id="myModal" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title" id="myModalLabel">Search Operators</h4>
                            </div>
                            <div class="modal-body">
                            <img src="<?=Yii::$app->params['imageUrl']?>twitter_search_operators.png" class="img-responsive" />
                            </div>
                       </div>
                   </div>
                </div>

                <p><a href="#" class="show_more_link" id="more_options_<?=$source?>">More Options</a></p>
                <div class="more well well-sm" style="display:none">
                    <?= $form->field($model, 'result_type')->inline()->radioList(['mixed' => 'Mixed', 'popular' => 'Popular', 'recent' => 'Recent']); ?>

                    <?= $form->field($model, 'include_retweets')->checkbox() ?>
                </div>

                <?= $form->field($model, 'hide_used_content')->checkbox() ?>

                <div class="form-group">
                    <?= Html::submitButton('Search', ['class' => 'btn btn-primary', 'id' => 'submit_button']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        <?php } ?>

        <?php if(Yii::$app->request->getQueryParam('r') == 'content/twitter-timeline') { ?>
            <div class="tab-pane active" id="pill_search">
                <?php $form = ActiveForm::begin(['method' => 'get', 'id' => 'search-form', 'action' => Yii::$app->urlManager->createUrl(['content/twitter-timeline'])]); ?>

                <?php echo $form->errorSummary($model); ?>

                <?= $form->field($model, 'hide_used_content')->checkbox() ?>

                <div class="form-group">
                    <?= Html::submitButton('Search', ['class' => 'btn btn-primary', 'id' => 'submit_button']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        <?php } ?>

        <?php if(Yii::$app->request->getQueryParam('r') == 'content/twitter-list') { ?>
        <div class="tab-pane active" id="pill_lists">
            <?php $form = ActiveForm::begin(['method' => 'get', 'id' => 'list-form', 'action' => Yii::$app->urlManager->createUrl(['content/twitter-list'])]); ?>

            <?php echo $form->errorSummary($model); ?>

            <?php
                $twitter = new TwitterList();
                $lists = $twitter->getLists();
            ?>
            <?= $form->field($model, 'list_id')->dropDownList($lists, ['prompt' => '--- Choose a list ---']) ?>

            <p><a href="#" class="show_more_link" id="more_options_<?=$source?>">More Options</a></p>
            <div class="more well well-sm" style="display:none">
            <?= $form->field($model, 'include_retweets')->checkbox() ?>
            </div>

            <?= $form->field($model, 'hide_used_content')->checkbox() ?>

            <div class="form-group">
                <?= Html::submitButton('Search', ['class' => 'btn btn-primary', 'id' => 'submit_button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
        <?php } ?>

    </div>

</div>