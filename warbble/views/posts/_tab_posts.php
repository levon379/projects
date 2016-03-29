<?php if (!$current_user->has_social_account()): ?>
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



    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading post-title">
                <h6>New post</h6>
                <div class="scrollbar" id="style-1">
                    <div class="force-overflow"></div>
                </div>
            </div>
            <div class="panel-body">
                <form id="new-post" role="form">
                    <input type="hidden" name="post[date]" id="post_date" class="form-control single-datepiker">
                    <div class="col-sm-6">
                        <div class="row">
                            <ul class="soc_ text-left padding_left0">
                                <?php $social_accounts = $current_user->get_social_accounts(); ?>
                                <?php $social_possible = get_config('social_types'); ?>
                                <?php $result_soc = array(); ?>
                                <?php foreach ($social_possible as $sockey => $socvalue) : ?>
                                    <?php
                                    foreach ($social_accounts as $social_account) {
                                        if (!isset($result_soc[$socvalue]) && $socvalue !== $social_account) {
                                            $result_soc[$socvalue] = false;
                                        } elseif ($socvalue === $social_account) {
                                            $result_soc[$socvalue] = true;
                                        }
                                    }
                                    ?>
                                <?php endforeach; ?>
                                <?php foreach ($result_soc as $sockey => $socvalue) : ?>
                                    <?php if ($socvalue === true) { ?>
                                        <li>
                                            <div class="checkbox ">
                                                <input type="checkbox" class="css-checkbox2" id="post[socials][<?php echo $sockey; ?>]" checked name="post[socials][<?php echo $sockey; ?>]" value="<?php echo $sockey; ?>" />
                                                <label data-type="<?php echo $sockey ?>" for="post[socials][<?php echo $sockey; ?>]"  class="tw-label <?php echo Posts::get_socialclasesNew($sockey); ?>"></label>
                                            </div>
                                        </li>
                                    <?php } else { ?>
                                        <?php $add_account_link = get_config('add_accounts_urls')->{$sockey}; ?>
                                        <li>
                                            <a href="<?= $add_account_link; ?>">
                                                <!--<span class="<?php //echo Posts::get_socialclases($sockey);             ?>-possible"></span>-->
                                                <div class="bg_more" ></div>
                                            </a>
                                        <li>  
                                        <?php } ?>
                                    <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="row">
                            <a href="#" class="btn btn_more btn-block"><i class="fa fa-plus"></i> Connect more accounts</a>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group post_form">
                        <label for="comment">Message for Facebook, Twitter</label>
                        <textarea name="post[text]" id="post_text" id="comment" rows="10" maxlength="" class="form-control"></textarea>
                    </div>

                    <div class="col-xs-5">
                        <div class="row actions">
                            <!--<input type="file" id="edit-file" class="form-file" />-->
                            <div class="upload-btn">
                                <span class="fa fa-camera">Upload Image</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-7 text-right">
                        <div class="row">
                            <ul class="list-inline">
                                <li>
                                    <button type="submit" data-type="<?php echo Posts_Model::TYPE_TIME ?>" class="btn  btn-primary new-post-submit get_started btn_ btn-submit-sedule">Schedule</button>
                                </li>
                                <li>
                                    <button type="submit" data-type="<?php echo Posts_Model::TYPE_NOW ?>" class="btn  btn-primary get_started btn_ btn_green new-post-submit btn-submit-now">Share Now</button>
                                </li>
                            </ul>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php if ($current_user->check_permission(array(Roles_Model::TYPE_LEVEL_USER, Roles_Model::TYPE_LEVEL_CUSTOMER, Roles_Model::TYPE_LEVEL_COMPANY_ADMIN))): ?>
        <div class="col-lg-6">

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

            <div class="panel panel-default post_scroll scrl">
                <div class="panel-heading post-title">
                    <h6>Suggested Posts</h6>
                </div>
                <div class="panel-body">
                    <?php echo $gridview_suggested_posts->render(true); ?>
                </div>

            </div>
        </div>
        <div class="clearfix"></div>
        <!-- Scheduled Posts -->
        <div class="col-lg-6">
            <div class="panel panel-default sheduled_post">
                <div class="panel-heading post-title">
                    <h6>Scheduled Posts</h6>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body">
                    <?php echo $gridview_sheduled->render(true); ?>
                </div>

            </div>
        </div>
        <!--End Scheduled Posts -->    

        <!--Posts History -->
        <div class="col-lg-6">
            <div class="panel panel-default post_scroll_lg scrl history_post">
                <div class="panel-heading post-title">
                    <h6>History</h6>
                    <div class="clearfix"></div>

                </div>
                <div class="panel-body">
                    <?php echo $gridview_history->render(true); ?>
                </div>
            </div>
        </div>
        <!--End Posts History -->

    <?php else: ?>

        <!--Posts History -->
        <div class="col-lg-6">
            <div class="panel panel-default post_scroll_lg scrl history_post">
                <div class="panel-heading post-title">
                    <h6>History</h6>
                    <div class="clearfix"></div>

                </div>
                <div class="panel-body">
                    <?php echo $gridview_history->render(true); ?>
                </div>
            </div>
        </div>
        <!--End Posts History -->


    <?php endif; ?>

<?php endif; ?>
<?php $medialibrary->render('posts', array("title" => "Pictures bank", "dragtext" => "Drag your picture here", "accept" => 'image/*')); ?>




