<?php  
require('assets/admin/ckeditor/ckeditor.php');
require('assets/admin/ckfinder/ckfinder.php');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Edit Currency
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url(); ?>admin"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Edit Currency</li>
	</ol>
</section>
<script>
	function check_form()
	{
		var error=0;
		if($("#currency_symbol").val().trim()=="")
		{
			$("#currency_symbol_error").show();
			error++;
		}
		else
		{
			$("#currency_symbol_error").hide();
		}
		if($("#currency_code").val().trim()=="")
		{
			$("#currency_code_error").show();
			error++;
		}
		else
		{
			$("#currency_code_error").hide();
		}
		var language_ids=$("#language_id_arr").val();
		var language_id_arr=new Array();
		language_id_arr=language_ids.split("^");
		for(var x=0; x<language_id_arr.length; x++)
		{
			if($("#currency_name"+language_id_arr[x]).val().trim()=="")
			{
				$("#currency_name_error"+language_id_arr[x]).show();
				error++;
			}
			else  
			{
				$("#currency_name_error"+language_id_arr[x]).hide();
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
	<a href="<?php echo base_url(); ?>admin/currency/list_currency/<?php echo $default_language_id; ?>" class="btn btn-primary btn-flat">BACK</a>
</div>

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<!-- general form elements -->
			<div class="box box-primary">
				<form role="form" id="form" action="<?php echo base_url(); ?>admin/currency/currency_edit/<?php echo $this->uri->segment(4); ?>/<?php echo $this->uri->segment(5)?>" method="POST" enctype="multipart/form-data" onsubmit="return check_form()">
					<div class="box-body">
						<div class="horizontal_div_full">
							Set Language Independent Content
						</div>
						<input type="hidden" value="<?php echo $this->uri->segment(5); ?>" name="currency_auto_id">
						<div class="form-group">
							<label for="exampleInputPassword1">CURRENCY SYMBOL<span style="color:red">*</span></label>
							<input type="text" name="currency_symbol" id="currency_symbol" class="form-control" placeholder="Currency Symbol" value="<?php echo $currency_unique_details[0]['currency_symbol']; ?>">
							<div class="form-group has-error" id="currency_symbol_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> Currency Symbol field is required</i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">CURRENCY CODE<span style="color:red">*</span></label>
							<input type="text" name="currency_code" id="currency_code" class="form-control" placeholder="Currency Code" value="<?php echo $currency_unique_details[0]['currency_code']; ?>">
							<div class="form-group has-error" id="currency_code_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> Currency Code field is required</i>
								</label>
							</div>
						</div>
						<div class="horizontal_div_full">
							Set Language Specific Content
						</div>
						<?php 
						$language_id_arr=array();
						foreach($currency_arr as $language)
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
									<label for="exampleInputPassword1">CURRENCY NAME<span style="color:red">*</span></label>
									<input type="text" name="currency_name<?php echo $language['id'] ?>" id="currency_name<?php echo $language['id'] ?>" class="form-control" placeholder="Currency Name" value="<?php echo $language['currency_name']; ?>">
									<div class="form-group has-error" id="currency_name_error<?php echo $language['id'] ?>" style="display:none;">
										<label class="control-label" for="inputError">
										<i class="fa fa-times-circle-o"> Currency Name field is required</i>
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