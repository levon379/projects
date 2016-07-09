<!-- IMPORTANT NOTE: CONTEXT MENU FUNCTION HAS BEEN WRITTEN IN THE FOOTER.PHP -->
<!-- header logo: style can be found in header.less -->
<div id='box' style="position:absolute; width:125px; height:auto; z-index:99999; background:#FFFFFF; display:none;">
	<div id="add_reservation_id" style="margin-left:10px;"><a style="cursor:pointer;" onclick="add_reservation()">Add a reservation</a></div>
	<div id="edit_reservation_id" style="margin-left:10px;"><a style="cursor:pointer;" onclick="edit_reservation()">Edit Reservation</a></div>
	<div id="mark_cleaning_id" style="margin-left:10px;"><a style="cursor:pointer;" onclick="mark_for_cleaning()">Mark for Cleaning</a></div>
	<div id="send_bill_id" style="margin-left:10px;"><a style="cursor:pointer;" onclick="send_bill()">Send Bill/Email</a></div>
	<div id="remove_cleaning_id" style="margin-left:10px;"><a style="cursor:pointer;" onclick="remove_cleaning()">Remove Cleaning</a></div>
</div>
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
			$('#'+selected_td_id).attr("class", "cleaning");//Set class as cleaning
			$('#'+selected_td_id).find('#cleaning_date').val(date);
			$("#box").hide();
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
			$("#box").hide();
		});
	}
	
	//Function to add a reservation
	function add_reservation()
	{
		//$('#add_reservation_div').modal('show'); 
		$("#box").hide();
		var selected_td_id=$('#hidden_unique_id').val(); //Get selected td id from hidden_unique_id. see below
		var arrival_date=$('#'+selected_td_id).find('#date').val();
		var bungalow_id=$('#'+selected_td_id).find('#bungalow_id').val();
		
		//Check for past date validation
		var arival_date_arr=arrival_date.split("-"); //Date is coming with YYYY-mm-dd format.
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
			alert("Select the date of after two days");
		}
		else 
		{
			$.post("<?php echo base_url(); ?>admin/home/ajax_get_add_reservation_form", { "bungalow_id":bungalow_id, "arrival_date":arrival_date }, function(data){
				$("#add_reservation_div").html(data);
				$('#add_reservation_div').modal('show');
			});
		}
	}
	
	
	//function for editing reservation 
	function edit_reservation()
	{
		$("#box").hide();
		var selected_td_id=$('#hidden_unique_id').val(); //Get selected td id from hidden_unique_id. see below
		var reservation_id=$('#'+selected_td_id).find('#reservation_id').val();
		$.post("<?php echo base_url(); ?>admin/home/ajax_get_edit_reservation_form", { "reservation_id":reservation_id}, function(data){
			$("#edit_reservation_div").html(data);
			$('#edit_reservation_div').modal('show');
		});
	}
	
	
	//Function for validating add reservation form which is coming from ajax
	function validate_add_reservation()
	{
		var error=0;
		if($("#user_id").val()=="")
		{
			$("#user_id_error").show();
			error++;
		}
		else 
		{
			$("#user_id_error").hide();
		}
		if($("#reservation_name").val().trim()=="")
		{
			$("#reservation_name_error").show();
			error++;
		}
		else 
		{
			$("#reservation_name_error").hide();
		}
		if($("#reservation_contact").val().trim()=="")
		{
			$("#reservation_contact_error").show();
			error++;
		}
		else 
		{
			$("#reservation_contact_error").hide();
		}
		
		if($("#arrival_date").val().trim()=="")
		{
			$("#arrival_date_error_text").html(" Arrival Date is required");
			$("#arrival_date_error").show();
			error++;
		}
		else if($("#arrival_date").val().trim()!="")
		{
			
			//Checking if arrival date is getting selected as past date
			var arrival_date=$("#arrival_date").val();
			var arival_date_arr=$("#arrival_date").val().split("/"); //This date format dd/mm/yyyy is coming from datepicker
			
			var valyear=arival_date_arr[2];
			var valmonth=arival_date_arr[1];
			var valday=arival_date_arr[0];
			var today = new Date()
			var new_arrival_date= new Date(valyear,(valmonth-1),valday);
			
			
			var date_after_18_month = new Date(new Date(today).setMonth(today.getMonth()+18));
			var year_after_18_months=date_after_18_month.getFullYear();
			var month_after_18_months=date_after_18_month.getMonth();
			var day_after_18_months=date_after_18_month.getDate();
			var new_date_after_18_month=new Date(year_after_18_months, month_after_18_months, day_after_18_months);
			
			var result=calcDate(today, new_arrival_date);
			
			if(result>0)
			{
				$("#arrival_date_error_text").html(" Past dates not allowed");
				$("#arrival_date_error").show();
				error++;
			}
			else if(result>-2)
			{
				$("#arrival_date_error_text").html(" Enter the date of after two days");
				$("#arrival_date_error").show();
				error++;
			}
			else 
			{
				//Checking if arrival date is within 18 months
				if(new_arrival_date > new_date_after_18_month)
				{
					$("#arrival_date_error_text").html("Reservation is allowed only within 18 months");
					$("#arrival_date_error").show();
					error++;
				}
				else 
				{
					$("#arrival_date_error_text").html("");
					$("#arrival_date_error").hide();
				}
			}
		}
		
		if($("#leave_date").val().trim()=="")
		{
			$("#leave_date_error_text").html(" Leave Date is required");
			$("#leave_date_error").show();
			error++;
		}
		else 
		{
			//Checking if leave date is less than arrival date
			var arrival_date=$("#arrival_date").val();
			var arival_date_arr=$("#arrival_date").val().split("/");
			var arrival_year=arival_date_arr[2];
			var arrival_month=arival_date_arr[1];
			var arrival_day=arival_date_arr[0];
			var new_arrival_date= new Date(arrival_year,(arrival_month-1),arrival_day);

			var leave_date=$("#leave_date").val();
			var leave_date_arr=$("#leave_date").val().split("/");
			var leave_year=leave_date_arr[2];
			var leave_month=leave_date_arr[1];
			var leave_day=leave_date_arr[0];
			var new_leave_date= new Date(leave_year,(leave_month-1),leave_day);
			var result=calcDate(new_arrival_date, new_leave_date);
			if(result>0)
			{
				$("#leave_date_error_text").html("Leave date should not less than Arrival date");
				$("#leave_date_error").show();
				error++;
			}
			else 
			{
				$("#leave_date_error_text").html("");
				$("#leave_date_error").hide();
			}
		}
		
		if(error>0)
		{
			//$(window).scrollTop($("#reservation_add_form").offset().top);
			return false;
		}
	}
	
	//Function for validating edit reservation form which is coming from ajax
	function validate_edit_reservation()
	{
		var error=0;
		if($("#user_id").val()=="")
		{
			$("#user_id_error").show();
			error++;
		}
		else 
		{
			$("#user_id_error").hide();
		}
		if($("#reservation_name").val().trim()=="")
		{
			$("#reservation_name_error").show();
			error++;
		}
		else 
		{
			$("#reservation_name_error").hide();
		}
		if($("#reservation_contact").val().trim()=="")
		{
			$("#reservation_contact_error").show();
			error++;
		}
		else 
		{
			$("#reservation_contact_error").hide();
		}
		
		if($("#arrival_date").val().trim()=="")
		{
			$("#arrival_date_error_text").html(" Arrival Date is required");
			$("#arrival_date_error").show();
			error++;
		}
		else if($("#arrival_date").val().trim()!="")
		{
			
			//Checking if arrival date is getting selected as past date
			var arrival_date=$("#arrival_date").val();
			var arival_date_arr=$("#arrival_date").val().split("/"); //This date format dd/mm/yyyy is coming from datepicker
			
			var valyear=arival_date_arr[2];
			var valmonth=arival_date_arr[1];
			var valday=arival_date_arr[0];
			var today = new Date()
			var new_arrival_date= new Date(valyear,(valmonth-1),valday);
			
			
			var date_after_18_month = new Date(new Date(today).setMonth(today.getMonth()+18));
			var year_after_18_months=date_after_18_month.getFullYear();
			var month_after_18_months=date_after_18_month.getMonth();
			var day_after_18_months=date_after_18_month.getDate();
			var new_date_after_18_month=new Date(year_after_18_months, month_after_18_months, day_after_18_months);
			
			var result=calcDate(today, new_arrival_date);
			
			if(result>0)
			{
				$("#arrival_date_error_text").html(" Past dates not allowed");
				$("#arrival_date_error").show();
				error++;
			}
			else if(result>-2)
			{
				$("#arrival_date_error_text").html(" Enter the date of after two days");
				$("#arrival_date_error").show();
				error++;
			}
			else 
			{
				//Checking if arrival date is within 18 months
				if(new_arrival_date > new_date_after_18_month)
				{
					$("#arrival_date_error_text").html("Reservation is allowed only within 18 months");
					$("#arrival_date_error").show();
					error++;
				}
				else 
				{
					$("#arrival_date_error_text").html("");
					$("#arrival_date_error").hide();
				}
			}
		}
		
		if($("#leave_date").val().trim()=="")
		{
			$("#leave_date_error_text").html(" Leave Date is required");
			$("#leave_date_error").show();
			error++;
		}
		else 
		{
			//Checking if leave date is less than arrival date
			var arrival_date=$("#arrival_date").val();
			var arival_date_arr=$("#arrival_date").val().split("/");
			var arrival_year=arival_date_arr[2];
			var arrival_month=arival_date_arr[1];
			var arrival_day=arival_date_arr[0];
			var new_arrival_date= new Date(arrival_year,(arrival_month-1),arrival_day);

			var leave_date=$("#leave_date").val();
			var leave_date_arr=$("#leave_date").val().split("/");
			var leave_year=leave_date_arr[2];
			var leave_month=leave_date_arr[1];
			var leave_day=leave_date_arr[0];
			var new_leave_date= new Date(leave_year,(leave_month-1),leave_day);
			var result=calcDate(new_arrival_date, new_leave_date);
			if(result>0)
			{
				$("#leave_date_error_text").html("Leave date should not less than Arrival date");
				$("#leave_date_error").show();
				error++;
			}
			else 
			{
				$("#leave_date_error_text").html("");
				$("#leave_date_error").hide();
			}
		}
		
		if(error>0)
		{
			//$(window).scrollTop($("#reservation_add_form").offset().top);
			return false;
		}
	}
	
	//Function for sending bill
	function send_bill()
	{
		$("#box").hide();
		var selected_td_id=$('#hidden_unique_id').val(); //Get selected td id from hidden_unique_id. see below
		var reservation_id=$('#'+selected_td_id).find('#reservation_id').val();
		location.href="<?php echo base_url(); ?>admin/home/send_invoice/"+reservation_id;
	}
	
	function search_reservation()
	{
		var error=0;
		if($("#search_arrival_date").val()=="")
		{
			$("#search_arrival_date_error").html("Arrival date is required");
			error++;
		}
		else 
		{
			$("#search_arrival_date_error").html("");
		}
		if($("#search_leave_date").val()=="")
		{
			$("#search_leave_date_error").html("Leave date is required");
			error++;
		}
		else 
		{
			var arrival_date=$("#search_arrival_date").val();
			var arival_date_arr=$("#search_arrival_date").val().split("/");
			var arrival_year=arival_date_arr[2];
			var arrival_month=arival_date_arr[1];
			var arrival_day=arival_date_arr[0];
			var new_arrival_date= new Date(arrival_year,(arrival_month-1),arrival_day);

			var leave_date=$("#search_leave_date").val();
			var leave_date_arr=$("#search_leave_date").val().split("/");
			var leave_year=leave_date_arr[2];
			var leave_month=leave_date_arr[1];
			var leave_day=leave_date_arr[0];
			var new_leave_date= new Date(leave_year,(leave_month-1),leave_day);
			var result=calcDate(new_arrival_date, new_leave_date);
			if(result>0)
			{
				$("#search_leave_date_error").html("Leave date should be greater than Arrival date");
				error++;
			}
			else 
			{
				$("#search_leave_date_error").html("");
				//month_year_November_2014
				var monthNames = [ "January", "February", "March", "April", "May", "June",
				"July", "August", "September", "October", "November", "December" ];
				var search_div_id="month_year_"+monthNames[arrival_month-1]+"_"+arrival_year;
				document.getElementById(search_div_id).scrollIntoView(true);
			}
		}
		if(error>0)
		{
			return false;
		}
	}
