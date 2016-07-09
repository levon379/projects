<?php  
require('assets/admin/ckeditor/ckeditor.php');
require('assets/admin/ckfinder/ckfinder.php');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Add Banner
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url(); ?>admin"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Add Banner</li>
	</ol>
</section>
<script>
	function check_form()
	{
		var error=0;
		if($("#banner_image").val()=="")
		{
			$("#banner_image_error").show();
			error++;
		}
		else if($("#banner_image").val()!="")
		{
			$("#banner_image_error").hide();
			var banner_image_name=$("#banner_image").val();
			var extension=banner_image_name.split('.').pop();
			if(extension=="jpg" || extension=="jpeg" || extension=="gif" || extension=="png")
			{
				$("#banner_error_text").html("Image size should be Width of 669px & Height of 453px");
				$("#banner_image_error").hide();
				return true;
			}
			else  
			{
				$("#banner_error_text").html("Only jpg, png, gif file is allowed");
				$("#banner_image_error").show();
				error++;
			}
		}
		else 
		{
			$("#banner_image_error").hide();
		}
		
		if($("#banner_url").val().trim()=="")
		{
			$("#banner_url_error").show();
			error++;
		}
		else
		{
			$("#banner_url_error").hide();
		}
		
		var language_ids=$("#language_id_arr").val();
		var language_id_arr=new Array();
		language_id_arr=language_ids.split("^");
		for(var x=0; x<language_id_arr.length; x++)
		{
			if($("#banner_title"+language_id_arr[x]).val().trim()=="")
			{
				$("#banner_title_error"+language_id_arr[x]).show();
				error++;
			}
			else  
			{
				$("#banner_title_error"+language_id_arr[x]).hide();
			}
			if($("#banner_desc"+language_id_arr[x]).val().trim()=="")
			{
				$("#banner_desc_error"+language_id_arr[x]).show();
				error++;
			}
			else  
			{
				$("#banner_desc_error"+language_id_arr[x]).hide();
			}
			if($("#banner_alt"+language_id_arr[x]).val().trim()=="")
			{
				$("#banner_alt_error"+language_id_arr[x]).show();
				error++;
			}
			else  
			{
				$("#banner_alt_error"+language_id_arr[x]).hide();
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
		<b><?php echo "Image size should be Width of 1600px & Height of 531px"; ?></b>
	</div>
	</section>
	<?php
}
?>

<div class="box_horizontal">
	<a href="<?php echo base_url(); ?>admin/banner/list_banner/<?php echo $default_language_id; ?>" class="btn btn-primary btn-flat">BACK</a>
</div>

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<!-- general form elements -->
			<div class="box box-primary">
				<form role="form" id="form" action="<?php echo base_url(); ?>admin/banner/banner_add" method="POST" enctype="multipart/form-data" onsubmit="return check_form()">
					<div class="box-body">
						<div class="horizontal_div_full">
							Set Language Independent Content
						</div>
						<div class="form-group">
							<label for="exampleInputEmail1">BANNER IMAGE<span style="color:red">*</span></label>
							<input type="file" name="banner_image" id="banner_image" size="20"/>
							<!--span class="text-light-blue">Image size should be within Width of 1600px & Height of 531px</span-->
							<div class="form-group has-error" id="banner_image_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o" id="banner_error_text"> Banner Image field is required</i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">BANNER URL<span style="color:red">*</span></label>
							<input type="text" name="banner_url" id="banner_url" class="form-control" placeholder="Banner URL" value="">
							<div class="form-group has-error" id="banner_url_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> Banner URL field is required</i>
								</label>
							</div>
						</div>
						
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
									<label for="exampleInputPassword1">BANNER TITLE<span style="color:red">*</span></label>
									<input type="text" name="banner_title<?php echo $language['id'] ?>" id="banner_title<?php echo $language['id'] ?>" class="form-control" placeholder="Banner Title" value="">
									<div class="form-group has-error" id="banner_title_error<?php echo $language['id'] ?>" style="display:none;">
										<label class="control-label" for="inputError">
										<i class="fa fa-times-circle-o"> Banner Title field is required</i>
										</label>
									</div>
								</div>
								<div class="form-group">
									<label for="exampleInputPassword1">BANNER DESCRIPTION<span style="color:red">*</span></label>
									<input type="text" name="banner_desc<?php echo $language['id'] ?>" id="banner_desc<?php echo $language['id'] ?>" class="form-control" placeholder="Banner Description" value="">
									<div class="form-group has-error" id="banner_desc_error<?php echo $language['id'] ?>" style="display:none;">
										<label class="control-label" for="inputError">
										<i class="fa fa-times-circle-o"> Banner Description field is required</i>
										</label>
									</div>
								</div>
								<div class="form-group">
									<label for="exampleInputPassword1">BANNER ALT<span style="color:red">*</span></label>
									<input type="text" name="banner_alt<?php echo $language['id'] ?>" id="banner_alt<?php echo $language['id'] ?>" class="form-control" placeholder="Banner Alt" value="">
									<div class="form-group has-error" id="banner_alt_error<?php echo $language['id'] ?>" style="display:none;">
										<label class="control-label" for="inputError">
										<i class="fa fa-times-circle-o"> Banner Alt field is required</i>
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