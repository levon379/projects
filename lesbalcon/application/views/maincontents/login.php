<script>
function check_login_form()
{
	var error=0
	if($("#login_email").val()=="")
	{
		$("#login_email_error").html("<?php echo lang('Email_is_required'); ?>");
		error++;
	}
	else 
	{
		var email=$("#login_email").val();
		var reg = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
		if (!reg.test(email)) 
		{	
			$("#login_email_error").html("<?php echo lang('Please_enter_valid_email_address') ?>");
			error++;
		}
		else 
		{
			$("#login_email_error").html("");
		}
	}
	if($("#login_password").val()=="")
	{
		$("#login_password_error").html("<?php echo lang('Password_is_required'); ?>");
		error++;
	}
	else 
	{
		$("#login_password_error").html("");
	}
	if(error>0)
	{
		$(window).scrollTop($("#login_div").offset().top);
		return false;
	}
}
</script>
<div class="row">
	<div class="inner-page-banner"> <img src="<?php echo base_url(); ?>assets/frontend/images/about-us-banner.jpg" alt=""></div>
</div>
<!--banner end-->
<div class="row innerpage-section" id="login_div">
	<div class="container">
		<h2><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-left.png" alt=""><?php echo lang('LOGIN'); ?><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-right.png" alt=""></h2>
		<div class="form-row form-group">
                      <div class="col-md-12">
                      <label style="max-width:610px;
  margin: 15px auto;
  display: block;
  text-align: center;"><?php echo lang('Login_text'); ?></label></div></div>
		<div class="row inner-content" style="padding-top:66px;">
				<h3 style="text-align:center; color:red;">
					<?php
					if(isset($error_message))
					{
						echo $error_message;
					}
					?>
				</h3>
      			<div class="login_block">
      				 <br/>
      				 <!--div class="form-row form-group">
                      <div class="col-md-12">
                      <label><?php echo lang('Login_text'); ?></label></div></div-->

                     
                	<form class="form-login form-horizontal" action="" method="POST" onsubmit="return check_login_form()">
                    <fieldset>
                    <!-- Text input-->
                    <div class="form-row form-group">
                      <div class="col-md-3">
                      <label><?php echo lang('Email'); ?><span style="color:red;">*</span></label>
                      </div>
                      <div class="col-md-9">
                      <input id="login_email" name="login_email" class="login-input testi-input form-control input-md" type="text" value="<?php echo $this->input->post("login_email"); ?>">
					  <div class="errormsg"><span id="login_email_error"></span></div>
                      </div>
                    </div>
                     <!-- Text input-->
                    <div class="form-row form-group">
                      <div class="col-md-3">
                      <label><?php echo lang('Password'); ?><span style="color:red;">*</span></label>
                      </div>
                      <div class="col-md-9">
						<input id="login_password" name="login_password" class="login-input testi-input form-control input-md" type="password">
						<div class="errormsg"><span id="login_password_error"></span></div>
                      </div>
                    </div>
                    
                    <!-- Button -->
                    <div class="form-row form-group">
                      <div class="col-md-8">
                        <a style="font-size:15px !important;" href="<?php echo base_url(); ?>user/forgot_password" class="link-form btn btn-default"><?php echo lang('FORGOT_PASSWORD'); ?></a> | <a style="font-size:15px !important;" href="<?php echo base_url(); ?>user/registration" class="link-form btn btn-default"><?php echo lang('REGISTER_HERE'); ?></a>
                      </div>
                      <div class="col-md-4">
                         <input id="textinput" name="login" class="submit-button btn btn-default" type="submit" style="float:right" value="<?php echo lang('Next'); ?>">
                      </div>
                    </div>
                    
                    </fieldset>
                    </form>
                </div>
      	</div>
	</div>
 </div>
