<?php use yii\helpers\Html; ?>

<div class="thumbnail post_unselected" id="item-<?=$model->id?>" style="<?=(isset($model->postType->color) ? 'border: 1px solid ' . $model->postType->color : '')?>">
    <a name="<?=$model->id?>"></a>
    <?php
    $format = '(D) ' . Yii::$app->postradamus->get_user_date_time_format();
    if(!$userTimezone = Yii::$app->user->identity->getSetting('timezone'))
    {
        $userTimezone = 'America/Los_Angeles';
    }
    $offset = Yii::$app->postradamus->get_timezone_offset($userTimezone);
    ?>
    <div class="caption">

        <img class="tooltips" data-placement="top" title="<?php echo (isset($model->origin_name) ? $model->origin_name : 'Unknown'); ?>" src="<?php echo $model->origin_image_url; ?>" width=20 height=20>
        <div class="tooltips" data-placement="top" title="<?php echo (isset($model->postType->name) ? $model->postType->name : 'No Post Type'); ?>" style="width:20px;height:20px;background-color:<?=(isset($model->postType->color) ? $model->postType->color : '#ffffff')?>;display:inline-block;margin-bottom:-6px; border:1px solid #808b9c; margin-right:0px"></div>
        <span<?php if($model->scheduled_time && ($model->scheduled_time + $offset) > (time() + 60 * 15)) { echo " style='font-family: tahoma; font-size:80%; color:green;'"; } else { echo " style='font-family: tahoma; font-size:80%; color:red;'"; } ?>><?php echo (($model->scheduled_time) ? date($format, $model->scheduled_time) : 'Not yet scheduled'); ?></span>
    </div>
    <?php if($model->image_url != '') { ?>
        <div style="position:relative; left: 0; top: 0;" class="list_image">
        <div style="position:relative; left: 0; top: 0;">

            <?php /* Coming soon...
            <video id="example_video_1" class="video-js vjs-default-skin"
                   controls preload="auto" width="100%"
                   data-setup='{"example_option":true}'>
                <source src="<?php echo $model->image_url; ?>" type='video/mp4' />
                <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
            </video>
 <?php */ ?>

            <a href="<?php echo $model->image_url; ?>" class="image_link" target="list"><img src="" data-src="<?php echo $model->image_url; ?>" class="lazy img-rounded img-thumbnail<?php if($model->link == '') { ?> photo-post<?php } else { ?> link-post<?php } ?>" alt="<?=$model->name?>"></a>
            <?php if($model->getImage_Url(1)) { ?><a href="<?php echo $model->getImage_Url(1); ?>" target="_blank"><img src="<?php echo $model->getImage_Url(1); ?>" style="max-width:70px; display:inline-block"></a><?php } ?>
            <?php if($model->getImage_Url(2)) { ?><a href="<?php echo $model->getImage_Url(2); ?>" target="_blank"><img src="<?php echo $model->getImage_Url(2); ?>" style="max-width:70px; margin-left: 1px; display:inline-block"></a><?php } ?>
            <?php if($model->getImage_Url(3)) { ?><a href="<?php echo $model->getImage_Url(3); ?>" target="_blank"><img src="<?php echo $model->getImage_Url(3); ?>" style="max-width:70px; margin-left: 1px; display:inline-block"></a><?php } ?>
        </div>
        <a class="edit_image" data-toggle="modal" data-target="#imageModal" data-id="<?=$model->id?>" target="_blank" href="<?=Yii::$app->urlManager->createUrl(['post/edit-image-modal', 'id' => $model->id])?>"><span class="fa fa-picture-o"></span></a>
        </div>
        <div style="text-align: center; color: gray; font-size:10px">
            <?= dosamigos\editable\Editable::widget([
                'options' => [
                    'id' => 'name' . $model->id,
                ],
                'clientOptions' => [
                    'savenochange' => true,
                    'pk' => $model->id,
                ],
                'url' => 'post/update-element',
                'model' => $model,
                'attribute' => 'name',
                'mode' => 'inline',
                'type' => 'textarea',
            ]);?></div>
    <?php } ?>
    <div class="caption">
        <?= dosamigos\editable\Editable::widget([
            'options' => [
                'id' => 'text' . $model->id,
            ],
            'clientOptions' => [
                'savenochange' => true,
                'pk' => $model->id,
                'rows' => 10
            ],
            'url' => 'post/update-element',
            'model' => $model,
            'attribute' => 'text',
            'mode' => 'inline',
            'type' => 'textarea',
        ]);?>
        <?php
        $this->registerJs("
        $('.editable').on('shown', function(e, editable) {
            console.log('test');
        });
        ");
        ?>
    </div>

    <div class="row">
        <div class="col-md-4">
            <input type="checkbox" name="post[<?=$model['id']?>][selected]" value="1" id="<?=$model['id']?>" class="checkbox_activate hidden" /><a href="#" class="btn btn-sm btn-primary select_button"><i class="fa fa-square"></i> Select</a>
        </div>
        <div class="col-md-3" style="text-align: center"></div>
        <div class="col-md-5" style="text-align: right">
            <a href="<?=Yii::$app->urlManager->createUrl(['post/update', 'id' => $model->id])?>" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></a>
            <a href="#" data-href="<?=Yii::$app->urlManager->createUrl(['post/delete', 'id' => $model->id])?>" class="hide_post btn btn-sm btn-danger delete-post" data-toggle="tooltip" title="Delete"><i class="fa fa-trash-o"></i></a>
        </div>
    </div>
</div>