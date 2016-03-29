<?php if(!$current_user->has_social_account()): ?>
    <div class="col-xs-12 col-md-12">
        <div class="alert alert-warning margin-top-25" role="alert">
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            <span class="sr-only">Warning:</span>
            Currently you don't have Twitter account. You can add <a href="/Twitter/add_account">this one</a>.
        </div>
        <div class="alert alert-warning margin-top-25" role="alert">
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            <span class="sr-only">Warning:</span>
            Currently you don't have Facebook account. You can add <a href="/Facebook/add_account">this one</a>.
        </div>
        <div class="alert alert-warning margin-top-25" role="alert">
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            <span class="sr-only">Warning:</span>
            Currently you don't have Blogger account. You can add <a href="/Blogger/login">this one</a>.
        </div>
    </div>
<?php else: ?>
    <div class="col-xs-12 col-md-12">
    </div>
    <div class="tab-posts">
        <div class="col-xs-12 col-md-5 first-col margin-top-25 posts">
            <div class="col-inner section">
                <form id="new-post" role="form">
                    <div class="col-xs-6 no-padding form-title">New Post</div>
                    <div class="col-xs-6 no-padding height-20">
                        <input type="hidden" name="post[date]" id="post_date" class="form-control single-datepiker">
                    </div>

                    <div class="form-separator"></div>
                    <?php $social_accounts =  $current_user->get_social_accounts(); ?>
                    <?php $social_possible =  get_config('social_types'); ?>
                    <?php $result_soc =  array(); ?>
                    <?php foreach($social_possible as $sockey => $socvalue) :?>
                        <?php foreach($social_accounts as $social_account) {
                            if(!isset($result_soc[$socvalue]) && $socvalue !== $social_account) {
                                $result_soc[$socvalue] = false;
                            } elseif($socvalue === $social_account) {
                                $result_soc[$socvalue] = true;
                            }
                        } ?>
                    <?php endforeach; ?>
                    <?php foreach($result_soc as $sockey => $socvalue) :?>
                        <?php if($socvalue ===  true) {?>
                            <label data-type="<?php echo $sockey ?>" class="socials-label selected" for="post[socials][<?php echo $sockey; ?>]">
                                <span class="<?php echo Posts::get_socialclases($sockey); ?>"></span>
                                <input class="socials" type="checkbox" checked name="post[socials][<?php echo $sockey; ?>]" value="<?php echo $sockey; ?>" />
                            </label>
                        <?php }else{ ?>
                                <label class="socials-label">
                                    <?php $add_account_link = get_config('add_accounts_urls')->{$sockey}; ?>
                                    <a class="add-account-url" href="<?= $add_account_link; ?>"><span class="<?php echo Posts::get_socialclases($sockey); ?>-possible"></span></a>
                                </label>
                        <?php } ?>
                    <?php endforeach; ?>


                    <div class="col-xs-12 no-padding">
                        <textarea name="post[text]" id="post_text" maxlength="" class="form-control"></textarea>
<!--                        <p class="post-text-count-left">0</p>-->
                    </div>

                    <div class="form-separator"></div>

                    <div class="col-xs-12 no-padding actions">
                        <div class="col-xs-4 no-padding">
                            <div class="upload-btn">
                                <img src="<?php echo BASE_URL; ?>assets/admin/img/empty-pic.png" alt="">
                                <span>Upload photo</span>
                            </div>
                        </div>
                        <div class="col-xs-8 no-padding">
                            <button type="submit" data-type="<?php echo Posts_Model::TYPE_NOW ?>" class="btn btn-blue pull-right new-post-submit btn-submit-now">SEND NOW</button>
                            <button type="submit" data-type="<?php echo Posts_Model::TYPE_TIME ?>" class="btn btn-green pull-right new-post-submit btn-submit-sedule">SCHEDULE</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?php if ($current_user->check_permission(array(Roles_Model::TYPE_LEVEL_USER, Roles_Model::TYPE_LEVEL_CUSTOMER, Roles_Model::TYPE_LEVEL_COMPANY_ADMIN))): ?>
            <div class="col-xs-12 col-md-7 last-col margin-top-25">
                <div class="modal wb-modal fade suggested-post-modal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title"></h4>
                            </div>
                            <div class="modal-body"></div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
                <div class="posts-table suggested-posts-table no-padding">
                    <h1>Suggested Posts</h1>
                    <?php echo $gridview_suggested_posts->render(); ?>
                </div>
            </div>
            <div class="col-xs-12 col-md-12 margin-top-25 no-padding">
                <div class="posts-table no-padding">
                    <?php $this->view('posts/_posts_table', array(
                        'gridview_suggested_posts'          => $gridview_suggested_posts
                    )) ?>
                </div>
            </div>
        <?php else: ?>
            <div class="col-xs-12 col-md-7 last-col margin-top-25">
                <div class="posts-table no-padding">
                    <?php $this->view('posts/_posts_table', array(
                        'gridview_suggested_posts'          => $gridview_suggested_posts
                    )) ?>
                </div>
            </div>
        <?php endif; ?>

    </div>
<?php endif; ?>
<?php $medialibrary->render('posts', array("title" => "Pictures bank", "dragtext" => "Drag your picture here", "accept" => 'image/*')); ?>
