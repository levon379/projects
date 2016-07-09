<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php echo lang('Change Password');?>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url(); ?>admin"><i class="fa fa-dashboard"></i> <?php echo lang('Home');?></a></li>
		<li class="active"><?php echo lang('Change Password');?></li>
	</ol>
</section>
<script>
	function check_form()
	{
		var error=0;
		if($("#old_password").val().trim()=="")
		{
			$("#old_password_error").show();
			error++;
		}
		else 
		{
			$("#old_password_error").hide();
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

<!-- Main content -->
<section class="content">
	<?php
	if($success_message)
	{
		?>
		<div class="alert alert-success alert-dismissable">
			<i class="fa fa-check"></i>
			<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
			<b><?php echo $success_message; ?></b>
		</div>
		
		<?php
	}
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
	if(isset($_GET["notexist"]))
	{
		?>
		<div class="alert alert-danger alert-dismissable">
			<i class="fa fa-ban"></i>
			<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
			<b><?php echo "Current Password does not exists."; ?></b>
		</div>
		<?php
	}
	?>
	<div class="row">
		<div class="col-md-11">
			<!-- general form elements -->
			<div class="box box-primary">
				<!--<div class="box-header">
					<h3 class="box-title">Quick Example</h3>
				</div>-->
				<!-- form start -->
				<form role="form" id="form" action="<?php echo base_url(); ?>admin/change_password/change_pass" method="POST" onsubmit="return check_form()">
					<div class="box-body">
						<div class="form-group">
							<label for="exampleInputEmail1"><?php echo lang('CURRENT PASSWORD');?><span style="color:red">*</span></label>
							<input type="password" name="old_password" id="old_password" class="form-control" id="exampleInputEmail1" placeholder="Current Password" value="">
							<div class="form-group has-error" id="old_password_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> <?php echo lang('Current Password field is required');?></i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1"><?php echo lang('NEW PASSWORD');?><span style="color:red">*</span></label>
							<input type="password" name="new_password" id="new_password" class="form-control" id="exampleInputPassword1" placeholder="New Password" value="">
							<div class="form-group has-error" id="new_password_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> <?php echo lang('New Password field is required');?></i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1"><?php echo lang('CONFIRM PASSWORD');?><span style="color:red">*</span></label>
							<input type="password" name="confirm_password" id="confirm_password" class="form-control" id="exampleInputPassword1" placeholder="Confirm Password" value="">
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