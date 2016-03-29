<div class="col-xs-12 daily-progress">
    <?php if (!empty($followers->users)): ?>
        <?php foreach ($followers->users as $follower): ?>
            <div class="follower">
                <div class="follower-img">
                    <img src="<?php echo $follower->profile_image_url ?>" alt="">
                </div>
                <div class="follower-body">
                    <div class="follower-name">
                        <?php echo $follower->name ?>
                    </div>
                    <div class="follower-screen-name">
                        @<?php echo $follower->screen_name ?>
                    </div>
                    <div class="follower-btns">
                        <div class="follower-btn">
                            <a href="#" class="reply-user" data-source-id="<?php echo $follower->id ?>" data-screen-name="<?php echo $follower->screen_name ?>"><i class="fa fa-reply"></i></a>
                        </div>
                        <div class="follower-btn">
                            <a href="#" class="follow-user" data-source-id="<?php echo $follower->id ?>" data-screen-name="<?php echo $follower->screen_name ?>"><i class="fa fa-star"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="no-items">
            No Followers
        </div>
    <?php endif; ?>
</div>
<?php if ($followers->previous_cursor || $followers->next_cursor): ?>
<div id="followers-pagination" class="pull-left margin-top-25">
    <a href="#" class="<?php echo $followers->previous_cursor? 'previous step': 'disabled' ?>" data-cursor="<?php echo $followers->previous_cursor ?>">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    </a>
    <a href="#" class="<?php echo $followers->next_cursor? 'next step': 'disabled' ?>" data-cursor="<?php echo $followers->next_cursor ?>">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    </a>
</div>
<?php endif; ?>