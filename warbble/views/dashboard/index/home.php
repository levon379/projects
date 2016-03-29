<script type="text/javascript">Stripe.setPublishableKey('<?php echo $payment_config['publishable_key'] ?>');</script>
<div  class="text-center">
    <h3>Setup Your Page</h3>
    <p class="margin_top_35 txt_middle">Tell us a few key facts about your business and we'll be ready to start connecting your account </p>
    <div class="steps">
        <ul>
            <li>
                <span class="badge active">1</span>
            </li>
            <li class="steps_border">
            </li>
            <li><span class="badge">2</span>
            </li>
        </ul>
        <ul class="step_text">
            <li>
                <a class="style_clr" href="#">Add Information</a>
            </li>
            <li>
                <a href="#">Connect Account</a>
            </li>
        </ul>
    </div>
</div>


</div> <!--text center -->
<div class="panel account_content margin_top_35">
    <form id="page-info-form" method="post">
        <input type="hidden" name="PageInfo[type]" id="PageInfo_type"/>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Business Name <span>*</span></label>
                <input type="text" name="PageInfo[business_name]" class="form-control" value="<?= $current_user->first_name . " " . $current_user->last_name; ?>">
            </div>
            <div class="form-group">
                <label> Street Address <span>*</span></label>
                <input type="text" name="PageInfo[street_address]" class="form-control">
            </div>
            <div class="form-group">
                <label>City <span>*</span></label>
                <input type="text" name="PageInfo[city]" class="form-control">
            </div>
            <div class="form-group">
                <label>Country <span>*</span></label>
                <input type="text" name="PageInfo[country]" class="form-control" >
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Business Category <span>*</span></label>
                <select name="PageInfo[business_category]" id="PageInfo_business_category" class="selectpicker btn-block">
                    <option value="">Please Select</option>
                </select>
            </div>
            <div class="form-group">
                <label>Postcode</label>
                <input type="text" name="PageInfo[postcode]" class="form-control" >
            </div>
            <div class="form-group">
                <label>Phone Number<span>*</span></label>
                <input type="text" name="PageInfo[phone_number]" class="form-control">
            </div>
            <div class="form-group">
                <label>Website</label>
                <input type="text" name="PageInfo[website]" class="form-control" value="<?= $current_user->website ? $current_user->website : '' ?>">
            </div>
        </div>
        <p class="pull-right sm_txt">*Required details</p>
        <div class="clearfix"></div>
        <div class="margin_top_20 text-center">
            <a href="javascript:void(0)" class="btn btn-lg step1_submit btn-primary get_started btn_" id="add_information">Let’s Get Started</a>
        </div>
    </form>
</div>
</div> <!--Content right -->

</div>
</div>
<div class="clearfix"></div>

