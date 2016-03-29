<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\cSchedule;
use common\models\cPostType;

/**
 * @var yii\web\View $this
 * @var common\models\cList $model
 * @var yii\widgets\ActiveForm $form
 */

$this->registerCss('
.tab-content {
padding: 0;
}
');

?>

<div class="c-list-form">

    <?php $form = ActiveForm::begin(['action' => Yii::$app->urlManager->createUrl(['list/change-post-type']), 'options' => ['class' => 'selection_form', 'id' => 'post-type-form']]); ?>

    <?php echo $form->errorSummary($model); ?>

    <?= $form->field($model, 'post_type_id')->dropDownList(ArrayHelper::map(cPostType::find()->all(), 'id', 'name'), ['prompt' => '-- No Post Type --']) ?>

    <?= Html::activeHiddenInput($model, 'list_id', ['value' => Yii::$app->request->get('id')]); ?>

    <div class="form-group">
        <?= Html::submitButton('Change Post Types', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>