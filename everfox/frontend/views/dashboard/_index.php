<?php
/* @var $this yii\web\View */
?>
<?php

/* @var $this yii\web\View */

use yii\widgets\Pjax;
use kartik\editable\Editable;
use kartik\helpers\Html;
use kartik\helpers\Enum;
use kartik\icons\Icon;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use \common\models\PermissionHelpers;
use yii\web\NotFoundHttpException;
use rmrevin\yii\fontawesome\FA;
use dosamigos\selectize\SelectizeTextInput;

// Initialize framework as per <code>icon-framework</code> param in Yii config
Icon::map($this);


//$this->title = 'Dashboard';
$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => ['dashboard/index']];

?>
<div class="row">

    <?php
    Modal::begin([
        'headerOptions' => ['id' => 'modalHeader'],
        'id'    => 'category-modal',
        'size'  => 'modal-xs',
        //'clientOptions' => ['backdrop' => 'static', 'keyboard' => TRUE]
    ]);

    echo "<div id='modalContent'></div>";

    Modal::end();
    ?>

    <div class="col-md-12">

        <div style="margin-left:15px;">
            <?= Html::a(Html::icon('plus',['style' => 'cursor: pointer;']) .' New Category', ['category', 'id' => -1], [
                'class' => 'btn btn-sm btn-success',
                'data' => [
                ],
            ]) ?>
            <span class="pull-right" style="margin-right:25px;">
                <?=FA::icon('question',['style' => 'cursor:pointer;'])->size(FA::SIZE_2X);;?>
            </span>
        </div>

        <div class="clearfix">

        </div>
        <?php foreach($categories as $category):?>

        <div class="col-md-3">
            <div class="project project-primary">
                <!--
                <div class="shape">
                    <div class="shape-text">
                    </div>
                </div>-->

                <div class="project-content">
                    <span class="lead">
                    </span>
                    <br />
                    <ul class="list-group">
                        <li class="list-group-item list-group-item-heading">
                            <strong>
                                <a href="<?= \yii\helpers\Url::to(['swots/index/','id' => $category->id])?>"> <?= $category->name ?> </a>
                            </strong>
                        </li>
                        <li class="no-borders list-group-item">
                            Strengths<span class="badge">0</span>
                        </li>
                      <li class="no-borders list-group-item">
                            Weaknesses <span class="badge">0</span>
                        </li>
                        <li class="no-borders list-group-item">
                            Opportunities <span class="badge">0</span>
                        </li>
                        <li class="no-borders list-group-item">
                            Threats <span class="badge">0</span>
                        </li>
                        <li class="no-borders list-group-item">
                            <i class="fa fa-group"></i> People <span class="badge">0</span>
                        </li>

                    </ul>

                    <div class="list-group-item" style="">

                        <div class="pull-right">
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
                        <div class="clearfix">
                        </div>
                    </div>

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
