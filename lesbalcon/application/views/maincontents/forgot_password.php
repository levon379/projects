<script>
function validate_email_form()
{
	var error=0;
	if($("#forgot_email").val().trim()=="")
	{
		$("#email_error_text").html("<?php echo lang('Email_is_required'); ?>");
		$("#email_error_div").show();
		error++;
	}
	else 
	{
		var email=$("#forgot_email").val();
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
	if(error>0)
	{
		$(window).scrollTop($("#forgot_form").offset().top);
		return false;
	}
}
function val_change()
{
	$("#check_val").val(200);
}
</script>
<div class="row">
	<div class="inner-page-banner"> <img src="<?php echo base_url(); ?>assets/frontend/images/about-us-banner.jpg" alt=""></div>
</div>
<!--banner end-->
<div class="row innerpage-section" id="forgot_form">
	<div class="container">
		<h2><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-left.png" alt=""><?php echo lang('FORGOT_PASSWORD'); ?><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-right.png" alt=""></h2>
		<div class="row inner-content">
		<h3 style="text-align:center; color:red;">
			<?php
			if(isset($success_message))
			{
				echo $success_message;
			}
			?>
		</h3>
		 <div class="login_block">
			<form class="form-login form-horizontal" action=" " method="POST" onsubmit="return validate_email_form()">
			<fieldset>
			<input type="hidden" name="middle_name" value="" />
			<input type="hidden" name="check_val" id="check_val" value="100" />
			<input type="hidden" name="mail_submit" value="true" />
			<!-- Text input-->
			<div class="form-row form-group">
			  <div class="col-md-3">
			  <label><?php echo lang('Enter_Email'); ?><span style="color:red;">*</span></label>
			  </div>
			  <div class="col-md-9">
			  <input id="forgot_email" name="forgot_email" class="login-input testi-input form-control input-md" type="text" onclick="return val_change();">
			  <div class="errormsg" id="email_error_div" style="display:none;"><span id="email_error_text"></span></div>
			  </div>
			</div>
			<!-- Button -->
			<div class="form-row form-group">
			  <div class="col-md-12">
				<input id="textinput" name="forgot_button" class="submit-button btn btn-default" type="submit" style="float:right" value="<?php echo lang('Send'); ?>">
			  </div>
			</div>
			</fieldset>
			</form>
		</div>
      </div>
	</div>
 </div>
