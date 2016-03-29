<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\cListSent */

$this->title = ucwords($model->target_name);
$this->params['breadcrumbs'][] = ['label' => 'C List Sents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="c-list-sent-view">

    <p>
        <?= Html::a('Cancel Send', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to cancel this send?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [                    // the owner name of the model
                'label' => 'Target',
                'value' => ucwords($model->target_name) . ' (' . $model->main_meta . ')',
            ],
            [
                'label' => 'List',
                'format' => 'html',
                'value' => Html::a($model->list->name, ['list/view', 'id' => $model->list_id])
            ],/*
            'started',
            'ended',*/
        ],
    ]) ?>

    <?php \common\models\cList::findCronSending()->all(); ?>
</div>

    </div>
    </div>

    <div class="panel">
        <div class="panel-heading">
            <span class="panel-title">Posts Sent</span>
        </div>

        <div class="panel-body">

            <div class="tab-content" style="margin-top:10px">



                <?php
                $dataProvider = new \yii\data\ActiveDataProvider([
                    'query' => \common\models\cListSentPost::find()->where(['list_sent_id' => $model->id]),
                    'pagination' => [
                        'pageSize' => 20,
                    ],
                    'sort' => [
                        'class' => 'common\components\cSort',
                        'defaultOrder' => [
                            'id' => SORT_DESC,
                        ],
                    ],
                ]);

                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    //'filterModel' => $searchModel,
                    'layout' => "{items}\n{pager}",
                    'columns' => [
                        [
                            'attribute' => 'list_post_id',
                            'label' => 'Post',
                            'format' => 'raw',
                            'value' => function ($data) {
                                return Html::a($data->list_post_id, ['post/update', 'id' => $data->list_post_id]);
                            }
                        ],
                        [
                            'attribute' => 'success',
                            'value' => function ($data) {
                                return ($data->success == 0 ? 'Failed' : 'Success');
                            }
                        ],
                        [
                            'attribute' => 'post_id',
                            'format' => 'raw',
                            'label' => 'Generated Post',
                            'value' => function ($data) {
                                return ($data->post_id != '' ? Html::a($data->post_id, $data->post_url, ['target' => 'blank']) : '');
                            }
                        ],
                        'error',
                        'sent:datetime'
                    ],
                ]);
                ?>


                </div>
            </div>


        </div></div>