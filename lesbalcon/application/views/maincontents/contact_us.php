<script>
function validate_contact_form()
{
	var error=0;
	if($("#contact_name").val().trim()=="")
	{
		$("#name_error_text").html("<?php echo lang('Name_is_required'); ?>");
		$("#name_error_div").show();
		error++;
	}
	else 
	{
		$("#name_error_text").html("");
		$("#name_error_div").hide();
	}
	if($("#contact_email").val().trim()=="")
	{
		$("#email_error_text").html("<?php echo lang('Email_is_required'); ?>");
		$("#email_error_div").show();
		error++;
	}
	else 
	{
		var email=$("#contact_email").val();
		var reg = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
		if (!reg.test(email)) 
		{	
			$("#email_error_text").html("<?php echo lang('Please_enter_valid_email_address') ?>");
			$("#email_error_div").show();
			error++;
		}
		else 
		{
			$("#email_error_text").html("");
			$("#email_error_div").hide();
		}
	}
	if($("#contact_phone").val().trim()=="")
	{
		$("#phone_error_text").html("<?php echo lang('Contact_no_is_required'); ?>");
		$("#phone_error_div").show();
		error++;
	}
	else 
	{
		$("#phone_error_text").html("");
		$("#phone_error_div").hide();
	}
	if($("#contact_comment").val().trim()=="")
	{
		$("#comment_error_text").html("<?php echo lang('Comment_is_required'); ?>");
		$("#comment_error_div").show();
		error++;
	}
	else 
	{
		$("#comment_error_text").html("");
		$("#comment_error_div").hide();
	}
	if(error>0)
	{
		$(window).scrollTop($("#contact_form").offset().top);
		return false;
	}
}
function validate_numbers(value, text_field_id)
{	
	if(value.match(/[^0-9]/g))
	{	
		document.getElementById(text_field_id).value=value.replace(/[^0-9]/g, '');
    }
}
function val_change()
{
	$("#check_val").val(200);
}
</script>
<div class="row">
	<div class="inner-page-banner"> <img class="img-responsive" src="<?php echo base_url(); ?>assets/frontend/images/about-us-banner.jpg" alt=""></div>
</div>
<!--banner end-->
<div class="row gallerypage-section" id="contact_form">
	<div class="container">
		<h2 class="bunglow-heading"><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-2-left.png" alt=""><?php echo lang('Contact_Us'); ?><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-2-right.png" alt=""></h2>
		<div class="inner-content">
				<h3 style="text-align:center; color:red;">
					<?php
					if(isset($success_message))
					{
						echo lang($success_message);
					}
					?>
				</h3>
      			<div class="col-md-7">
				<div class="contact_info">
				<p><label>Adress:</label>15 avenue du lagon, Oyster-Pond ,97150 Saint -Martin</p>
				<p><label><?php echo lang('Phone'); ?>:</label> (00159) or (0059) 0590 29 43 39</p>
				<p><label><?php echo lang('Emailer'); ?>:</label>lesbalcons@lesbalcons.com</p>
				<p><label><?php echo lang('Faxer'); ?>:</label>(01133) or (0033)1.72.70.35.05 or 01.72.70.35.05</p>
				</div>
                	<form class="form-contact form-horizontal" action="" method="POST" onsubmit="return validate_contact_form()">
                    <fieldset>
					<input type="hidden" name="middle_name" value="" />
					<input type="hidden" name="check_val" id="check_val" value="100" />
					<input type="hidden" name="mail_submit" value="true" />
                    <!-- Text input-->
                    <div class="form-row form-group">
                      <div class="col-md-3">
                      <label><?php echo lang('Name'); ?><span style="color:red;">*</span> :</label>
                      </div>
                      <div class="col-md-9">
                      <input id="contact_name" name="contact_name" class="login-input testi-input form-control input-md" type="text">
					  <div class="errormsg" id="name_error_div" style="display:none;"><span id="name_error_text"></span></div>
                      </div>
                    </div>
                     <!-- Text input-->
                    <div class="form-row form-group">
                      <div class="col-md-3">
                      <label>Email<span style="color:red;">*</span> :</label>
                      </div>
                      <div class="col-md-9">
                      <input id="contact_email" name="contact_email" class="login-input testi-input form-control input-md" type="text" onclick="return val_change();">
					  <div class="errormsg" id="email_error_div" style="display:none;"><span id="email_error_text"></span></div>
                      </div>
                    </div>
                    
                    <div class="form-row form-group">
                      <div class="col-md-3">
                      <label><?php echo lang('Contact_no'); ?><span style="color:red;">*</span> :</label>
                      </div>
                      <div class="col-md-9">
                      <input id="contact_phone" name="contact_phone" class="login-input testi-input form-control input-md" type="text" onkeyup="validate_numbers(this.value, 'contact_phone')">
					  <div class="errormsg" id="phone_error_div" style="display:none;"><span id="phone_error_text"></span></div>
                      </div>
                    </div>
                    
                     <div class="form-row form-group">
                      <div class="col-md-3">
                      <label><?php echo lang('Comments'); ?><span style="color:red;">*</span> :</label>
                      </div>
                      <div class="col-md-9">
                       <textarea id="contact_comment" name="contact_comment" class="contact-textar testi-textarea form-control"></textarea>
					   <div class="errormsg" id="comment_error_div" style="display:none;"><span id="comment_error_text"></span></div>
                      </div>
                    </div>
                    
                    <!-- Button -->
                    <div class="form-row form-group">
                      <div class="col-md-12">
                         <input id="textinput" name="submit_contact" class="submit-button btn btn-default nw_btn" type="submit" style="float:right" value="<?php echo lang('Send'); ?>">
                      </div>
                    </div>
                    
                    </fieldset>
                    </form>
                </div>
                <div class="col-md-5">
                <div class="contact_map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3793.299734101312!2d-63.017265099999996!3d18.057673800000003!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8c0e6fd5a97c4453%3A0xac5e78af3b054b33!2sAvenue+du+lagon%2C+St+Martin!5e0!3m2!1sen!2s!4v1435083281001" width="100%" height="300" frameborder="0" style="border:0"></iframe>
                </div>
                </div>
      	</div>
	</div>
 </div>
