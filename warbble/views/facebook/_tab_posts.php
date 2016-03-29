<?php if(!$current_user->get_fb_token()): ?>
    <div class="col-xs-12 col-md-12">
        <div class="alert alert-warning margin-top-25" role="alert">
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            <span class="sr-only">Warning:</span>
            Currently you don't have Facebook account. You can add <a href="/Facebook/add_account">this one</a>.
        </div>
    </div>
<?php else: ?>
    <div class="tab-post-fb">
        <div class="col-xs-12 col-md-5 first-col margin-top-25 posts_fb">
            <div class="col-inner section">
                <form id="new-fb-post" role="form">
                    <div class="col-xs-6 no-padding form-title">New Post</div>
                    <div class="col-xs-6 no-padding">
                        <input type="text" name="fb[date]" id="fb_date" class="form-control single-datepiker">
                    </div>

                    <div class="form-separator"></div>

                    <div class="col-xs-12 no-padding">
                        <textarea name="fb[text]" id="fb_text" maxlength="140" class="form-control"></textarea>
                    </div>

                    <div class="form-separator"></div>

                    <div class="col-xs-12 no-padding actions">
                        <div class="col-xs-6 no-padding">
                            <div class="upload-btn">
                                <img src="<?php echo BASE_URL; ?>assets/admin/img/empty-pic.png" alt="">
                                <span>Upload photo</span>
                            </div>
                        </div>
                        <div class="col-xs-6 no-padding">
                            <button type="submit" data-type="<?php echo Post_fb_Model::TYPE_NOW ?>" class="btn btn-blue pull-right new-post-fb-submit btn-submit-now">POST NOW</button>
                            <button type="submit" data-type="<?php echo Post_fb_Model::TYPE_TIME ?>" class="btn btn-green pull-right new-post-fb-submit btn-submit-sedule">SHEDULE</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-xs-12 col-md-7 last-col margin-top-25">
            <div class="post-fb-table no-padding">
                <?php $this->view('facebook/_facebook_post_table', array(
                    'gridview'          => $gridview
                )) ?>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php $medialibrary->render('post_fb', array("title" => "Pictures bank", "dragtext" => "Upload your picture here", "accept" => 'image/*')); ?>
