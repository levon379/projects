<!--<table class="table">
    <tr>
<?php //foreach ($columns as $column): ?>
            <th><?php //echo $column['title']    ?></th>
<?php //endforeach; ?>
    </tr>
<?php //if (!empty($models)): ?>
<?php //foreach ($models as $model): ?>
            <tr>
<?php //foreach ($columns as $column): ?>
<?php //if (array_key_exists('filter', $column) && is_callable($column['filter'])): ?>
                        <td><?php //echo $column['filter']($model)    ?></td>
<?php //else: ?>
                        <td><?php // echo $model->$column['name']    ?></td>
<?php //endif; ?>
<?php //endforeach; ?>
            </tr>
<?php //endforeach; ?>
<?php //else: ?>
        <tr>
            <td colspan="<?php //echo count($columns)    ?>">No Items</td>
        </tr>
<?php //endif; ?>
</table>-->




<?php if (!empty($models)): ?>
    <?php foreach ($models as $model): ?>
        <div class="post">
            <div class="media">
                <??>
                <a class="pull-right" href="#">
                    <img class="media_img img-rounded" src="img/media_img.png" alt="">
                </a>
                <div class="media-body">
                    <p><?php echo $model->text ?></p>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="row">
                    <ul class="soc_ text-left padding_left0">
                        <?php $key = array_search($model->social_type, (array) get_config('social_types')); ?>
                        <li>
                            <a class="social_link " href="#" target="_blank">
                                <span class="badge fb_bg badge_">
                                    <?php if ($key == "type_twitter"): ?>
                                        <i class="fa fa-twitter"></i>
                                    <?php elseif ($key == "type_facebook"): ?>
                                        <i class="fa fa-facebook"></i>
                                    <?php endif; ?>
                                </span>
                            </a>
                        </li>
                        <!--                        <li>
                                                    <a class="social_link pinterest" href="#" target="_blank">
                                                        <span class="badge tw_bg badge_">
                                                            <i class="fa fa-twitter"></i>
                                                        </span>
                                                    </a>
                                                </li>-->
                    </ul>
                </div>
            </div>
            <div class="col-sm-10 text-right">
                <div class="row">
                    <ul class="list-inline post_editor">
                        <li>
                            <a href="javascript:;"  data-id="<?php echo $model->id ?>" class="remove_suggested_post">
                                <i class="fa fa-trash"></i> Delete
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;" data-id="<?php echo $model->id ?>" class="view_suggested_posts">
                                <i class="fa fa-pencil"></i> Edit
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                <img src="<?php echo BASE_URL; ?>assets/admin/img/reshedule.png" alt=""> Reschedule
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                <i class="fa fa-long-arrow-right"></i> Share Now
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <h3>No Items</h3>
<?php endif; ?>




<?php if ($pagination['total_pages'] > 1): ?>
    <div class="gridview-pagination pagination-<?php echo "ajax_$model_name" ?>" class="pull-right"></div>
<?php endif; ?>

<script type="text/javascript">
    $(document).ready(function () {
<?php echo "gridview_{$model_name}" ?> = new OGridview({
            page: '<?php echo $pagination['current_page'] ?>',
            total: '<?php echo $pagination['total_pages'] ?>',
            selector: '<?php echo $css_class ?>',
            action: '<?php echo "ajax_$model_name" ?>',
        });
    })
</script>
