<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\cSchedule $model
 */

$this->title = 'New Schedule';
$this->params['breadcrumbs'][] = 'Settings';
$this->params['breadcrumbs'][] = ['label' => 'Schedules', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="c-schedule-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
        </div>
    </div>