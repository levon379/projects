<?php
use kartik\popover\PopoverX;
use kartik\helpers\Html;
use kartik\widgets\ActiveForm;
use rmrevin\yii\fontawesome\FA;
use yii\bootstrap\Dropdown;
use kartik\widgets\Growl; // this widget had installed.
use kartik\growl\GrowlAsset;
GrowlAsset::register($this); //Register widget css, js etc..
?>
<?php
/* JS code for ajax send to the Swots controller */
$template = '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' .
		'<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' .
		'<span data-notify="icon"></span> ' .
		'<span data-notify="title"><h4>{1}</h4></span> <br>' .
		'<span data-notify="message">{2}</span>' .
	'</div>' ;
$this->registerJs("
        $('#" . $item->id . "_submit').click(function(e){
            e.preventDefault();
            var url  = '/swots/store-swots';
            var json_data = {
                'id'            : '" . $item->id . "',
                'categoryId'    : '" . $category . "',
                'type'          : '" . $type . "',
                'name'          : $('#" . $type . "_" . $item->id . "_form').find('input#swots-name').val(),
                'description'   : $('#" . $type . "_" . $item->id . "_form').find('textarea#swots-description').val(),
            }
            $.post(url, json_data, function(data) {
                if(data.success){
                    $('#popover-cancel-" . $item->id . "').click();
                    $('#" . $item->type . "-list-contents').find('#swots_content_" . $item->id . ">div').html(data.view);
                      
                        var notify = $.notify({
                            icon: 'glyphicon glyphicon-ok-sign',
                            title: 'Note',
                            message: 'Your Swot item updated successfuly!',
                        },{
                            // settings
                            element: 'body',
                            position: null,
                            type: 'success',
                            allow_dismiss: true,
                            newest_on_top: true,
                            showProgressbar: true,
                            placement: {
                                    from: 'top',
                                    align: 'center'
                            },
                            offset: 89,
                            spacing: 10,
                            z_index: 1031,
                            delay: 5000,
                            timer: 1000,
                            mouse_over: null,
                            animate: {
                                    enter: 'animated fadeInDown',
                                    exit: 'animated fadeOutUp'
                            },
                            onShow: null,
                            onShown: null,
                            onClose: null,
                            onClosed: null,
                            icon_type: 'class',
                            template: '".$template."'
                        });
                }else{
                    $('#popover-cancel-" . $item->id . "').click();
                    $('#" . $item->type . "-list-contents').find('#swots_content_" . $item->id . ">div').html();
                }
            });
                
        });
        
    ");
?>

<div id="_toolbar_swot_item_<?= $item->id ?>"
     style="display: compact; margin-right: -10px; margin-top: -2px; font-size: 8px;"
     class="pull-right">

    <div class="pull-left">
        <?php
        $form = ActiveForm::begin(['action' => '', 'method' => 'post', 'id' => $item->type . '_' . $item->id . '_form', 'fieldConfig' => ['showLabels' => false]]);
        PopoverX::begin([
            'size' => PopoverX::SIZE_LARGE,
            'placement' => PopoverX::ALIGN_LEFT,
            'type' => PopoverX::TYPE_PRIMARY,
            'footer' => Html::button('View', ['class' => 'btn btn-primary']),
            'toggleButton' => ['label' => FA::icon('pencil-square-o') . '', 'class' => 'btn btn-xs btn-default'],
            'header' => '<i class="fa fa-edit"></i> Edit ' . $type,
            'footer' => Html::submitButton('Submit', ['class' => 'btn btn-xs btn-primary', 'id' => $item->id . '_submit']) .
            Html::button('Cancel', ['class' => 'btn btn-xs btn-default', 'id' => 'popover-cancel-' . $item->id, 'data-dismiss' => 'popover-x'])
        ]);

        echo $form->field($item, 'name')->input('text', ['placeholder' => 'Give this ' . $type . ' a short yet descriptive name.']);
        echo $form->field($item, 'description')->textArea(['rows' => '4', 'placeholder' => 'Give this ' . $type . ' a short yet descriptive summary...']);

        PopoverX::end();
        ActiveForm::end();
        ?>

    </div>

    <div class="pull-right">

        <?php
        $form = ActiveForm::begin(['action' => '/swots/move?id=' . $item->id, 'method' => 'post', 'fieldConfig' => ['showLabels' => false]]);
        PopoverX::begin([
            'size' => PopoverX::SIZE_MEDIUM,
            'placement' => PopoverX::ALIGN_LEFT,
            'type' => PopoverX::TYPE_PRIMARY,
            'footer' => Html::button('View', ['class' => 'btn btn-primary']),
            'toggleButton' => ['label' => FA::icon('unsorted') . '', 'class' => 'btn btn-xs btn-default'],
            'header' => '<i class="fa fa-send-o"></i> Move to... ',
            'footer' => Html::submitButton('Move', ['class' => 'btn btn-xs btn-primary', 'id' => 'move_' . $item->id]) .
            Html::button('Cancel', ['class' => 'btn btn-xs btn-default', 'data-dismiss' => 'popover-x'])
        ]);

        $items['Strength'] = ['Weakness' => 'Weaknesses', 'Opportunity' => 'Opportunities', 'Threat' => 'Threats'];
        $items['Weakness'] = ['Strength' => 'Strengths', 'Opportunity' => 'Opportunities', 'Threat' => 'Threats'];
        $items['Opportunity'] = ['Strength' => 'Strengths', 'Weakness' => 'Weaknesses', 'Threat' => 'Threats'];
        $items['Threat'] = ['Strength' => 'Strengths', 'Weakness' => 'Weaknesses', 'Opportunity' => 'Opportunites'];
        echo Html::dropDownList('swot_types', null, $items[$type], ['class' => 'form-control', 'prompt' => 'Move to...']);

        PopoverX::end();
        ActiveForm::end();
        ?>

    </div>

    <?=
    Html::a(FA::icon('trash-o', ['style' => 'cursor: pointer;']) . '', ['delete', 'id' => $item->id], [
        'class' => 'btn btn-xs btn-default',
        'data' => [
            'confirm' => Yii::t('app', 'Are you sure to delete this item?'),
            'method' => 'post',
        ],
    ])
    ?>

</div>

<div class="pull-left drag_handle" style="cursor: pointer;"><img src="/images/drag_icon.png" style="margin-left: -20px;"></div>
