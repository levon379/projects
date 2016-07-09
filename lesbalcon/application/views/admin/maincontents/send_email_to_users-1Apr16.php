<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/ckeditor/ckeditor.js"></script>
<?php  

require('assets/admin/ckeditor/ckeditor.php');
require('assets/admin/ckfinder/ckfinder.php');
?>
<script>
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
</script>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php echo lang('Send_Email_To_Users'); ?>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url(); ?>admin"><i class="fa fa-dashboard"></i> <?php echo lang('Home'); ?></a></li>
		<li class="active"><?php echo lang('Send_Email_To_Users'); ?></li>
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
                        return false;
		}
		else  
		{
			$("#template_id_error").hide();
		}
		if($("#language_id_arr").length)
		{
			var language_ids=$("#language_id_arr").val();
			var language_id_arr=new Array();
			language_id_arr=language_ids.split("^");
			for(var x=0; x<language_id_arr.length; x++)
			{
				if($("#subject"+language_id_arr[x]).val().trim()=="")
				{
					$("#subject_error"+language_id_arr[x]).show();
					error++;
				}
				else  
				{
					$("#subject_error"+language_id_arr[x]).hide();
				}
				if(CKEDITOR.instances['message'+language_id_arr[x]].getData()=="")
				{
					$("#message_error"+language_id_arr[x]).show();
					error++;
				}
				else  
				{
					$("#message_error"+language_id_arr[x]).hide();
				}
			}
		}
		if($('#txt_res_id').val() == '' || $('#txt_res_id').val() == 'mailsent'){
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
	function unselect_attachment(val)
	{
		document.getElementById("attachment_dropdown").selectedIndex = "0";
	}
	function remove_upload_file(val)
	{
		if(val!="")
		{
			document.getElementById("attachment_file").value = "";
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
		<b><?php echo lang("Email_sent_Successfully"); ?></b>
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
					<input type="hidden" name="txt_res_id" id="txt_res_id" value="<?php echo $_SERVER['QUERY_STRING']; ?>">
					<div class="box-body">
						<div class="form-group">
							<label for="exampleInputPassword1"><?php echo lang("EMAIL_TEMPLATE"); ?><span style="color:red">*</span></label>
							<select name="template_id" id="template_id" class="form-control" onchange="get_content(this.value)">
								<option value="">--Sélectionner--</option>
								<?php 
								foreach($template_arr as $template)
								{
									?>
									<option value="<?php echo $template['template_id']; ?>"><?php echo ($template['type']=='other' || $template['type']=='Autre')?$template['other']: $template['type'] ?></option>	
									<?php 
								}
								?>
								<option value="0">New</option>
							</select>
							<div class="form-group has-error" id="template_id_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> <?php echo lang("Email_template_is_required"); ?></i>
								</label>
							</div>
						</div>
						<div id="content_div">
							
						</div>
						<?php if(!($_SERVER['QUERY_STRING']) || $_SERVER['QUERY_STRING'] == 'mailsent'){ ?>
						<div class="form-group">
							<label for="exampleInputPassword1"><?php echo lang("SELECT_USERS"); ?><span style="color:red">*</span></label>
							<?php
							if(count($all_users_arr)>0)
							{
								?>
								<a style="cursor:pointer;" onclick="select_all()"><u><?php echo lang("select_all"); ?></u></a> | 
								<a style="cursor:pointer;" onclick="cancel_select_all()"><u><?php echo lang("deselect_all"); ?></u></a>
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
							<span><i><b><?php echo lang("Note"); ?></b>: <?php echo lang("Mulitple_select_message") ?></i></span>
							<div class="form-group has-error" id="user_id_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> <?php echo lang("User_is_required"); ?></i>
								</label>
							</div>
						</div>
						<?php } else { ?>
						<div class="form-group">
							<label for="exampleInputPassword1"><?php echo lang('user'); ?></label>
							<div style="color:red"><?php echo $selected_user; ?></div>
						</div>
						<?php } ?>
						<div class="form-group">
							<label for="exampleInputPassword1"><?php echo lang('upload_new_attachment'); ?></label>
							<input type="file" name="attachment_file_1" id="attachment_file_1" onchange="unselect_attachment(this.value)">
						</div>
                                            <div class="form-group">
							<label for="exampleInputPassword1"><?php echo lang('upload_new_attachment'); ?></label>
							<input type="file" name="attachment_file_2" id="attachment_file_2" onchange="unselect_attachment(this.value)">
						</div>
                                            <div class="form-group">
							<label for="exampleInputPassword1"><?php echo lang('upload_new_attachment'); ?></label>
							<input type="file" name="attachment_file_3" id="attachment_file_3" onchange="unselect_attachment(this.value)">
						</div>
						<p><strong>OU</strong></p>
						<div class="form-group">
							<label for="exampleInputPassword1"><?php echo lang('select_attachment'); ?></label>
							<select name="attachment_dropdown" id="attachment_dropdown" class="form-control" onchange="remove_upload_file(this.value)">
								<option value="">--Sélectionner--</option>
								<?php 
								if(count($documents_arr)>0)
								{
									foreach($documents_arr as $documents)
									{
										?>
										<option value="<?php echo $documents['document_id'] ?>"><?php echo $documents['document_title'] ?></option>
										<?php 
									}
								}
								?>
							</select>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1"><?php echo lang('select_attachment'); ?></label>
							<select name="attachment_dropdown2" id="attachment_dropdown2" class="form-control" onchange="remove_upload_file(this.value)">
								<option value="">--Sélectionner--</option>
								<?php 
									if(count($documents_arr)>0)
									{
										foreach($documents_arr as $documents)
										{
										?>
										<option value="<?php echo $documents['document_id'] ?>"><?php echo $documents['document_title'] ?></option>
										<?php 
										}
									}
								?>
							</select>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1"><?php echo lang('select_attachment'); ?></label>
							<select name="attachment_dropdown3" id="attachment_dropdown3" class="form-control" onchange="remove_upload_file(this.value)">
								<option value="">--Sélectionner--</option>
								<?php 
									if(count($documents_arr)>0)
									{
										foreach($documents_arr as $documents)
										{
										?>
										<option value="<?php echo $documents['document_id'] ?>"><?php echo $documents['document_title'] ?></option>
										<?php 
										}
									}
								?>
							</select>
						</div>
					</div><!-- /.box-body -->
					<div class="box-footer">
						<input type="submit" class="btn btn-primary" name="save" value="<?php echo lang('Send'); ?>">
					</div>
				</form>
			</div><!-- /.box -->
		</div>
	</div>   <!-- /.row -->
</section><!-- /.content -->