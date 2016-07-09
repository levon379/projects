<?php  
require('assets/admin/ckeditor/ckeditor.php');
require('assets/admin/ckfinder/ckfinder.php');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php echo lang('Edit Gallery');?>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url(); ?>admin"><i class="fa fa-dashboard"></i> <?php echo lang('Home');?></a></li>
		<li class="active"><?php echo lang('Edit Gallery');?></li>
	</ol>
</section>
<script>
	function check_form()
	{
		var error=0;
		if($("#gallery_image").val()!="")
		{
			$("#gallery_image_error").hide();
			var banner_image_name=$("#gallery_image").val();
			var extension=banner_image_name.split('.').pop();
			if(extension=="jpg" || extension=="jpeg" || extension=="gif" || extension=="png")
			{
				$("#gallery_image_error_text").html("Image size should be Width of 669px & Height of 453px");
				$("#gallery_image_error").hide();
				return true;
			}
			else  
			{
				$("#gallery_image_error_text").html("Only jpg, png, gif file is allowed");
				$("#gallery_image_error").show();
				error++;
			}
		}
		else 
		{
			$("#gallery_image_error").hide();
		}
		
		
		var language_ids=$("#language_id_arr").val();
		var language_id_arr=new Array();
		language_id_arr=language_ids.split("^");
		for(var x=0; x<language_id_arr.length; x++)
		{
			if($("#gallery_title"+language_id_arr[x]).val().trim()=="")
			{
				$("#gallery_title_error"+language_id_arr[x]).show();
				error++;
			}
			else  
			{
				$("#gallery_title_error"+language_id_arr[x]).hide();
			}
			if($("#description"+language_id_arr[x]).val().trim()=="")
			{
				$("#description_error"+language_id_arr[x]).show();
				error++;
			}
			else  
			{
				$("#description_error"+language_id_arr[x]).hide();
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
<?php 
if(isset($_GET["size"]))
{
	?>
	<section class="content" >
	<div class="alert alert-danger alert-dismissable" style="margin-bottom:0px;">
		<i class="fa fa-ban"></i>
		<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
		<b><?php echo lang('Image size should be Width of 360px & Height of 238px'); ?></b>
	</div>
	</section>
	<?php
}
?>

<div class="box_horizontal">
	<a href="<?php echo base_url(); ?>admin/gallery/list_gallery/<?php echo $default_language_id; ?>" class="btn btn-primary btn-flat"><?php echo lang('Back');?></a>
</div>

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<!-- general form elements -->
			<div class="box box-primary">
				<form role="form" id="form" action="<?php echo base_url(); ?>admin/gallery/gallery_edit/<?php echo $this->uri->segment(4); ?>/<?php echo $this->uri->segment(5); ?>" method="POST" enctype="multipart/form-data" onsubmit="return check_form()">
					<div class="box-body">
						<input type="hidden" value="<?php echo $this->uri->segment(5); ?>" name="gallery_id">
						<input type="hidden" value="<?php echo $this->uri->segment(4); ?>" name="language_id">
						<div class="horizontal_div_full">
							<?php echo lang('Set_Language_independent_content');?>
						</div>
						<div class="form-group">
							<label for="exampleInputEmail1"><?php echo lang('GALLERY IMAGE');?><span style="color:red">*</span></label>
							<input type="file" name="gallery_image" id="gallery_image" size="20"/>
							<img src="<?php echo base_url(); ?>/assets/upload/gallery/thumb/<?php echo $gallery_unique_details[0]['image_file_name']; ?>" width="50px" height="50px">
							<!--span class="text-light-blue">Image size should be Width of 360px & Height of 238px</span-->
							<div class="form-group has-error" id="gallery_image_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o" id="gallery_image_error_text"> <?php echo lang('Gallery Image field is required');?></i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputEmail1"><?php echo lang('Set_Featured');?></label><br>
							<input type="radio" name="is_featured" value="Y" <?php if($gallery_unique_details[0]['is_featured']=="Y"){  echo "checked"; } ?>>&nbsp;Yes&nbsp;&nbsp;
							<input type="radio" name="is_featured" value="N" <?php if($gallery_unique_details[0]['is_featured']=="N"){  echo "checked"; } ?>>&nbsp;No
						</div>
						
						<div class="horizontal_div_full">
							<?php echo lang('Set Language Specific Content');?>
						</div>
						<?php 
						$language_id_arr=array();
						foreach($gallery_arr as $language)
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
									<label for="exampleInputPassword1"><?php echo lang('GALLERY TITLE');?><span style="color:red">*</span></label>
									<input type="text" name="gallery_title<?php echo $language['id'] ?>" id="gallery_title<?php echo $language['id'] ?>" class="form-control" placeholder="Gallery Title" value="<?php echo $language['title'] ?>">
									<div class="form-group has-error" id="gallery_title_error<?php echo $language['id'] ?>" style="display:none;">
										<label class="control-label" for="inputError">
										<i class="fa fa-times-circle-o"> <?php echo lang('Gallery Title field is required');?></i>
										</label>
									</div>
								</div>
								<div class="form-group">
									<label for="exampleInputPassword1"><?php echo lang('Description');?><span style="color:red">*</span></label>
									<textarea id="description<?php echo $language['id'] ?>" class="form-control" name="description<?php echo $language['id'] ?>" rows="3" placeholder="Description"><?php echo $language['description'] ?></textarea>
									<div class="form-group has-error" id="description_error<?php echo $language['id'] ?>" style="display:none;">
										<label class="control-label" for="inputError">
										<i class="fa fa-times-circle-o"> <?php echo lang('Description field is required');?></i>
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
						<input type="submit" class="btn btn-primary" name="save" value="<?php echo lang('Submit');?>">
					</div>
				</form>
			</div><!-- /.box -->
		</div>
	</div>   <!-- /.row -->
</section><!-- /.content -->