<?php if($modal == true) { ?>
<script src="js/image-editing.js" type="script/javascript"></script>
<script>
$(function() {
<?php } else { ?>
<?php $this->registerJsFile('js/image-editing.js');
$lockMovement = 'lockMovement(canvas);';
?>
<?php } ?>
    <?php
        echo $fabric_image_js;
    ?>

<?php $js = <<<EOF

    $('#bring_to_front_button').on('click', function () {
        var obj = canvas.getActiveObject();
        obj.bringForward();
    });

    $('#add_text').on('click', function () {
        text = addText(2, 2, 'My Text', 'tahoma', '#fff', 55, 1, canvas);
        $lockMovement
    });

    $('#add_image').on('click', function () {
        $('#images').show();
    });

    $('.image_overlay').on('click', function () {
        obj = addImage(2, 2, $(this).attr('src'), 1, canvas);
        moveObject(obj, 2, 2, canvas);
        $lockMovement
        $('#images').hide();
    });

    $('#delete').on('click', function () {
        var obj = canvas.getActiveObject();
        obj.remove();
    });

    $('#move').on('change', function () {
        var obj = canvas.getActiveObject();
        xy = $(this).val().split(',');
        moveObject(obj, xy[0], xy[1], canvas);
    });

    $('#bold').on('click', function() {
        $(this).toggleClass('active');
        var obj = canvas.getActiveObject();
        if($(this).hasClass('active'))
        {
            obj.fontWeight = 'bold';
        }
        else
        {
            obj.fontWeight = 'normal';
        }
        canvas.renderAll();
    });

    $('#italic').on('click', function() {
        $(this).toggleClass('active');
        var obj = canvas.getActiveObject();
        if($(this).hasClass('active'))
        {
            obj.fontStyle = 'italic';
        }
        else
        {
            obj.fontStyle = 'normal';
        }
        canvas.renderAll();
    });

    $('#family').on('change', function() {
        var obj = canvas.getActiveObject();
        obj.fontFamily = $(this).val();
        canvas.renderAll();
    });

    $('#meme').on('click', function () {
        addMeme(canvas);
    });

    $('#save').on('click', function(){
		$(this).attr('disabled',true);
        saveImage($id, '$save_url', '$redirect_url', '', canvas);
    });

    /* This changes the opacity of an object based on slider position */
    $( "#slider" ).slider({
        value: 100,
        min: 0,
        max: 100,
        slide: function( event, ui ) {
            if(canvas.getActiveGroup()) {
                canvas.getActiveGroup().forEachObject(function(o){
                    o.opacity = ui.value / 100;
                });
            } else {
                obj = canvas.getActiveObject();
                console.log(ui.value / 100);
                obj.opacity = ui.value / 100;
            }
            canvas.renderAll();
        }
    });

    /* This sets the correct opacity slider position, when we select an object on the canvas */
    canvas.on('object:selected', function(options) {
        if(options.target.type == 'i-text')
        {
            $('#text-controls').show();
            if(options.target.fontWeight == 'bold')
            {
                $('#bold').addClass('active');
            }
            if(options.target.fontStyle == 'italic')
            {
                $('#italic').addClass('active');
            }
            if(options.target.fontFamily)
            {
                $('#family').val(options.target.fontFamily);
            }
            if(options.target.fill)
            {
                $('#color').minicolors('value', options.target.fill);
            }
        }
        else
        {
            $('#text-controls').hide();
        }
        console.log(options.target);
        if(options.target.x)
        {
            $('#move').val(options.target.x + ',' + options.target.y);
            moveObject(options.target, options.target.x, options.target.y, canvas);
        }
        $('#no_object_selected').hide();
        $('#object-controls').show();
        $( "#slider" ).slider({ value:options.target.opacity * 100 });
    });

    canvas.on('selection:cleared', function(options) {
        $('#text-controls').hide();
        $('#no_object_selected').show();
        $('#object-controls').hide();
    });

    var canvasWrapper = document.getElementById('canvasWrap');
    canvasWrapper.tabIndex = 1000;
    canvasWrapper.addEventListener("keydown", keyboard, false);

    function keyboard()
    {
        document.onkeydown = function(e) {
            obj = canvas.getActiveObject();
            switch (e.keyCode) {
                case 9: //backspace key
                case 46: //delete
                    e.preventDefault();
                    if(canvas.getActiveGroup()){
                        canvas.getActiveGroup().forEachObject(function(o){ canvas.remove(o) });
                        canvas.discardActiveGroup().renderAll();
                    } else {
                        canvas.remove(canvas.getActiveObject());
                    }
                    break;
                case 37: //left
                    e.preventDefault();
                    if(canvas.getActiveGroup()){
                        canvas.getActiveGroup().forEachObject(function(o){
                            o.setLeft(o.left - 1);
                        });
                    } else {
                        obj.setLeft(obj.left - 1);
                    }
                    break;
                case 38: //up
                    e.preventDefault();
                    if(canvas.getActiveGroup()){
                        canvas.getActiveGroup().forEachObject(function(o){
                            o.setTop(o.top - 1);
                        });
                    } else {
                        obj.setTop(obj.top - 1);
                    }
                    break;
                case 39: //right
                    e.preventDefault();
                    if(canvas.getActiveGroup()){
                        canvas.getActiveGroup().forEachObject(function(o){
                            o.setLeft(o.left + 1);
                        });
                    } else {
                        obj.setLeft(obj.left + 1);
                    }
                    break;
                case 40: //down
                    e.preventDefault();
                    if(canvas.getActiveGroup()){
                        canvas.getActiveGroup().forEachObject(function(o){
                            o.setTop(o.top + 1);
                        });
                    } else {
                        obj.setTop(obj.top + 1);
                    }
                    break;
            }
            canvas.renderAll();
        }
    }

    $('#color').minicolors({
        control: 'hue',
        position: 'top right',
        theme: 'bootstrap',
        change: function(hex, opacity) {
            obj = canvas.getActiveObject();
            if(canvas.getActiveGroup()){
                canvas.getActiveGroup().forEachObject(function(o){
                    o.setFill(hex);
                });
            } else {
                obj.setFill(hex);
            }
            canvas.renderAll();
        }
    });
    $('button').tooltip();

EOF;
if($modal == true)
echo $js;
else
$this->registerJs($js);

?>
<?php if($modal == true) { ?>
});
</script>
<?php } ?>
<style>
    .canvas-container {
        margin: 0 auto;
    }
    .minicolors {
        width: 26px;
        display:inline-block;
    }
