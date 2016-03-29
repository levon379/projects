<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var \common\models\LoginForm $model
 * @var \backend\controllers\ExportController $lists
 */
$this->title = 'Facebook Direct Export';
$this->params['breadcrumbs'][] = 'Export';
$this->params['breadcrumbs'][] = $this->title;

$this->params['help']['message'] = 'Using this export method will send the posts in your list to Facebook one at a time (according to the dates and times you set). You will not need to take any further steps.';

$this->registerJs('
$("#export-form").submit(function(e) {
   $("#submit_button").attr("disabled", "disabled").html("Please wait. Sending to Facebook...");
   return true;
});
function format(page) {
    el = $(page.element);
    if (!el.data("image_url")) return page.text; // optgroup
    return \'<img class=\"select-image\" src=\"\' + el.data("image_url") + \'" />\' + page.text;
}

$("#facebookdirectexportform-fb_page_id").select2({
    formatResult: format,
    formatSelection: format,
    placeholder: "(Choose one)",
    escapeMarkup: function(m) { return m; }
});

$("#facebookdirectexportform-fb_page_id").on("change", function(e) { 
   $("#facebookdirectexportform-fb_page_name").val($(this).find(":selected").text());

   var  fbTargetType = $(this).find(":selected").closest("optgroup").attr("label");
   $("#facebookdirectexportform-fb_target_type").val(fbTargetType);
   
   if(fbTargetType=="Groups"){
	//$("#facebookdirectexportform-internal_scheduler").prop("checked",true);
	//$("#facebookdirectexportform-internal_scheduler").attr("disabled",true);
   }
   else{
	//$("#facebookdirectexportform-internal_scheduler").attr("disabled",false);
   }
});

');

$pages = $fh->get_user_pages();
$new_pages=[];
foreach($pages as $page)
{
    $new_pages[$page->id] = $page->name;
    $data_elements[$page->id] = ['data-image_url' => ($page->cover->source ? $page->cover->source : 'http://placehold.it/25x25')];
}
//array_multisort(array_map('strtolower', $new_pages), $new_pages);

$groups = $fh->get_user_groups();
$groupsList=[];
foreach($groups as $group){
    $groupsList[$group->id] = $group->name;
    $data_elements[$group->id] = ['data-image_url' => ($group->cover->source ? $group->cover->source : 'http://placehold.it/25x25')];
}
//array_multisort(array_map('strtolower', $groupsList), $groupsList);

$me = $fh->get_user_profile();
$fb_target_list=['My Feed' => [$me['id'] => $me['name']], 'Pages'=>$new_pages, 'Groups'=>$groupsList];
//$fh->get_user_pages_test();

?>
<?php $form = ActiveForm::begin(['id' => 'export-form', 'enableClientValidation' => false]); ?>
        <?php echo $form->errorSummary($model); ?>
        <?= $form->field($model, 'list_id')->dropDownList($lists, ['prompt' => '', 'class' => 'form-control select2']) ?>
		<?php /* if(empty($new_pages)){$new_pages = [];} 
		$fb_target_list = $new_pages */ ?>
		<?= $form->field($model, 'fb_page_id')->dropDownList($fb_target_list, ['prompt' => '', 'options' => $data_elements, 'class' => 'form-control'])->label('Facebook Page/Group') ?>
		<?=$form->field($model, 'internal_scheduler')->checkbox(); ?>
    </div>
    <div class="panel-footer text-left">
        <div class="form-group">
            <?= Html::submitButton('Schedule to Facebook', ['class' => 'btn btn-primary', 'name' => 'export-button', 'id' => 'submit_button']) ?>
        </div>
    </div>
<?= $form->field($model, 'fb_page_name', ['options'=>['class' => 'hidden']] )->label(false)->hiddenInput( ); ?>
<?= $form->field($model, 'fb_target_type', ['options'=>['class' => 'hidden']] )->label(false)->hiddenInput( ); ?>
<?php ActiveForm::end(); ?>
</div>