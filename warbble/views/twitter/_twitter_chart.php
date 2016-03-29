<?php if ($type == 'activity' || $type == 'all'): ?>
<div class="col-lg-3 col-md-6 border_left_grey">
    <div class="ov_item">
        <h1 class="huge"><?php echo $favorites_count ?></h1><span>Favorites</span>
    </div>
</div>
<div class="col-lg-3  col-md-6 border_left_grey">
    <div class="ov_item">
        <h1 class="huge"><?php echo $retweets_count ?></h1><span>Retweets</span>
    </div>
</div>
<?php endif; ?>
<?php if ($type == 'followers' || $type == 'all'): ?>
<div class="col-lg-3  col-md-6 border_left_grey">
    <div class="ov_item">
        <h1 class="huge"><?php echo $all_followers_count ?></h1><span>All Followers</span>
    </div>
</div>
<div class="col-lg-3  col-md-6">
    <div class="ov_item">
        <h1 class="huge font_size_60_inline"><?php echo $new_followers_count ?></h1><span>New Followers</span>
    </div>
</div>
<?php endif; ?>