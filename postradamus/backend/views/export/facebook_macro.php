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
$this->title = 'Facebook Macro Export';
$this->params['breadcrumbs'][] = 'Export';
$this->params['breadcrumbs'][] = $this->title;

$this->params['help']['message'] = 'This option is recommended for advanced users only. This will allow you to schedule your list to Facebook via the usage of a Macro.';

$pages = $fh->get_user_pages();
foreach($pages as $page)
{
    $new_pages[$page->id] = $page->name;
    $data_elements[$page->id] = ['data-image_url' => ($page->cover->source ? $page->cover->source : 'http://placehold.it/25x25')];
}
//array_multisort(array_map('strtolower', $new_pages), $new_pages);

$this->registerJs('
function format(page) {
    el = $(page.element);
    if (!el.data("image_url")) return page.text; // optgroup
    return \'<img class=\"select-image\" src=\"\' + el.data("image_url") + \'" />\' + page.text;
}
$("#facebookmacroexportform-fb_page_id").select2({
    formatResult: format,
    placeholder: "(Choose one)",
    formatSelection: format,
    escapeMarkup: function(m) { return m; }
});
')

?>
<?php $form = ActiveForm::begin(['id' => 'export-form', 'enableClientValidation' => false]); ?>

            <?php echo $form->errorSummary($model); ?>
            <?= $form->field($model, 'list_id')->dropDownList($lists, ['prompt' => '', 'class' => 'form-control select2']) ?>
            <?= $form->field($model, 'fb_page_id')->dropDownList($new_pages, ['prompt' => '', 'options' => $data_elements, 'class' => 'form-control']) ?>
        </div>
        <div class="panel-footer text-left">
            <div class="form-group">
                <?= Html::submitButton('Next Step', ['class' => 'btn btn-primary', 'name' => 'export-button']) ?>
            </div>
        </div>
</div>
<?php ActiveForm::end(); ?>

<?php if($macro_text != '') { ?>
    <div class="panel panel-success">
        <div class="panel-heading">
            <span class="panel-title">Step 1</span>
        </div>

        <div class="panel-body">
            <p>Using this export method requires <a href="http://www.getfirefox.com" target="_blank">Firefox</a> and <a href="https://addons.mozilla.org/en-US/firefox/addon/imacros-for-firefox/" target="_blank">iMacros for Firefox</a>. If you already have these, skip to step 2.</p>
            <p>If not, please download and install those now. If you need help installing iMacros for Firefox, check out this <a href="https://www.youtube.com/watch?v=zMb4j9eLCS4&index=5&list=PLGZu5E9ifiNew9wO2lCst68V3Wi8wAkAp" target="_blank">video</a>.</p>
        </div>
    </div>


    <div class="panel panel-success">
        <div class="panel-heading">
            <span class="panel-title">Step 2</span>
        </div>

        <div class="panel-body">
            <p>Did you setup your <b>iMacros Downloads path setting</b> in Postradamus?</p>
            <p>If you did, skip this step. If not, <a href="<?php echo Yii::$app->urlManager->createUrl('setting/update'); ?>">please do so now</a>.</p>
        </div>
    </div>

    <div class="panel panel-success">
        <div class="panel-heading">
            <span class="panel-title">Step 3</span>
        </div>

        <div class="panel-body">
            <p>There's a new way to run your macros! This is now the preferred way.</p>
            <ol>
            <li>Download the following <a href="http://1s0s.com/app/Postradamus.php">file</a>.</li>
            <li>Move it to your C:\Users\YOURNAME\Documents\iMacros\Macros\ folder (or /Users/YOURNAME/iMacros/Macros/ if you are using a Mac).</li>
            <li>Open Firefox, you should now see a "Postradamus.js" macro in your iMacros panel. Click on it and press the Play button.</li>
            <li>If nothing happens, please watch this <a href="https://www.youtube.com/watch?v=MZosiUi-8eM" target="_blank">video</a>.</li>
            </ol>
            <p>Need help? There's <a href="http://youtu.be/LU1ULv6t4xw" target="_blank">a video for this step too</a>!</p>
            <p><b>New way not working for you? Here's the old way.</b></p>
            <p>Copy the below text into your #Current.iim file inside imacros. Then press play.</p>
            <p><?= Html::textarea('macro_text', $macro_text, ['class' => 'form-control', 'rows' => 7]) ?></p>
        </div>
    </div>
<?php } ?>