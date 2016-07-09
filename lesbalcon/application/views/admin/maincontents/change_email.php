<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php echo lang('Change Email');?>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url(); ?>admin"><i class="fa fa-dashboard"></i> <?php echo lang('Home');?></a></li>
		<li class="active"><?php echo lang('Change Email');?></li>
	</ol>
</section>
<script>
	function check_form()
	{
		var error=0;
		if($("#old_email").val().trim()=="")
		{
			$("#old_email_error").show();
			error++;
		}
		else 
		{
			$("#old_email_error").hide();
		}
		if($("#new_email").val().trim()=="")
		{
			$("#new_email_error").show();
			error++;
		}
		else 
		{
			$("#new_email_error").hide();
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
			<b><?php echo "Email updated successfully."; ?></b>
		</div>
		<?php
	}
	if(isset($_GET["notexist"]))
	{
		?>
		<div class="alert alert-danger alert-dismissable">
			<i class="fa fa-ban"></i>
			<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
			<b><?php echo "Current Email does not exists."; ?></b>
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
				<form role="form" id="form" action="<?php echo base_url(); ?>admin/change_email/change" method="POST" onsubmit="return check_form()">
					<div class="box-body">
						<div class="form-group">
							<label for="exampleInputEmail1"><?php echo lang('CURRENT EMAIL');?><span style="color:red">*</span></label>
							<input type="text" name="old_email" id="old_email" class="form-control" id="exampleInputEmail1" placeholder="Current Email" value="">
							<div class="form-group has-error" id="old_email_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> <?php echo lang('Current Email field is required');?></i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1"><?php echo lang('NEW EMAIL');?><span style="color:red">*</span></label>
							<input type="text" name="new_email" id="new_email" class="form-control" id="exampleInputPassword1" placeholder="New Email" value="">
							<div class="form-group has-error" id="new_email_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> <?php echo lang('New Email field is required');?></i>
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