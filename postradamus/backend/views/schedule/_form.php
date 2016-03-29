<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use common\models\cCampaign;

/**
 * @var yii\web\View $this
 * @var common\models\cSchedule $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="c-schedule-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

	<?php if(!$model->isNewRecord) { ?>
        <?= $form->field($model, 'campaign_id')->dropDownList(ArrayHelper::map(cCampaign::find()->all(), 'id', 'name'), ['class' => 'form-control', 'prompt' => 'Master Campaign']) ?>
    <?php } ?>
	<?php /*
	if(Yii::$app->session->get('campaign_id') != 0) { 
		echo $form->field($model, 'campaigns')->checkbox(['label' => 'Make available to all Campaigns']);
    }
	*/ ?>

	
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
