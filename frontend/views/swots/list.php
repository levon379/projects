<?php
use kartik\popover\PopoverX;
use kartik\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\icons\Icon;
use rmrevin\yii\fontawesome\FA;
use yii\widgets\Pjax;

$model = new \frontend\models\Swots();
Icon::map($this);
?>
<div class="list-group-item list-group-item-heading list-group-item-info">

    <div class="pull-left" style="margin-right: 10px;">
        <?php
        $form = ActiveForm::begin(['id' => $type.'-form',
        'action' => '/swots/swot?id=0&categoryId='.$category.'&type='.$type,
        'enableAjaxValidation' => true,
        'validationUrl' => '/swots/validate',
        'method'=>'post','fieldConfig' => ['showLabels' => false], 
        'options' => []]);
        
        PopoverX::begin([
            'size' => PopoverX::SIZE_LARGE,
            'placement' => PopoverX::ALIGN_RIGHT,
            'type' => PopoverX::TYPE_PRIMARY,
            'footer' => Html::button('View', ['class'=>'btn btn-primary']),
            'toggleButton' => ['label'=> FA::icon('plus-circle').'', 'class'=>'btn btn-xs btn-default'],
            'header' => '<i class="fa fa-plus-square-o"></i> Add a '.$type,
            'footer'=>Html::submitButton('Add', ['class'=>'btn btn-xs btn-primary']) .
                Html::button('I\'m done adding', ['class'=>'btn btn-xs btn-default','data-dismiss' => 'popover-x'])
        ]);

        echo $form->field($model, 'name')->input('text',['placeholder' => 'Give this '.$type.' a short yet descriptive name.']);
        echo $form->field($model, 'description')->textArea(['rows' => '4','placeholder' => 'Give this '.$type.' a short yet descriptive summary...']);

        PopoverX::end();
        ActiveForm::end();
        ?>
    </div>

    <a href="/swots/<?=$category?>/<?=$heading?>" style="font-size: 17px; color: darkslategray;"><?=$heading?></a> (<?=count($swot_items)?>)
    <div class="pull-right" style="pointer:hand;"
        data-toggle="tooltip" data-placement="top"
        data-original-title="<?= $this->render('help/_'.$heading) ?>">
        <i class="fa fa-question-circle"> </i>
    </div>

    <div class="clearfix"></div>

    <div id="<?=$heading?>_help" class="alert alert-info" style="display: none;">
        <small>
            <?= $this->render('help/_'.$heading) ?>
        </small>
    </div>

</div>

<?php Pjax::begin(['id'=> $type.'-list-contents' ]); ?>
    <div>
        <?= $this->render('list-contents',['swot_items' => $swot_items,'category' => $category,'type' => $type]) ?>
    </div>
<?php Pjax::end(); ?>

<div class="clearfix"></div>
<br/>

<?php

$script = <<< JS

    $('body').on('beforeSubmit', '#{$type}-form', function(e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var form = $(this);
        if (form.find('.has-error').length) 
        {
            return false;
        }
        $.ajax({
            url    : form.attr('action'),
            type   : 'post',
            data   : form.serialize(),
            success: function (response) 
            {
                $.pjax.reload({container:'#{$type}-list-contents'}); 
                sortableList('{$type}');
            },
            error  : function () 
            {
            }
        });
    
        return false;
    
    });
                
   $(document).on('ready pjax:success', function(){
        $('[data-toggle="popover-x"]').popover();
        /*$("#<?=$heading?>_help").fadeToggle("fast", "linear");*/
   });

JS;

$this->registerJs($script);

?>
