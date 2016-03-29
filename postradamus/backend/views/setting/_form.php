<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->registerJsFile(Yii::getAlias('@web') . '/js/bootstrap-slider.js', [yii\web\JqueryAsset::className()]);
$this->registerCssFile(Yii::getAlias('@web') . '/css/slider.css', [yii\bootstrap\BootstrapAsset::className()]);

/**
 * @var yii\web\View $this
 * @var common\models\cSetting $model
 * @var yii\widgets\ActiveForm $form
 */

$this->registerCss(".showMoreLinkBlock{margin:10px 0 5px;} #showMoreLink{text-decoration:underline;} .deprecatedOptions{display:none;} .clear-fix{float:none;clear:both;}");
 
$this->registerJs('
					init.push(function () {
						// Single select
						$(".timezone").select2({
							allowClear: true,
							placeholder: "Select a Timezone"
						});
				    });
');
?>

<div class="c-setting-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php

    function formatOffset($offset) {
        $hours = $offset / 3600;
        $remainder = $offset % 3600;
        $sign = $hours > 0 ? '+' : '-';
        $hour = (int) abs($hours);
        $minutes = (int) abs($remainder / 60);

        if ($hour == 0 AND $minutes == 0) {
            $sign = ' ';
        }
        return $sign . str_pad($hour, 2, '0', STR_PAD_LEFT) .':'. str_pad($minutes,2, '0');

    }

    $utc = new DateTimeZone('UTC');
    $dt = new DateTime('now', $utc);

    foreach(DateTimeZone::listIdentifiers() as $tz) {
        $current_tz = new DateTimeZone($tz);
        $offset =  $current_tz->getOffset($dt);
        $transition =  $current_tz->getTransitions($dt->getTimestamp(), $dt->getTimestamp());
        $abbr = $transition[0]['abbr'];
        $options[$tz] = str_replace("_", " ", $tz). ' [' .$abbr. ' '. formatOffset($offset). ']';
    }

	$date_format_choose = [
		date('d-m-y',time())=>['date_format'=>'d-m-y'],
		date('d-m-Y',time())=>['date_format'=>'d-m-Y'],
		date('d M y',time())=>['date_format'=>'d M y'],
		date('d M y',time())=>['date_format'=>'d M y'],
		date('D j/n/Y',time())=>['date_format'=>'D j/n/Y'],
		date('jS \o\f F Y',time())=>['date_format'=>'jS of F Y'],
	];
	$time_format_choose = [
		date('H:i',time())   => ['time_format'=>'H:i'],
		date('G:i',time())   => ['time_format'=>'G:i'],
		date('g:i A',time()) => ['time_format'=>'g:i A'],
		date('h:i A',time()) => ['time_format'=>'h:i A'],
		date('g:i a',time()) => ['time_format'=>'g:i a'],
		date('h:i a',time()) => ['time_format'=>'h:i a'],
	];

    ?>

    <?= $form->field($model, 'timezone')->dropDownList($options, ['prompt' => '', 'class' => 'form-control timezone']) ?>

	<label for="date_format_select"> Choose Date Format
		<select id="date_format_select" class="form-control">
			<?php foreach($date_format_choose as $key=>$value): ?>
				<option value="<?=$value['date_format']?>"><?=$key?></option>
			<?php endforeach ?>
		</select>
	</label>
	<label for="time_format_select"> Choose Time Format
		<select  id="time_format_select" class="form-control">
			<option value="H:i"><?=date('H:i',time())?></option>
			<option value="G:i" ><?=date('g:i',time())?></option>
			<option value="g:i A"><?=date('g:i A',time())?></option>
			<option value="h:i A"><?=date('h:i A',time())?></option>
			<option value="g:i a"><?=date('g:i a',time())?></option>
			<option value="h:i a"><?=date('h:i a',time())?></option>
		</select>
	</label>
	</br>
<!--	<h4>Or fill yourself</h4>-->

    <?php //$form->field($model, 'date_format')->textInput(['placeholder' => 'M d y']); ?>

    <?php //$form->field($model, 'time_format')->textInput(['placeholder' => 'h:i A']); ?>

<!--    <p><a href="http://us3.php.net/manual/en/function.date.php" target="blank">Click here for a list of letters you can use for the date and time.</a></p>-->
    <div class="row tooltip_row">
            <?php
            $this->registerCss("
				.switcher-sm{width:50px !important;}
				.switcher-sm .switcher-state-on, .switcher-sm .switcher-state-off{font-size: 9px !important;line-height:24px !important;}
				.switcher-sm .switcher-state-off{padding-left:13px !important;}
				.separator{float:none;clear:both;margin-top:25px;}
				.tooltips-label-line{float: left;margin-right: 12px;padding-top: 1px;}
				.loading-cursor{cursor:wait !important;}
				#time_format_select, #date_format_select {font-weight:normal!important;}
				.tooltip_row {margin-top:15px;}
				");
            ?>
		<div class="panel">
			<div class="panel-heading">
				<span class="panel-title">Tooltips</span>
				<div class="panel-heading-controls">
				</div> <!-- / .panel-heading-controls -->
			</div> <!-- / .panel-heading -->
                <div class="panel-body">
                    <div class="tooltips-label-line">
                        On/Off tooltips settings to enable/disable all tooltips
                    </div>

                    <div class="switcher switcher-sm switcher-primary">
                        <input type="checkbox" data-class="switcher-sm switcher-primary" id="on-off-tooltips" <?=($isTooltipsOn)?'checked="checked"':''?> data-status="<?=($isTooltipsOn)?'true':'false'?>" data-on-off-tooltips-url="<?=Yii::$app->urlManager->createUrl(['tooltips/default/on-off-tooltips'])?>">
                    </div>

                </div>
		</div>
            <?php
            $this->registerJs("
            $(document).ready(function(){
					var switcherEl = $('#on-off-tooltips').switcher();
					$('#on-off-tooltips').on('change',function(e){
						switcherEl.switcher('disable');
						var inputElm=$(this);
						var status=inputElm.data('status');
						status=status?false:true;
						var tooltipsOnOffUrl=inputElm.data('onOffTooltipsUrl');
						$.ajax({
							'url' : tooltipsOnOffUrl,
							'type' : 'POST',
							'dataType' : 'JSON',
							'data':{status:status},
							'beforeSend' : function(){
							},
							'success':function(result){
								if(result.success=='1'){
									inputElm.data('status',status);
									if(status){
										switcherEl.switcher('on');
									}
									else{
										switcherEl.switcher('off');
									}
								}
								else{
									alert('Error!');
								}

							},
							'error' : function(){
								alert('Error!');
							},
							'complete' : function(){
								switcherEl.switcher('enable');
							}
						});
					});
				});

			$('#date_format_select').change(function(){
				var value = $(this).val();
				$('#csetting-date_format').val(value);
			});
			$('#time_format_select').change(function(){
				var value = $(this).val();
				$('#csetting-time_format').val(value);
			});
		");
            ?>
    </div>
	<div class="clear-fix"></div>
	<div class="row showMoreLinkBlock">
		<a id="showMoreLink" href="javascript:void(0);">Show deprecated options</a>
	</div>	
	<div class="clear-fix"></div>
	
    <fieldset style="padding: 10px; border: 1px solid #e2e2e2; margin-bottom: 10px; background-color: #f6f6f6" class="deprecatedOptions">
        <!--<legend style="margin:0; border:0; padding-left:5px;">Facebook Macro Export Settings</legend>-->
    <div class="note note-info padding-xs-vr"><h4>What is this?</h4> This is only required if you plan to use the Facebook Macro export option. <a href="http://youtu.be/UxqU2ikVhRI" target="_blank">Watch a video on how to find this.</a></div>

    <?= $form->field($model, 'macro_path')->textInput(['maxlength' => 255])->hint('Windows Example: C:\Users\YourName\Documents\iMacros\Downloads\ <br /> Macintosh Example: /Users/YourName/iMacros/Downloads/') ?>

    <?= $form->field($model, 'macro_speed')->dropDownList([-2 => 'Very Slow (About 2 minutes per post)', -1 => 'Slow (About 1 minute per post)', 0 => 'Normal (About 30 seconds per post)'], ['class' => 'form-control']); ?>
    </fieldset>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php $this->beginBlock('viewJs'); ?>
<script type="text/javascript">
	$(document).ready(function(){
		$('#showMoreLink').on('click',function(){
			$('.deprecatedOptions').slideToggle();
			if( $(this).html() == 'Show deprecated options' ){
				$(this).html('Hide deprecated options');
			}
			else{
				$(this).html('Show deprecated options');
			}
		});
	});
</script>
<?php $this->endBlock(); ?>