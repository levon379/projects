<script>
	function check_form()
	{
		var error=0;
		if($("#old_password").val().trim()=="")
		{
			$("#old_password_error").html("<?php echo lang("Old_Password_is_required") ?>");
			error++;
		}
		else 
		{
			$("#old_password_error").html("");
		}
		if($("#new_password").val().trim()=="")
		{
			$("#new_password_error").html("<?php echo lang("New_Password_is_required") ?>");
			error++;
		}
		else 
		{
			$("#new_password_error").html("");
		}
		if($("#conf_password").val().trim()=="")
		{
			$("#conf_password_error").html("<?php echo lang("Confirm_Password_is_required") ?>");
			error++;
		}
		else 
		{
			if($("#new_password").val()!=$("#conf_password").val())
			{
				$("#conf_password_error").html("<?php echo lang("Password_does_not_match") ?>");
				error++;
			}
			else 
			{
				$("#conf_password_error").hide();
			}
		}
		
		if(error>0)
		{
			$(window).scrollTop($("#form_div").offset().top);
			return false;
		}
	}
</script>
<div class="row">
	<div class="inner-page-banner"><img src="<?php echo base_url(); ?>assets/frontend/images/about-us-banner.jpg" alt=""></div>
</div>
<!--banner end-->
<div class="row innerpage-section">
	<div class="container">
		<h2><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-left.png" alt=""><?php echo lang('Change_Password'); ?><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-right.png" alt=""></h2>
         <div class="tabs-holder">
			<ul class="my_tab_menu">
				<li><a href="<?php echo base_url(); ?>user/my_profile"><?php echo lang('My_Profile'); ?></a></li>
				<li><a href="<?php echo base_url(); ?>user/my_booking"><?php echo lang('My_Bookings'); ?></a></li>
				<li><a href="<?php echo base_url(); ?>user/my_mails"><?php echo lang('My_Mails'); ?></a></li>
				<li><a class="active_user" href="<?php echo base_url(); ?>user/change_password"><?php echo lang('Change_Password'); ?></a></li>
				<li><a href="<?php echo base_url(); ?>user/logout"><?php echo lang('Logout'); ?></a></li>
			</ul>
		</div>
		<div class="row inner-content" id="form_div">
			<h3 style="text-align:center; color:red;">
				<?php
				if(isset($error_message))
				{
					echo lang($error_message);
				}
				?>
			</h3>
      		<div class="login_block">
				<form class="form-login form-horizontal" action="" onsubmit="return check_form()" method="POST">
                    <fieldset>
						 <div class="form-row form-group">
						  <div class="col-md-3">
						  <label><?php echo lang('Old_Password'); ?><span style="color:red;">*<span></label>
						  </div>
						  <div class="col-md-9">
						  <input id="old_password" name="old_password" class="login-input testi-input form-control input-md" type="password">
						  <div class="errormsg"><span id="old_password_error"></span></div>
						  </div>
						</div>
                        
                        <div class="form-row form-group">
						  <div class="col-md-3">
						  <label><?php echo lang('New_Password'); ?><span style="color:red;">*<span></label>
						  </div>
						  <div class="col-md-9">
						  <input id="new_password" name="new_password" class="login-input testi-input form-control input-md" type="password">
						  <div class="errormsg"><span id="new_password_error"></span></div>
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

						<!-- Button -->
						<div class="form-row form-group">
						  <div class="col-md-12">
							 <input id="textinput" name="update" class="submit-button btn btn-default" type="submit" style="float:right" value="Submit">
						  </div>
						</div>
                    </fieldset>
				</form>
			</div>
      </div>
	</div>
 </div>