</style>

<div class="row">
    <div class="col-md-12">
        <div id="canvasWrap" style="text-align: center">
            <canvas id="c"></canvas>
        </div>

        <div class="row" style="margin-top:10px">
            <div class="col-md-6">

                <div id="controls_global" class="well well-sm">
                    <h4>Canvas</h4>

                    <button type="button" id="add_text" class="btn btn-default" title="Add Custom Text">Add Text</button>
                    <button type="button" id="meme" class="btn btn-default" title="Add Typical Meme Text">Add Meme Text</button>
                    <button type="button" id="add_image" class="btn btn-default" data-toggle="modal" data-target="#myModal" title="Add an image you've previously uploaded">Add Image</button>

                    <div id="images" style="display:none">
                        <?php
                        $overlays = \common\models\cImageOverlay::find()->all();
                        if(count($overlays) == 0)
                        {
                            ?>
                            You don't have any images uploaded yet. <a href="<?php echo Yii::$app->urlManager->createUrl('image-overlay/create'); ?>" target="_blank">Upload some here</a>.
                        <?php
                        }
                        else
                        {
                            ?>
                            <a href="<?php echo Yii::$app->urlManager->createUrl('image-overlay/create'); ?>" target="_blank">Upload more</a>
                        <?php
                        }
                        foreach($overlays as $overlay) {
                            ?>
                            <img src="<?=$overlay->image_url?>" style="max-height: 70px; float: left; margin-left: 10px; cursor:pointer" class="img-responsive image_overlay">
                        <?php
                        }
                        ?>
                        <div style="clear:both"></div>
                    </div>

                </div>
            </div>
            <div class="col-md-6">
                <div id="controls" class="well well-sm">
                    <h4>Object</h4>

                    <div id="no_object_selected">No object selected.</div>

                    <div id="object-controls" style="display:none;">

                        <div id="opacity" style="width: 200px">
                            Opacity:
                            <div id="slider" class="ui-slider-success ui-slider-colors-demo"></div>
                        </div>

                        <div id="bring_to_front">
                            <button type="button" id="bring_to_front_button" title="Bring Object Forward" class="btn btn-default"><span class="fa fa-mail-forward"></span></button>
                            <button type="button" id="delete" title="Delete" class="btn btn-default"><span class="fa fa-trash-o"></span></button>
                        </div>

                        <select id="move">
                            <option value="1,1">Left Top</option>
                            <option value="1,2">Left Center</option>
                            <option value="1,3">Left Bottom</option>
                            <option value="2,1">Center Top</option>
                            <option value="2,2">Center Center</option>
                            <option value="2,3">Center Bottom</option>
                            <option value="3,1">Right Top</option>
                            <option value="3,2">Right Center</option>
                            <option value="3,3">Right Bottom</option>
                        </select>

                    </div>

                    <div id="text-controls" style="display:none;">
                        <div>
                            <button id="bold" class="btn btn-default" title="Bold"><span class="fa fa-bold"></span></button>
                            <button id="italic" class="btn btn-default" title="Italic"><span class="fa fa-italic"></span></button>

                            <select id="family">
                                <option value="times new roman">Times New Roman</option>
                                <option value="helvetica">Helvetica</option>
                                <option value="tahoma">Tahoma</option>
                                <option value="impact">Impact</option>
                            </select>

                            <input type="hidden" id="color" class="btn btn-default" />

                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>