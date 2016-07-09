<?php  
require('assets/admin/ckeditor/ckeditor.php');
require('assets/admin/ckfinder/ckfinder.php');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Edit Options
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url(); ?>admin"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Edit Options</li>
	</ol>
</section>
<script>
	function check_form()
	{
		var error=0;

		if($("#charge_in_dollars").val().trim()=="")
		{
			$("#charge_in_dollars_error").show();
			error++;
		}
		else
		{
			$("#charge_in_dollars_error").hide();
		}
		if($("#charge_in_euro").val().trim()=="")
		{
			$("#charge_in_euro_error").show();
			error++;
		}
		else
		{
			$("#charge_in_euro_error").hide();
		}
		var language_ids=$("#language_id_arr").val();
		var language_id_arr=new Array();
		language_id_arr=language_ids.split("^");
		for(var x=0; x<language_id_arr.length; x++)
		{
			if($("#options_name"+language_id_arr[x]).val().trim()=="")
			{
				$("#options_name_error"+language_id_arr[x]).show();
				error++;
			}
			else  
			{
				$("#options_name_error"+language_id_arr[x]).hide();
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
	function validate_numbers(value, text_field_id)
	{
		if(value.match(/[^0-9]/g))
		{
			document.getElementById(text_field_id).value=value.replace(/[^0-9]/g, '');
		}
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
		<b><?php echo "Image size should be within 669 * 453"; ?></b>
	</div>
	</section>
	<?php
}
?>

<div class="box_horizontal">
	<a href="<?php echo base_url(); ?>admin/options/list_options/<?php echo $default_language_id; ?>" class="btn btn-primary btn-flat">BACK</a>
</div>


<section class="content">
	<div class="row">
		<div class="col-md-12">
			<!-- general form elements -->
			<div class="box box-primary">
				<form role="form" id="form" action="<?php echo base_url(); ?>admin/options/options_edit/<?php echo $this->uri->segment(4); ?>/<?php echo $this->uri->segment(5); ?>" method="POST" enctype="multipart/form-data" onsubmit="return check_form()">
					<div class="box-body">
						<input type="hidden" value="<?php echo $this->uri->segment(5); ?>" name="options_id">
						<input type="hidden" value="<?php echo $this->uri->segment(4); ?>" name="language_id">
						<div class="horizontal_div_full">
							Set Language Independent Content
						</div>
						<div class="form-group">
							<label for="exampleInputEmail1">CHARGES IN (&dollar;)<span style="color:red">*</span></label>
							<input type="text" name="charge_in_dollars" id="charge_in_dollars" class="form-control" placeholder="Charge In (&dollar;)" value="<?php echo $options_unique_details[0]['charge_in_dollars']; ?>">
							<div class="form-group has-error" id="charge_in_dollars_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> Charges In (&dollar;) field is required</i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputEmail1">CHARGES IN (&euro;)<span style="color:red">*</span></label>
							<input type="text" name="charge_in_euro" id="charge_in_euro" class="form-control" placeholder="Charge In (&euro;)" value="<?php echo $options_unique_details[0]['charge_in_euro']; ?>">
							<div class="form-group has-error" id="charge_in_euro_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> Charges In (&euro;) field is required</i>
								</label>
							</div>
						</div>
						<div class="horizontal_div_full">
							Set Language Specific Content
						</div>
						<?php 
						$language_id_arr=array();
						foreach($options_arr as $language)
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
									<label for="exampleInputPassword1">OPTIONS NAME<span style="color:red">*</span></label>
									<input type="text" name="options_name<?php echo $language['id'] ?>" id="options_name<?php echo $language['id'] ?>" class="form-control" placeholder="Option Name" value="<?php echo $language['options_name']; ?>">
									<div class="form-group has-error" id="options_name_error<?php echo $language['id'] ?>" style="display:none;">
										<label class="control-label" for="inputError">
										<i class="fa fa-times-circle-o"> Option Name field is required</i>
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