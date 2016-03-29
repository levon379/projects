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
$this->title = 'CSV';
$this->params['breadcrumbs'][] = 'Export';
$this->params['breadcrumbs'][] = $this->title;

$this->params['help']['message'] = 'Export your list as a CSV file so you can use it with various other tools.';

$this->registerCss('.fw-normal{font-weight:normal;}');
?>
<?php $form = ActiveForm::begin(['id' => 'export-form' , 'enableClientValidation' => false ]); ?>

        <?php echo $form->errorSummary($model); ?>
        <?= $form->field($model, 'list_id')->dropDownList($lists, ['prompt' => '-- Choose One --']) ?>
		
		<div class="form-group">
			<?=Html::checkbox('include_images',false , ['id'=>'include_images'] )?> <label for="include_images" class="fw-normal">Include Images</label>
		</div>
		
    </div>
    <div class="panel-footer text-left">
        <div class="form-group">
            <?= Html::submitButton('Export', ['class' => 'btn btn-primary', 'name' => 'export-button']) ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>