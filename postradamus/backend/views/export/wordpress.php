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
$this->title = 'Wordpress Export';
$this->params['breadcrumbs'][] = 'Export';
$this->params['breadcrumbs'][] = $this->title;

$this->params['help']['message'] = "Send posts in a list to your Wordpress blog.";
$this->params['help']['modal_body'] = '<iframe id="youtube-video" width="853" height="480" src="//www.youtube.com/embed/wqjTP-pECI4" frameborder="0" allowfullscreen></iframe>';

$this->registerJs('
$("#export-form").submit(function(e) {
   $("#submit_button").attr("disabled", "disabled").html("Please wait. Sending to Wordpress...");
   return true;
});
');

?>
<?php if(Yii::$app->user->identity->getWordpressConnection('username', Yii::$app->session->get('campaign_id'))) { ?>
    <?php $form = ActiveForm::begin(['id' => 'export-form' , 'enableClientValidation' => false ]); ?>
    <?php echo $form->errorSummary($model); ?>
    <?= $form->field($model, 'list_id')->dropDownList($lists, ['prompt' => '', 'class' => 'form-control select2']) ?>

    <div class="form-group field-wordpressexportform-list_id required">
        <label class="control-label" for="s2id_autogen1">Blog</label>
        <div><a href="<?=Yii::$app->user->identity->getWordpressConnection('xml_rpc_url', Yii::$app->session->get('campaign_id'))?>" target="blank"><?=Yii::$app->user->identity->getWordpressConnection('xml_rpc_url', Yii::$app->session->get('campaign_id'))?></a></div>
    </div>

    <?php

    $export = new \backend\components\exporters\Wordpress;

    $wordpress = new \backend\components\WordpressHelper(Yii::$app->user->identity->getWordpressConnection('username', Yii::$app->session->get('campaign_id')), Yii::$app->user->identity->getWordpressConnection('password', Yii::$app->session->get('campaign_id')), Yii::$app->user->identity->getWordpressConnection('xml_rpc_url', Yii::$app->session->get('campaign_id')) . 'xmlrpc.php');
    $categories_list = $wordpress->getCategories();

    ?>
    <?php echo $form->field($model, 'category_id')->dropDownList($categories_list, ['prompt' => 'Uncategorized', 'class' => 'form-control select2']) ?>

    </div>
    <div class="panel-footer text-left">
        <div class="form-group">
            <?= Html::submitButton('Schedule to Wordpress', ['class' => 'btn btn-primary', 'name' => 'export-button', 'id' => 'submit_button']) ?>
        </div>
    </div>
    <?= $form->field($model, 'blog_name', ['options'=>['class' => 'hidden']] )->label(false)->hiddenInput(['value' => Yii::$app->user->identity->getWordpressConnection('xml_rpc_url', Yii::$app->session->get('campaign_id'))]); ?>
    <?php ActiveForm::end(); ?>
    </div>
<?php } else {
    $this->params['error']['message'] = 'In order to use this feature you must first create a <a href="'.Yii::$app->urlManager->createUrl('connection-pinterest/update').'">Wordpress connection</a>.';
} ?>