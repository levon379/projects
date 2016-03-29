<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model frontend\models\Categories */
/* @var $form ActiveForm */
$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => ['dashboard/index']];
$this->params['breadcrumbs'][] = ['label' => 'Focus Area Editor'];
?>
<div class="dashboard-category">

  <div class="row">

      <div class="col-md-8">
        <?php $form = ActiveForm::begin([
            'options' => [
                'id' => 'category-form'
            ]
        ]);
        ?>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h2 class="panel-title">
                <? if($model->isNewRecord): ?>
                Add a new Focus Area
                <? else: ?>
                    Edit Focus Area Details
                <? endif; ?>
            </h2>
          </div>
          <div class="panel-body">
              <p class="help-block"><small>Focus Area names can be "Study, Work, or perhaps a project or any area that could be improved or requires focused attention."</small></p>
            <?= $form->field($model, 'name') ?>
            <p class="help-block"><small>Add some details: My study skills could be improved so therefore this category. 
            - OR - Funds are getting low, need to focus on money.</small></p>
            <?= $form->field($model, 'description')->textArea(['rows' => '2']); ?>

            <div class="form-group-options">

            <p class="help-block"><small>These are the people you will collaborate with in these Focus Areas .e.g 
                They might assist in activities that impede threats or mitigate strenghts etc</small></p>
              <label class="control-label" for="categories-description">People to Invite </label>
                <div class="input-group input-group-option col-xs-12">
                    <input type="text" name="people[]" class="form-control" placeholder="Email Address">
                    <span class="input-group-addon input-group-addon-remove">
                        <span class="glyphicon glyphicon-remove"></span>
                    </span>
                </div>
            </div>

          </div>

          <div class="panel-footer">
            <?= Html::submitButton('Go for it!', ['class' => 'btn btn-md btn-primary']) ?>
            <?= Html::a('Cancel',['dashboard/index'], ['class' => 'btn btn-md btn-primary']) ?>
          </div>

        </div>

        <?php ActiveForm::end(); ?>

      </div>

      <div class="col-md-4">
        <div class="alert alert-info">
            What are focus areas and why...
        </div>
      </div>

  </div>

</div><!-- dashboard-category -->
