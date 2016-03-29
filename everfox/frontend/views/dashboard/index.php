<?php
/* @var $this yii\web\View */
?>
<?php

/* @var $this yii\web\View */

use kartik\helpers\Html;
use kartik\icons\Icon;
use rmrevin\yii\fontawesome\FA;
use common\models\SwotHelpers;

// Initialize framework as per <code>icon-framework</code> param in Yii config
Icon::map($this);

$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => ['dashboard/index']];

?>
<div class="row">

    <div class="col-md-12">

        <div class="pull-left" style="margin-right: 25px;">
            <h3>Focus Areas</h3>
        </div>

        <div style="margin-left:15px;margin-top: 20px;">
            <?= Html::a(Html::icon('plus',['style' => 'cursor: pointer;']) .' New Focus Area', ['category', 'id' => -1], [
                'class' => 'btn btn-sm btn-success',
                'data' => [
                ],
            ]) ?>
            <span class="pull-right" style="margin-right:25px;">
                <?=FA::icon('question',['style' => 'cursor:pointer;'])->size(FA::SIZE_2X);?>
            </span>
        </div>

        <div class="clearfix"></div>

        <hr />

        <?php foreach($categories as $category):?>

        <div class="col-md-3">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>
                        <a href="<?= \yii\helpers\Url::to(['swots/index/','id' => $category->id])?>"
                        data-toggle="tooltip"
                        data-placement="bottom"
                        data-original-title="<?=$category->name;?> - <?=$category->description;?>">
                        <?= \yii\helpers\StringHelper::truncate($category->name,25); ?>
                        </a>
                    </strong>
                </div>
                <div class="panel-body">

                    <div class="list-group">

                        <a href="/swots/<?=$category->id?>/Strengths" class="no-borders list-group-item">
                            Strengths<span class="badge"><?= SwotHelpers::countSwotTypeByCategory($category->id,'Strength') ?></span>
                        </a>
                        <a href="/swots/<?=$category->id?>/Weaknesses" class="no-borders list-group-item">
                            Weaknesses <span class="badge"><?= SwotHelpers::countSwotTypeByCategory($category->id,'Weakness') ?></span>
                        </a>
                        <a href="/swots/<?=$category->id?>/Opportunities" class="no-borders list-group-item">
                            Opportunities <span class="badge"><?= SwotHelpers::countSwotTypeByCategory($category->id,'Opportunity') ?></span>
                        </a>
                        <a href="/swots/<?=$category->id?>/Threats" class="no-borders list-group-item">
                            Threats <span class="badge"><?= SwotHelpers::countSwotTypeByCategory($category->id,'Threat') ?></span>
                        </a>
                        <a class="no-borders list-group-item">
                            <i class="fa fa-group"></i> People <span class="badge">0</span>
                        </a>

                    </div>
                </div>
                <div class="panel-footer">

                        <?= Html::a(Html::icon('edit',['style' => 'cursor: pointer;']) .'', ['category', 'id' => $category->id], [
                            'class' => '',
                            'data' => [
                            ],
                        ]) ?>

                        <?= Html::a(Html::icon('trash', ['style' => 'cursor: pointer;']) .'', ['delete', 'id' => $category->id], [
                            'class' => '',
                            'data' => [
                                'confirm' => Yii::t('app', 'Are you sure to delete this item?'),
                                'method' => 'post',
                            ],
                        ]) ?>

                        <?= Html::a(Html::icon('off', ['style' => 'cursor: pointer;']) .'', ['delete', 'id' => $category->id], [
                            'class' => '',
                            'data' => [
                                'confirm' => Yii::t('app', 'Are you sure to Stop working on this Category? It will be archived for later.'),
                                'method' => 'post',
                            ],
                        ]) ?>

                </div>

            </div>

        </div>

        <?php endforeach; ?>

    </div>

</div><!--/row-->

<div class="modal fade" id="categoryFormModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
    </div>
</div>

<script>
    $(document).ready(function(){
    });
</script>
