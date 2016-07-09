<?php  
require('assets/admin/ckeditor/ckeditor.php');
require('assets/admin/ckfinder/ckfinder.php');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php echo lang('Add_Page');?>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url(); ?>admin"><i class="fa fa-dashboard"></i><?php echo lang('Home');?></a></li>
		<li class="active"><?php echo lang('Add_Page');?></li>
	</ol>
</section>
<script>
	function check_form()
	{
		var error=0;
		if($("#page_slug").val().trim()=="")
		{
			$("#page_slug_error").show();
			error++;
		}
		else
		{
			$("#page_slug_error").hide();
		}
		
		if($("#page_seo_url").val().trim()=="")
		{
			$("#page_url_text").html(" Page Title field is required");
			$("#page_seo_url_error").show();
			error++;
		}
		else
		{
			$("#page_seo_url_error").hide();
		}
		if($("#page_banner").val()=="")
		{
			$("#page_banner_error").show();
			error++;
		}
		else if($("#page_banner").val()!="")
		{
			$("#page_banner_error").hide();
			var banner_image_name=$("#page_banner").val();
			var extension=banner_image_name.split('.').pop();
			if(extension=="jpg" || extension=="jpeg" || extension=="gif" || extension=="png")
			{
				$("#page_banner_text").html("Image size should be Width of 669px & Height of 453px");
				$("#page_banner_error").hide();
			}
			else  
			{
				$("#page_banner_text").html("Only jpg, png, gif file is allowed");
				$("#page_banner_error").show();
				error++;
			}
		}
		else 
		{
			$("#page_banner_error").hide();
		}
		var language_ids=$("#language_id_arr").val();
		var language_id_arr=new Array();
		language_id_arr=language_ids.split("^");
		for(var x=0; x<language_id_arr.length; x++)
		{
			if($("#page_title"+language_id_arr[x]).val().trim()=="")
			{
				$("#page_title_error"+language_id_arr[x]).show();
				error++;
			}
			else  
			{
				$("#page_title_error"+language_id_arr[x]).hide();
			}
			if(CKEDITOR.instances['page_desc'+language_id_arr[x]].getData()=="")
			{
				$("#page_desc_error"+language_id_arr[x]).show();
				error++;
			}
			else  
			{
				$("#page_desc_error"+language_id_arr[x]).hide();
			}
			if($("#meta_title"+language_id_arr[x]).val().trim()=="")
			{
				$("#meta_title_error"+language_id_arr[x]).show();
				error++;
			}
			else  
			{
				$("#meta_title_error"+language_id_arr[x]).hide();
			}
			if($("#meta_keyword"+language_id_arr[x]).val().trim()=="")
			{
				$("#meta_keyword_error"+language_id_arr[x]).show();
				error++;
			}
			else  
			{
				$("#meta_keyword_error"+language_id_arr[x]).hide();
			}
			if($("#meta_desc"+language_id_arr[x]).val().trim()=="")
			{
				$("#meta_desc_error"+language_id_arr[x]).show();
				error++;
			}
			else  
			{
				$("#meta_desc_error"+language_id_arr[x]).hide();
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
	<a href="<?php echo base_url(); ?>admin/cms/list_cms/<?php echo $default_language_id; ?>" class="btn btn-primary btn-flat"><?php echo lang('Back');?></a>
</div>

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<!-- general form elements -->
			<div class="box box-primary">
				<form role="form" id="form" action="<?php echo base_url(); ?>admin/cms/cms_add" method="POST" enctype="multipart/form-data" onsubmit="return check_form()">
					<div class="box-body">
						<div class="horizontal_div_full">
							<?php echo lang('Set_Language_independent_content');?>
						</div>
						<div class="form-group">
							<label for="exampleInputEmail1">PAGE SLUG<?php echo lang('Set_Language_independent_content');?><span style="color:red">*</span></label>
							<input type="text" name="page_slug" id="page_slug" class="form-control" placeholder="Page Slug" value=""/>
							<div class="form-group has-error" id="page_slug_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o" id="page_slug_text"> Page Slug field is required<?php echo lang('Set_Language_independent_content');?></i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">PAGE SEO URL<?php echo lang('Set_Language_independent_content');?><span style="color:red">*</span></label>
							<div>
								<p style="width:auto; float:left; margin-top:7px;"><?php echo base_url(); ?></p><input type="text" name="page_seo_url" id="page_seo_url" class="form-control" style="width:50%;" placeholder="Page SEO URL" value="">
								<div class="form-group has-error" id="page_seo_url_error" style="display:none;">
									<label class="control-label" for="inputError">
									<i class="fa fa-times-circle-o" id="page_url_text"> Page SEO URL field is required<?php echo lang('Set_Language_independent_content');?></i>
									</label>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputEmail1">PAGE BANNER<?php echo lang('Set_Language_independent_content');?><span style="color:red">*</span></label>
							<input type="file" name="page_banner" id="page_banner" size="20"/>
							<span class="text-light-blue">Image size should be within Width of 1600px & Height of 193px</span>
							<div class="form-group has-error" id="page_banner_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o" id="page_banner_text"> <?php echo lang('Page Banner field is required');?></i>
								</label>
							</div>
						</div>
						<div class="horizontal_div_full">
							<?php echo lang('Set Language Specific Content');?>
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
								Add Content for<?php echo lang('Set_Language_independent_content');?> <?php echo $language['language_name']; ?>
								</a>
							</div>
							<div id="div_<?php echo $language['id']; ?>">
								<div class="form-group">
									<label for="exampleInputPassword1"><?php echo lang('Page_Title');?><span style="color:red">*</span></label>
									<input type="text" name="page_title<?php echo $language['id'] ?>" id="page_title<?php echo $language['id'] ?>" class="form-control" placeholder="Page Title" value="">
									<div class="form-group has-error" id="page_title_error<?php echo $language['id'] ?>" style="display:none;">
										<label class="control-label" for="inputError">
										<i class="fa fa-times-circle-o"> <?php echo lang('Page Title field is required');?></i>
										</label>
									</div>
								</div>
								<div class="form-group">
									<label for="exampleInputPassword1"><?php echo lang('PAGE DESCRIPTION');?><span style="color:red">*</span></label>
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
										$code = $CKEditor->editor("page_desc".$language['id'], '');
										echo $code;
									?>
									<div class="form-group has-error" id="page_desc_error<?php echo $language['id'] ?>" style="display:none;">
										<label class="control-label" for="inputError">
										<i class="fa fa-times-circle-o"> <?php echo lang('Page Description field is required');?></i>
										</label>
									</div>
								</div>
								<div class="form-group">
									<label for="exampleInputPassword1"><?php echo lang('Meta_Title');?><span style="color:red">*</span></label>
									<input type="text" name="meta_title<?php echo $language['id'] ?>" id="meta_title<?php echo $language['id'] ?>" class="form-control" placeholder="Meta Title" value="">
									<div class="form-group has-error" id="meta_title_error<?php echo $language['id'] ?>" style="display:none;">
										<label class="control-label" for="inputError">
										<i class="fa fa-times-circle-o"> <?php echo lang('Meta Title field is required');?></i>
										</label>
									</div>
								</div>
								<div class="form-group">
									<label for="exampleInputPassword1"><?php echo lang('META KEYWORDS');?><span style="color:red">*</span></label>
									<input type="text" name="meta_keyword<?php echo $language['id'] ?>" id="meta_keyword<?php echo $language['id'] ?>" class="form-control" placeholder="Meta Keyword" value="">
									<div class="form-group has-error" id="meta_keyword_error<?php echo $language['id'] ?>" style="display:none;">
										<label class="control-label" for="inputError">
										<i class="fa fa-times-circle-o"> <?php echo lang('Meta Keyword field is required');?></i>
										</label>
									</div>
								</div>
								<div class="form-group">
									<label for="exampleInputPassword1"><?php echo lang('META DESCRIPTION');?><span style="color:red">*</span></label>
									<input type="text" name="meta_desc<?php echo $language['id'] ?>" id="meta_desc<?php echo $language['id'] ?>" class="form-control" placeholder="Meta Description" value="">
									<div class="form-group has-error" id="meta_desc_error<?php echo $language['id'] ?>" style="display:none;">
										<label class="control-label" for="inputError">
										<i class="fa fa-times-circle-o"> <?php echo lang('Meta Description field is required');?></i>
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