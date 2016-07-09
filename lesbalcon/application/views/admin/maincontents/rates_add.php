<?php  
require('assets/admin/ckeditor/ckeditor.php');
require('assets/admin/ckfinder/ckfinder.php');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Add Rates
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url(); ?>admin"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Add Rates</li>
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
	
	function validate_numeric_field(value, text_field_id)
	{
		if(value.match(/[^0-9]/g))
		{
			document.getElementById(text_field_id).value=value.replace(/[^0-9]/g, '');
		}
	}
	
</script>
<!-- Main content -->
<?php 
if(isset($_GET["exists"]))
{
	?>
	<section class="content" >
	<div class="alert alert-danger alert-dismissable" style="margin-bottom:0px;">
		<i class="fa fa-ban"></i>
		<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
		<b><?php echo "Rates already exists. You can edit rates."; ?></b>
	</div>
	</section>
	<?php
}
?>

<div class="box_horizontal">
	<a href="<?php echo base_url(); ?>admin/rates/list_rates/<?php echo $default_language_id; ?>" class="btn btn-primary btn-flat">BACK</a>
</div>

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<!-- general form elements -->
			<div class="box box-primary">
				<form role="form" id="form" action="<?php echo base_url(); ?>admin/rates/rates_add" method="POST" enctype="multipart/form-data" onsubmit="return check_form()">
					<div class="box-body">
						<div class="form-group">
							<label for="exampleInputPassword1">CHOOSE BUNGLOW<span style="color:red">*</span></label>
							<select name="bunglow_id" id="bunglow_id" class="form-control" style="width:40%;">
								<option value="">--Select--</option>
								<?php
									foreach($bunglow_arr as $bunglow)
									{
										?>
										<option value="<?php echo $bunglow['bunglow_id']; ?>"><?php echo $bunglow['bunglow_name']; ?></option>
										<?php 
									}
								?>
							</select>
							<div class="form-group has-error" id="bunglow_id_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> Bunglow field is required</i>
								</label>
							</div>
						</div>
						<?php 
						$season_id_arr=array();
						if(count($seasons_arr)>0)
						{
							?>

<!--<div class="bunglow-choose-main">
							<div class="col1">&nbsp;</div>
							<div class="col3"><label>Rates in &dollar;Per Night</label></div>
							<div class="col4"><label>Rates in &euro; Per Night</label></div>
<div class="col3a"><label>Test 111</label></div>
                            <div class="col2"><label>Discount in % (Optional) Per Night</label></div>
							<div class="col5"><label>Rates in &dollar;Per Week</label></div>
							<div class="col6"><label>Rates in &euro; Per Week</label></div>
<div class="col6a"><label>Test 222</label></div>
							<div class="col7"><label>Discount in % (Optional) Per Week</label></div>
						</div>-->


							<div class="bunglow-choose-main">
							<div class="col1">&nbsp;</div>
							<!-- <div class="col2"><label>Rates in &dollar;Per Night</label></div> -->
							<div class="col3"><label>Rates in &euro; Per Night</label></div>
                             <div class="col3a"><label>Extra night after week rental &euro; price</label></div>
                            <!--<div class="col4"><label>Discount in % (Optional) Per Night</label></div>
							<div class="col5"><label>Rates in &dollar;Per Week</label></div>
							<div class="col6"><label>Rates in &euro; Per Week</label></div>
                            <div class="col6a"><label>Extra night after week rental &dollar; price</label></div>
							<div class="col7"><label>Discount in % (Optional) Per Week</label></div> -->
						</div>
							<?php 
							foreach($seasons_arr as $season)
							{
								array_push($season_id_arr, $season['season_id']);
								?>
								<div class="bunglow-choose-main">
									<div class="col1"><label for="exampleInputPassword1">RATE FOR <?php echo strtoupper($season['season_name']); ?><span style="color:red">*</span></label></div>
									<?php /*?><input type="text" name="discount<?php echo $season['season_id'] ?>" id="discount<?php echo $season['season_id'] ?>" class="form-control" Style="width:12%; float:right; margin-left:2%;" placeholder="Discount in % (Optional)" value="" onkeyup="validate_numeric_field(this.value, this.id)"><?php */?>
                                    <!-- <div class="col2"><input type="text" name="rate_in_dollar_night<?php echo $season['season_id'] ?>" id="rate_in_dollar_night<?php echo $season['season_id'] ?>" class="form-control"  placeholder="Rate in &dollar;" value="" onkeyup="validate_numeric_field(this.value, this.id)"></div> -->
									<div class="col3"><input type="text" name="rate_in_euro_night<?php echo $season['season_id'] ?>" id="rate_in_euro_night<?php echo $season['season_id'] ?>" class="form-control"  placeholder="Rate in &euro;" value="" onkeyup="validate_numeric_field(this.value, this.id)"></div>
                                     <div class="col3a"><input type="text" name="extranight_perday_europrice<?php echo $season['season_id'] ?>" id="extranight_perday_europrice<?php echo $season['season_id'] ?>" class="form-control"  placeholder="Rate in &euro;" value="" onkeyup="validate_numeric_field(this.value, this.id)"></div>
                                    <!--<div class="col4"><input type="text" name="discount_per_night<?php echo $season['season_id'] ?>" id="discount_per_night<?php echo $season['season_id'] ?>" class="form-control"  placeholder="Discount in % (Optional)" value="" onkeyup="validate_numeric_field(this.value, this.id)"></div>
                                    <div class="col5"><input type="text" name="rate_in_dollar_week<?php echo $season['season_id'] ?>" id="rate_in_dollar_week<?php echo $season['season_id'] ?>" class="form-control"  placeholder="Rate in &dollar;" value="" onkeyup="validate_numeric_field(this.value, this.id)"></div>
                                    <div class="col6"><input type="text" name="rate_in_euro_week<?php echo $season['season_id'] ?>" id="rate_in_euro_week<?php echo $season['season_id'] ?>" class="form-control"  placeholder="Rate in &euro;" value="" onkeyup="validate_numeric_field(this.value, this.id)"></div>
                                    <div class="col7"><input type="text" name="discount_per_week<?php echo $season['season_id'] ?>" id="discount_per_week<?php echo $season['season_id'] ?>" class="form-control"  placeholder="Discount in % (Optional)" value="" onkeyup="validate_numeric_field(this.value, this.id)"></div>
                                    <div class="col6a"><input type="text" name="extranight_perday_dollerprice<?php echo $season['season_id'] ?>" id="extranight_perday_dollerprice<?php echo $season['season_id'] ?>" class="form-control"  placeholder="Rate in &dollar;" value="" onkeyup="validate_numeric_field(this.value, this.id)"></div>
									 -->
									
									<div class="form-group has-error" id="rate_error<?php echo $season['season_id'] ?>" style="padding-left:21%; display:none;">
										<label class="control-label" for="inputError">
										<i class="fa fa-times-circle-o"> Both &euro; and $ Rate Fields are required</i>
										</label>
									</div>
								</div>
								
								<?php 
							}
						}
						else 
						{
							?>
							<div class="form-group">Please add seasons to add rates</div>
							<?php 
						}
						?>
						<input type="hidden" value="<?php echo implode("^", $season_id_arr); ?>" name="season_id_arr" id="season_id_arr">
					</div><!-- /.box-body -->
					<?php 
					if(count($seasons_arr)>0)
					{
						?>
						<div class="box-footer">
							<input type="submit" class="btn btn-primary" name="save" value="Submit">
						</div>
						<?php 
					}
					?>
				</form>
			</div><!-- /.box -->
		</div>
	</div>   <!-- /.row -->
</section><!-- /.content -->