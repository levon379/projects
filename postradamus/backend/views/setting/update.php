<?php
use yii\helpers\Html;
/**
 * @var yii\web\View $this
 * @var common\models\cSetting $model
 */

$this->title = 'Update Settings';
$this->params['breadcrumbs'][] = 'Settings';
$this->params['breadcrumbs'][] = 'General';

$this->params['help']['message'] = "Fine tune Postradamus through various settings on this page.";
$this->params['help']['modal_body'] = '';
?>

<div class="c-setting-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
	
	<div class="separator">&nbsp;</div>

</div>
</div>
    </div>