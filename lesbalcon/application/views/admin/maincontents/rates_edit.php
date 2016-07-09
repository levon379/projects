<?php  
require('assets/admin/ckeditor/ckeditor.php');
require('assets/admin/ckfinder/ckfinder.php');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php echo lang('Edit Rates');?>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url(); ?>admin"><i class="fa fa-dashboard"></i><?php echo lang('Home');?></a></li>
		<li class="active"><?php echo lang('Edit Rates');?></li>
	</ol>
</section>
<script>
	function check_form()
	{
		var error=0;
		
		if($("#bunglow_id").val()=="")
		{
			$("#bunglow_id_error").show();
			error++;
		}
		else
		{
			$("#bunglow_id_error").hide();
		}
		
		var seasons_ids=$("#season_id_arr").val();
		var seasons_id_arr=new Array();
		seasons_id_arr=seasons_ids.split("^");
		for(var x=0; x<seasons_id_arr.length; x++)
		{
			if($("#rate_in_dollar_night"+seasons_id_arr[x]).val().trim()=="" || $("#rate_in_euro_night"+seasons_id_arr[x]).val().trim()=="" || $("#rate_in_dollar_week"+seasons_id_arr[x]).val().trim()=="" || $("#rate_in_euro_week"+seasons_id_arr[x]).val().trim()=="")
			{
				$("#rate_error"+seasons_id_arr[x]).show();
				error++;
			}
			{
				$("#rate_error"+seasons_id_arr[x]).show();
				error++;
			}
			else  
			{
				$("#rate_error"+seasons_id_arr[x]).hide();
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
		<b><?php echo lang('Image size should be Width of 669px & Height of 453px'); ?></b>
	</div>
	</section>
	<?php
}
?>

<div class="box_horizontal">
	<a href="<?php echo base_url(); ?>admin/rates/list_rates/<?php echo $default_language_id; ?>" class="btn btn-primary btn-flat"><?php echo lang('Back');?></a>
</div>

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<!-- general form elements -->
			<div class="box box-primary">
				<form role="form" id="form" action="<?php echo base_url(); ?>admin/rates/rates_edit" method="POST" enctype="multipart/form-data" onsubmit="return check_form()">
					<div class="box-body">
						<input type="hidden" name="edit_bunglow_id" id="edit_bunglow_id" value="<?php echo $this->uri->segment(4); ?>">
						<div class="form-group">
							<label for="exampleInputPassword1"><?php echo lang('CHOOSE BUNGLOW');?><span style="color:red">*</span></label>
							<select name="bunglow_id" id="bunglow_id" class="form-control" style="width:40%;" disabled="true">
								<option value="">--Select--</option>
								<?php
									foreach($bunglow_arr as $bunglow)
									{
										?>
										<option value="<?php echo $bunglow['bunglow_id']; ?>" <?php if($this->uri->segment(4)==$bunglow['bunglow_id']){ echo "selected"; } ?>><?php echo $bunglow['bunglow_name']; ?></option>
										<?php 
									}
								?>
							</select>
							<div class="form-group has-error" id="bunglow_id_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> <?php echo lang('Bunglow field is required');?></i>
								</label>
							</div>
						</div>

						<!--CHOOSE BUNGLOW section start-->
						
						<div class="bunglow-choose-main">
							<div class="col1">&nbsp;</div>
							<div class="col2"><label><?php echo lang('Rates in &dollar;Per Night');?></label></div>
							<div class="col3"><label><?php echo lang('Rates in &euro; Per Night');?></label></div>
                            <div class="col3a"><label><?php echo lang('Extra night after week rental &euro; price');?></label></div>
                            <div class="col4"><label><?php echo lang('Discount in % (Optional) Per Night');?></label></div>
							<div class="col5"><label><?php echo lang('Rates in &dollar;Per Week');?></label></div>
							<div class="col6"><label><?php echo lang('Rates in &euro; Per Week');?></label></div>
                            <div class="col6a"><label><?php echo lang('Extra night after week rental &euro; price');?></label></div>
							<div class="col7"><label><?php echo lang('Discount in % (Optional) Per Week');?></label></div>
						</div>
						
						<?php
						$season_id_arr=array();
						foreach($rates_arr as $season)
						{
							array_push($season_id_arr, $season['season_id']);
							?>
						<div class="bunglow-choose-main">
							<div class="col1"><label for="exampleInputPassword1"><?php echo lang('RATE FOR');?> <?php echo strtoupper($season['season_name']); ?><span style="color:red">*</span></label></div>
							<div class="col2"><input type="text" name="rate_in_dollar_night<?php echo $season['season_id'] ?>" id="rate_in_dollar_night<?php echo $season['season_id'] ?>" class="form-control" placeholder="Rate in &dollar;" value="<?php echo $season['rate_per_day_dollar'] ?>"></div>
							<div class="col3"><input type="text" name="rate_in_euro_night<?php echo $season['season_id'] ?>" id="rate_in_euro_night<?php echo $season['season_id'] ?>" class="form-control" placeholder="Rate in &euro;" value="<?php echo $season['rate_per_day_euro'] ?>"></div>
							<div class="col3a"><input type="text" name="extranight_perday_europrice<?php echo $season['season_id'] ?>" id="extranight_perday_europrice<?php echo $season['season_id'] ?>" class="form-control"  placeholder="Rate in &euro;" value="<?php echo $season['extranight_perday_europrice'] ?>" onkeyup="validate_numeric_field(this.value, this.id)"></div>
							<div class="col4"><input type="text" name="discount_per_night<?php echo $season['season_id'] ?>" id="discount_per_night<?php echo $season['season_id'] ?>" class="form-control" placeholder="Discount in % (Optional)" value="<?php echo $season['discount_per_night'] ?>"></div>
							<div class="col5"><input type="text" name="rate_in_dollar_week<?php echo $season['season_id'] ?>" id="rate_in_dollar_week<?php echo $season['season_id'] ?>" class="form-control" placeholder="Rate in &dollar;" value="<?php echo $season['rate_per_week_dollar'] ?>"></div>
							<div class="col6"><input type="text" name="rate_in_euro_week<?php echo $season['season_id'] ?>" id="rate_in_euro_week<?php echo $season['season_id'] ?>" class="form-control" placeholder="Rate in &euro;" value="<?php echo $season['discount_per_week'] ?>"></div>
							<div class="col7"><input type="text" name="discount_per_week<?php echo $season['season_id'] ?>" id="discount_per_week<?php echo $season['season_id'] ?>" class="form-control"  placeholder="Discount11 in % (Optional)" value="<?php echo $season['discount_per_week'] ?>" onkeyup="validate_numeric_field(this.value, this.id)"></div>
							<div class="col6a"><input type="text" name="extranight_perday_dollerprice<?php echo $season['season_id'] ?>" id="extranight_perday_dollerprice<?php echo $season['season_id'] ?>" class="form-control"  placeholder="Rate in &dollar;" value="<?php echo $season['extranight_perday_dollerprice'] ?>" onkeyup="validate_numeric_field(this.value, this.id)"></div>
						
                       <div class="form-group has-error" id="rate_error<?php echo $season['season_id'] ?>" style="padding-left:21%; display:none;">
							<label class="control-label" for="inputError">
							<i class="fa fa-times-circle-o"> <?php echo lang('Both &euro; and $ Rate Fields are required');?></i>
							</label>
						</div>
                        </div>
						<?php 
						}
						?>

						<!--CHOOSE BUNGLOW section start-->

						<!--<div class="form-group">
							    <label></label>
							    <table><tr><td>
							    <label Style="width:25%; float:right; margin-left:2%;">Discount in % (Optional) Per Night</label>
								<label Style="width:25%; float:right; margin-left:2%;">Rates in &dollar;Per Night</label>
								<label Style="width:25%; float:right; margin-left:2%;">Rates in &euro; Per Night</label></td>
								<td>
								<label Style="width:25%; float:right; margin-left:2%;">Discount in % (Optional) Per Week</label>
								<label Style="width:25%; float:right; margin-left:2%;">Rates in &dollar;Per Week</label>
								<label Style="width:25%; float:right; margin-left:2%;">Rates in &euro; Per Week</label></td>
								</tr>
								</table>
						</div>-->
						<?php /*?><?php 
						$season_id_arr=array();
						foreach($rates_arr as $season)
						{
							array_push($season_id_arr, $season['season_id']);
							?>
							<div class="form-group">
								<label for="exampleInputPassword1">RATE FOR <?php echo strtoupper($season['season_name']); ?><span style="color:red">*</span></label>
								<input type="text" name="discount_week<?php echo $season['season_id'] ?>" id="discount_week<?php echo $season['season_id'] ?>" class="form-control" Style="width:12%; float:right; margin-left:2%;" placeholder="Discount in % (Optional)" value="<?php echo $season['discount_week'] ?>">
								<input type="text" name="rate_in_dollar_week<?php echo $season['season_id'] ?>" id="rate_in_dollar_week<?php echo $season['season_id'] ?>" class="form-control" Style="width:12%; float:right; margin-left:2%;" placeholder="Rate in &dollar;" value="<?php echo $season['rate_per_week_dollar'] ?>">
								<input type="text" name="rate_in_euro_week<?php echo $season['season_id'] ?>" id="rate_in_euro_week<?php echo $season['season_id'] ?>" class="form-control" Style="width:12%; float:right;" placeholder="Rate in &euro;" value="<?php echo $season['rate_per_week_euro'] ?>">
								<input type="text" name="discount_night<?php echo $season['season_id'] ?>" id="discount_night<?php echo $season['season_id'] ?>" class="form-control" Style="width:12%; float:right; margin-left:2%;" placeholder="Discount in % (Optional)" value="<?php echo $season['discount_night'] ?>">
								<input type="text" name="rate_in_dollar_night<?php echo $season['season_id'] ?>" id="rate_in_dollar_night<?php echo $season['season_id'] ?>" class="form-control" Style="width:12%; float:right; margin-left:2%;" placeholder="Rate in &dollar;" value="<?php echo $season['rate_per_day_dollar'] ?>">
								<input type="text" name="rate_in_euro_night<?php echo $season['season_id'] ?>" id="rate_in_euro_night<?php echo $season['season_id'] ?>" class="form-control" Style="width:12%; float:right;" placeholder="Rate in &euro;" value="<?php echo $season['rate_per_day_euro'] ?>">
								<div class="form-group has-error" id="rate_error<?php echo $season['season_id'] ?>" style="padding-left:21%; display:none;">
									<label class="control-label" for="inputError">
									<i class="fa fa-times-circle-o"> Both Rate Fields are required</i>
									</label>
								</div>
							</div>
							
							<?php 
						}
						?><?php */?>

						<input type="hidden" value="<?php echo implode("^", $season_id_arr); ?>" name="season_id_arr" id="season_id_arr">
					</div><!-- /.box-body -->
					<div class="box-footer">
						<input type="submit" class="btn btn-primary" name="save" value="<?php echo lang('Submit');?>">
					</div>
				</form>
			</div><!-- /.box -->
		</div>
	</div>   <!-- /.row -->
</section><!-- /.content -->