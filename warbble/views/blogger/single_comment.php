<div class="col-xs-12 event one-comment"
     data-id="<?= $comment['id']; ?>"
     data-author-id="<?= $comment['authorid']; ?>"
     data-post-id="<?= $comment['post_id']; ?>"
     data-blog-id="<?= $comment['blog_id']; ?>">
    <div class="col-md-2 col-sm-2 col-xs-2">
        <div class="comment-author-logo"><img src="<?= $comment['image']; ?>" alt=""></div>
    </div>
    <div class="col-md-4 col-sm-4 col-xs-4">
        <div class="comment-content">
            <a href="<?= $comment['url']; ?>"><span class="user-name"><?= $comment['name']; ?></span></a>
        </div>
        <div class="event-body">
            <?= $comment['content']; ?>
        </div>
    </div>
    <div class="col-md-4 col-sm-4 col-xs-4">
        <div class="e-date"><?= $comment['date']; ?></div>
    </div>

    <div class="spam-comment col-md-1 col-sm-1 col-xs-1"></div>
    <div class="remove-comment col-md-1 col-sm-1 col-xs-1"></div>
</div>