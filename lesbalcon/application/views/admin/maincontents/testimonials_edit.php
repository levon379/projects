<?php  
require('assets/admin/ckeditor/ckeditor.php');
require('assets/admin/ckfinder/ckfinder.php');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php echo lang('Modifier les Testimoniaux');?>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url(); ?>admin"><i class="fa fa-dashboard"></i> <?php echo lang('Home');?></a></li>
		<li class="active"><?php echo lang('Modifier les Testimoniaux');?></li>
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
	<a href="<?php echo base_url(); ?>admin/bunglow/view_testimonials/<?php echo $default_language_id; ?>" class="btn btn-primary btn-flat"><?php echo lang('Back');?></a>
</div>

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<!-- general form elements -->
			<div class="box box-primary">
				<form role="form" id="form" action="<?php echo base_url(); ?>admin/testimonials/edit_testimonials" method="POST" enctype="multipart/form-data">
					<div class="box-body">
						<div class="horizontal_div_full">
							<?php echo lang('Set_language_Specific_content');?>
						</div>
						<input type="hidden" value="<?php echo $this->uri->segment(5); ?>" name="testimonials_id">
						<input type="hidden" value="<?php echo $this->uri->segment(4); ?>" name="language_id">
						
						<?php /*?><input type="hidden" value="<?php echo $this->uri->segment(6); ?>" name="bunglow_id"><?php */?>
						<?php 
						$language_id_arr=array();
						foreach($testimonials_arr as $language)
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
									<label for="exampleInputPassword1"><?php echo lang('Name');?><!--<span style="color:red">*</span>--></label>
									<input type="text" name="test_name<?php echo $language['id'] ?>" id="test_name<?php echo $language['id'] ?>" class="form-control" placeholder="Name" value="<?php echo $language['user_name']; ?>">
									<div class="form-group has-error" id="test_name_error<?php echo $language['id'] ?>" style="display:none;">
										<label class="control-label" for="inputError">
										<i class="fa fa-times-circle-o"> <?php echo lang('Name_field_is_required');?></i>
										</label>
									</div>
								</div>
								<div class="form-group">
									<label for="exampleInputPassword1"><?php echo lang('Email');?><!--<span style="color:red">*</span>--></label>
									<input type="text" name="test_email<?php echo $language['id'] ?>" id="test_email<?php echo $language['id'] ?>" class="form-control" placeholder="Email" value="<?php echo $language['user_email']; ?>">
									<div class="form-group has-error" id="test_email_error<?php echo $language['id'] ?>" style="display:none;">
										<label class="control-label" for="inputError">
										<i class="fa fa-times-circle-o"> <?php echo lang('Email field is required');?></i>
										</label>
									</div>
								</div>
								<div class="form-group">
									<label for="exampleInputPassword1"><?php echo lang('Description');?><!--<span style="color:red">*</span>--></label>
									<textarea name="test_comment<?php echo $language['id'] ?>" id="test_comment<?php echo $language['id'] ?>" class="form-control" placeholder="Description" rows="3"><?php echo $language['content']; ?></textarea>
									<div class="form-group has-error" id="test_comment_error<?php echo $language['id'] ?>" style="display:none;">
										<label class="control-label" for="inputError">
										<i class="fa fa-times-circle-o"><?php echo lang('Description field is required');?></i>
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