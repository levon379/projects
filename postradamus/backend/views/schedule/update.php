<?php

use yii\bootstrap\ActiveForm;
use common\models\cScheduleTime;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use common\models\cPostType;

/**
 * @var yii\web\View $this
 * @var common\models\cSchedule $model
 */

$this->title = 'Update Schedule: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = 'Settings';
$this->params['breadcrumbs'][] = ['label' => 'Schedules', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;

$this->registerCss(" #cschedule-name,#cschedule-campaign_id,#s2id_cschedule-campaign_id,#cscheduletime-time{ width:300px !important;}
#s2id_cschedule-campaign_id{display:block;}
#s2id_cschedule-campaign_id .select2-choice{border-radius:4px;}
.existing-time-block .timepicker,.field-cscheduletime-post_types{ width:300px !important;}
.c-schedule-update{display:none;}
");

$this->registerJs("
					init.push(function () {

						var options = {
							minuteStep: 1,
							showSeconds: false,
							showMeridian: false,
							minuteStep: 10,
							showInputs: false,
							orientation: $('body').hasClass('right-to-left') ? { x: 'right', y: 'auto'} : { x: 'auto', y: 'auto'}
						}
						$('.timepicker').timepicker(options);

						// Colors
						$('.select').select2({
                            formatSelectionCssClass: function (data, container) { data.id; }
                        });

					});
");
?>

	<div class="row col-md-12 showBasicUpdate">
		<?=$model->name?> &nbsp;  <a id="showUpdateFieldsLink" href="javascript:void(0);"><i class="glyphicon glyphicon-pencil" data-toggle="tooltip" data-placement="bottom" title="Click to edit Schedule Name & Campaign"></i></a>
	</div>	
	<?php
		$this->registerJs("$(document).ready(function(){
			$('#showUpdateFieldsLink').on('click',function(){
				$('.c-schedule-update').slideToggle();
				$(this).closest('.showBasicUpdate').hide();
			});
		});");
	?>
	
	<div class="c-schedule-update">
		<?= $this->render('_form', [
			'model' => $model,
		]) ?>
	</div>
</div>
    </div>


<div class="panel">
    <div class="panel-heading">
        <span class="panel-title">Schedule Setup</span>
    </div>

    <div class="panel-body">

        <!-- Pills -->
        <ul class="nav nav-pills bs-tabdrop-example">
            <li class="<?php if(!isset($weekday) || $weekday == '1') { ?> active<?php } ?>"><a href="<?php echo Yii::$app->urlManager->createUrl(['schedule/update', 'id' => $_GET['id'], 'weekday' => 1]) ?>">Monday</a></li>
            <li class="<?php if(isset($weekday) && $weekday == '2') { ?> active<?php } ?>"><a href="<?php echo Yii::$app->urlManager->createUrl(['schedule/update', 'id' => $_GET['id'], 'weekday' => 2]) ?>">Tuesday</a></li>
            <li class="<?php if(isset($weekday) && $weekday == '3') { ?> active<?php } ?>"><a href="<?php echo Yii::$app->urlManager->createUrl(['schedule/update', 'id' => $_GET['id'], 'weekday' => 3]) ?>">Wednesday</a></li>
            <li class="<?php if(isset($weekday) && $weekday == '4') { ?> active<?php } ?>"><a href="<?php echo Yii::$app->urlManager->createUrl(['schedule/update', 'id' => $_GET['id'], 'weekday' => 4]) ?>">Thursday</a></li>
            <li class="<?php if(isset($weekday) && $weekday == '5') { ?> active<?php } ?>"><a href="<?php echo Yii::$app->urlManager->createUrl(['schedule/update', 'id' => $_GET['id'], 'weekday' => 5]) ?>">Friday</a></li>
            <li class="<?php if(isset($weekday) && $weekday == '6') { ?> active<?php } ?>"><a href="<?php echo Yii::$app->urlManager->createUrl(['schedule/update', 'id' => $_GET['id'], 'weekday' => 6]) ?>">Saturday</a></li>
            <li class="<?php if(isset($weekday) && $weekday == '7') { ?> active<?php } ?>"><a href="<?php echo Yii::$app->urlManager->createUrl(['schedule/update', 'id' => $_GET['id'], 'weekday' => 7]) ?>">Sunday</a></li>
        </ul>
        <div class="tab-pane active" id="bs-tabdrop-pill1">
            <?php echo $this->render('_time_form', ['list_id' => $model->id, 'weekday' => (isset($weekday) ? $weekday : 1)]); ?>
        </div>

        <div style="background-color:#f9f9f9; padding: 10px; margin-top:15px">
            <h3 style="margin-top:0px">Add Time</h3>

            <div>

                <div>

                    <?php $mymodel = new cScheduleTime(); ?>

                    <?php $form = ActiveForm::begin([
                            'action' => Yii::$app->urlManager->createUrl(['schedule-time/create', 'id' => $_GET['id'], 'weekday' => (isset($weekday) ? $weekday : 1)])
                    ]); ?>

                    <?= $form->field($mymodel, 'time')->textInput(['class' => 'form-control timepicker']) ?>

                    <?= $form->field($mymodel, 'post_types')->listBox(ArrayHelper::map(cPostType::find()->all(), 'id', 'name'), ['class' => 'select form-control', 'multiple' => 'multiple']); ?>

                    <?php
                        $mymodel->weekdays = $weekday;
                    ?>
                    <?= $form->field($mymodel, 'weekdays')->inline()->checkboxList([1 => 'Mon', 2 => 'Tue', 3 => 'Wed', 4 => 'Thu', 5 => 'Fri', 6 => 'Sat', 7 => 'Sun']); ?> <a href="#" id="check-all">[ Select All ]</a><br /><br />

                    <div class="form-group">
                        <?php echo Html::submitButton($mymodel->isNewRecord ? 'Create' : 'Update', ['class' => $mymodel->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>

        <?php
            echo $this->registerJs("
                $(document).ready(function() {
                    $('#check-all').click(function(event) {  //on click
                        event.preventDefault();
                        is_checked = false;
                        $('input[type=\"checkbox\"][name=\"cScheduleTime[weekdays][]\"]').each(function() { //loop through each checkbox
                            this.checked = true;  //select all checkboxes with class
                        });
                    });
                });
            ");
        ?>

    </div>

    </div>