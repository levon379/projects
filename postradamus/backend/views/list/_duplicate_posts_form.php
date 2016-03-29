<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\cSchedule;

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

    <?php $form = ActiveForm::begin(['action' => Yii::$app->urlManager->createUrl(['list/duplicate-posts']), 'options' => ['class' => 'selection_form', 'id' => 'duplicate-form']]); ?>

    <?php echo $form->errorSummary($model); ?>

    <?= Html::activeHiddenInput($model, 'list_id', ['value' => Yii::$app->request->get('id')]); ?>

    <div class="form-group">
        <?= Html::submitButton('Duplicate Posts', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>