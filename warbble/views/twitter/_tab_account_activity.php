<?php if (!$current_user->get_twitter_tokens()): ?>
    <div id="menu1" class="tab-pane fade in active">
        <div class="col-lg-12">
            <div class="panel account_content margin_top_35 bg_white">
                <div  class="text-center">
                    <p class="margin_top_35 txt_middle">Currently you don't have a Twitter account. Please add your Twitter account.</p>
                </div>
                <div class="col-md-6 col-md-offset-3">
                    <div class="text-center margin_top_35">
                        <a class="soc_log" href="/Twitter/add_account">
                            <img src="<?php echo $base_url; ?>assets/admin-new/img/social_twitter_logo.png" alt="">
                            <p class="tw">Twitter</p>
                        </a>
                    </div>

                    <div class="margin_top_20 text-center">
                        <a href="/Twitter/add_account" class="btn btn_ btn-lg social_letter_spacing_1 btn_tw btn-block">Connect with your current account</a>
                    </div>
                    <div class="margin_top_20 text-center">
                        <img src="<?php echo $base_url; ?>assets/admin-new/img/social_or_bg.png" alt="">
                    </div>
                    <div class="margin_top_20 text-center">
                        <a href="/Dashboard" class="btn btn_ btn-lg btn-primary get_started btn_ social_letter_spacing_1 btn-block">Create a new Business account</a>
                    </div>
                </div>

            </div>
        </div>
    </div>

