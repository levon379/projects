<?php  
require('assets/admin/ckeditor/ckeditor.php');
require('assets/admin/ckfinder/ckfinder.php');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Add Testimonials
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url(); ?>admin"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Add Testimonials</li>
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
			if($("#test_name"+language_id_arr[x]).val().trim()=="")
			{
				$("#test_name_error"+language_id_arr[x]).show();
				error++;
			}
			else  
			{
				$("#test_name_error"+language_id_arr[x]).hide();
			}
			if($("#test_email"+language_id_arr[x]).val().trim()=="")
			{
				$("#test_email_error"+language_id_arr[x]).show();
				error++;
			}
			else  
			{
				$("#test_email_error"+language_id_arr[x]).hide();
			}
			if($("#test_comment"+language_id_arr[x]).val().trim()=="")
			{
				$("#test_comment_error"+language_id_arr[x]).show();
				error++;
			}
			else  
			{
				$("#test_comment_error"+language_id_arr[x]).hide();
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
	<a href="<?php echo base_url(); ?>admin/testimonials/view_testimonials/<?php echo $default_language_id; ?>" class="btn btn-primary btn-flat">BACK</a>
</div>

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<!-- general form elements -->
			<div class="box box-primary">
				<form role="form" id="form" action="<?php echo base_url(); ?>admin/testimonials/add_testimonials" method="POST" enctype="multipart/form-data" <!--onsubmit="return check_form()"-->>
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
									<label for="exampleInputPassword1">Name<!--<span style="color:red">*</span>--></label>
									<input type="text" name="test_name<?php echo $language['id'] ?>" id="test_name<?php echo $language['id'] ?>" class="form-control" placeholder="Name" value="">
									<div class="form-group has-error" id="test_name_error<?php echo $language['id'] ?>" style="display:none;">
										<label class="control-label" for="inputError">
										<i class="fa fa-times-circle-o"> Name field is required</i>
										</label>
									</div>
								</div>
								<div class="form-group">
									<label for="exampleInputPassword1">Email<!--<span style="color:red">*</span>--></label>
									<input type="text" name="test_email<?php echo $language['id'] ?>" id="test_email<?php echo $language['id'] ?>" class="form-control" placeholder="Email" value="">
									<div class="form-group has-error" id="test_email_error<?php echo $language['id'] ?>" style="display:none;">
										<label class="control-label" for="inputError">
										<i class="fa fa-times-circle-o"> Email field is required</i>
										</label>
									</div>
								</div>
								<div class="form-group">
									<label for="exampleInputPassword1">Description<!--<span style="color:red">*</span>--></label>
									<textarea name="test_comment<?php echo $language['id'] ?>" id="test_comment<?php echo $language['id'] ?>" class="form-control" placeholder="Description" rows="3"></textarea>
									<div class="form-group has-error" id="test_comment_error<?php echo $language['id'] ?>" style="display:none;">
										<label class="control-label" for="inputError">
										<i class="fa fa-times-circle-o"> Description field is required</i>
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