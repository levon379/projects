

<!-- Content Header (Page header) -->
<div id="box_moblie" style="width:125px; height:85px; background:#CCC; position:absolute; z-index:9999; display:none;">
	<!--<div class="cls" style="width:15px; height:15px; background:#963; position:relative; float:right;">X</div>-->
	<div style="margin-left:10px;"><a href="#">Add a reservation</a></div>
	<div style="margin-left:10px;"><a href="#">Edit Reservation</a></div>
	<div style="margin-left:10px;"><a href="#">Mark for Cleaning</a></div>
	<div style="margin-left:10px;"><a href="#">Send Bill/Email</a></div>
</div>
<section class="content-header">
	<h1>
		<?php echo lang("Dashboard") ?>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url(); ?>admin"><i class="fa fa-dashboard"></i> <?php echo lang("Home") ?></a></li>
		<li class="active"><?php echo lang("Dashboard") ?></li>
	</ol>
</section>

<!-- Main content -->
<section class="content">

	<div class="row">
		<!-- left column -->
		<div class="col-md-11">
			<div class="error-page" style="margin:top:10%; color:#3c8dbc;">
				
			</div>
		</div>
        
        <div class="col-md-11">
         
         <div class="col-md-5">
         <div class="form-group">
         <label for="dtp_input2" class="col-md-3 control-label">Checkin</label>
                <div class="input-group date form_date col-md-8" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="" readonly>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
					<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
				<input type="hidden" id="dtp_input2" value="" />
         </div>
         </div>
         
          <div class="col-md-5">
          <div class="form-group">
         <label for="dtp_input2" class="col-md-3 control-label">Checkout</label>
                <div class="input-group date form_date col-md-8" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="" readonly>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
					<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
				<input type="hidden" id="dtp_input2" value="" />
          </div>
         </div>
			
		</div>
        
        <div class="col-md-11" style="margin-bottom: 30px">
			<div class="reserved reserved_div">
				<span>RESERVED</span>
			</div>
			<div class="cleaning cleaning_div" style="margin-left:2%;">
				<span>CLEANING</span>
			</div>
        </div>
        
        <div class="col-md-11 mobile_view">
        	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="mobile_table">
              <tr>
                <td align="left" valign="top" width="10%"></td>
                <td align="left" valign="top" width="10%"></td>
				<?php 
					if(count($bungalows_arr)>0)//If bungalows are available 
					{
						foreach($bungalows_arr as $bungalows)
						{
							?>
								<td align="left" valign="top"><?php echo $bungalows['bunglow_name'] ?></td>
							<?php
						}
					}
					?>
              </tr>
			  
				  <?php 
				  foreach($years_with_months as $years)
				  {
						foreach($years as $value)
						{
							$months_days=$value['total_days'];
							for($i=1; $i<=$months_days; $i++)
							{
								?>
								<tr>
									<?php 
									if($i==1)
									{
										?>
										<td align="left" valign="top" width="10%" rowspan="<?php echo $months_days; ?>"><?php echo $value['month_name']." ".$value['years']; ?></td>
										<?php 
									}
									?>
									<td align="left" valign="top" width="10%"><?php echo sprintf("%02s", $i); ?></td>
									<?php 
									if(count($bungalows_arr)>0)//placing days according to bungalows
									{
										foreach($bungalows_arr as $bungalows)
										{
											$current_date=$value['years']."-".sprintf("%02s", $value['month'])."-".sprintf("%02s", $i);
											$unique_id=$bungalows['bunglow_id'];
											?>
											<td id="<?php echo $unique_id."^".$current_date; ?>" align="left" valign="top">&nbsp;</td>
											<?php 
										}
									}
									?>
								</tr>
								<?php 
							}
						}
				  }
				  ?>
			</table>
        </div>
	</div>   <!-- /.row -->
</section><!-- /.content -->