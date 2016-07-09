<?php  
require('assets/admin/ckeditor/ckeditor.php');
require('assets/admin/ckfinder/ckfinder.php');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php echo lang('Edit_Welcome_Text'); ?>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url(); ?>admin"><i class="fa fa-dashboard"></i> <?php echo lang('Home'); ?></a></li>
		<li class="active"><?php echo lang('Edit_Welcome_Text'); ?></li>
	</ol>
</section>
<script>
	function check_form()
	{
		var error=0;
		var language_ids=$("#language_id_arr").val();
		var language_id_arr=new Array();
		language_id_arr=language_ids.split("^");
		for(var x=0; x<language_id_arr.length; x++)
		{
			if(CKEDITOR.instances['welcome_text'+language_id_arr[x]].getData()=="")
			{
				$("#welcome_text_error"+language_id_arr[x]).show();
				error++;
			}
			else  
			{
				$("#welcome_text_error"+language_id_arr[x]).hide();
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
	<a href="<?php echo base_url(); ?>admin/welcome/welcome_text/<?php echo $default_language_id; ?>" class="btn btn-primary btn-flat"><?php echo lang('Back'); ?></a>
</div>

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<!-- general form elements -->
			<div class="box box-primary">
				<form role="form" id="form" action="<?php echo base_url(); ?>admin/welcome/text_edit/<?php echo $this->uri->segment(4); ?>/<?php echo $this->uri->segment(5)?>" method="POST" enctype="multipart/form-data" onsubmit="return check_form()">
					<div class="box-body">
						<div class="horizontal_div_full">
							<?php echo lang('Set_language_Specific_content'); ?>
						</div>
						<input type="hidden" value="<?php echo $this->uri->segment(5); ?>" name="text_id">
						<input type="hidden" value="<?php echo $this->uri->segment(4); ?>" name="language_id">
						<?php 
						$language_id_arr=array();
						foreach($text_arr as $language)
						{
							array_push($language_id_arr, $language['id']);
							?>
							<div class="horizontal_div">
								<a style="cursor:pointer;" onclick="display_div('div_<?php echo $language['id']; ?>')">
								<img src="<?php echo base_url(); ?>assets/upload/flag/<?php echo $language['flag_image_name']; ?>">
								<?php echo lang('Define_content_for'); ?> <?php echo lang($language['language_name'].'1'); ?>
								</a>
							</div>
							<div id="div_<?php echo $language['id']; ?>">
								<div class="form-group">
									<label for="exampleInputPassword1"><?php echo lang('WELCOME_TEXT'); ?><span style="color:red">*</span></label>
									<!--<input type="text" name="welcome_text<?php echo $language['id'] ?>" id="welcome_text<?php echo $language['id'] ?>" class="form-control" placeholder="Welcome Text" value="<?php echo $language['text']; ?>">-->
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
										$code = $CKEditor->editor("welcome_text".$language['id'], $language['text']);
										echo $code;
									?>
									<div class="form-group has-error" id="welcome_text_error<?php echo $language['id'] ?>" style="display:none;">
										<label class="control-label" for="inputError">
										<i class="fa fa-times-circle-o"> <?php echo lang('Welcome_Text_field_is_required'); ?></i>
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
						<input type="submit" class="btn btn-primary" name="save" value="<?php echo lang('Submit'); ?>">
					</div>
				</form>
			</div><!-- /.box -->
		</div>
	</div>   <!-- /.row -->
</section><!-- /.content -->