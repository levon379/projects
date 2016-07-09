<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php echo lang('Site Settings');?>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url(); ?>admin"><i class="fa fa-dashboard"></i> <?php echo lang('Home');?></a></li>
		<li class="active"><?php echo lang('Site Settings');?></li>
	</ol>
</section>
<script>
	function check_form()
	{
		var error=0;
		if($("#site_name").val().trim()=="")
		{
			$("#site_name_error").show();
			error++;
		}
		else 
		{
			$("#site_name_error").hide();
		}
		if($("#pagination_no").val().trim()=="")
		{
			$("#pagination_no_error").show();
			error++;
		}
		else 
		{
			$("#pagination_no_error").hide();
		}
		/*if($("#site_address").val()=="")
		{
			$("#site_address_error").show();
			error++;
		}
		else 
		{
			$("#site_address_error").hide();
		}*/
		if($("#partial_amount").val().trim()=="")
		{
			$("#partial_amount_error").show();
			error++;
		}
		else 
		{
			$("#partial_amount_error").hide();
		}
		if($("#site_title").val().trim()=="")
		{
			$("#site_title_error").show();
			error++;
		}
		else 
		{
			$("#site_title_error").hide();
		}
		if($("#admin_time_zone").val()=="")
		{
			$("#admin_time_zone_error").show();
			error++;
		}
		else 
		{
			$("#admin_time_zone_error").hide();
		}
		if($("#meta_title").val().trim()=="")
		{
			$("#meta_title_error").show();
			error++;
		}
		else 
		{
			$("#meta_title_error").hide();
		}
		if($("#meta_keyword").val().trim()=="")
		{
			$("#meta_keyword_error").show();
			error++;
		}
		else 
		{
			$("#meta_keyword_error").hide();
		}
		if($("#meta_description").val().trim()=="")
		{
			$("#meta_description_error").show();
			error++;
		}
		else 
		{
			$("#meta_description_error").hide();
		}
		if($("#paypal_url").val().trim()=="")
		{
			$("#paypal_url_error").show();
			error++;
		}
		else 
		{
			$("#paypal_url_error").hide();
		}
		if($("#paypal_id").val().trim()=="")
		{
			$("#paypal_id_error").show();
			error++;
		}
		else 
		{
			$("#paypal_id_error").hide();
		}
		if(error>0)
		{
			$(window).scrollTop($("#form").offset().top);
			return false;
		}
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
<section class="content">
	<?php
	if($success_message)
	{
		?>
		<div class="alert alert-success alert-dismissable">
			<i class="fa fa-check"></i>
			<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
			<b><?php echo $success_message; ?></b>
		</div>
		
		<?php
	}
	if($error_message)
	{
		?>
		<div class="alert alert-danger alert-dismissable">
			<i class="fa fa-ban"></i>
			<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
			<b><?php echo $error_message; ?></b>
		</div>
		<?php
	}
	?>
	<div class="row">
		<div class="col-md-11">
			<!-- general form elements -->
			<div class="box box-primary">
				<!--<div class="box-header">
					<h3 class="box-title">Quick Example</h3>
				</div>-->
				<!-- form start -->
				<form role="form" id="form" action="<?php echo base_url(); ?>admin/admin_setting/index/1" method="POST" onsubmit="return check_form()">
					<input type="hidden" name="site_setting_id" id="site_setting_id" value="<?php echo $row["site_setting_id"]; ?>">
					<div class="box-body">
						<div class="form-group">
							<label for="exampleInputEmail1"><?php echo lang('SITE NAME');?><span style="color:red">*</span></label>
							<input type="text" name="site_name" id="site_name" class="form-control" id="exampleInputEmail1" placeholder="Site Name" value="<?php echo $row['site_name']; ?>">
							<div class="form-group has-error" id="site_name_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> <?php echo lang('Site Name field is required');?></i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1"><?php echo lang('DEFAULT PAGINATION NO');?>.<span style="color:red">*</span></label>
							<input type="text" name="pagination_no" id="pagination_no" class="form-control" id="exampleInputPassword1" placeholder="Site Pagination No" value="<?php echo $row['pagination_no']; ?>">
							<div class="form-group has-error" id="pagination_no_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> <?php echo lang('Site Pagination No field is required');?></i>
								</label>
							</div>
						</div>
						<!--<div class="form-group">
							<label for="exampleInputPassword1">SITE ADDRESS<span style="color:red">*</span></label>
							<input type="text" name="site_address" id="site_address" class="form-control" id="exampleInputPassword1" placeholder="Site Address" value="<?php echo $row['site_address']; ?>">
							<div class="form-group has-error" id="site_address_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> Site Address field is required</i>
								</label>
							</div>
						</div>-->
						<div class="form-group">
							<label for="exampleInputPassword1"><?php echo lang('PARTIAL PAYMENT AMOUNT');?>(%)<span style="color:red">*</span></label>
							<input type="text" name="partial_amount" id="partial_amount" class="form-control" id="exampleInputPassword1" placeholder="Partial Payment Amount" value="<?php echo $row['partial_amount_percentage']; ?>" onkeyup="validate_numeric_field(this.value, this.id)">
							<div class="form-group has-error" id="partial_amount_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> <?php echo lang('Partial Payment Amount field is required');?></i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1"><?php echo lang('SITE TITLE');?><span style="color:red">*</span></label>
							<input type="text" name="site_title" id="site_title" class="form-control" id="exampleInputPassword1" placeholder="Site Title" value="<?php echo $row['site_title']; ?>">
							<div class="form-group has-error" id="site_title_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> <?php echo lang('Site Title field is required');?></i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1"><?php echo lang('ADMIN TIME ZONE');?><span style="color:red">*</span></label>
							<?php $this->load->view('admin/maincontents/list-time-zone'); ?>
							<div class="form-group has-error" id="admin_time_zone_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> <?php echo lang('Admin Time Zone field is required');?></i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1"><?php echo lang('Meta_Title');?><span style="color:red">*</span></label>
							<input type="text" name="meta_title" id="meta_title" class="form-control" id="exampleInputPassword1" placeholder="Meta Title" value="<?php echo $row['meta_title']; ?>">
							<div class="form-group has-error" id="meta_title_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> <?php echo lang('Meta Title field is required');?></i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1"><?php echo lang('META KEYWORDS');?><span style="color:red">*</span></label>
							<input type="text" name="meta_keyword" id="meta_keyword" class="form-control" id="exampleInputPassword1" placeholder="Meta Keyword" value="<?php echo $row['meta_keyword']; ?>">
							<div class="form-group has-error" id="meta_keyword_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> <?php echo lang('Meta Keywords field is required');?></i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1"><?php echo lang('Meta_Description');?><span style="color:red">*</span></label>
							<input type="text" name="meta_description" id="meta_description" class="form-control" id="exampleInputPassword1" placeholder="Meta Description" value="<?php echo $row['meta_description']; ?>">
							<div class="form-group has-error" id="meta_description_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> <?php echo lang('Meta Description field is required');?></i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1"><?php echo lang('PAYPAL URL');?><span style="color:red">*</span></label>
							<input type="text" name="paypal_url" id="paypal_url" class="form-control" id="exampleInputPassword1" placeholder="Paypal URL" value="<?php echo $row['paypal_url']; ?>">
							<div class="form-group has-error" id="paypal_url_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> <?php echo lang('Paypal URL field is required');?></i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1"><?php echo lang('PAYPAL ID');?><span style="color:red">*</span></label>
							<input type="text" name="paypal_id" id="paypal_id" class="form-control" id="exampleInputPassword1" placeholder="Paypal Id" value="<?php echo $row['paypal_id']; ?>">
							<div class="form-group has-error" id="paypal_id_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> <?php echo lang('Paypal Id field is required');?></i>
								</label>
							</div>
						</div>
					</div><!-- /.box-body -->
					<div class="box-footer">
						<input type="submit" class="btn btn-primary" name="save" value="<?php echo lang();?>">
					</div>
				</form>
			</div><!-- /.box -->
		</div>
	</div>   <!-- /.row -->
</section><!-- /.content -->