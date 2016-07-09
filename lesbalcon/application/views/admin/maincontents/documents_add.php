<?php  
require('assets/admin/ckeditor/ckeditor.php');
require('assets/admin/ckfinder/ckfinder.php');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Add Documents
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url(); ?>admin"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Add Documents</li>
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
			if($("#document_file"+language_id_arr[x]).val()=="")
			{
				$("#document_file_error"+language_id_arr[x]).show();
				error++;
			}
			else if($("#document_file"+language_id_arr[x]).val()!="")
			{
				$("#document_file_error"+language_id_arr[x]).hide();
				var document_file_name=$("#document_file"+language_id_arr[x]).val();
				var extension=document_file_name.split('.').pop();
				if(extension=="doc" || extension=="docx" || extension=="pdf")
				{
					$("#document_file_error_text"+language_id_arr[x]).html("Choose File field is required");
					$("#document_file_error"+language_id_arr[x]).hide();
					return true;
				}
				else  
				{
					$("#document_file_error_text"+language_id_arr[x]).html("Only .doc, .docx, .pdf files are allowed");
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
	<a href="<?php echo base_url(); ?>admin/documents/list_documents/<?php echo $default_language_id; ?>" class="btn btn-primary btn-flat">BACK</a>
</div>

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<!-- general form elements -->
			<div class="box box-primary">
				<form role="form" id="form" action="<?php echo base_url(); ?>admin/documents/documents_add" method="POST" enctype="multipart/form-data" onsubmit="return check_form()">
					<div class="box-body">
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
									<label for="exampleInputEmail1">CHOOSE FILE<span style="color:red">*</span></label>
									<input type="file" name="document_file<?php echo $language['id'] ?>" id="document_file<?php echo $language['id'] ?>" size="20"/>
									<span class="text-light-blue">Only .doc, .docx, .pdf files are allowed</span>
									<div class="form-group has-error" id="document_file_error<?php echo $language['id'] ?>" style="display:none;">
										<label class="control-label" for="inputError">
										<i class="fa fa-times-circle-o" id="document_file_error_text<?php echo $language['id'] ?>"> Choose File field is required</i>
										</label>
									</div>
								</div>
								<div class="form-group">
									<label for="exampleInputPassword1">DOCUMENT TITLE<span style="color:red">*</span></label>
									<input type="text" name="document_title<?php echo $language['id'] ?>" id="document_title<?php echo $language['id'] ?>" class="form-control" placeholder="Document Title" value="">
									<div class="form-group has-error" id="document_title_error<?php echo $language['id'] ?>" style="display:none;">
										<label class="control-label" for="inputError">
										<i class="fa fa-times-circle-o"> Document Title field is required</i>
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