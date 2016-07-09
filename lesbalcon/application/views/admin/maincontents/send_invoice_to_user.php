<?php  
require('assets/admin/ckeditor/ckeditor.php');
require('assets/admin/ckfinder/ckfinder.php');
?>
<script>
	function get_content(template_id)
	{
		$.post("<?php echo base_url(); ?>admin/send_email_to_users/get_content", { "template_id":template_id }, function(data){
			$("#content_div").html(data);
		});
	}
</script>
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
				<form role="form" id="form" action="<?php echo base_url(); ?>admin/users/send_invoice" method="POST" enctype="multipart/form-data" onsubmit="return check_form()">
					<div class="box-body">
						<div class="form-group">
							<label for="exampleInputPassword1">EMAIL TEMPLATE<span style="color:red">*</span></label>
							<select name="template_id" id="template_id" class="form-control" onchange="get_content(this.value)">
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
						<div id="content_div">
							
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">USER</label>
							<input type="text" class="form-control" readonly name="user_email" id="user_email" size="20" value="<?php echo $users_arr[0]['email']; ?>"/>
						</div>
					</div><!-- /.box-body -->
					<div class="box-footer">
						<input type="submit" class="btn btn-primary" name="send" value="Send">
					</div>
				</form>
			</div><!-- /.box -->
		</div>
	</div>   <!-- /.row -->
</section><!-- /.content -->