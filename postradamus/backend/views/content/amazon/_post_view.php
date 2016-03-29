<?php use yii\helpers\Html; ?>
<div class="thumbnail post_unselected">
    <?php if(isset($model['image_url']) && $model['image_url'] != '') { ?>
    <a href="<?php echo $model['product_link']; ?>" target="_blank"><img src="<?php echo $model['image_url']; ?>" class="img-rounded img-responsive link-post" alt="<?//=$model['author_name']?>"></a>
    <?php } ?>
    <div class="caption">
        <p><b><?php echo $model['title']; ?></b></p>
        <p><?php if(isset($model['text'])) { echo $model['text']; } ?></p>
        <?php if(isset($model['product_link'])) { ?>
        <p><?php echo "<a href='".$model['product_link']."' target='amazon'>" . $model['product_link'] . "</a>"; ?></p>
        <?php } ?>
        <p><b>Sales Rank:</b> <?php if(isset($model['sales_rank'])) { echo (int)$model['sales_rank']; } ?></p>
        <textarea style="display:none" name="post[<?=$model['id']?>][text]"><?php if(isset($model['text'])) { echo $model['text']; } ?></textarea>
        <textarea style="display:none" name="post[<?=$model['id']?>][name]"><?php if(isset($model['title'])) { echo $model['title']; } ?></textarea>
        <?php if(isset($model['image_url'])) { ?>
        <input type="hidden" name="post[<?=$model['id']?>][image_url]" value="<?=$model['image_url']?>">
        <?php } ?>
        <input type="hidden" name="post[<?=$model['id']?>][id]" value="<?=$model['id']?>">
        <input type="hidden" name="post[<?=$model['id']?>][meta][sales_rank]" value="<?php if(isset($model['likes'])) { echo (int)$model['sales_rank']; } ?>">
        <input type="hidden" name="post[<?=$model['id']?>][meta][author_name]" value="<?php if(isset($model['author'])) { echo $model['author']; } ?>">
        <input type="hidden" name="post[<?=$model['id']?>][meta][url]" value="<?php if(isset($model['product_link'])) { echo $model['product_link']; } ?>">
        <input type="hidden" name="post[<?=$model['id']?>][meta][title]" value="<?php if(isset($model['title'])) { echo $model['title']; } ?>">
    </div>
    <?php echo $this->render('../_select_hide_buttons', ['model' => $model]); ?>
</div>