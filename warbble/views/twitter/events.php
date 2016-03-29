<table class="table graph-users-table">
    <tbody>
        <?php if(!empty($events)): ?>
            <?php foreach($events as $event): ?>
                <?php
                switch($event->event) {
                    case Events_twitter_Model::TYPE_FAVORITE:
                        $message = sprintf('<span class="gray">@%s</span> added you tweet to favorites.', $event->source_screen_name);
                        break;
                    case Events_twitter_Model::TYPE_UNFAVORITE:
                        $message = sprintf('<span class="gray">@%s</span> remove your tweet from favorites.', $event->source_screen_name);
                        break;
                    case Events_twitter_Model::TYPE_RETWEET:
                        $message = sprintf('<span class="gray">@%s</span> retweeted you.', $event->source_screen_name);
                        break;
                    case Events_twitter_Model::TYPE_REPLY:
                        $message = sprintf('<span class="gray">@%s</span> %s', $event->source_screen_name, $event->object);
                        break;
                    case Events_twitter_Model::TYPE_FOLLOW:
                        $message = sprintf('<span class="gray">@%s</span> Is following you now.', $event->source_screen_name);
                        break;
                    case Events_twitter_Model::TYPE_UNFOLLOW:
                        $message = sprintf('<span class="gray">@%s</span> Is un-following you now.', $event->source_screen_name);
                        break;
                }
                ?>
                <tr class="event">
                    <?php $event->object = json_decode($event->object) ?>
                    <td>
                        <img src="<?php echo $event->source_profile_image_url ?>" alt="">
                    </td>
                    <td>
                        <img src="/assets/admin/img/events/<?php echo $event->event ?>.png" alt="">
                    </td>
                    <td><?php echo $message ?></td>
                    <td>
                        <div>
                            <?php echo date('h:i:s A \o\n d/m/y', $event->date) ?>
                        </div>
                    </td>
                    <td>
                        <a href="#" class="reply-user" data-source-id="<?php echo $event->source_id ?>" data-screen-name="<?php echo $event->source_screen_name ?>"><i class="fa fa-reply"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">No Activity</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>