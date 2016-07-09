<script>
function check_register_form()
{
	var error=0;
	if($("#user_language").val()=="")
	{
		$("#user_language_err").html("<?php echo lang('Language_Type_is_required'); ?>");
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
		$(window).scrollTop($("#my_profile_div").offset().top);
		return false;
	}
}
</script>
<div class="row">
	<div class="inner-page-banner"><img class="img-responsive" src="<?php echo base_url(); ?>assets/frontend/images/about-us-banner.jpg" alt=""></div>
</div>
<!--banner end-->
<div class="row innerpage-section">
	<div class="container">
		<h2><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-left.png" alt=""><?php echo lang('My_Profile'); ?><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-right.png" alt=""></h2>
		<div class="tabs-holder">
			<ul class="my_tab_menu">
				<li><a class="active_user" href="<?php echo base_url(); ?>user/my_profile"><?php echo lang('My_Profile'); ?></a></li>
				<li><a href="<?php echo base_url(); ?>user/my_booking"><?php echo lang('My_Bookings'); ?></a></li>
				<li><a href="<?php echo base_url(); ?>user/my_mails"><?php echo lang('My_Mails'); ?></a></li>
				<li><a href="<?php echo base_url(); ?>user/change_password"><?php echo lang('Change_Password'); ?></a></li>
				<li><a href="<?php echo base_url(); ?>user/logout"><?php echo lang('Logout'); ?></a></li>
			</ul>
		</div>
		<div class="row inner-content" id="my_profile_div">
			<h3 style="text-align:center; color:red;">
				<?php
				if(isset($error_message))
				{
					echo lang($error_message);
				}
				?>
			</h3>
            <div class="login_block">
				<form class="form-login form-horizontal" action="" onsubmit="return check_register_form()" method="POST">
                    <fieldset>
						<div class="form-row form-group">
						  <div class="col-md-3">
						  <label><?php echo lang('Language_type'); ?><span style="color:red;">*<span></label>
						  </div>
						  <div class="col-md-9">
							<select name="user_language" id="user_language" class="login-input testi-input form-control input-md">
								<option value="">--<?php echo lang('Select'); ?>--</option>
								<?php 
								foreach($languages as $value)
								{
									?>
									<option value="<?php echo $value['id'] ?>" <?php if($user_details[0]['user_language']==$value['id']){ echo "selected"; } ?>><?php echo $value['language_name'] ?></option>
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
							<input id="user_name" name="user_name" class="login-input testi-input form-control input-md" type="text" value="<?php echo $user_details[0]['name'] ?>">
							<div class="errormsg"><span id="name_error"></span></div>
						  </div>
						</div>
						
						 <!-- Text input-->
						<div class="form-row form-group">
						  <div class="col-md-3">
						  <label>Email<span style="color:red;">*<span></label>
						  </div>
						  <div class="col-md-9">
							<input id="user_email" name="user_email" class="login-input testi-input form-control input-md" type="text" value="<?php echo $user_details[0]['email'] ?>" readonly>
							<div class="errormsg"><span id="email_error"></span></div>
						  </div>
						</div>

						<div class="form-row form-group">
						  <div class="col-md-3">
						  <label><?php echo lang('Contact_no'); ?><span style="color:red;">*<span></label>
						  </div>
						  <div class="col-md-9">
						  <input id="user_contact" name="user_contact" class="login-input testi-input form-control input-md" type="text" value="<?php echo $user_details[0]['contact_number'] ?>"> 
						   <div class="errormsg"><span id="contact_error"></span></div>
						  </div>
						</div>
                    
						<div class="form-row form-group">
						  <div class="col-md-3">
						  <label><?php echo lang('Address'); ?><span style="color:red;">*<span></label>
						  </div>
						  <div class="col-md-9">
						   <textarea class="contact-textar testi-textarea form-control" name="user_address" id="user_address" ><?php echo $user_details[0]['address'] ?></textarea>
						   <div class="errormsg"><span id="address_error"></span></div>
						  </div>
						</div>
						
						<div class="form-row form-group">
						  <div class="col-md-3">
						  <label><?php echo lang('About_me'); ?></label>
						  </div>
						  <div class="col-md-9">
						   <textarea class="contact-textar testi-textarea form-control" name="user_notes" id="user_notes"><?php echo $user_details[0]['notes'] ?></textarea>
						  </div>
						</div>

						<!-- Button -->
						<div class="form-row form-group">
						  <div class="col-md-12">
							 <input id="textinput" name="update" class="submit-button btn btn-default" type="submit" style="float:right" value="<?php echo lang("Next"); ?>">
						  </div>
						</div>
                    </fieldset>
				</form>
			</div>
        </div>
	</div>
 </div>
