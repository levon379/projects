<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use common\models\cPostType;
use kartik\widgets\FileInput;

/**
 * @var yii\web\View $this
 * @var common\models\cListPost $model
 * @var yii\widgets\ActiveForm $form
 */



$this->title = 'Post Now';
$this->params['breadcrumbs'][] = $this->title;

$pages = $fh->get_user_pages();

$new_pages=[];
foreach($pages as $page)
{
    $new_pages[$page->id] = $page->name;
    $data_elements[$page->id] = ['data-image_url' => ($page->cover->source ? $page->cover->source : 'http://placehold.it/25x25')];
}


$groups = $fh->get_user_groups();
$groupsList=[];
foreach($groups as $group){
    $groupsList[$group->id] = $group->name;
    $data_elements[$group->id] = ['data-image_url' => ($group->cover->source ? $group->cover->source : 'http://placehold.it/25x25')];
}


$me = $fh->get_user_profile();
$fb_target_list=['My Feed' => [$me['id'] => $me['name']], 'Pages'=>$new_pages, 'Groups'=>$groupsList];


$wpCat = $wp_categories;


?>
<?php if($post_alert): ?>
<div class="alert alert-<?=$post_status ?>" ><?=$post_alert ?></div>
<?php endif ?>
<div class="c-list-post-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data','id'=>'post_now_form']]); ?>

    <div class="form-group field-clistpost-link">
        <label class="control-label" for="post_to">Where you want to post?
            <select name="post_to" class="form-control" id="post_to">
                <option value="" >Select Platform</option>
                <option value="facebook">Facebook</option>
                <option value="pinterest">Pinterest</option>
                <?php if($wpCat): ?><option value="wordpress">Wordpress</option><?php endif ?>
            </select>
            <p class="pos_error no_display" id="platform_alert" >Field is required </p>
        </label>

        <div class="no_display lists_block" id="fb_list_block" >
            <?= $form->field($model, 'fb_page_id')->dropDownList($fb_target_list, ['prompt' => 'Select List', 'options' => $data_elements, 'class' => 'form-control'])->label('Facebook Page/Group') ?>
            <input type="hidden" name="page_type" value="" id="page_type" />
            <p class="pos_error no_display" id="fb_list_alert" >Field is required </p>
        </div>
        <div class="no_display lists_block" id="wp_list_block" >
            <?= $form->field($model, 'wp_cat_id')->dropDownList($wpCat, ['prompt' => 'Select List', 'class' => 'form-control'])->label('Wordpress Categories') ?>
            <p class="pos_error no_display" id="wp_list_alert" >Field is required </p>
            <?= $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>
        </div>
        <div class="no_display lists_block" id="pin_boards_block" >
            <?= $form->field($model, 'board_id')->dropDownList($pinBoards, ['prompt' => 'Select List', 'class' => 'form-control'])->label('Pinterest Board') ?>
            <p class="pos_error no_display" id="pin_list_alert" >Field is required </p>
        </div>

    </div>

    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'link')->textInput(['maxlength' => 255, 'placeholder' => '(Optional - If you fill in this field, this post will be submitted as a LINK to Facebook)']) ?>


    <?php
    $post_image = $new_post_data->large_image;
    $preview[0] = "<a href=\"$post_image\" target=\"_blank\"><img src=\"" . $post_image . "\" class='file-preview-image' ></a>";
    ?>
    <input type="hidden" value="<?=$post_image ?>" name="image_url" />
    <?php
    echo $form->field($model, 'image')->widget(FileInput::classname(), [
        'options' => [
            'multiple' => true,
            'value' => 'aa'
        ],
        'pluginOptions' => [
            'previewFileType' => 'any',
            'showUpload' => false,
            'showRemove' => true,
            'showCaption' => false,
            'browseClass' => "btn btn-primary",
            'mainTemplate' => '{preview}',
            'maxFileCount' => 4,
            'initialPreview' => $preview,
        ]
    ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton('Send Now' ,['class' => 'btn btn-success', 'id' => 'btn_send' ]) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php
    Yii::$app->view->registerJsFile(Yii::getAlias('@web').'/js/custom/post.js', ['depends' => [
            'yii\web\YiiAsset',
            'yii\bootstrap\BootstrapAsset'],
        ]);
    ?>
</div>