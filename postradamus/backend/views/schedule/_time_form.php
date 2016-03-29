<?php

use common\models\cScheduleTime;
use common\models\cScheduleTimePostType;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\models\cPostType;

//find all models for this week day and user and schedule_id
$times = cScheduleTime::find()->andWhere(['weekday' => $weekday, 'schedule_id' => $list_id])->orderBy('time')->all();

$this->registerCss(".showMoreLinkBlock{margin:10px 0 5px;} .showMoreLinkBlock > .showMoreLink{text-decoration:underline;} .field-cscheduletime-post_types{display:none;} .clear-fix{float:none;clear:both;} .btn-icon{padding:3px 5px !important; margin-right:4px !important;} .btn-icon > i{font-size:11px !important;} a.btn-icon{position:absolute;}");
?>

<div style="padding: 10px;">
<h3 style="margin-bottom:0; margin-top: 5px">Existing Times</h3>
<?php
if(!empty($times)) {
    foreach($times as $time) {
        ?>
        <div class="existing-time-block" style="background-color:#ffffff; padding-top:10px">
            <?php /* ?>
                    <h1 class="fa fa-minus-square primary" style="float:left"></h1>
                    <?php */ ?>
            <div>
                <?php $form = ActiveForm::begin(['action' => Yii::$app->urlManager->createUrl(['schedule-time/update', 'id' => $time->id, 'weekday' => $weekday])]); ?>

                <?= $form->field($time, 'time')->textInput(['class' => 'form-control timepicker']) ?>

				<div class="clear-fix"></div>
				<div class="row showMoreLinkBlock">
					<a class="showMoreLink" href="javascript:void(0);">Show More</a>
				</div>	
				<div class="clear-fix"></div>
				
                <?php
                $post_types = cScheduleTimePostType::find()->where(['schedule_time_id' => $time->id])->all();
                $selected_options = [];
                foreach($post_types as $post_type)
                {
                    $time->post_types[] = $post_type->post_type_id;
                }
                ?>
                <?= $form->field($time, 'post_types')->listBox(ArrayHelper::map(cPostType::find()->all(), 'id', 'name'), ['class' => 'form-control select', 'multiple' => 'multiple']); ?>

                <div class="form-group">
                    <?php /* ?><?=Html::submitButton($time->isNewRecord ? 'Create' : 'Update', ['class' => $time->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?><?php */ ?>
					<?=Html::submitButton( '<i class="glyphicon glyphicon-floppy-disk"></i>', ['class' => 'btn btn-primary btn-icon', 'data-toggle' => 'tooltip' , 'data-placement' => 'bottom' , 'title' => 'Update']) ?>
                    <?= Html::a( '<i class="glyphicon glyphicon-trash"></i>' , ['schedule-time/delete', 'id' => $time->id, 'weekday' => $weekday], ['class' => 'btn btn-danger btn-icon' , 'onclick' => 'return confirm("Are you sure?");' , 'data-toggle' => 'tooltip' , 'data-placement' => 'bottom' , 'title' => 'Delete' ]) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    <?php } ?>
<?php } else { ?>
No times exist for this day.
<?php } ?>
</div>
<?php $this->beginBlock('viewJs'); ?>
<script type="text/javascript">
	$(function () {
	  $('[data-toggle="tooltip"]').tooltip()
	});
	$(document).ready(function(){
		$('.showMoreLink').on('click',function(){
			var relatedField = $(this).closest('.existing-time-block').find('.field-cscheduletime-post_types') ; 
			relatedField.slideToggle();
			if( $(this).html() == 'Show More' ){
				$(this).html('Show Less');
			}
			else{
				$(this).html('Show More');
			}
		});
	});
</script>
<?php $this->endBlock(); ?>