<script type="text/javascript">Stripe.setPublishableKey('<?php echo $payment_config['publishable_key'] ?>');</script>
<div class="admin_section">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <div  class="text-center">
                <h3>Setup Your Social Accounts</h3>
                <p class="margin_top_35 txt_middle">Connect your existing Social media business accounts or we will create one for you.</p>
                <div class="steps">
                    <ul>
                        <li>
                            <span class="badge social_step_checked">
                                <img src="<?php echo $base_url ?>assets/admin/img/social_step_checked.png" alt="">
                            </span>
                        </li>
                        <li class="steps_border">
                        </li>
                        <li><span class="badge active">2</span>
                        </li>
                    </ul>
                    <ul class="step_text">
                        <li>
                            <a href="#">Add Information</a>
                        </li>
                        <li>
                            <a class="style_clr" href="#">Connect Account</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="panel account_content social_content margin_top_35 social_content_bg">
            <div class="col-lg-5 col-lg-offset-1 col-md-6">
                <!-- facebook section -->
                <div class="margin_top_20 text-center">
                    <a class="soc_log" href="/facebook/add_account">
                        <img src="<?php echo $base_url ?>assets/admin/img/social_fb_logo.png" />
                        <p class="fb">Facebook</p></a>
                    </a>
                </div>
                <div class="margin_top_20 text-center">
                    <a href="/facebook/add_account"  class="btn btn_ btn-lg social_letter_spacing_1 btn_fb btn-block">Connect with your current account</a>
                </div>
                <div class="margin_top_20 text-center">
                    <img src="<?php echo $base_url ?>assets/admin/img/social_or_bg.png" />
                </div>
                <div class="margin_top_20 text-center">
                    <a href="<?php echo $base_url ?>Dashboard" class=" btn_ btn btn-lg btn-primary get_started btn_ social_letter_spacing_1 btn-block">Create a new Business account</a>
                </div>
                <!-- Blog section -->
                <div class="margin_top_60 text-center">
                    <a class="soc_log" href="/blogger/login">
                        <img src="<?php echo $base_url ?>assets/admin/img/social_blog_logo.png" alt="">
                        <p class="blog">Blog</p>
                    </a>
                </div>

                <div class="margin_top_20 text-center">
                    <a href="/blogger/login" class="btn btn_ btn-lg social_letter_spacing_1 btn_blog btn-block">Connect with your current account</a>
                </div>
                <div class="margin_top_20 text-center">
                    <img src="<?php echo $base_url ?>assets/admin/img/social_or_bg.png" alt="">
                </div>
                <div class="margin_top_20 text-center">
                    <a href="<?php echo $base_url ?>Dashboard" class="btn btn_ btn-lg btn-primary get_started btn_ social_letter_spacing_1 btn-block">Create a new Business account</a>
                </div>

            </div>



            <div class="col-lg-5 col-lg-offset-1 col-md-6">
                <!-- twitter section -->
                <div class="margin_top_20 text-center">
                    <a class="soc_log" href="/twitter/add_account">
                        <img src="<?php echo $base_url ?>assets/admin/img/social_twitter_logo.png" alt="">
                        <p class="tw">Twitter</p>
                    </a>
                </div>
                <div class="margin_top_20 text-center">
                    <a href="/twitter/add_account" class="btn btn_ btn-lg social_letter_spacing_1 btn_tw btn-block">Connect with your current account</a>
                </div>
                <div class="margin_top_20 text-center">
                    <img src="<?php echo $base_url ?>assets/admin/img/social_or_bg.png" alt="">
                </div>
                <div class="margin_top_20 text-center">
                    <a href="<?php echo $base_url ?>Dashboard" class="btn btn_  btn-lg btn-primary get_started btn_ social_letter_spacing_1 btn-block">Create a new Business account</a>
                </div>
                <div class="margin_top_60 text-center">
                    <a class="soc_log" href="#">
                        <img src="<?php echo $base_url ?>assets/admin/img/social_add_logo.png" alt="">
                        <p class="style_clr">Another Social Account</p>
                    </a>

                    <div class="margin_top_20 text-center">
                        <p class="text-left margin_left_17p"> If there's another social media tool you use or would like to use just
                            <span class="style_clr ral_bold">let us know</span>
                            and we'll set it up for you.

                        </p>
                    </div>
                    <div class="margin_top_20 text-center">
                        <ul class="soc_ text-left padding_left0">
                            <li>
                                <p class="social_title">Coming Soon:</p>
                            </li>
                            <li>
                                <a class="social_link web " href="#" target="_blank">
                                    <span class="fa-stack fa-lg web">
                                        <i class="fa fa-circle fa-stack-2x"></i>
                                        <i class="fa fa-stack-1x fa-inverse"><img src="<?php echo $base_url ?>assets/admin/img/web_icn.png" /></i>
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a class="social_link " href="https://www.linkedin.com" target="_blank">
                                    <span class="fa-stack fa-lg linkedin">
                                        <i class="fa fa-circle fa-stack-2x"></i>
                                        <i class="fa fa-linkedin fa-stack-1x fa-inverse"></i>
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a class="social_link pinterest" href="#" target="_blank">
                                    <span class="fa-stack fa-lg pint">
                                        <i class="fa fa-circle fa-stack-2x"></i>
                                        <i class="fa fa-pinterest-p fa-stack-1x fa-inverse"></i>
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a class="social_link " href="#" target="_blank">
                                    <span class="fa-stack fa-lg camera">
                                        <i class="fa fa-circle fa-stack-2x"></i>
                                        <i class="fa fa-camera-retro fa-stack-1x fa-inverse"></i>
                                    </span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>

        </div>
    </div>
</div>
<div class="clearfix"></div>
