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
$this->title = 'Pinterest Direct Export';
$this->params['breadcrumbs'][] = 'Export';
$this->params['breadcrumbs'][] = $this->title;

$this->params['help']['message'] = "Send posts in a list to your Pinterest board.";
$this->params['help']['modal_body'] = '<iframe id="youtube-video" width="853" height="480" src="//www.youtube.com/embed/wqjTP-pECI4" frameborder="0" allowfullscreen></iframe>';

$this->registerJs('
$("#export-form").submit(function(e) {
   $("#submit_button").attr("disabled", "disabled").html("Please wait. Sending to Pinterest...");
   return true;
});
function format(page) {
    el = $(page.element);
    if (!el.data("image_url")) return page.text; // optgroup
    return \'<img class=\"select-image\" src=\"\' + el.data("image_url") + \'" />\' + page.text;
}

$("#pinterestdirectexportform-board_id").select2({
    formatResult: format,
    formatSelection: format,
    placeholder: "(Choose one)",
    escapeMarkup: function(m) { return m; }
});

$("#pinterestexportform-board_id").on("change", function(e) {
    $("#pinterestexportform-board_name").val($(this).find(":selected").text());
});
');

?>
<?php if(Yii::$app->user->identity->getPinterestConnection('username', Yii::$app->session->get('campaign_id'))) { ?>
<?php $form = ActiveForm::begin(['id' => 'export-form' , 'enableClientValidation' => false ]); ?>
<?php echo $form->errorSummary($model); ?>
<?= $form->field($model, 'list_id')->dropDownList($lists, ['prompt' => '', 'class' => 'form-control select2']) ?>
<?= $form->field($model, 'board_id')->dropDownList($pinterest->getBoards(), ['prompt' => '', 'class' => 'form-control select2']) ?>
</div>
<div class="panel-footer text-left">
    <div class="form-group">
        <?= Html::submitButton('Schedule to Pinterest', ['class' => 'btn btn-primary', 'name' => 'export-button', 'id' => 'submit_button']) ?>
    </div>
</div>
<?= $form->field($model, 'board_name', ['options'=>['class' => 'hidden']] )->label(false)->hiddenInput(); ?>
<?php ActiveForm::end(); ?>
</div>
<?php } else {
    $this->params['error']['message'] = 'In order to use this feature you must first create a <a href="'.Yii::$app->urlManager->createUrl('connection-pinterest/update').'">Pinterest connection</a>.';
} ?>