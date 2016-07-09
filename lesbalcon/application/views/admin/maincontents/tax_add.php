<?php  
require('assets/admin/ckeditor/ckeditor.php');
require('assets/admin/ckfinder/ckfinder.php');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php echo lang('Add_Tax'); ?>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url(); ?>admin"><i class="fa fa-dashboard"></i> <?php echo lang('Home'); ?></a></li>
		<li class="active"><?php echo lang('Add_Tax'); ?></li>
	</ol>
</section>
<script>
	function check_form()
	{
		var error=0;

		if($("#rate_in_percentage").val().trim()=="")
		{
			$("#rate_in_percentage_error").show();
			error++;
		}
		else
		{
			$("#rate_in_percentage_error").hide();
		}
		
		var language_ids=$("#language_id_arr").val();
		var language_id_arr=new Array();
		language_id_arr=language_ids.split("^");
		for(var x=0; x<language_id_arr.length; x++)
		{
			if($("#tax_name"+language_id_arr[x]).val().trim()=="")
			{
				$("#tax_name_error"+language_id_arr[x]).show();
				error++;
			}
			else  
			{
				$("#tax_name_error"+language_id_arr[x]).hide();
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
	function validate_numeric_field(value, text_field_id)
	{
		if(value.match(/[^0-9]/g))
		{
			document.getElementById(text_field_id).value=value.replace(/[^0-9]/g, '');
		}
	}
</script>
<!-- Main content -->

<div class="box_horizontal">
	<a href="<?php echo base_url(); ?>admin/tax/list_tax/<?php echo $default_language_id; ?>" class="btn btn-primary btn-flat"><?php echo lang('Back'); ?></a>
</div>

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<!-- general form elements -->
			<div class="box box-primary">
				<form role="form" id="form" action="<?php echo base_url(); ?>admin/tax/tax_add" method="POST" enctype="multipart/form-data" onsubmit="return check_form()">
					<div class="box-body">
						<div class="horizontal_div_full">
							<?php echo lang('Set_Language_independent_content'); ?>
						</div>
						<div class="form-group">
							<label for="exampleInputEmail1"><?php echo lang('RATE_IN'); ?> (%)<span style="color:red">*</span></label>
							<input type="text" name="rate_in_percentage" id="rate_in_percentage" class="form-control" placeholder="<?php echo lang('RATE_IN'); ?> (%)" value="" onkeyup="validate_numeric_field(this.value, this.id)">
							<div class="form-group has-error" id="rate_in_percentage_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> <?php echo lang('Rate_In_(%)_field_is_required'); ?></i>
								</label>
							</div>
						</div>
						<div class="horizontal_div_full">
							<?php echo lang('Set_language_Specific_content'); ?>
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
								<?php echo lang('Define_content_for'); ?> <?php echo $language['language_name']; ?>
								</a>
							</div>
							<div id="div_<?php echo $language['id']; ?>">
								<div class="form-group">
									<label for="exampleInputPassword1"><?php echo lang('TAX_NAME'); ?><span style="color:red">*</span></label>
									<input type="text" name="tax_name<?php echo $language['id'] ?>" id="tax_name<?php echo $language['id'] ?>" class="form-control" placeholder="<?php echo lang('TAX_NAME'); ?>" value="">
									<div class="form-group has-error" id="tax_name_error<?php echo $language['id'] ?>" style="display:none;">
										<label class="control-label" for="inputError">
										<i class="fa fa-times-circle-o"> <?php echo lang('Tax_Name_field_is_required'); ?></i>
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