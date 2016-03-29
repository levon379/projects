<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\cListPost $model
 */

$this->title = 'New Post';
if( isset($model->list) && !empty($model->list) ){
	$listName = $model->list->name ;	
}
else{
	$listName = 'List' ;	
}
$this->params['breadcrumbs'][] = ['label' => $listName , 'url' => ['list/view', 'id' => $model->list_id ]];
$this->params['breadcrumbs'][] = $this->title;
?>


        <div class="c-list-post-create">

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>

        </div>
    </div>

</div>