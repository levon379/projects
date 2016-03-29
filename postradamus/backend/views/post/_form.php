<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use common\models\cPostType;

/**
 * @var yii\web\View $this
 * @var common\models\cListPost $model
 * @var yii\widgets\ActiveForm $form
 */



?>

<div class="c-list-post-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data','id'=>'post_form_update']]); ?>

    <?php echo $form->errorSummary($model); ?>

    <?php /* ?>
    <?= $form->field($model, 'fb_post_type')->inline()->radioList(['0' => 'Status', '1' => 'Photo', '2' => 'Link']) ?>
    <?php */ ?>

    <?php
    use kartik\datecontrol\DateControl;
    $settings['type'] = DateControl::FORMAT_DATETIME;
    // Use a DateTimePicker input with ActiveForm and model validation enabled.
    echo $form->field($model, 'scheduled_time')->widget(DateControl::classname(), [
        'type'=>DateControl::FORMAT_DATETIME,
        'ajaxConversion' => true,
        'displayFormat' => 'php:' . Yii::$app->postradamus->get_user_date_time_format(),
        'saveFormat' => 'php:U',
        'displayTimezone' => 'America/Los_Angeles',
    ]);
    ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255, 'placeholder' => '(Optional - You can use this field for internal notes purposes)']) ?>

    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'link')->textInput(['maxlength' => 255, 'placeholder' => '(Optional - If you fill in this field, this post will be submitted as a LINK to Facebook)']) ?>

    <?php
    $image_filename0 = ($model->image_filename0 != '' ? $model->image_url : 'http://placehold.it/250x250&text=No+Image');
    $image_filename1 = ($model->image_filename1 != '' ? Yii::$app->params['imageUrl'] . 'posts/' . $model->user_id . '/' . $model->list_id . '/' . $model->image_filename1 : '');
    $image_filename2 = ($model->image_filename2 != '' ? Yii::$app->params['imageUrl'] . 'posts/' . $model->user_id . '/' . $model->list_id . '/' . $model->image_filename2 : '');
    $image_filename3 = ($model->image_filename3 != '' ? Yii::$app->params['imageUrl'] . 'posts/' . $model->user_id . '/' . $model->list_id . '/' . $model->image_filename3 : '');

    $preview[0] = "<a href=\"$image_filename0\" target=\"_blank\"><img src=\"" . $image_filename0 . "\" class='file-preview-image' alt='" . $model->name . "' title='" . $model->name . "'></a>";

    if($image_filename1 != '')
    {
        $preview[1] = "<a href=\"$image_filename1\" target=\"_blank\"><img src=\"" . $image_filename1 . "\" class='file-preview-image' alt='" . $model->name . "' title='" . $model->name . "'></a>";
    }
    if($image_filename2 != '')
    {
        $preview[2] = "<a href=\"$image_filename2\" target=\"_blank\"><img src=\"" . $image_filename2 . "\" class='file-preview-image' alt='" . $model->name . "' title='" . $model->name . "'></a>";
    }
    if($image_filename3 != '')
    {
        $preview[3] = "<a href=\"$image_filename3\" target=\"_blank\"><img src=\"" . $image_filename3 . "\" class='file-preview-image' alt='" . $model->name . "' title='" . $model->name . "'></a>";
    }


        use kartik\widgets\FileInput;
        echo $form->field($model, 'image[]')->widget(FileInput::classname(), [
            'options' => [
                'multiple' => true,
            ],
            'pluginOptions' => [
                'previewFileType' => 'any',
                'showUpload' => false,
                'showRemove' => true,
                'showCaption' => false,
                'browseClass' => "btn btn-primary",
                'mainTemplate' => '{preview} {browse} {remove}',
                'maxFileCount' => 4,
                'initialPreview' => $preview,
            ]
        ]);
    ?>

    <?php
    $categories_list = array();
//    $export = new \backend\components\exporters\Wordpress;
//
//    $wordpress = new \backend\components\WordpressHelper(Yii::$app->user->identity->getWordpressConnection('username', Yii::$app->session->get('campaign_id')), Yii::$app->user->identity->getWordpressConnection('password', Yii::$app->session->get('campaign_id')), Yii::$app->user->identity->getWordpressConnection('xml_rpc_url', Yii::$app->session->get('campaign_id')) . 'xmlrpc.php');
//    $categories_list = $wordpress->getCategories();

    ?>
    <?php if($wordpress || !empty($wordpress)):?>
        <label for="wordpress_category">
            <select id="wordpress_category">
                <?php foreach($categories_list as $key=>$value):?>
                    <option value="<?=$key?>"><?=$value?></option>
                <?php endforeach;?>
            </select>
        </label>
    <?php endif; ?>

    <?= $form->field($model, 'post_type_id')->dropDownList(ArrayHelper::map(cPostType::find()->all(), 'id', 'name'), ['prompt' => '-- Choose One (Optional) --']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
<?php
$this->registerJs("

        $('form#post_form_update').find('div.file-input button.fileinput-remove').click(function(e){
            $.ajax({
                    url: '" . Yii::$app->urlManager->createUrl('post/remove-image') . "',
                    type: 'POST',
                    data: {
                        id : '".$model->id."',
                    },
                    success: function(data, textStatus) {

                    }
            });
        })

        $('#wordpress_category').change(function(){

        });
");
?>
</div>