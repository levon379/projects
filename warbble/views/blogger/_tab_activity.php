<?php if(!$current_user->get_blogger_token()): ?>
    <div class="col-xs-12 col-md-12">
        <div class="alert alert-warning margin-top-25" role="alert">
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            <span class="sr-only">Warning:</span>
            Currently you don't have Blogger account. You can add <a href="/blogger/login">this one</a>.
        </div>
    </div>

<div id="menu3" class="tab-pane fade in active">
                                <!-- Page Heading -->
                                <div class="col-lg-12">
                                    <div class="panel account_content margin_top_35 bg_white">
                                        <div  class="text-center">
                                            <p class="margin_top_35 txt_middle">Currently you don't have a Blogger account. Please add your Blogger account.</p>
                                        </div>
                                        <div class="col-md-6 col-md-offset-3">
                                            <div class="text-center margin_top_35">
                                                <a class="soc_log" href="/blogger/login">
                                                    <img src="<?php echo $base_url; ?>assets/admin/img/social_blog_logo.png" alt="">
                                                    <p class="blog">Blog</p>
                                                </a>
                                            </div>
                                            <div class="margin_top_20 text-center">
                                                <a href="/blogger/login" class="btn btn_ btn-lg social_letter_spacing_1 btn_blog btn-block">Connect with your current account</a>
                                            </div>
                                            <div class="margin_top_20 text-center">
                                                <img src="<?php echo $base_url; ?>assets/admin/img/social_or_bg.png" alt="">
                                            </div>
                                            <div class="margin_top_20 text-center">
                                                <a href="/Dashboard" class="btn btn_ btn-lg btn-primary get_started btn_ social_letter_spacing_1 btn-block">Create a new Business account</a>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

<?php else: ?>
    <div class="col-xs-12 col-md-12 daily-progress no-padding margin-top-25 activity">
        <div class="col-inner section">
            <div class="pull-right timeline">
                <div class="period_time pull-right">
                    <input type="text" class="form-control blogger_datepicker" value="THIS WEEK" placeholder="THIS WEEK" data-start="<?php echo $startDate ?>" data-end="<?php echo $endDate ?>">
                    <i class="fa fa-angle-down"></i>
                    <div class="blogger_datepicker_dropdown"></div>
                </div>
            </div>
            <div class="blogger-chart-info">
                <?php echo $this->view('blogger/_chart', array(
                    'chart_categories'  => $chart_categories,
                    'startDate'         => $startDate,
                    'endDate'           => $endDate,
                ), TRUE) ?>
            </div>
            <div id="blogger_chart" data-columns='[<?php echo json_encode($comments_chart,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) ?>]' data-categories='<?php echo json_encode($chart_categories) ?>'></div>
        </div>
    </div>

    <div class="col-lg-7 col-md-7 col-sm-12 margin-top-25 no-padding clearfix">
        <div class="blogger-comments">
            <div class="event-overlay overlay-preloader"></div>
        </div>
        <a href="#" class="comment-show-more">Show more</a>
    </div>

    <div class="modal fade comment-more-dialog wb-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Comments</h4>
                </div>
                <div class="modal-body"></div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade reply-dialog wb-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Reply</h4>
                </div>
                <div class="modal-body">
                    <form method="post" role="form">
                        <div class="hidden">
                            <input type="hidden" name="Reply[user_id]" id="Reply_user_id">
                            <input type="hidden" name="Reply[blog_id]" id="Reply_blog_id">
                            <input type="hidden" name="Reply[post_id]" id="Reply_post_id">
                        </div>
                        <div class="form-group">
                            <label for="Reply_message">Message</label>
                            <textarea name="Reply[message]" id="Reply_message" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Reply</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade activity-users-dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">Users
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body"></div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


<?php endif; ?>