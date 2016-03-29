<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\cUserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="c-user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p style="display:none">
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php
        $searchModel->parent_id = 0;
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'parent_id',
            [
                'class' => \dosamigos\grid\EditableColumn::className(),
                'attribute' => 'status',
                'url' => ['editable'],
                'type' => 'text',
                'editableOptions' => [
                    'mode' => 'inline',
                ]
            ],
            //'email:email',
            // 'updated_at',
            'username',
            [
                'class' => \dosamigos\grid\EditableColumn::className(),
                'attribute' => 'first_name',
                'url' => ['editable'],
                'type' => 'text',
                'editableOptions' => [
                    'mode' => 'inline',
                ]
            ],
            [
                'class' => \dosamigos\grid\EditableColumn::className(),
                'attribute' => 'last_name',
                'url' => ['editable'],
                'type' => 'text',
                'editableOptions' => [
                    'mode' => 'inline',
                ]
            ],
            // 'role',
            [
                'class' => \dosamigos\grid\EditableColumn::className(),
                'attribute' => 'email',
                'url' => ['editable'],
                'type' => 'text',
                'editableOptions' => [
                    'mode' => 'inline',
                ]
            ],
            [
                'attribute' => 'created_at',
                'value' => function($data) {
                    return date('M d y h:i A', $data->created_at);
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
