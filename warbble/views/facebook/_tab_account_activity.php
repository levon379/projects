<?php if (!$current_user->get_fb_token()): ?>
    <div id="menu2" class="tab-pane fade in active">
        <div class="col-lg-12">
            <div class="panel account_content margin_top_35  bg_white">
                <div  class="text-center">
                    <p class="margin_top_35 txt_middle">Currently you don't have a Facebook account. Please add your Facebook account.</p>
                </div>
                <div class="col-md-6 col-md-offset-3">
                    <div class="text-center margin_top_35">
                        <a class="soc_log" href="/Facebook/add_account">
                            <img src="<?php echo $base_url; ?>assets/admin/img/social_fb_logo.png" alt="">
                            <p class="fb">Facebook</p></a>
                    </div>
                    <div class="margin_top_20 text-center">
                        <a href="/Facebook/add_account" class="btn btn_ btn-lg social_letter_spacing_1 btn_fb btn-block">Connect with your current account</a>
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
                    <input type="text" class="form-control facebook_datepicker" value="THIS WEEK" placeholder="THIS WEEK" data-start="<?php echo $startDate ?>" data-end="<?php echo $endDate ?>">
                    <div class="mobile-datepiker hidden-xs"></div>
                    <i class="fa fa-angle-down"></i>
                    <div class="facebook_datepicker_dropdown"></div>
                </div>
            </div>
            <div class="facebook-chart-info">
                <?php
                echo $this->view('facebook/_facebook_chart', array(
                    'chart_categories' => $chart_categories,
                    'startDate' => $startDate,
                    'endDate' => $endDate,
                    'type' => 'activity',
                        ), TRUE)
                ?>
            </div>
            <input type="hidden" id="formToken" name="formToken" value="<?php echo $formToken ?>">
            <div id="facebook_chart" data-columns='[<?php echo json_encode($posts_chart, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) ?>, <?php echo json_encode($comments_chart, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) ?>, <?php echo json_encode($likes_chart, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) ?>, <?php echo json_encode($shares_chart, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) ?> ]' data-categories='<?php echo json_encode($chart_categories) ?>'></div>
        </div>
    </div>

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
                            <input type="hidden" name="Reply[screen_name]" id="Reply_screen_name">
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
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Users</h4>
                </div>
                <div class="modal-body"></div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


<?php endif; ?>