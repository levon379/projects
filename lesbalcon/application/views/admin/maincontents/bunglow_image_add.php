<?php  
require('assets/admin/ckeditor/ckeditor.php');
require('assets/admin/ckfinder/ckfinder.php');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Add Bungalow Image
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url(); ?>admin"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="<?php echo base_url()."admin/bunglow/list_bunglow/".$default_language_id; ?>"><?php echo lang("Manage_Bunglow_Property"); ?></a></li>
		<li><a href="<?php echo base_url()."admin/bunglow/bunglow_image_list/".$this->uri->segment(4)."/".$this->uri->segment(5); ?>">Bungalow Images</a></li>
		<li class="active">Add Bungalow Image</li>
	</ol>
</section>
<script>
	function check_form()
	{
		var error=0;
		if($("#bunglow_image").val()=="")
		{
			$("#bunglow_image_error").show();
			error++;
		}
		else if($("#bunglow_image").val()!="")
		{
			$("#bunglow_image_error").hide();
			var bunglow_image_name=$("#bunglow_image").val();
			var extension=bunglow_image_name.split('.').pop();
			if(extension=="jpg" || extension=="jpeg" || extension=="gif" || extension=="png")
			{
				$("#bunglow_image_error_text").html("Image size should be Width of 669px & Height of 453px");
				$("#bunglow_image_error").hide();
				return true;
			}
			else  
			{
				$("#bunglow_image_error_text").html("Only jpg, png, gif file is allowed");
				$("#bunglow_image_error").show();
				error++;
			}
		}
		else 
		{
			$("#bunglow_image_error").hide();
		}
		
		var language_ids=$("#language_id_arr").val();
		var language_id_arr=new Array();
		language_id_arr=language_ids.split("^");
		for(var x=0; x<language_id_arr.length; x++)
		{
			if($("#caption"+language_id_arr[x]).val()=="")
			{
				$("#caption_error"+language_id_arr[x]).show();
				error++;
			}
			else  
			{
				$("#caption_error"+language_id_arr[x]).hide();
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
		<b><?php echo "Image size should be Width of 488px & Height of 241px"; ?></b>
	</div>
	</section>
	<?php
}
?>

<div class="box_horizontal">
	<label style='float:left; margin-left:5px; margin-top:6px;'><?php echo $bunglow_name; ?></label>
	<a href="<?php echo base_url(); ?>admin/bunglow/bunglow_image_list/<?php echo $this->uri->segment(4)."/".$this->uri->segment(5)?>" class="btn btn-primary btn-flat">BACK</a>
</div>
		
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<!-- general form elements -->
			<div class="box box-primary">
				<form role="form" id="form" action="<?php echo base_url(); ?>admin/bunglow/bunglow_image_add/<?php echo $this->uri->segment(4);?>/<?php echo $this->uri->segment(5);?>" method="POST" enctype="multipart/form-data" onsubmit="return check_form()">
					<div class="box-body">
						<div class="horizontal_div_full">
							Set Language Independent Content
						</div>
						<input type="hidden" value="<?php echo $this->uri->segment(5); ?>" name="bunglow_id">
						<input type="hidden" value="<?php echo $this->uri->segment(4); ?>" name="language_id">
						<div class="form-group">
							<label for="exampleInputEmail1">BUNGALOW IMAGE<span style="color:red">*</span></label>
							<input type="file" name="bunglow_image" id="bunglow_image" size="20"/>
							<span class="text-light-blue"><!--Image size should be Width of 488px & Height of 241px--></span>
							<div class="form-group has-error" id="bunglow_image_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o" id="bunglow_image_error_text"> Bungalow Image field is required</i>
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
									<label for="exampleInputPassword1">CAPTION<span style="color:red">*</span></label>
									<input type="text" name="caption<?php echo $language['id'] ?>" id="caption<?php echo $language['id'] ?>" class="form-control" placeholder="Caption" value="">
									<div class="form-group has-error" id="caption_error<?php echo $language['id'] ?>" style="display:none;">
										<label class="control-label" for="inputError">
										<i class="fa fa-times-circle-o"> Caption field is required</i>
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