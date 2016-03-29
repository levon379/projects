<?php
foreach($posts as $post)
{
    ?>
    <?php if(/*$post->cta_id != 0 || */isset($_GET['random_cta']) && $_GET['random_cta'] == 1) { ?>
    <?php //see if we have 1 2 3 images ?>
    <img width=10 height=10 id="<?=$post->id?>" src="?sub2=image&src=<?php echo $post->getImage_Url(); ?>&list_item_id=<?=$post->id?>&user_id=<?=$_GET['user_id']?>&random_cta=<?=$_GET['random_cta']?>" style="max-height:270px; max-width:300px;" class="content_img img-thumbnail"><br />
<?php } else { ?>
    <?php if($post->getImage_Url(1) != '') { ?><img width=10 height=10 id="<?=$post->id?>1" src="<?php echo $post->getImage_Url(1); ?>" style="max-height:270px; max-width:300px;" class="content_img img-thumbnail"><br /><?php } ?>

    <?php if($post->getImage_Url(2) != '') { ?><img width=10 height=10 id="<?=$post->id?>2" src="<?php echo $post->getImage_Url(2); ?>" style="max-height:270px; max-width:300px;" class="content_img img-thumbnail"><br /><?php } ?>

    <?php if($post->getImage_Url(3) != '') { ?><img width=10 height=10 id="<?=$post->id?>3" src="<?php echo $post->getImage_Url(3); ?>" style="max-height:270px; max-width:300px;" class="content_img img-thumbnail"><br /><?php } ?>

    <img width=10 height=10 id="<?=$post->id?>" src="<?=$post->image_url?>" style="max-height:270px; max-width:300px;" class="content_img img-thumbnail"><br />

<?php } ?>

<?php
}
?>