<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\cSchedule;

/**
 * @var yii\web\View $this
 * @var common\models\cList $model
 * @var yii\widgets\ActiveForm $form
 */

use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use backend\components\FacebookHelper;

$this->registerCss('
.tab-content {
padding: 0;
}
');

$this->registerJs(
"
    $('#page_id').hide();

    $('#find_last_scheduled_time_link').on('click', function() {
        $('#search_last_scheduled_time').show();
        $('#find_last_scheduled_time').hide();

        $.ajax({
          url: '".Yii::$app->urlManager->createUrl('list/get-pages')."',
          access_token: '".$_SESSION['fb_token']."',
          dataType: 'json',
        }).done(function(data) {
            $.each(data, function(i, value) {
                $('#page_id').append($('<option>').text(value).attr('value', i));
            });
            $('#page_id').show();
            $('#loading2').hide();
        }).fail(function() {
            $('#loading2').html('There was a temporary problem retrieving your pages. Please <a href=\'" . Yii::$app->urlManager->createUrl('list/get-pages') . "\' target=\'_blank\'>click here</a>, wait for the page to load, then close the page and refresh this page and all should be well in the world :) This will be fixed soon.');
        });
    });

    $('#page_id').on('change', function() {
        $.ajax({
          url: '".Yii::$app->urlManager->createUrl('list/get-last-scheduled-time')."',
          data: { page_id: $('#page_id').val() },
          dataType: 'json',
        }).done(function(data) {
          $('#last_scheduled_time').text(data.formatted);
          $('#date_insert').data('date', data.formatted_picker);
          $('#show_post').attr('href', 'http://fb.com/' + data.post_id);
          if(data.formatted == 'None Found')
          $('#set_date').hide();
          else
          $('#set_date').show();
        });
    });

    $('#date_insert').on('click', function() {
          $('#listschedulerform-start_date-disp').val($(this).data('date'));
          $('#listschedulerform-start_date-disp').parent().datepicker('update');
    });
"
);

?>
<div class="well well-sm">
    <div id="find_last_scheduled_time">
        <a href="#" id="find_last_scheduled_time_link"><span class="glyphicon glyphicon-search"></span> Lookup Last Scheduled Post Time</a>
    </div>
    <div id="search_last_scheduled_time" style="display:none">
        <p id="loading2" style="margin-bottom:0">Loading your pages...</p>
        <?= Html::dropDownList('page_id', [], [], ['prompt' => 'Choose a page...', 'class' => 'form-control', 'style' => 'margin-bottom:0', 'id' => 'page_id']) ?>
        <span id="last_scheduled_time" style="font-weight:bold"></span>
        <div id="set_date" style="display:none">
            <?php /* ?><a href="#" id="date_insert">Set Date</a>
            | <?php */ ?><a href="#" id="show_post" target="_blank">Show Post</a>
        </div>
    </div>
</div>
<div class="c-list-form">

    <?php $form = ActiveForm::begin(['action' => Yii::$app->urlManager->createUrl(['list/view', 'id' => $id])]); ?>

    <?php echo $form->errorSummary($model); ?>

    <?= Html::activeHiddenInput($model, 'list_id', ['value' => $id]); ?>

    <?php
        use kartik\datecontrol\DateControl;
        // Use a DateTimePicker input with ActiveForm and model validation enabled.
        echo $form->field($model, 'start_date')
            ->widget(DateControl::classname(), [
            'type'=>DateControl::FORMAT_DATE,
                'displayFormat' => 'php:M d Y',
                'saveFormat' => 'php:Y-m-d'
        ]);
    ?>

    <?= $form->field($model, 'schedule_id')->dropDownList(ArrayHelper::map(cSchedule::find()->all(), 'id', 'name'), ['class' => 'form-control select2']) ?>

    <?= $form->field($model, 'randomize_time')->checkbox(['maxlength' => 255])->hint('This will add or subtract up to 20 minutes onto the scheduled time of each post.') ?>

    <?= $form->field($model, 'randomize_posts')->checkbox(['maxlength' => 255])->hint('This will shuffle your posts right before the scheduler runs against them.') ?>

    <?= $form->field($model, 'unscheduled_posts_only')->checkbox(['maxlength' => 255]) ?>

    <div class="form-group">
        <?= Html::submitButton('Run Scheduler', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
