<script>
function check_register_form()
{
	var error=0
	if($("#user_language").val()=="")
	{
		$("#user_language_err").html("<?php echo lang('Language_is_required'); ?>");
		error++;
	}
	else 
	{
		$("#user_language_err").html("");
	}
	if($("#user_name").val().trim()=="")
	{
		$("#name_error").html("<?php echo lang('Name_is_required'); ?>");
		error++;
	}
	else 
	{
		$("#name_error").html("");
	}
	if($("#user_email").val().trim()=="")
	{
		$("#email_error").html("<?php echo lang('Email_is_required'); ?>");
		error++;
	}
	else 
	{
		var email=$("#user_email").val();
		var reg = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
		if (!reg.test(email)) 
		{	
			$("#email_error").html("<?php echo lang('Please_enter_valid_email_address') ?>");
			error++;
		}
		else 
		{
			$("#email_error").html("");
		}
	}
	if($("#user_password").val().trim()=="")
	{
		$("#password_error").html("<?php echo lang('Password_is_required'); ?>");
		error++;
	}
	else 
	{
		$("#password_error").html("");
	}
	if($("#conf_password").val().trim()=="")
	{
		$("#conf_password_error").html("<?php echo lang('Confirm_Password_is_required'); ?>");
		error++;
	}
	else 
	{
		if($("#user_password").val()!=$("#conf_password").val())
		{
			$("#conf_password_error").html("<?php echo lang('Password_does_not_match'); ?>");
			error++;
		}
		else 
		{
			$("#conf_password_error").html("");
		}
	}
	if($("#user_contact").val().trim()=="")
	{
		$("#contact_error").html("<?php echo lang('Contact_no_is_required'); ?>");
		error++;
	}
	else 
	{
		$("#contact_error").html("");
	}
	if($("#user_address").val().trim()=="")
	{
		$("#address_error").html("<?php echo lang('Address_is_required'); ?>");
		error++;
	}
	else 
	{
		$("#address_error").html("");
	}
	if(error>0)
	{
		$(window).scrollTop($("#registration_div").offset().top);
		return false;
	}
}
</script>
<?php 
//If user does not exist while facebook login then details will be placed into registration field
if($this->session->userdata("facebook_reg_details"))
{ 
	$facebook_reg_details=$this->session->userdata("facebook_reg_details");
	$facebook_reg_name=$facebook_reg_details['facebook_reg_name'];
	$facebook_reg_email=$facebook_reg_details['facebook_reg_email'];
} 
?>
<div class="row">
	<div class="inner-page-banner"> <img src="<?php echo base_url(); ?>assets/frontend/images/about-us-banner.jpg" alt=""></div>
