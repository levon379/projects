<script type="text/javascript">Stripe.setPublishableKey('<?php echo $payment_config['publishable_key'] ?>');</script>
<div class="admin_section">
    <div class="row">
        <div class="col-lg-12">
            <div  class="text-center">
                <h3>Complete Order</h3>
                <p class="margin_top_35 txt_middle">In order to complete your order please provide us with your payment details </p>
                <div class="steps">
                    <ul>
                        <li>
                            <span class="badge social_step_checked">
                                <img src="<?php echo $base_url ?>assets/admin/img/social_step_checked.png" />
                            </span>
                        </li>
                        <li class="steps_border comp_order_steps_border">
                        </li>
                        <li>
                            <span class="badge active">2</span>
                        </li>
                        <li class="steps_border comp_order_steps_border">
                        </li>
                        <li>
                            <span class="badge">3</span>
                        </li>
                    </ul>
                    <ul class="step_text">
                        <li class="comp_order_circle_left">
                            <a href="#">Choose Design</a>
                        </li>
                        <li class="comp_order_circle_center">
                            <a class="style_clr" href="#">Complete Order</a>
                        </li>
                        <li class="comp_order_circle_right">
                            <a href="#">Order Confirmation</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="panel account_content margin_top_35">
                <div class="col-sm-6">
                    <h3>Order Summary</h3>
                    <hr class="comp_order_pink_hr">

                    <div class="margin_top_20">
                        <ul class="list-inline">
                            <li>
                                <a href="#">
                                    <img src="<?php echo $base_url ?>assets/admin/img/social_fb_logo.png" alt="">
                                </a>
                            </li>
                            <li>Facebook Set Up</li>
                            <li class="pull-right">$15</li>
                        </ul>
                    </div>
                    <hr class="complete_account_hr_grey">

                    <div class="margin_top_20 ">
                        <ul class="list-inline">
                            <li>
                                <a href="#">
                                    <img src="<?php echo $base_url ?>assets/admin/img/social_fb_logo.png" alt="">
                                </a>
                            </li>
                            <li>Facebook Custom Design</li>
                            <li class="pull-right">Included</li>
                        </ul>
                    </div>
                    <hr class="complete_account_hr_grey">
                    <div class="margin_top_20 ">
                        <ul class="list-inline">
                            <li></li>
                            <li>Total</li>
                            <li class="pull-right ral_bold style_clr">$15</li>
                        </ul>
                    </div>

                </div>
                <div class="col-sm-6">
                    <h3>Payment Details</h3>
                    <hr class="comp_order_pink_hr">
                    <form class="form-group">
                        <label>Card Holder</label>
                        <input type="text" name="cardHolder" class="form-control">
                    </form>
                    <form class="form-group">
                        <label>Card Number</label>
                        <input type="text" name="cardNumber"  class="form-control">
                    </form>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <form class="form-group">
                                    <label>Expire Date</label>
                                    <select name="month" class="selectpicker btn-block">
                                        <option value="">Month</option>
                                        <option value="july">July</option>
                                        <option value="august">August</option>
                                    </select>
                                </form>
                            </div>
                            <div class="col-md-6">
                                <form class="form-group">
                                    <label>&nbsp</label>
                                    <select name="year" class="selectpicker btn-block">
                                        <option value="">Year</option>
                                        <option value="2015">2015</option>
                                        <option value="2014">2014</option>
                                    </select>
                                </form>
                            </div>
                        </div> 
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <form class="form-group ">
                                <label>Card Security Code</label><br>
                                <input type="text" name="securityCode" class="form-control complete_order_ecurity_code_w100p">
                            </form>
                        </div>
                    </div>
                    <div class="margin_top_20 text-left">
                        <a href="#" class="btn btn-lg btn-primary get_started btn_">Make the Payment</a>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>

    </div>
</div>
<div class="clearfix"></div>