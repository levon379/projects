<script type="text/javascript">Stripe.setPublishableKey('<?php echo $payment_config['publishable_key'] ?>');</script>
<div  class="text-center">
                <h3>Choose a Page Design</h3>
                <p class="margin_top_35 txt_middle">Once you have a chosen a design you like our design team will set about tailoring it to your business needs </p>
                <div class="steps">
                    <ul>
                        <li>
                            <span class="badge active">1</span>
                        </li>
                        <li class="steps_border comp_order_steps_border">
                        </li>
                        <li>
                            <span class="badge">2</span>
                        </li>
                        <li class="steps_border comp_order_steps_border">
                        </li>
                        <li>
                            <span class="badge">3</span>
                        </li>
                    </ul>
                    <ul class="step_text">
                        <li class="comp_order_circle_left">
                            <a class="style_clr" href="javascript:void(0)">Choose Design</a>
                        </li>
                        <li class="comp_order_circle_center">
                            <a href="javascript:void(0)">Complete Order</a>
                        </li>
                        <li class="comp_order_circle_right">
                            <a href="javascript:void(0)">Order Confirmation</a>
                        </li>
                    </ul>

                    <div class="margin_top_80 text-center">
                        <a href="javascript:void(0)">
                            <img id="choosed_design" src="<?php echo $base_url  ?>assets/admin/products/bar_design_icon.png" />
                            <img class="design_common_part" src="<?php echo $base_url  ?>assets/admin/products/design_common_part.png" />
                        </a>
                    </div>

                    <div class="margin_top_20 text-center">
                        <a href="javascript:void(0)" class="btn btn-lg btn-primary get_started btn_ letter_spacing_2 design_choose_btn">
                            &nbsp;&nbsp;&nbsp;Select This Design&nbsp;&nbsp;&nbsp;
                        </a>
                    </div>
                </div>
            </div>
            <div class="panel account_content margin_top_35">
               
                <div class="col-md-12">
                    <div class="col-sm-4">
                        <div class="margin_top_20 text-center">
                            <a href="javascript:void(0)" class="choose_design"><img src="<?php echo $base_url  ?>assets/admin/products/hotel_design_icon.png" /></a>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="margin_top_20 text-center selected_design_icon">
                            <a href="javascript:void(0)" class="choose_design"><img src="<?php echo $base_url  ?>assets/admin/products/bar_design_icon.png" /></a>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="margin_top_20 text-center">
                            <a href="javascript:void(0)" class="choose_design"><img src="<?php echo $base_url  ?>assets/admin/products/danceClasses_design_icon.png" /></a>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                
                
                <div class="col-md-12">
                    <div class="col-sm-4">
                        <div class="margin_top_20 text-center">
                            <a href="javascript:void(0)" class="choose_design"><img src="<?php echo $base_url  ?>assets/admin/products/pilates_design_icon.png" /></a>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="margin_top_20 text-center">
                            <a href="javascript:void(0)" class="choose_design"><img src="<?php echo $base_url  ?>assets/admin/products/recruitment_design_icon.png" /></a>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="margin_top_20 text-center">
                            <a href="javascript:void(0)" class="choose_design"><img src="<?php echo $base_url  ?>assets/admin/products/yoga_design_icon.png" /></a>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="col-md-12">
                    <div class="col-sm-4">
                        <div class="margin_top_20 text-center">
                            <a href="javascript:void(0)" class="choose_design"><img src="<?php echo $base_url  ?>assets/admin/products/solictors_design_icon.png" /></a>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="margin_top_20 text-center">
                            <a href="javascript:void(0)" class="choose_design"><img src="<?php echo $base_url  ?>assets/admin/products/holiday_design_icon.png" /></a>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="margin_top_20 text-center">
                            <a href="javascript:void(0)" class="choose_design"><img src="<?php echo $base_url  ?>assets/admin/products/travel_design_icon.png" /></a>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>

            </div>
        </div>

    </div>
</div>
<div class="clearfix"></div>
<script type="text/javascript">
        $(".choose_design").on("click", function(){
            var img_src = $(this).find("img").attr("src");
            $("#choosed_design").attr("src", img_src);
            $(".margin_top_20").removeClass("selected_design_icon");
            $(this).parent().addClass("selected_design_icon");
        });
    </script>