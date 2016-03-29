<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\cListPost $model
 */

$this->title = 'Update Post: ' . ' ' . $model->name;
if( isset($model->list) && !empty($model->list) ){
	$listName = $model->list->name ;	
}
else{
	$listName = 'List' ;	
}
$this->params['breadcrumbs'][] = ['label' => $listName , 'url' => ['list/view', 'id' => $model->list_id ]];
//todo below
//$this->params['breadcrumbs'][] = ['label' => 'Test Stest 2', 'url' => ['list/view', 'id' => 2]];
//$this->params['breadcrumbs'][] = ['label' => $model->name];
$this->params['breadcrumbs'][] = 'Update '.$model->name ;

?>

        <div class="c-list-post-update">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>