<?php else: ?>
    <div id="menu1" class="tab-pane fade in active">
        <div id="overview_content" class="panel account_content margin_top_35 bg_white margin_bot_60 ">
            <div class="col-lg-9">
                <h1 class=" text-left">Overview</h1>
            </div>
           <div class="pull-right timeline">
                    <div class="period_time pull-right">
                        <input type="text" class="form-control twitter_datepicker" value="THIS WEEK" placeholder="THIS WEEK" data-start="<?php echo $startDate ?>" data-end="<?php echo $endDate ?>">
                        <div class="mobile-datepiker hidden-xs"></div>
                        <i class="fa fa-angle-down"></i>
                        <div class="twitter_datepicker_dropdown"></div>
                    </div>
                </div>
            
            <div class="clearfix"></div>
            <div class="margin_top_35">
                <?php
                echo $this->view('twitter/_twitter_chart', array(
                    'chart_categories' => $chart_categories,
                    'startDate' => $startDate,
                    'endDate' => $endDate,
                    'type' => 'all',
                        ), TRUE)
                ?>
            </div>
            <input type="hidden" id="formToken" name="formToken" value="<?php echo $formToken ?>">
            <div class="margin_top_35 col-md-12">
                <div id="twitter_chart" data-columns='[<?php echo json_encode($favorites_chart, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) ?>, <?php echo json_encode($retweets_chart, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) ?>, <?php echo json_encode($all_followers_chart, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) ?>, <?php echo json_encode($new_followers_chart, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) ?> ]' data-categories='<?php echo json_encode($chart_categories) ?>'></div>
            </div>

        </div>
        
        <div class="col-lg-7">
                                    <div id="scrollbox3" class="panel bg_white">
                                        <div class="panel-heading post-title">
                                            <h6>Latest Interactions</h6>
                                        </div>
                                        <div class="panel-body latest_post">
                                            <div class="row margin_bottom_20">
                                                <div class="col-xs-2 ">
                                                    <img src="img/twitter_icon_man.png" alt="">
                                                </div>
                                                <div class="col-xs-8 ">
                                                    <p>
                                                        <span class="post_sm_tittle">Abidaly Nicole</span>
                                                        <span>@terry</span>
                                                    </p>
                                                    <p>
                                                        <span>is following you now</span>
                                                    </p>
                                                </div>
                                                <div class="col-xs-2">
                                                    <p class="text-right">4h</p>
                                                    <ul class="list-inline pull-right">
                                                        <li>
                                                            <a href="#"><img src="img/messedit.png" alt=""></a>
                                                        </li>
                                                        <li>
                                                            <a href="#"><img src="img/share.png" alt=""></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <hr class="c_hr">
                                            <div class="row margin_bottom_20">
                                                <div class="col-xs-2 ">
                                                    <img src="img/heart_icon_bg.png" alt="">
                                                </div>
                                                <div class="col-xs-8 ">
                                                    <p>
                                                        <span class="post_sm_tittle">Zappening</span>
                                                        <span class="semi_txt">liked you Tweet</span>
                                                    </p>
                                                    <p>
                                                        <span>Integer tempor. In dapibus augue non sapien.</span>
                                                    </p>
                                                </div>
                                                <div class="col-s-2">
                                                    <p class="text-right">6h</p>
                                                    <ul class="list-inline pull-right">
                                                        <li>
                                                            <a href="#"><img src="img/messedit.png" alt=""></a>
                                                        </li>
                                                        <li>
                                                            <a href="#"><img src="img/share.png" alt=""></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <hr class="c_hr">
                                            <div class="row margin_bottom_20">
                                                <div class="col-xs-2">
                                                    <img src="img/refresh_icon_bg.png" alt="">
                                                </div>
                                                <div class="col-xs-8">
                                                    <p>
                                                        <span class="post_sm_tittle">James Valentine</span>
                                                        <span class="semi_txt">and</span>
                                                        <span class="post_sm_tittle">Kaly Lister</span>
                                                        <span class="semi_txt">retweeted you</span>
                                                    </p>
                                                    <p>
                                                        <span>Integer tempor. In dapibus augue non sapien. In dapibus augue non sapien.</span>
                                                    </p>
                                                </div>
                                                <div class="col-xs-2">
                                                    <p class="text-right">6h</p>
                                                </div>
                                            </div>
                                            <hr class="c_hr">
                                            <div class="row margin_bottom_20">
                                                <div class="col-xs-2 ">
                                                    <img src="img/person_icon_bg.png" alt="">
                                                </div>
                                                <div class="col-xs-8 ">
                                                    <p>
                                                        <span class="post_sm_tittle">James Valentine</span>
                                                        <span class="semi_txt">and</span>
                                                        <span class="post_sm_tittle">Kaly Lister</span>
                                                        <span class="semi_txt">retweeted you</span>
                                                    </p>
                                                    <p>
                                                        <span>Integer tempor. In dapibus augue non sapien. In dapibus augue non sapien.</span>
                                                    </p>
                                                </div>
                                                <div class="col-xs-2">
                                                    <p class="text-right">6h</p>
                                                </div>
                                            </div>
                                            <hr class="c_hr">
                                            <div class="row margin_bottom_20">
                                                <div class="col-xs-2 ">
                                                    <img src="img/twitter_icon_man.png" alt="">
                                                </div>
                                                <div class="col-xs-8 ">
                                                    <p>
                                                        <span class="post_sm_tittle">Abidaly Nicole</span>
                                                        <span>@terry</span>
                                                    </p>
                                                    <p>
                                                        <span>is following you now</span>
                                                    </p>
                                                </div>
                                                <div class="col-xs-2">
                                                    <p class="text-right">4h</p>
                                                    <ul class="list-inline pull-right">
                                                        <li>
                                                            <a href="#"><img src="img/messedit.png" alt=""></a>
                                                        </li>
                                                        <li>
                                                            <a href="#"><img src="img/share.png" alt=""></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <hr class="c_hr">
                                            <div class="row margin_bottom_20">
                                                <div class="col-xs-2">
                                                    <img src="img/heart_icon_bg.png" alt="">
                                                </div>
                                                <div class="col-xs-8 ">
                                                    <p>
                                                        <span class="post_sm_tittle">Zappening</span>
                                                        <span class="semi_txt">liked you Tweet</span>
                                                    </p>
                                                    <p>
                                                        <span>Integer tempor. In dapibus augue non sapien.</span>
                                                    </p>
                                                </div>
                                                <div class="col-xs-2">
                                                    <p class="text-right">6h</p>
                                                    <ul class="list-inline pull-right">
                                                        <li>
                                                            <a href="#"><img src="img/messedit.png" alt=""></a>
                                                        </li>
                                                        <li>
                                                            <a href="#"><img src="img/share.png" alt=""></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <hr class="c_hr">
                                            <div class="row margin_bottom_20">
                                                <div class="col-xs-2 ">
                                                    <img src="img/refresh_icon_bg.png" alt="">
                                                </div>
                                                <div class="col-xs-8">
                                                    <p>
                                                        <span class="post_sm_tittle">James Valentine</span>
                                                        <span class="semi_txt">and</span>
                                                        <span class="post_sm_tittle">Kaly Lister</span>
                                                        <span class="semi_txt">retweeted you</span>
                                                    </p>
                                                    <p>
                                                        <span>Integer tempor. In dapibus augue non sapien. In dapibus augue non sapien.</span>
                                                    </p>
                                                </div>
                                                <div class="col-xs-2">
                                                    <p class="text-right">6h</p>
                                                </div>
                                            </div>
                                            <hr class="c_hr">
                                            <div class="row margin_bottom_20">
                                                <div class="col-xs-2">
                                                    <img src="img/person_icon_bg.png" alt="">
                                                </div>
                                                <div class="col-xs-8">
                                                    <p>
                                                        <span class="post_sm_tittle">James Valentine</span>
                                                        <span class="semi_txt">and</span>
                                                        <span class="post_sm_tittle">Kaly Lister</span>
                                                        <span class="semi_txt">retweeted you</span>
                                                    </p>
                                                    <p>
                                                        <span>Integer tempor. In dapibus augue non sapien. In dapibus augue non sapien.</span>
                                                    </p>
                                                </div>
                                                <div class="col-xs-2">
                                                    <p class="text-right">6h</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
        
        
        <div class="col-lg-5">
                                    <div id="scrollbox4" class="panel account_content bg_white ">
                                        <div class="panel-heading post-title">
                                            <h6>Followers</h6>
                                        </div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-sm-6 margin_bottom_20">
                                                    <div class="media">
                                                        <a class="pull-left" href="#">
                                                            <img class="img-rounded sml_img" src="img/terry_icon_bg.png" alt="">
                                                        </a>
                                                        <div class="media-body foll_cnt">
                                                            <p class="margin_0 post_sm_tittle">Terri Byrd </p>
                                                            <div class="clearfix"></div>
                                                            <span class="margin_0">@terry</span>
                                                            <div class="clearfix"></div>
                                                            <ul class="list-inline pull-right">
                                                                <li>
                                                                    <a href="#"><img src="img/messedit.png" alt=""></a>
                                                                </li>
                                                                <li>
                                                                    <a href="#"><img src="img/share.png" alt=""></a>
                                                                </li>
                                                            </ul>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 margin_bottom_20">
                                                    <div class="media">
                                                        <a class="pull-left" href="#">
                                                            <img class="img-rounded sml_img" src="img/terry_icon_bg.png" alt="">
                                                        </a>
                                                        <div class="media-body foll_cnt">
                                                            <p class="margin_0 post_sm_tittle">Terri Byrd </p>
                                                            <div class="clearfix"></div>
                                                            <span class="margin_0">@terry</span>
                                                            <div class="clearfix"></div>
                                                            <ul class="list-inline pull-right">
                                                                <li>
                                                                    <a href="#"><img src="img/messedit.png" alt=""></a>
                                                                </li>
                                                                <li>
                                                                    <a href="#"><img src="img/share.png" alt=""></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 margin_bottom_20">
                                                    <div class="media">
                                                        <a class="pull-left" href="#">
                                                            <img class="img-rounded sml_img" src="img/terry_icon_bg.png" alt="">
                                                        </a>
                                                        <div class="media-body foll_cnt">
                                                            <p class="margin_0 post_sm_tittle">Terri Byrd </p>
                                                            <div class="clearfix"></div>
                                                            <span class="margin_0">@terry</span>
                                                            <div class="clearfix"></div>
                                                            <ul class="list-inline pull-right">
                                                                <li>
                                                                    <a href="#"><img src="img/messedit.png" alt=""></a>
                                                                </li>
                                                                <li>
                                                                    <a href="#"><img src="img/share.png" alt=""></a>
                                                                </li>
                                                            </ul>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 margin_bottom_20">
                                                    <div class="media">
                                                        <a class="pull-left" href="#">
                                                            <img class="img-rounded sml_img" src="img/terry_icon_bg.png" alt="">
                                                        </a>
                                                        <div class="media-body foll_cnt">
                                                            <p class="margin_0 post_sm_tittle">Terri Byrd </p>
                                                            <div class="clearfix"></div>
                                                            <span class="margin_0">@terry</span>
                                                            <div class="clearfix"></div>
                                                            <ul class="list-inline pull-right">
                                                                <li>
                                                                    <a href="#"><img src="img/messedit.png" alt=""></a>
                                                                </li>
                                                                <li>
                                                                    <a href="#"><img src="img/share.png" alt=""></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 margin_bottom_20">
                                                    <div class="media">
                                                        <a class="pull-left" href="#">
                                                            <img class="img-rounded sml_img" src="img/terry_icon_bg.png" alt="">
                                                        </a>
                                                        <div class="media-body foll_cnt">
                                                            <p class="margin_0 post_sm_tittle">Terri Byrd </p>
                                                            <div class="clearfix"></div>
                                                            <span class="margin_0">@terry</span>
                                                            <div class="clearfix"></div>
                                                            <ul class="list-inline pull-right">
                                                                <li>
                                                                    <a href="#"><img src="img/messedit.png" alt=""></a>
                                                                </li>
                                                                <li>
                                                                    <a href="#"><img src="img/share.png" alt=""></a>
                                                                </li>
                                                            </ul>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 margin_bottom_20">
                                                    <div class="media">
                                                        <a class="pull-left" href="#">
                                                            <img class="img-rounded sml_img" src="img/terry_icon_bg.png" alt="">
                                                        </a>
                                                        <div class="media-body foll_cnt">
                                                            <p class="margin_0 post_sm_tittle">Terri Byrd </p>
                                                            <div class="clearfix"></div>
                                                            <span class="margin_0">@terry</span>
                                                            <div class="clearfix"></div>
                                                            <ul class="list-inline pull-right">
                                                                <li>
                                                                    <a href="#"><img src="img/messedit.png" alt=""></a>
                                                                </li>
                                                                <li>
                                                                    <a href="#"><img src="img/share.png" alt=""></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 margin_bottom_20">
                                                    <div class="media">
                                                        <a class="pull-left" href="#">
                                                            <img class="img-rounded sml_img" src="img/terry_icon_bg.png" alt="">
                                                        </a>
                                                        <div class="media-body foll_cnt">
                                                            <p class="margin_0 post_sm_tittle">Terri Byrd </p>
                                                            <div class="clearfix"></div>
                                                            <span class="margin_0">@terry</span>
                                                            <div class="clearfix"></div>
                                                            <ul class="list-inline pull-right">
                                                                <li>
                                                                    <a href="#"><img src="img/messedit.png" alt=""></a>
                                                                </li>
                                                                <li>
                                                                    <a href="#"><img src="img/share.png" alt=""></a>
                                                                </li>
                                                            </ul>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 margin_bottom_20">
                                                    <div class="media">
                                                        <a class="pull-left" href="#">
                                                            <img class="img-rounded sml_img" src="img/terry_icon_bg.png" alt="">
                                                        </a>
                                                        <div class="media-body foll_cnt">
                                                            <p class="margin_0 post_sm_tittle">Terri Byrd </p>
                                                            <div class="clearfix"></div>
                                                            <span class="margin_0">@terry</span>
                                                            <div class="clearfix"></div>
                                                            <ul class="list-inline pull-right">
                                                                <li>
                                                                    <a href="#"><img src="img/messedit.png" alt=""></a>
                                                                </li>
                                                                <li>
                                                                    <a href="#"><img src="img/share.png" alt=""></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 margin_bottom_20">
                                                    <div class="media">
                                                        <a class="pull-left" href="#">
                                                            <img class="img-rounded sml_img" src="img/terry_icon_bg.png" alt="">
                                                        </a>
                                                        <div class="media-body foll_cnt">
                                                            <p class="margin_0 post_sm_tittle">Terri Byrd </p>
                                                            <div class="clearfix"></div>
                                                            <span class="margin_0">@terry</span>
                                                            <div class="clearfix"></div>
                                                            <ul class="list-inline pull-right">
                                                                <li>
                                                                    <a href="#"><img src="img/messedit.png" alt=""></a>
                                                                </li>
                                                                <li>
                                                                    <a href="#"><img src="img/share.png" alt=""></a>
                                                                </li>
                                                            </ul>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 margin_bottom_20">
                                                    <div class="media">
                                                        <a class="pull-left" href="#">
                                                            <img class="img-rounded sml_img" src="img/terry_icon_bg.png" alt="">
                                                        </a>
                                                        <div class="media-body foll_cnt">
                                                            <p class="margin_0 post_sm_tittle">Terri Byrd </p>
                                                            <div class="clearfix"></div>
                                                            <span class="margin_0">@terry</span>
                                                            <div class="clearfix"></div>
                                                            <ul class="list-inline pull-right">
                                                                <li>
                                                                    <a href="#"><img src="img/messedit.png" alt=""></a>
                                                                </li>
                                                                <li>
                                                                    <a href="#"><img src="img/share.png" alt=""></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 margin_bottom_20">
                                                    <div class="media">
                                                        <a class="pull-left" href="#">
                                                            <img class="img-rounded sml_img" src="img/terry_icon_bg.png" alt="">
                                                        </a>
                                                        <div class="media-body foll_cnt">
                                                            <p class="margin_0 post_sm_tittle">Terri Byrd </p>
                                                            <div class="clearfix"></div>
                                                            <span class="margin_0">@terry</span>
                                                            <div class="clearfix"></div>
                                                            <ul class="list-inline pull-right">
                                                                <li>
                                                                    <a href="#"><img src="img/messedit.png" alt=""></a>
                                                                </li>
                                                                <li>
                                                                    <a href="#"><img src="img/share.png" alt=""></a>
                                                                </li>
                                                            </ul>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 margin_bottom_20">
                                                    <div class="media">
                                                        <a class="pull-left" href="#">
                                                            <img class="img-rounded sml_img" src="img/terry_icon_bg.png" alt="">
                                                        </a>
                                                        <div class="media-body foll_cnt">
                                                            <p class="margin_0 post_sm_tittle">Terri Byrd </p>
                                                            <div class="clearfix"></div>
                                                            <span class="margin_0">@terry</span>
                                                            <div class="clearfix"></div>
                                                            <ul class="list-inline pull-right">
                                                                <li>
                                                                    <a href="#"><img src="img/messedit.png" alt=""></a>
                                                                </li>
                                                                <li>
                                                                    <a href="#"><img src="img/share.png" alt=""></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 margin_bottom_20">
                                                    <div class="media">
                                                        <a class="pull-left" href="#">
                                                            <img class="img-rounded sml_img" src="img/terry_icon_bg.png" alt="">
                                                        </a>
                                                        <div class="media-body foll_cnt">
                                                            <p class="margin_0 post_sm_tittle">Terri Byrd </p>
                                                            <div class="clearfix"></div>
                                                            <span class="margin_0">@terry</span>
                                                            <div class="clearfix"></div>
                                                            <ul class="list-inline pull-right">
                                                                <li>
                                                                    <a href="#"><img src="img/messedit.png" alt=""></a>
                                                                </li>
                                                                <li>
                                                                    <a href="#"><img src="img/share.png" alt=""></a>
                                                                </li>
                                                            </ul>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 margin_bottom_20">
                                                    <div class="media">
                                                        <a class="pull-left" href="#">
                                                            <img class="img-rounded sml_img" src="img/terry_icon_bg.png" alt="">
                                                        </a>
                                                        <div class="media-body foll_cnt">
                                                            <p class="margin_0 post_sm_tittle">Terri Byrd </p>
                                                            <div class="clearfix"></div>
                                                            <span class="margin_0">@terry</span>
                                                            <div class="clearfix"></div>
                                                            <ul class="list-inline pull-right">
                                                                <li>
                                                                    <a href="#"><img src="img/messedit.png" alt=""></a>
                                                                </li>
                                                                <li>
                                                                    <a href="#"><img src="img/share.png" alt=""></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                        </div>
                                    </div>
                                </div>

        
