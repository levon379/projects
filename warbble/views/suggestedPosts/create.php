<h1>Create Post</h1>

<div class="col-xs-12">
    <?php if(!empty($errors)): ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
        <?php foreach($errors as $error): ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <p><?php echo $error ?></p>
        <?php endforeach ?>
        </div>
    <?php endif; ?>
</div>

<form method="post" enctype="multipart/form-data">
    <div class="form-group">
        <div class="col-xs-4">
            <label for="SuggestedPosts_message">Message</label>
        </div>

        <div class="col-xs-8">
            <textarea name="SuggestedPosts[message]" id="SuggestedPosts_message" class="form-control"></textarea>
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-4">
            <label for="Product_type">Channels</label>
        </div>

        <div class="col-xs-8">
            <div class="type-wrapper type-checkbox twitter">
                <input type="checkbox" name="SuggestedPosts[channels][]" value="<?php echo Suggested_posts_Model::TYPE_TWITTER ?>">
            </div>

            <div class="type-wrapper type-checkbox facebook">
                <input type="checkbox" name="SuggestedPosts[channels][]" value="<?php echo Suggested_posts_Model::TYPE_FACEBOOK ?>">
            </div>

            <div class="type-wrapper type-checkbox blogger">
                <input type="checkbox" name="SuggestedPosts[channels][]" value="<?php echo Suggested_posts_Model::TYPE_BLOGGER ?>">
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-4">
            <label for="SuggestedPostsTo_user_id">Users To</label>
        </div>

        <div class="col-xs-8">
            <select class="form-control chosen-select" data-placeholder="Select users..." name="SuggestedPostsTo[user_id][]" multiple id="SuggestedPostsTo_user_id">
                <?php foreach($users as $user): ?>
                    <option value="<?php echo $user->user_id ?>"><?php echo htmlentities($user->get_name() . ' <' . $user->email . '>')?></option>
                <?php endforeach ?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-4">
            <label for="attachment">Attachment</label>
        </div>

        <div class="col-xs-8">
            <input type="hidden" name="SuggestedPosts[attachment_id]" id="SuggestedPosts_attachment_id">
            <div class="simple-upload">
                <div class="simple-upload-preview"></div>
                <div class="simple-upload-section col-xs-2">
                    <div class="btn btn-default btn-upload">Image</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xs-4"></div>
    <div class="col-xs-8">
        <input type="submit" value="Create" class="btn btn-success">
    </div>

</form>
<?php $medialibrary->render('suggested_posts', array("title" => "Pictures bank", "dragtext" => "Drag your picture here", "accept" => 'image/*')); ?>