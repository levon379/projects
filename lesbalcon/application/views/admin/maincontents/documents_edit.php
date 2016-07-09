<?php  
require('assets/admin/ckeditor/ckeditor.php');
require('assets/admin/ckfinder/ckfinder.php');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php echo lang("edit_document"); ?>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url(); ?>admin"><i class="fa fa-dashboard"></i> <?php echo lang("Home") ?></a></li>
		<li class="active"><?php echo lang("edit_document"); ?>	</li>
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
			if($("#document_file"+language_id_arr[x]).val()!="")
			{
				$("#document_file_error"+language_id_arr[x]).hide();
				var document_file_name=$("#document_file"+language_id_arr[x]).val();
				var extension=document_file_name.split('.').pop();
				if(extension=="doc" || extension=="docx" || extension=="pdf")
				{
					$("#document_file_error_text"+language_id_arr[x]).html("<?php echo lang('Choose_file_field_is_required'); ?>");
					$("#document_file_error"+language_id_arr[x]).hide();
					return true;
				}
				else  
				{
					$("#document_file_error_text"+language_id_arr[x]).html("<?php echo lang('allowed_file_type'); ?>");
					$("#document_file_error"+language_id_arr[x]).show();
					error++;
				}
			}
			else 
			{
				$("#document_file_error").hide();
			}
			if($("#document_title"+language_id_arr[x]).val().trim()=="")
			{
				$("#document_title_error"+language_id_arr[x]).show();
				error++;
			}
			else  
			{
				$("#document_title_error"+language_id_arr[x]).hide();
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
	<a href="<?php echo base_url(); ?>admin/documents/list_documents/<?php echo $default_language_id; ?>" class="btn btn-primary btn-flat"><?php echo lang("BACK"); ?></a>
</div>

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<!-- general form elements -->
			<div class="box box-primary">
				<form role="form" id="form" action="<?php echo base_url(); ?>admin/documents/documents_edit/<?php echo $this->uri->segment(4); ?>/<?php echo $this->uri->segment(5); ?>" method="POST" enctype="multipart/form-data" onsubmit="return check_form()">
					<div class="box-body">
						<div class="horizontal_div_full">
							<?php echo lang("Set_Language_Specific_Content"); ?>
						</div>
						<input type="hidden" value="<?php echo $this->uri->segment(5); ?>" name="document_id">
						<input type="hidden" value="<?php echo $this->uri->segment(4); ?>" name="language_id">
						<?php 
						$language_id_arr=array();
						foreach($documents_arr as $language)
						{
							array_push($language_id_arr, $language['id']);
							?>
							<div class="horizontal_div">
								<a style="cursor:pointer;" onclick="display_div('div_<?php echo $language['id']; ?>')">
								<img src="<?php echo base_url(); ?>assets/upload/flag/<?php echo $language['flag_image_name']; ?>">
								<?php echo lang("Add_Content_for")." ". $language['language_name']; ?>
								</a>
							</div>
							<div id="div_<?php echo $language['id']; ?>">
								<div class="form-group">
									<label for="exampleInputEmail1"><?php echo lang("CHOOSE_FILE"); ?><span style="color:red">*</span></label>
									<input type="file" name="document_file<?php echo $language['id'] ?>" id="document_file<?php echo $language['id'] ?>" size="20"/>
									<span class="text-light-blue"><?php echo lang('allowed_file_type'); ?></span><br>
									<?php echo $language['document_file']; ?>
									<div class="form-group has-error" id="document_file_error<?php echo $language['id'] ?>" style="display:none;">
										<label class="control-label" for="inputError">
										<i class="fa fa-times-circle-o" id="document_file_error_text<?php echo $language['id'] ?>"> <?php echo lang('Choose_file_field_is_required'); ?></i>
										</label>
									</div>
								</div>
								<div class="form-group">
									<label for="exampleInputPassword1"><?php echo lang("Document_Title"); ?><span style="color:red">*</span></label>
									<input type="text" name="document_title<?php echo $language['id'] ?>" id="document_title<?php echo $language['id'] ?>" class="form-control" placeholder="<?php echo lang("Document_Title"); ?>" value="<?php echo $language['document_title']; ?>">
									<div class="form-group has-error" id="document_title_error<?php echo $language['id'] ?>" style="display:none;">
										<label class="control-label" for="inputError">
										<i class="fa fa-times-circle-o"> <?php echo lang("Document_Title_field_is_required"); ?></i>
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
						<input type="submit" class="btn btn-primary" name="save" value="<?php echo lang("submit"); ?> ">
					</div>
				</form>
			</div><!-- /.box -->
		</div>
	</div>   <!-- /.row -->
</section><!-- /.content -->