</script>

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
<div id="contextMenu"></div>

<?php 
if(isset($_GET["addsuccess"]))
{
	?>
	<section class="content">
	<div class="alert alert-success alert-dismissable" style="margin-bottom:0px;">
		<i class="fa fa-check"></i>
		<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
		<b>Reservation made successfully</b>
	</div>
	</section>
	<?php
}
if(isset($_GET["editsuccess"]))
{
	?>
	<section class="content">
	<div class="alert alert-success alert-dismissable" style="margin-bottom:0px;">
		<i class="fa fa-check"></i>
		<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
		<b>Reservation updated successfully</b>
	</div>
	</section>
	<?php
}
if(isset($_GET["sent"]))
{
	?>
	<section class="content">
	<div class="alert alert-success alert-dismissable" style="margin-bottom:0px;">
		<i class="fa fa-check"></i>
		<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
		<b>Invoice sent successfully</b>
	</div>
	</section>
	<?php
}
?>
<!-- Main content -->
<section class="content">
	<div class="row">
		<!-- left column -->
		<div class="col-md-11">
			<div class="error-page" style="margin:top:10%; color:#3c8dbc;">	
			</div>
		</div>
        
        <div class="col-md-12">
			<div class="col-md-4">
				<div class="form-group">
				<label for="dtp_input2" class="col-md-3 control-label">Check In</label>
                <div class="input-group date form_date col-md-8" data-date="" data-date-format="dd/mm/yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                    <input class="form-control" name="search_arrival_date" id="search_arrival_date" size="16" type="text" value="" readonly>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
					<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
					
                </div>
				<p id="search_arrival_date_error" style="color:red;"></p>
				<input type="hidden" id="dtp_input2" value="" />
         </div>
         </div>
         
          <div class="col-md-4">
          <div class="form-group">
         <label for="dtp_input2" class="col-md-3 control-label">Check Out</label>
                <div class="input-group date form_date col-md-8" data-date="" data-date-format="dd/mm/yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                    <input class="form-control" name="search_leave_date" id="search_leave_date" size="16" type="text" value="" readonly>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
					<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
				<p id="search_leave_date_error" style="color:red;"></p>
				<input type="hidden" id="dtp_input2" value="" />
          </div>
         </div>
			<div class="col-md-4">
				<input type="button" class="btn btn-primary" name="save" value="Go" onclick="search_reservation()">
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
					<td id="month_year_<?php echo $value['month_name']."_".$value['years']; ?>" align="left" valign="top" colspan="<?php echo $value['total_days'] ?>"><?php echo $value['month_name']." ".$value['years']; ?></td>
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
							<td align="left" valign="top"><?php echo sprintf("%02s", $i); ?></td>
							<?php 
						}
					}
				}
			?>
		</tr>

		<?php 
		if(count($bungalows_arr)>0)//placing days according to bungalows
		{
			//Getting Reserved date in array
			foreach($bungalows_arr as $bungalows)
			{
				$key_reserved_date_array=array();
				if(count($bungalows['reservation'])>0)
				{
					foreach($bungalows['reservation'] as $key => $value)
					{
						array_push($key_reserved_date_array, $key);
					}
				}
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
										<input type="hidden" id="date" name="date" value="<?php echo $current_date; ?>"/>
										<input type="hidden" id="bungalow_id" name="bungalow_id" value="<?php echo $bungalows['bunglow_id']; ?>"/>
										<input type="hidden" id="reservation_id" name="reservation_id" value="<?php echo $reservation_id; ?>"/>
										<input type="hidden" id="cleaning_date" name="cleaning_date" value="<?php echo $cleaning_date; ?>"/>
									</td>
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
<input type="hidden" name="hidden_unique_id" id="hidden_unique_id" value="">
<div class="col-md-11">
		<ul class="navigation-sec">
			<li><a class="prev_month" href="#"><img src="<?php echo base_url();?>assets/images/prev-icon.png" alt="" /></a></li>
			<li><a class="next_month" href="#"><img src="<?php echo base_url();?>assets/images/next-icon.png" alt="" /></a></li>
		</ul>
</div>    
</div>   <!-- /.row -->
	<div class="reserved reserved_div">
		<span>RESERVED</span>
	</div>
	<div class="cleaning cleaning_div" style="margin-left:2%;">
		<span>CLEANING</span>
	</div>

	<!--<div class="popup-overlay" style="z-index:999;">
		<img style="margin-top:30%; margin-left:50%;" src="<?php echo base_url() ?>assets/images/ajax-loader-big.gif" alt="" />
	</div>
	<script>
		//$('html').addClass('overlay');
		//$('html').removeClass('overlay');
	</script>-->
	
</section><!-- /.content -->
<!-- Div for adding reservation -->
<div id="add_reservation_div" style="display:none;" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade"></div>
<!-- Div for editing reservation -->
<div id="edit_reservation_div" style="display:none;" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade"></div>


