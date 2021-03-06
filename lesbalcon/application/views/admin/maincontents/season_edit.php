<?php  
require('assets/admin/ckeditor/ckeditor.php');
require('assets/admin/ckfinder/ckfinder.php');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Edit Season
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url(); ?>admin"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Edit Season</li>
	</ol>
</section>
<script>
	function check_form()
	{
		var error=0;
		/*var all_months=document.getElementsByName("months[]");
		var checked_attribute=0;
		for(var i=0; i<all_months.length; i++)
		{
			var result=all_months[i].parentNode.getAttribute("aria-checked");
			if(result=="true")
			{
				checked_attribute++;
			}
		}
		if(checked_attribute==0)
		{
			$("#months_error").show();
			error++;
		}
		else 
		{
			$("#months_error").hide();
		}*/
		var language_ids=$("#language_id_arr").val();
		var language_id_arr=new Array();
		language_id_arr=language_ids.split("^");
		for(var x=0; x<language_id_arr.length; x++)
		{
			if($("#season_name"+language_id_arr[x]).val().trim()=="")
			{
				$("#season_name_error"+language_id_arr[x]).show();
				error++;
			}
			else  
			{
				$("#season_name_error"+language_id_arr[x]).hide();
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
	<a href="<?php echo base_url(); ?>admin/season/list_season/<?php echo $default_language_id; ?>" class="btn btn-primary btn-flat">BACK</a>
</div>
<?php $months_arr=explode("^", $unique_details[0]['months']); ?>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<!-- general form elements -->
			<div class="box box-primary">
				<form role="form" id="form" action="<?php echo base_url(); ?>admin/season/season_edit/<?php echo $this->uri->segment(4); ?>/<?php echo $this->uri->segment(5); ?>" method="POST" enctype="multipart/form-data" onsubmit="return check_form()">
					<div class="box-body">
						<div class="horizontal_div_full">
							Set Language Independent Content
						</div>
						<?php /*?><div class="form-group">
							<label for="exampleInputEmail1">SELECT MONTHS <span style="color:red">*</span></label>
							<div style="width:50%; height:150px; border:1px solid #ccc; overflow-y:scroll;">
								<div style="margin-left:2%;">
									<input type="checkbox" name="months[]" value="1" <?php if(in_array(1, $months_arr)){ echo "checked"; } ?>>&nbsp;JANUARY<br>
									<input type="checkbox" name="months[]" value="2" <?php if(in_array(2, $months_arr)){ echo "checked"; } ?>>&nbsp;FEBRUARY<br>
									<input type="checkbox" name="months[]" value="3" <?php if(in_array(3, $months_arr)){ echo "checked"; } ?>>&nbsp;MARCH<br>
									<input type="checkbox" name="months[]" value="4" <?php if(in_array(4, $months_arr)){ echo "checked"; } ?>>&nbsp;APRIL<br>
									<input type="checkbox" name="months[]" value="5" <?php if(in_array(5, $months_arr)){ echo "checked"; } ?>>&nbsp;MAY<br>
									<input type="checkbox" name="months[]" value="6" <?php if(in_array(6, $months_arr)){ echo "checked"; } ?>>&nbsp;JUNE<br>
									<input type="checkbox" name="months[]" value="7" <?php if(in_array(7, $months_arr)){ echo "checked"; } ?>>&nbsp;JULY<br>
									<input type="checkbox" name="months[]" value="8" <?php if(in_array(8, $months_arr)){ echo "checked"; } ?>>&nbsp;AUGUST<br>
									<input type="checkbox" name="months[]" value="9" <?php if(in_array(9, $months_arr)){ echo "checked"; } ?>>&nbsp;SEPTEMBER<br>
									<input type="checkbox" name="months[]" value="10" <?php if(in_array(10, $months_arr)){ echo "checked"; } ?>>&nbsp;OCTOBER<br>
									<input type="checkbox" name="months[]" value="11" <?php if(in_array(11, $months_arr)){ echo "checked"; } ?>>&nbsp;NOVEMBER<br>
									<input type="checkbox" name="months[]" value="12" <?php if(in_array(12, $months_arr)){ echo "checked"; } ?>>&nbsp;DECEMBER<br>
								</div>
							</div>
							<div class="form-group has-error" id="months_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> Select Months field is required</i>
								</label>
							</div>
						</div><?php */?>
						<div class="horizontal_div_full">
							Set Language Specific Content
						</div>
						<input type="hidden" value="<?php echo $this->uri->segment(5); ?>" name="season_id">
						<input type="hidden" value="<?php echo $this->uri->segment(4); ?>" name="language_id">
						<?php 
						$language_id_arr=array();
						foreach($season_arr as $language)
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
									<label for="exampleInputPassword1">SEASON NAME<span style="color:red">*</span></label>
									<input type="text" name="season_name<?php echo $language['id'] ?>" id="season_name<?php echo $language['id'] ?>" class="form-control" placeholder="Season Name" value="<?php echo $language['season_name']; ?>">
									<div class="form-group has-error" id="season_name_error<?php echo $language['id'] ?>" style="display:none;">
										<label class="control-label" for="inputError">
										<i class="fa fa-times-circle-o"> Season Name field is required</i>
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