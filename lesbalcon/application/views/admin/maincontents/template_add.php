<?php  
require('assets/admin/ckeditor/ckeditor.php');
require('assets/admin/ckfinder/ckfinder.php');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Add Email Template
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url(); ?>admin"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Add Email Template</li>
	</ol>
</section>
<script>
	function check_form()
	{
		var error=0;
		var language_ids=$("#language_id_arr").val();
		var language_id_arr=new Array();
		language_id_arr=language_ids.split("^");
		if($("#mail_type").val()=="")
		{
			$("#mail_type_error").show();
			error++;
		}
		else  
		{
			$("#mail_type_error").hide();
		}
		for(var x=0; x<language_id_arr.length; x++)
		{
			if($("#email_subject"+language_id_arr[x]).val().trim()=="")
			{
				$("#email_subject_error"+language_id_arr[x]).show();
				error++;
			}
			else  
			{
				$("#email_subject_error"+language_id_arr[x]).hide();
			}
			if(CKEDITOR.instances['email_message'+language_id_arr[x]].getData()=="")
			{
				$("#email_message_error"+language_id_arr[x]).show();
				error++;
			}
			else  
			{
				$("#email_message_error"+language_id_arr[x]).hide();
			}
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

</script>
<!-- Main content -->

<div class="box_horizontal">
	<a href="<?php echo base_url(); ?>admin/template/list_template/<?php echo $default_language_id; ?>" class="btn btn-primary btn-flat">BACK</a>
</div>

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<!-- general form elements -->
			<div class="box box-primary">
				<form role="form" id="form" action="<?php echo base_url(); ?>admin/template/template_add" method="POST" enctype="multipart/form-data" onsubmit="return check_form()">
					<div class="box-body">
						<div class="horizontal_div_full">
							Set Language Independent Content
						</div>
						<div class="form-group">
							<label for="exampleInputEmail1">EMAIL TYPE<span style="color:red">*</span></label>
                                                        <select name="mail_type" onchange="optionchangeAction()" id="mail_type" class="form-control">
								<option value="">--Select--</option>
								<?php 
								foreach($email_type_arr as $email_type)
								{
                                                                    
									?>
									<option value="<?php echo $email_type['type_id'] ?>"><?php echo $email_type['title'] ?></option>
									<?php 
								}
								?>
							</select>
							<div class="form-group has-error" id="mail_type_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o" > Email Type field is required</i>
								</label>
							</div>
						</div>
                                            
                                            <div style="display:none;" id="email_other_field" class="form-group">
									<label for="exampleInputPassword1">OTHER</label>
									<input type="text" name="email_other" id="email_other" class="form-control" placeholder="Write Other" value="">
									
								</div>
                                            <script>
                                            function optionchangeAction(){
                                                var mail_type=$('#mail_type').val();
                                                $('#email_other').val('');
                                                if(mail_type=='7')
                                                    $('#email_other_field').show();
                                                else{
                                                    $('#email_other_field').hide();
                                                }
                                                
                                                    
                                            }
                                            </script>
                                            
						<div class="horizontal_div_full">
							Set Language Specific Content
						</div>
						<?php 
						$language_id_arr=array();
						foreach($language_arr as $language)
						{
							array_push($language_id_arr, $language['id']);
							?>
							<div class="horizontal_div">
								<a style="cursor:pointer;" onclick="display_div('div_<?php echo $language['id']; ?>')">
								<img src="<?php echo base_url(); ?>assets/upload/flag/<?php echo $language['flag_image_name']; ?>">
								Add Content for <?php echo $language['language_name']; ?>
								</a>
							</div>
							<div id="div_<?php echo $language['id']; ?>">
								<div class="form-group">
									<label for="exampleInputPassword1">EMAIL SUBJECT<span style="color:red">*</span></label>
									<input type="text" name="email_subject<?php echo $language['id'] ?>" id="email_subject<?php echo $language['id'] ?>" class="form-control" placeholder="Email Subject" value="">
									<div class="form-group has-error" id="email_subject_error<?php echo $language['id'] ?>" style="display:none;">
										<label class="control-label" for="inputError">
										<i class="fa fa-times-circle-o"> Email Subject field is required</i>
										</label>
									</div>
								</div>
                                                            
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
										$code = $CKEditor->editor("email_message".$language['id'], '');
										echo $code;
									?>
									<span><b>Dynamic Variable:</b> ##(Username), @@(Password), %%(Date), $$(URL)</span>
									<div class="form-group has-error" id="email_message_error<?php echo $language['id'] ?>" style="display:none;">
										<label class="control-label" for="inputError">
										<i class="fa fa-times-circle-o"> Email Message field is required</i>
										</label>
									</div>
								</div>
							</div>
							<?php 
						}
						?>
						<input type="hidden" value="<?php echo implode("^", $language_id_arr); ?>" name="language_id_arr" id="language_id_arr">
					</div><!-- /.box-body -->
					<div class="box-footer">
						<input type="submit" class="btn btn-primary" name="save" value="Submit">
					</div>
				</form>
			</div><!-- /.box -->
		</div>
	</div>   <!-- /.row -->
</section><!-- /.content -->