</div>
<!--banner end-->
<div class="row innerpage-section">
	<div class="container">
		<h2><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-left.png" alt=""><?php echo lang('REGISTRATION'); ?><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-right.png" alt=""></h2>
		<div class="row inner-content" id="registration_div">
			<div class="popup-overlay" style="z-index:999;"></div>
				<?php
				if(isset($error_message))
				{
					if($error_message == "User_already_exist") {
						?>
						<script type="text/javascript">
							$("html").attr("class","overlay");
						</script>
						<div id="example-popup" class="popup visible">
							<div class="popup-body">	
							<span class="popup-exit" onclick='$("#example-popup").attr("class","popup"); $("html").attr("class","");'></span>
							<div class="popup-content">
								<?php if($this->session->userdata('current_lang_id') == "1"){ ?>
								<h2 class="popup-title">Already Registered</h2>
								<label style="margin-top:5px;">If your email is already registered, please <span style="text-decoration:underline"><a href="http://dev.caribwebservices.com/projects/lesbalcons/user/forgot_password">click here</a></span> to generate a new one.</label>
								<?php } else{ ?> 
								<h2 class="popup-title">Déjà Membre</h2>
								<label style="margin-top:5px;">Si votre email est déjà enregistré, merci de régénérer un nouveau mot de passe en <span style="text-decoration:underline"><a href="http://dev.caribwebservices.com/projects/lesbalcons/user/forgot_password">cliquant ici</a></span>.</label>
								<?php } ?>
							</div>
							</div>
						</div>
						<?php
					}
					else echo '<h3 style="text-align:center; color:red;">'.lang($error_message).'</h3>';
				}
				?>
			
      		<div class="login_block">
				<form class="form-login form-horizontal" action="" onsubmit="return check_register_form()" method="POST">
                    <fieldset>
						<input type="hidden" value="<?php if($this->session->userdata("facebook_reg_details")){ echo "F"; }else{ echo "N"; } ?>" name="user_type" id="user_type">
						<div class="form-row form-group"> 
						  <div class="col-md-3"> 
						  <label><?php echo lang('Language'); ?><span style="color:red;">*<span></label>
						  </div>
						  <div class="col-md-9">
							<select name="user_language" id="user_language" class="login-input testi-input form-control input-md">
								<option value="">--<?php echo lang('Select'); ?>--</option>
								<?php 
								foreach($languages as $value)
								{
									?>
									<option value="<?php echo $value['id'] ?>" <?php if($this->session->userdata('current_lang_id')==$value['id']){ echo "selected"; } ?>><?php echo $value['language_name'] ?></option>
									<?php 
								}
								?>
							</select>
							<div class="errormsg"><span id="user_language_err"></span></div>
						  </div>
						</div>
					
						<!-- Text input-->
						<div class="form-row form-group">
						  <div class="col-md-3">
						  <label><?php echo lang('Name'); ?><span style="color:red;">*<span></label>
						  </div>
						  <div class="col-md-9">
							<input id="user_name" name="user_name" class="login-input testi-input form-control input-md" type="text" value="<?php if(isset($facebook_reg_name)){ echo $facebook_reg_name; } ?>">
							<div class="errormsg"><span id="name_error"></span></div>
						  </div>
						</div>
						
						 <!-- Text input-->
						<div class="form-row form-group">
						  <div class="col-md-3">
						  <label>Email<span style="color:red;">*<span></label>
						  </div>
						  <div class="col-md-9">
							<input id="user_email" name="user_email" class="login-input testi-input form-control input-md" type="text" value="<?php if(isset($facebook_reg_email)){ echo $facebook_reg_email; } ?>">
							<div class="errormsg"><span id="email_error"></span></div>
						  </div>
						</div>
                    
						<div class="form-row form-group">
						  <div class="col-md-3">
						  <label><?php echo lang('Password'); ?><span style="color:red;">*<span></label>
						  </div>
						  <div class="col-md-9">
						  <input id="user_password" name="user_password" class="login-input testi-input form-control input-md" type="password">
						  <div class="errormsg"><span id="password_error"></span></div>
						  </div>
						</div>
                    
						<div class="form-row form-group">
						  <div class="col-md-3">
						  <label><?php echo lang('Confirm_Password'); ?><span style="color:red;">*<span></label>
						  </div>
						  <div class="col-md-9">
						  <input id="conf_password" name="conf_password" class="login-input testi-input form-control input-md" type="password">
						  <div class="errormsg"><span id="conf_password_error"></span></div>
						  </div>
						</div>
                    
						<div class="form-row form-group">
						  <div class="col-md-3">
						  <label><?php echo lang('Contact_no'); ?><span style="color:red;">*<span></label>
						  </div>
						  <div class="col-md-9">
						  <input id="user_contact" name="user_contact" class="login-input testi-input form-control input-md" type="text">
						   <div class="errormsg"><span id="contact_error"></span></div>
						  </div>
						</div>
                    
						<div class="form-row form-group">
						  <div class="col-md-3">
						  <label><?php echo lang('Address'); ?><span style="color:red;">*<span></label>
						  </div>
						  <div class="col-md-9">
						   <textarea class="contact-textar testi-textarea form-control" name="user_address" id="user_address"></textarea>
						   <div class="errormsg"><span id="address_error"></span></div>
						  </div>
						</div>
						
						<div class="form-row form-group">
						  <div class="col-md-3">
						  <label><?php echo lang('About_me'); ?></label>
						  </div>
						  <div class="col-md-9">
						   <textarea class="contact-textar testi-textarea form-control" name="user_notes" id="user_notes"></textarea>
						  </div>
						</div>

						<!-- Button -->
						<div class="form-row form-group">
						  <div class="col-md-12">
							 <input id="textinput" name="register" class="submit-button btn btn-default" type="submit" style="float:right" value="<?php if($this->session->userdata('current_lang_id') == "1") echo "Register"; else echo "S'enregistrer"; ?>">
						  </div>
						</div>
                    </fieldset>
				</form>
			</div>
		</div>
	</div>
 </div>