<!--        <div class="col-lg-5 col-md-5 col-sm-12 margin-top-25 no-padding clearfix">
            <div class="twitter-events">
                <div class="event-overlay overlay-preloader"></div>
            </div>
            <a href="#" class="event-show-more">Show more</a>
        </div>-->

        <div class="col-lg-7 col-md-7 col-sm-12 margin-top-25 followers-list">
            <?php
            $this->view('twitter/followers-list', array(
                'followers' => $followers
            ))
            ?>
        </div>

        <div class="modal fade event-more-dialog wb-modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Events</h4>
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
                        <h4 class="modal-title">Tweet</h4>
                    </div>
                    <div class="modal-body">
                        <form method="post" role="form">
                            <div class="hidden">
                                <input type="hidden" name="Reply[user_id]" id="Reply_user_id">
                                <input type="hidden" name="Reply[screen_name]" id="Reply_screen_name">
                                <input type="hidden" name="Reply[type]" id="Reply_type" value="tweet">
                            </div>
                            <div class="form-group">
                                <input type="checkbox" class="reply-type" checked data-toggle="toggle" data-width="100" data-on="Tweet" data-off="DM" data-onstyle="success" data-offstyle="primary">
                            </div>
                            <div class="form-group">
                                <label for="Reply_message">Message</label>
                                <textarea name="Reply[message]" id="Reply_message" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Tweet</button>
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