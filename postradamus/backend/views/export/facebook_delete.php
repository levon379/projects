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
$this->title = 'Facebook Export Delete';
$this->params['breadcrumbs'][] = 'Export';
$this->params['breadcrumbs'][] = $this->title;

$this->params['help']['message'] = 'This will delete ALL posts in your scheduler at Facebook for the chosen page.';

$this->registerJs('
$("#export-form").submit(function(e) {
   $("#submit_button").attr("disabled", "disabled").html("Please wait...");
   return true;
});
function format(page) {
    el = $(page.element);
    if (!el.data("image_url")) return page.text; // optgroup
    return \'<img class=\"select-image\" src=\"\' + el.data("image_url") + \'" />\' + page.text;
}

$("#facebookexportdeleteform-fb_page_id").select2({
    formatResult: format,
    formatSelection: format,
    placeholder: "(Choose one)",
    escapeMarkup: function(m) { return m; }
});

');

$pages = $fh->get_user_pages();
foreach($pages as $page)
{
    $new_pages[$page->id] = $page->name;
    $data_elements[$page->id] = ['data-image_url' => ($page->cover->source ? $page->cover->source : 'http://placehold.it/25x25')];
}
//array_multisort(array_map('strtolower', $new_pages), $new_pages);

?>
<?php $form = ActiveForm::begin(['id' => 'export-form']); ?>
<?php echo $form->errorSummary($model); ?>
<?= $form->field($model, 'fb_page_id')->dropDownList($new_pages, ['prompt' => '', 'options' => $data_elements, 'class' => 'form-control']) ?>
</div>
<div class="panel-footer text-left">
    <div class="form-group">
        <?= Html::submitButton('Delete From Facebook Scheduler', ['class' => 'btn btn-primary', 'name' => 'export-button', 'id' => 'submit_button']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
</div>