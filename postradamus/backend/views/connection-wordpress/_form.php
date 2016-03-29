<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\models\cConnectionFacebook $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="c-connection-wordpress-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => 255, 'autocomplete' => 'off']) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => 255, 'autocomplete' => 'off']) ?>

    <?= $form->field($model, 'xml_rpc_url')->textInput(['maxlength' => 255, 'autocomplete' => 'off'])->hint('<b>Examples</b>: http://YourUserName.wordpress.com/, http://YourUserName.blog.com/, http://www.MyOwnBlog.com/ or http://www.MyOwnSite.com/blog/') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
