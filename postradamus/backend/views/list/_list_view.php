<div class="col-sm-6 col-md-4">
    <div class="thumbnail">
        <h2><?php echo $model->name; ?> (<?php echo $model->post_count; ?>)</h2>
        <div class="caption">
            <a href="<?php echo Yii::$app->urlManager->createUrl(['list/view', 'id' => $model->id]); ?>" class="btn btn-primary">Load</a> <a href="<?php echo Yii::$app->urlManager->createUrl(['list/delete', 'id' => $model->id]); ?>" class="btn btn-danger">Delete</a>
        </div>
    </div>
</div>