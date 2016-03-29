<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\cCampaign;

/**
 * @var yii\web\View $this
 * @var common\models\cList $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="c-list-form">

    <?php $form = ActiveForm::begin(['action' => Yii::$app->urlManager->createUrl(['list/rename', 'id' => $model->id])]); ?>

    <?php echo $form->errorSummary($model); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
