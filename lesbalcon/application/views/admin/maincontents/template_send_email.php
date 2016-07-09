<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/ckeditor/ckeditor.js"></script>
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
	function get_content(template_id)
	{
		$.post("<?php echo base_url(); ?>admin/send_email_to_users/get_content", { "template_id":template_id }, function(data){
			if (CKEDITOR.instances['message1']) 
			{
			   CKEDITOR.remove(CKEDITOR.instances['message1']);
			}
			if (CKEDITOR.instances['message2']) 
			{
			   CKEDITOR.remove(CKEDITOR.instances['message2']);
			}
			$("#content_div").html(data);
		});
	}
	function display_div(div_id)
	{
		$("#"+div_id).slideToggle("slow");
	}
</script>
<!-- Main content -->
<?php 
if(isset($_GET["exists"]))
{
	?>
	<section class="content" >
	<div class="alert alert-danger alert-dismissable" style="margin-bottom:0px;">
		<i class="fa fa-ban"></i>
		<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
		<b><?php echo "User already exists."; ?></b>
	</div>
	</section>
	<?php
}
?>
<div class="box_horizontal">
	<a href="<?php echo base_url(); ?>admin/template/list_template/<?php echo $this->uri->segment(4); ?>" class="btn btn-primary btn-flat">BACK</a>
</div>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<!-- general form elements -->
			<div class="box box-primary">
				<form role="form" id="form" action="<?php echo base_url(); ?>admin/template/send_email/<?php echo $this->uri->segment(4); ?>/<?php echo $this->uri->segment(5); ?>" method="POST" enctype="multipart/form-data" onsubmit="return check_form()">
					<div class="box-body">
						<div class="form-group">
							<input type="hidden" name="hidden_template_id" id="hidden_template_id" value="<?php echo $sent_template_id; ?>">
							<label for="exampleInputPassword1">EMAIL TEMPLATE<span style="color:red">*</span></label>
							<select name="template_id" id="template_id" class="form-control" onchange="get_content(this.value)">
								<option value="">--Select--</option>
								<?php 
								foreach($template_arr as $template)
								{
									?>
									<option value="<?php echo $template['template_id']; ?>" <?php if($sent_template_id==$template['template_id']){ echo "selected"; } ?>><?php echo $template['subject'] ?></option>	
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
							<?php 
							foreach($current_template as $language)
							{
								?>
								<div class="horizontal_div">
									<a style="cursor:pointer;" onclick="display_div('div_<?php echo $language['id']; ?>')">
									<img src="<?php echo base_url(); ?>assets/upload/flag/<?php echo $language['flag_image_name']; ?>">
									Edit Content for <?php echo $language['language_name']; ?>
									</a>
								</div>
								<div id="div_<?php echo $language['id']; ?>">
									<div class="form-group">
										<label for="exampleInputPassword1">EMAIL MESSAGE<span style="color:red">*</span></label>
										<?php								
											$basePathUrl=base_url()."assets/admin";
											$CKEditor = new CKEditor();
											$CKEditor->basePath = base_url().'assets/admin/ckeditor/';
											$CKEditor->config['height'] = 200;
											$CKEditor->config['width'] = '100%';
											$CKEditor->config['uiColor'] = "#E4ECEF";
									
											//########################################################################//
											//################ SET ckfinder PATH FOR IMAGE UPLOAD ####################//
											//########################################################################//
									
											$CKEditor->config['filebrowserBrowseUrl'] = $basePathUrl."/ckfinder/ckfinder.html";
											$CKEditor->config['filebrowserImageBrowseUrl'] = $basePathUrl."/ckfinder/ckfinder.html?Type=Images";
											$CKEditor->config['filebrowserFlashBrowseUrl'] = $basePathUrl."/ckfinder/ckfinder.html?Type=Flash";
											$CKEditor->config['filebrowserUploadUrl'] = $basePathUrl."/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files";
											$CKEditor->config['filebrowserImageUploadUrl'] = $basePathUrl."/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images";
											$CKEditor->config['filebrowserFlashUploadUrl'] = $basePathUrl."/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash";
									
											//########################################################################//
											//################ SET ckfinder PATH FOR IMAGE UPLOAD ####################//
											//########################################################################//
									
											$CKEditor->returnOutput = true;
											$code = $CKEditor->editor("message".$language['id'], $language['message']);
											echo $code;
										?>
									</div>
								</div>
								<?php 
							}
							?>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">SELECT USERS<span style="color:red">*</span></label>
							<?php
							if(count($all_users_arr)>0)
							{
								?>
								<a style="cursor:pointer;" onclick="select_all()"><u>Select All</u></a> | 
								<a style="cursor:pointer;" onclick="cancel_select_all()"><u>Cancel</u></a>
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