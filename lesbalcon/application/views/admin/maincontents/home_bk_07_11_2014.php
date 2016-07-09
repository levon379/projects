<!-- header logo: style can be found in header.less -->
<div id='box' style="position:absolute; width:125px; height:85px; z-index:99999; background:#FFFFFF; display:none;">
	<div style="margin-left:10px;"><a href="#">Add a reservation</a></div>
	<div style="margin-left:10px;"><a href="#">Edit Reservation</a></div>
	<div style="margin-left:10px;"><a href="#">Mark for Cleaning</a></div>
	<div style="margin-left:10px;"><a href="#">Send Bill/Email</a></div>
</div>

<!-- Content Header (Page header) -->
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
        
        <div class="col-md-11 desktop_view">
        	 <div class="bunglow-cols">
             	 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="bunglow-style">
                 		<tr>
    						<td align="left" valign="top">&nbsp;</td>
    					</tr>
                        <tr>
    						<td align="left" valign="top">&nbsp;</td>
    					</tr>
						<?php 
						if(count($bungalows_arr)>0)//If bungalows are available 
						{
							foreach($bungalows_arr as $bungalows)
							{
								?>
								<tr>
									<td align="left" valign="bottom"><?php echo $bungalows['bunglow_name'] ?></td>
								</tr>
								<?php
							}
						}
						?>
                        
                 </table>
             </div>
             <div class="time-line-cols">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="calender-style">
		
		<!-- Months Name e.g January, February etc... --->
         <tr id="months">
			<?php 
			foreach($years_with_months as $years)
			{
				foreach($years as $value)
				{
					?>
					<td align="left" valign="top" colspan="<?php echo $value['total_days'] ?>"><?php echo $value['month_name']." ".$value['years']; ?></td>
					<?php 
				}
				
			}
			?>
         </tr>
		 
		<!-- Months Days e.g 1,2,3,4 etc... -->             
		<tr>
			<?php 
				foreach($years_with_months as $years)
				{
					foreach($years as $value)
					{
						$months_days=$value['total_days'];
						for($i=1; $i<=$months_days; $i++)
						{
							?>
							<td id="month_year_<?php echo $value['month_name']."_".$value['years']; ?>" align="left" valign="top"><?php echo sprintf("%02s", $i); ?></td>
							<?php 
						}
					}
				}
			?>
		</tr>

		<?php 
		if(count($bungalows_arr)>0)//placing days according to bungalows
		{
			foreach($bungalows_arr as $bungalows)
			{
				?>
				<tr>
					<?php 
						foreach($years_with_months as $years)
						{
							//Set class as 'class="reserved"' of <td>
							//Set class as 'class="cleaning"' of <td>
							foreach($years as $value)
							{
								$months_days=$value['total_days'];
								for($i=1; $i<=$months_days; $i++)
								{
									$current_date=$value['years']."-".sprintf("%02s", $value['month'])."-".sprintf("%02s", $i);
									$unique_id=$bungalows['bunglow_id'];
									?>
									<td id="<?php echo $current_date; ?>" align="left" valign="top">&nbsp;</td>
									<?php 
								}
							}
						}
					?>
				</tr>
				<?php 
			}
		}
		?>
</table>

             </div>
        </div>
        
        <div class="col-md-11">
        		<ul class="navigation-sec">
                	<li><a class="prev" href="#"><img src="<?php echo base_url();?>assets/images/prev-icon.png" alt="" /></a></li>
                    <li><a class="next" href="#"><img src="<?php echo base_url();?>assets/images/next-icon.png" alt="" /></a></li>
                </ul>
        </div>  
	</div>   <!-- /.row -->
	<div class="reserved reserved_div">
		<span>RESERVED</span>
	</div>
	<div class="cleaning cleaning_div" style="margin-left:2%;">
		<span>CLEANING</span>
	</div>
</section><!-- /.content -->