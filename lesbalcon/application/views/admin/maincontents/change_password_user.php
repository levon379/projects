<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php echo lang('Change Password for User');?>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url(); ?>admin"><i class="fa fa-dashboard"></i> <?php echo lang('Home');?></a></li>
		<li class="active"><?php echo lang('Change Password for User');?></li>
	</ol>
</section>
<script>
	function generate_password()
	{
		$.post("<?php echo base_url(); ?>admin/users/get_new_password", function(data){
			$("#new_password").val(data.trim());
		})
	}
	function check_form()
	{
		var error=0;
		if($("#email_address").val().trim()=="")
		{
			$("#email_address_error").show();
			error++;
		}
		else if($("#email_address").val()!="")
		{
			var email=$("#email_address").val();
			var reg = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
			if (!reg.test(email)) 
			{	
				$("#email_address_error_text").html(" Enter valid email address");
				$("#email_address_error").show();
				error++;
			}
			else 
			{
				$("#user_email_error_text").html(" Email Address field is required");
				$("#email_address_error").hide();
			}
		}
		if($("#new_password").val().trim()=="")
		{
			$("#new_password_error").show();
			error++;
		}
		else 
		{
			$("#new_password_error").hide();
		}
		if($("#confirm_password").val().trim()=="")
		{
			$("#confirm_password_error").show();
			error++;
		}
		else 
		{
			if($("#new_password").val()!=$("#confirm_password").val())
			{
				$("#confirm_password_error_text").html("Password does not match");
				$("#confirm_password_error").show();
				error++;
			}
			else 
			{
				$("#confirm_password_error").hide();
			}
		}
		
		if(error>0)
		{
			$(window).scrollTop($("#form").offset().top);
			return false;
		}
	}
</script>
<div class="box_horizontal">
	<a class="btn btn-primary btn-flat" href="<?php echo base_url(); ?>admin/users/list_users"><?php echo lang('Back');?></a>
</div>
<!-- Main content -->
<section class="content">
	<?php
	if(isset($_GET["updated"]))
	{
		?>
		<div class="alert alert-success alert-dismissable">
			<i class="fa fa-check"></i>
			<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
			<b><?php echo "Password updated successfully."; ?></b>
		</div>
		<?php
	}
	?>
	
	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<form role="form" id="form" action="<?php echo base_url(); ?>admin/users/change_password/<?php echo $this->uri->segment(4); ?>" method="POST" onsubmit="return check_form()">
					<div class="box-body">
						<div class="form-group">
							<label for="exampleInputEmail1"><?php echo lang('Email');?><span style="color:red">*</span></label>
							<input type="text" name="email_address" id="email_address" class="form-control" id="exampleInputEmail1" placeholder="Email Address" readonly value="<?php echo $user_details[0]['email']; ?>">
							<div class="form-group has-error" id="email_address_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o" id="email_address_error_text"> <?php echo lang('Email Address field is required');?></i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1"><?php echo lang('New_Password');?><span style="color:red">*</span></label>
							<input type="text" name="new_password" id="new_password" class="form-control" id="exampleInputPassword1" placeholder="New Password" value="">
							<label style="background-color:#367fa9; margin-top:5px; text-align:center; width:150px; float:right;">
								<a style="cursor:pointer; color:#fff; text-decoration:none;" onclick="generate_password()"><?php echo lang('Generate Password');?></a>
							</label>
							<div class="form-group has-error" id="new_password_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> <?php echo lang('New Password field is required');?></i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1"><?php echo lang('Confirm_Password');?><span style="color:red">*</span></label>
							<input type="text" name="confirm_password" id="confirm_password" class="form-control" id="exampleInputPassword1" placeholder="Confirm Password" value="">
							<div class="form-group has-error" id="confirm_password_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o" id="confirm_password_error_text"> <?php echo lang('Confirm Password field is required');?></i>
								</label>
							</div>
						</div>
					</div><!-- /.box-body -->
					<div class="box-footer">
						<input type="submit" class="btn btn-primary" name="save" value="<?php echo lang('Submit');?>">
					</div>
				</form>
			</div><!-- /.box -->
		</div>
	</div>   <!-- /.row -->
</section><!-- /.content -->