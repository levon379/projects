<!-- IMPORTANT NOTE: ONCLICK OF DATE FUNCTION HAS BEEN WRITTEN IN HEAD_MOBILE.PHP  -->
<!-- Content Header (Page header) -->
<div id="box_moblie" style="width:125px; height:auto; background:#CCC; position:absolute; z-index:9999; display:none;">
	<!--<div class="cls" style="width:15px; height:15px; background:#963; position:relative; float:right;">X</div>-->
	<div id="add_reservation_id" style="margin-left:10px;"><a style="cursor:pointer;" onclick="add_reservation()">Add a reservation</a></div>
	<div id="edit_reservation_id" style="margin-left:10px;"><a href="#">Edit Reservation</a></div>
	<div id="mark_cleaning_id" style="margin-left:10px;"><a style="cursor:pointer;" onclick="mark_for_cleaning()">Mark for Cleaning</a></div>
	<div id="send_bill_id" style="margin-left:10px;"><a href="#">Send Bill/Email</a></div>
	<div id="remove_cleaning_id" style="margin-left:10px;"><a style="cursor:pointer;" onclick="remove_cleaning()">Remove Cleaning</a></div>
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
<script>
	function calcDate(date1,date2) 
	{
		var diff = Math.floor(date1.getTime() - date2.getTime());
		var day = 1000 * 60 * 60 * 24;
		var days = Math.floor(diff/day);
		var months = Math.floor(days/31);
		var years = Math.floor(months/12);
		return days;
	}
	//function for mark as cleaning
	function mark_for_cleaning()
	{
		var selected_td_id=$('#hidden_unique_id').val(); //Get selected td id from hidden_unique_id. see below
		var date=$('#'+selected_td_id).find('#date').val();
		var bungalow_id=$('#'+selected_td_id).find('#bungalow_id').val();
		$.post("<?php echo base_url(); ?>admin/home/ajax_mark_for_cleaning", { "bungalow_id":bungalow_id, "date":date }, function(data){
			$('#'+selected_td_id).attr("class", "cleaning");
			$('#'+selected_td_id).find('#cleaning_date').val(date);
			$("#box_moblie").hide();
		});
	}
	
	//Function for remove cleaning status
	function remove_cleaning()
	{
		var selected_td_id=$('#hidden_unique_id').val(); //Get selected td id from hidden_unique_id. see below
		var cleaning_date=$('#'+selected_td_id).find('#cleaning_date').val();
		var bungalow_id=$('#'+selected_td_id).find('#bungalow_id').val();
		$.post("<?php echo base_url(); ?>admin/home/ajax_remove_cleaning", { "bungalow_id":bungalow_id, "cleaning_date":cleaning_date }, function(data){
			$('#'+selected_td_id).attr("class", ""); //remove cleaning class
			$('#'+selected_td_id).find('#cleaning_date').val('');
			$("#box_moblie").hide();
		});
	}
	
	//Function to add a reservation
	function add_reservation()
	{
		//$('#add_reservation_div').modal('show'); 
		$("#box_mobile").hide();
		var selected_td_id=$('#hidden_unique_id').val(); //Get selected td id from hidden_unique_id. see below
		var arrival_date=$('#'+selected_td_id).find('#date').val();
		var bungalow_id=$('#'+selected_td_id).find('#bungalow_id').val();
		
		//Check for past date validation
		var arival_date_arr=arrival_date.split("-");
		var valyear=parseInt(arival_date_arr[0]);
		var valmonth=parseInt(arival_date_arr[1]);
		var valday=parseInt(arival_date_arr[2]);
		var today = new Date()
		var new_arrival_date= new Date(valyear,(valmonth-1),valday);
		var result=calcDate(today, new_arrival_date);

		if(result>0)
		{
			alert("Past dates not allowed");
		}
		else if(result>-2)
		{
			alert("Reservation is allowed from two days later");
		}
		else 
		{
			$.post("<?php echo base_url(); ?>admin/home/ajax_get_add_reservation_form", { "bungalow_id":bungalow_id, "arrival_date":arrival_date }, function(data){
				$("#add_reservation_div").html(data);
				$('#add_reservation_div').modal('show');
			});
		}
	}
</script>

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
											//Getting Reserved date in array
											$key_reserved_date_array=array();
											if(count($bungalows['reservation'])>0)
											{
												foreach($bungalows['reservation'] as $key => $keyvalue)
												{
													array_push($key_reserved_date_array, $key);
												}
											}
											$current_date=$value['years']."-".sprintf("%02s", $value['month'])."-".sprintf("%02s", $i);
											$unique_id=$bungalows['bunglow_id'];
											
											//If date is existing in reserved dates array
											if(in_array($current_date, $key_reserved_date_array))
											{
												$reserved_class="class='reserved'";
												$reservation_id=$bungalows['reservation'][$current_date]['reservation_id'];
											}
											else
											{
												$reserved_class="";
												$reservation_id="";
											}
											
											//Check if date is reserved for cleaning
											if(in_array($current_date, $bungalows['cleaning']))
											{
												$cleaning_class="class='cleaning'";
												$cleaning_date=$current_date;
											}
											else
											{
												$cleaning_class="";
												$cleaning_date="";
											}
											?>
											<td id="<?php echo $unique_id."-".$current_date; ?>" align="left" valign="top" <?php echo $reserved_class; ?> <?php echo $cleaning_class; ?>>&nbsp;
												<input type="hidden" id="date" value="<?php echo $current_date; ?>"/>
												<input type="hidden" id="bungalow_id" value="<?php echo $bungalows['bunglow_id']; ?>"/>
												<input type="hidden" id="reservation_id" value="<?php echo $reservation_id; ?>"/>
												<input type="hidden" id="cleaning_date" value="<?php echo $cleaning_date; ?>"/>
											</td>
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
	<input type="hidden" name="hidden_unique_id" id="hidden_unique_id" value="">
	<!--<div class="popup-overlay" style="z-index:999;">
		<img src="<?php echo base_url() ?>assets/images/ajax-loader-big.gif" alt="" />
	</div>
	<script>
		$('html').addClass('overlay');
		//$('html').removeClass('overlay');
	</script>-->
</section><!-- /.content -->
<div id="add_reservation_div" style="display:none;" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
	
</div>