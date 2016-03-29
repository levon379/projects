<div class="col-xs-12 view-content">
    <div><?php echo $post->text ?></div>
    <?php if($post->attachment): ?>
        <div>
            <img src="<?php echo BASE_URL . $post->attachment->uri ?>" alt="">
        </div>
    <?php endif; ?>
</div>