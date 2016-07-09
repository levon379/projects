<?php  
require('assets/admin/ckeditor/ckeditor.php');
require('assets/admin/ckfinder/ckfinder.php');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Send Email to Users
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url(); ?>admin"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Send Email to Users</li>
	</ol>
</section>
<script>
	function check_form()
	{
		var error=0;
		if($("#template_id").val()=="")
		{
			$("#template_id_error").show();
			error++;
		}
		else  
		{
			$("#template_id_error").hide();
		}
		
		var options = $('#user_id > option:selected');
		if(options.length == 0)
		{
			$("#user_id_error").show();
			error++;
		}
		else 
		{
			$("#user_id_error").hide();
		}
		if(error>0)
		{
			$(window).scrollTop($("#form").offset().top);
			return false;
		}
	}
	function display_div(div_id)
	{
		$("#"+div_id).slideToggle("slow");
	}
	function validate_numeric_field(value, text_field_id)
	{
		if(value.match(/[^0-9]/g))
		{
			document.getElementById(text_field_id).value=value.replace(/[^0-9]/g, '');
		}
	}
	function select_all()
	{
		var length = document.getElementById("user_id").options.length;
		for(var i = 0; i<length; i++)
		{
			document.getElementById("user_id").options[i].selected = "selected";
		}
	}
	function cancel_select_all()
	{
		var length = document.getElementById("user_id").options.length;
		for(var i = 0; i<length; i++)
		{
			document.getElementById("user_id").options[i].selected = "";
		}
	}
</script>
<!-- Main content -->
<?php 
if(isset($_GET["mailsent"]))
{
	?>
	<section class="content">
	<div class="alert alert-success alert-dismissable" style="margin-bottom:0px;">
		<i class="fa fa-check"></i>
		<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
		<b><?php echo "Email Sent Successfully."; ?></b>
	</div>
	</section>
	<?php
}
?>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<!-- general form elements -->
			<div class="box box-primary">
				<form role="form" id="form" action="<?php echo base_url(); ?>admin/send_email_to_users" method="POST" enctype="multipart/form-data" onsubmit="return check_form()">
					<div class="box-body">
						<div class="form-group">
							
							<label for="exampleInputPassword1">EMAIL TEMPLATE<span style="color:red">*</span></label>
							<select name="template_id" id="template_id" class="form-control">
								<option value="">--Select--</option>
								<?php 
								foreach($template_arr as $template)
								{
									?>
									<option value="<?php echo $template['template_id']; ?>"><?php echo $template['subject'] ?></option>	
									<?php 
								}
								?>
							</select>
							<div class="form-group has-error" id="template_id_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> Email Template field is required</i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">SELECT USERS<span style="color:red">*</span></label>
							<?php
							if(count($all_users_arr)>0)
							{
								?>
								<a style="cursor:pointer;" onclick="select_all()"><u>Select All</u></a> | 
								<a style="cursor:pointer;" onclick="cancel_select_all()"><u>Deselect All</u></a>
								<?php 
							}
							?>
							<select name="user_id[]" id="user_id" class="form-control" multiple="true">
								<?php
								foreach($all_users_arr as $users)
								{
									?>
									<option style="cursor:pointer; margin-bottom:2px;" value="<?php echo $users['id'] ?>"><?php echo $users['name']." < ".$users['email']." >"; ?></option>
									<?php
								}
								?>
							</select>
							<span><i><b>Note</b>: Please press ctrl to select multiple users</i></span>
							<div class="form-group has-error" id="user_id_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> Select Users field is required</i>
								</label>
							</div>
						</div>
					</div><!-- /.box-body -->
					<div class="box-footer">
						<input type="submit" class="btn btn-primary" name="save" value="Send">
					</div>
				</form>
			</div><!-- /.box -->
		</div>
	</div>   <!-- /.row -->
</section><!-- /.content -->