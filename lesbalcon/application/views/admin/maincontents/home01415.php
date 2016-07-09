<!-- IMPORTANT NOTE: CONTEXT MENU FUNCTION HAS BEEN WRITTEN IN THE FOOTER.PHP -->
<!-- header logo: style can be found in header.less -->
<?php 
$this->session->unset_userdata("referer_url");
?>
<div id='box' style="position:absolute; width:125px; height:auto; z-index:99999; background:#FFFFFF; display:none;">
	<div id="add_reservation_id" style="margin-left:10px;"><a style="cursor:pointer;" onclick="add_reservation()">Add a reservation</a></div>
	<div id="edit_reservation_id" style="margin-left:10px;"><a style="cursor:pointer;" onclick="edit_reservation()">Edit Reservation</a></div>
	<div id="mark_cleaning_id" style="margin-left:10px;"><a style="cursor:pointer;" onclick="mark_for_cleaning()">Mark for Cleaning</a></div>
	<div id="send_bill_id" style="margin-left:10px;"><a style="cursor:pointer;" onclick="send_bill()">Send Bill/Email</a></div>
	<div id="remove_cleaning_id" style="margin-left:10px;"><a style="cursor:pointer;" onclick="remove_cleaning()">Remove Cleaning</a></div>
	<div id="print_details_id" style="margin-left:10px;"><a style="cursor:pointer;" onclick="print_details()">Print Details</a></div>
</div>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>-->
<script>
/*function test()
{
	alert('@@@@');
}
$(document).ready(function(){

	$(".next_month").click(function(e){
		e.preventDefault();
		var start_month=$(".next_month").attr('rel');
		alert(start_month);
		return false;
		$.ajax({
			 type:"POST",
			 url:"<?php //echo base_url();?>admin/home/index",
			 data:"start_month="+start_month,
			 success:function(msg)
			 {
			 	$("").html(msg);
			 }else
			 {
			 	alert('Try Agian');
				return false;
			 }
		});
	});
});*/
	function calcDate(date1,date2) 
	{
		var diff = Math.floor(date1.getTime() - date2.getTime());
		var day = 1000 * 60 * 60 * 24;
		var days = Math.floor(diff/day);
		var months = Math.floor(days/31);
		var years = Math.floor(months/12);
		return days;
	}
	
		//Function for next month
	/*function next_month(){
		var selected_td_id=$('#hidden_unique_id').val(); //Get selected td id from hidden_unique_id. see below
		var cleaning_date=$('#'+selected_td_id).find('#cleaning_date').val();
		var bungalow_id=$('#'+selected_td_id).find('#bungalow_id').val();
		$.post("<?php echo base_url(); ?>admin/home/ajax_remove_cleaning", { "bungalow_id":bungalow_id, "cleaning_date":cleaning_date }, function(data){
			$('#'+selected_td_id).attr("class", ""); //remove cleaning class
			$('#'+selected_td_id).find('#cleaning_date').val('');
			$("#box").hide();
		});
	}*/
	
	
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
			$("#hidden_bungalow_id").val('');
			$("#hidden_arrival_date").val('');
			$("#hidden_bungalow_id").val(bungalow_id);
			$("#hidden_arrival_date").val(arrival_date);
			$("#ask_for_user_type_div").modal('show');
			/*$.post("<?php echo base_url(); ?>admin/home/ajax_get_add_reservation_form", { "bungalow_id":bungalow_id, "arrival_date":arrival_date }, function(data){
				$("#add_reservation_div").html(data);
				$('#add_reservation_div').modal('show');
			});*/
		}
	}
	
	//function for getting add reservation form after selecting user type
	function proceed_to_get_add_reservation_form()
	{
		$("#ask_for_user_type_div").modal('hide');
		var bungalow_id=$("#hidden_bungalow_id").val();
		var arrival_date=$("#hidden_arrival_date").val();
		var selected_user_type=$('input[name=user_type]:checked').val();
		if(selected_user_type=="R")//If selected user type is registered
		{
			$('#ajax_progress').modal('show');
			$.post("<?php echo base_url(); ?>admin/home/ajax_get_add_reservation_form", { "bungalow_id":bungalow_id, "arrival_date":arrival_date }, function(data){
				$('#ajax_progress').modal('hide');
				$("#add_reservation_div").html(data);
				$('#add_reservation_div').modal('show');
			});
		}
		else //If selected user type is unregistered
		{
			$('#ajax_progress').modal('show');
			$.post("<?php echo base_url(); ?>admin/home/ajax_get_add_reservation_form_unregistered", { "bungalow_id":bungalow_id, "arrival_date":arrival_date }, function(data){
				$('#ajax_progress').modal('hide');
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
		if ($("#user_id").length > 0)
		{
			if($("#user_id").val()=="")
			{
				$("#user_id_error").show();
				error++;
			}
			else 
			{
				$("#user_id_error").hide();
			}
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
		
		if ($("#reservation_email").length > 0)
		{
			if($("#reservation_email").val()=="")
			{
				$("#reservation_email_error").show();
				error++;
			}
			else 
			{
				$("#reservation_email_error").hide();
			}
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
		
		if ($("#reservation_address").length > 0)
		{
			if($("#reservation_address").val()=="")
			{
				$("#reservation_address_error").show();
				error++;
			}
			else 
			{
				$("#reservation_address_error").hide();
			}
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
			$("#leave_date_error_text").html(" Departure Date is required");
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
				$("#leave_date_error_text").html("Departure date should not less than Arrival date");
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
			$("#leave_date_error_text").html(" Departure Date is required");
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
				$("#leave_date_error_text").html("Departure date should not less than Arrival date");
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
		//location.href="<?php echo base_url(); ?>admin/home/send_invoice/"+reservation_id;
		location.href="<?php echo base_url(); ?>admin/users/invoice/"+reservation_id;
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
			$("#search_leave_date_error").html("Departure date is required");
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
				$("#search_leave_date_error").html("Departure date should be greater than Arrival date");
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
	
	
	//function for showing details on mouseover 25-11-2014
	function show_details_on_mouseover(reservation_id)
	{
		$('#ajax_progress').modal('show');
		$.post("<?php echo base_url(); ?>admin/home/ajax_get_reservation_details", { "reservation_id":reservation_id}, function(data){
			$("#full_details_div").html(data);
			$('#ajax_progress').modal('hide');
			$('#full_details_div').modal('show');
		});
	}
	
	//function for show details for tooltip
	function show_details_for_tooltip(reservation_id, tdid)
	{
		$.post("<?php echo base_url(); ?>admin/home/ajax_get_details_for_tooltip", { "reservation_id":reservation_id}, function(data){
			$('#'+tdid).attr('title', data).tooltip('fixTitle').tooltip('show');
		});
	}
	
	//function to hide tooltip
	function hide_tooltip(tdid)
	{
		$('#'+tdid).attr('title', '').tooltip('fixTitle').tooltip('hide');
	}
	
	//function to hide all tooltips
	function hide_all_tooltip()
	{
		$('[rel=tooltip]').tooltip('hide');
	}
	
	//Function for print details
	function print_details()
	{
		$("#box").hide();
		var selected_td_id=$('#hidden_unique_id').val(); //Get selected td id from hidden_unique_id. see below
		var cleaning_date=$('#'+selected_td_id).find('#cleaning_date').val();
		var reservation_id=$('#'+selected_td_id).find('#reservation_id').val();
		if(reservation_id!="")
		{
			$('#ajax_progress').modal('show');
			$.post("<?php echo base_url(); ?>admin/home/ajax_get_print_details", { "reservation_id":reservation_id}, function(data){
				$("#print_details_div").html(data);
				$('#ajax_progress').modal('hide');
				var divContents = $("#print_details_div").html();
				var printWindow = window.open('', '', 'height=700,width=1000');
				printWindow.document.write('<html><head><title>Print Data</title>');
				printWindow.document.write('</head><body>');
				printWindow.document.write(divContents);
				printWindow.document.write('</body></html>');
				printWindow.document.close();
				printWindow.print();
			});
		}
		else if(cleaning_date!="") 
		{
			$('#ajax_progress').modal('show');
			$.post("<?php echo base_url(); ?>admin/home/ajax_get_print_cleaning_details", { "cleaning_date":cleaning_date}, function(data){
				$("#print_details_div").html(data);
				$('#ajax_progress').modal('hide');
				var divContents = $("#print_details_div").html();
				var printWindow = window.open('', '', 'height=700,width=1000');
				printWindow.document.write('<html><head><title>Print Data</title>');
				printWindow.document.write('</head><body>');
				printWindow.document.write(divContents);
				printWindow.document.write('</body></html>');
				printWindow.document.close();
				printWindow.print();
			});
		}
	}
	$(function() {
	  var HasTooltip = $('.hastooltip');
	  HasTooltip.on('click', function(e) {
		e.preventDefault();
		var isShowing = $(this).data('isShowing');
		HasTooltip.removeData('isShowing');
		if (isShowing !== 'true')
		{
		  HasTooltip.not(this).tooltip('hide');
		  $(this).data('isShowing', "true");
		  $(this).tooltip('show');
		}
		else
		{
		  $(this).tooltip('hide');
		}

	  }).tooltip({
		animation: true,
		trigger: 'manual'
	  });
	  
	 var arr = [];
	 $(".completed").each(function(n){
	 	//alert($(this).attr('data-id'));
		var myname= $(this).attr('id');
		if( $.inArray( myname, arr ) < 0 ){
     	arr.push(myname); 
  		}
	 });
	 //alert(arr);
	 
	 
	 
	 
	  
	});
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
if(isset($_GET["saved"]))
{
	?>
	<section class="content">
	<div class="alert alert-success alert-dismissable" style="margin-bottom:0px;">
		<i class="fa fa-check"></i>
		<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
		<b><?php echo "Data saved Successfully"; ?></b>
	</div>
	</section>
	<?php
}
?>
<!-- Latest Reservation -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-body table-responsive">
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th style="text-align:center;" colspan="7"><h4>Latest Booking</h4></th>
							</tr>
							<tr>
								<th class="sorting_disabled">Date</th>
								<th class="sorting_disabled">Arrival Date</th>
								<th class="sorting_disabled">Departure Date</th>
								<th class="sorting_disabled">Bungalow</th>
								<th class="sorting_disabled">Options</th>
								<th class="sorting_disabled">Payment Status</th>
								<th class="sorting_disabled">Source</th>
							</tr>
							<?php 
							if(count($latest_booking)>0)
							{
								?>
								<tr>
									<td><?php echo $latest_booking['reservation_date'] ?></td>
									<td><?php echo $latest_booking['arrival_date'] ?></td>
									<td><?php echo $latest_booking['leave_date'] ?></td>
									<td><?php echo $latest_booking['bungalow_name'] ?></td>
									<td><?php echo $latest_booking['options'] ?></td>
									<td><?php echo $latest_booking['payment_status'] ?></td>
									<td>
										<?php 
										if($latest_booking['source']=="W")
										{
											echo "WEBSITE";
										}
										if($latest_booking['source']=="M")
										{
											echo "MANUAL";
										}
										if($latest_booking['source']=="D")
										{
											echo "DIRECT";
										}
										?>
									</td>
								</tr>
								<?php 
							}
							else 
							{
								?>
								<tr>
									<td colspan="7" align="center">No records found</td>
								</tr>
								<?php 
							}
							?>
							
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>
<!------------------------->
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
                    <input class="form-control" name="search_arrival_date" id="search_arrival_date" size="16" type="text" value="" readonly style="cursor:auto;">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
					<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
				<p id="search_arrival_date_error" style="color:red;"></p>
				<input type="hidden" id="dtp_input2" value="" />
         </div>
         </div>
         
          <div class="col-md-4">
          <div class="form-group">
         <label for="dtp_input2" class="col-md-4 control-label">Check Out</label>
                <div class="input-group date form_date col-md-8" data-date="" data-date-format="dd/mm/yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                    <input class="form-control" name="search_leave_date" id="search_leave_date" size="16" type="text" value="" readonly style="cursor:auto;">
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
    						<td align="left" valign="top" class="toprow" height="20">&nbsp;</td>
    					</tr>
                        <tr>
    						<td align="left" valign="top" class="toprow" height="20">&nbsp;</td>
    					</tr>
						<?php 
						if(count($bungalows_arr)>0)//If bungalows are available 
						{
							foreach($bungalows_arr as $bungalows)
							{
								?>
								<tr>
									<td align="left" valign="middle"><?php echo $bungalows['bunglow_name'] ?></td>
								</tr>
								<?php
							}
						}
						?>
                        
                 </table>
             </div>
             <div class="time-line-cols">
             <div class="up-scroller-wrapper">
             	<div class="up-scroller"></div>
             </div>
									<input type="text" id="test_row" value="" name="mode" />
									<?php
										$a1 = 0;
										$a2 = 0;
										$a3 = 0;
										$a4 = 0;
									?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="calender-style">
		
		<!-- Months Name e.g January, February etc... --->
         <tr id="months">
			<?php 
			foreach($years_with_months as $years)
			{
				foreach($years as $value)
				{
					?>
					<td id="month_year_<?php echo $value['month_name']."_".$value['years']; ?>" class="toprow2" align="left" valign="top" colspan="<?php echo $value['total_days'] ?>"><?php echo $value['month_name']." ".$value['years']; ?></td>
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
							<td align="left" valign="top" class="toprow2"><?php echo sprintf("%02s", $i); ?></td>
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
								$j=0;
								$k=0;
								for($i=1; $i<=$months_days; $i++)
								{
									$current_date=$value['years']."-".sprintf("%02s", $value['month'])."-".sprintf("%02s", $i);
									$unique_id=$bungalows['bunglow_id'];
									//If date is existing in reserved dates array
									if(in_array($current_date, $key_reserved_date_array))
									{
										if(!empty($bungalows['reservation'][$current_date]['options']))
										{
											$reserved_class="class='reserved paid' style='background-color:".$bungalows['reservation'][$current_date]['color_code']." !important; border-right: 1px solid ".$bungalows['reservation'][$current_date]['color_code'].";'";
										}
										else 
										{
											$reserved_class="class='reserved' style='background-color:".$bungalows['reservation'][$current_date]['color_code']." !important; border-right: 1px solid ".$bungalows['reservation'][$current_date]['color_code'].";'";
										}
										$reservation_id=$bungalows['reservation'][$current_date]['reservation_id'];
										$mouse_over_function="onclick='show_details_on_mouseover(".$reservation_id.")' onmouseover='show_details_for_tooltip(".$reservation_id.", this.id)' onmouseout='hide_tooltip(this.id)' rel='tooltip' data-toggle='tooltip' data-trigger='hover' data-placement='top' data-html='true' data-title=''  data-container='body'";
									}
									else
									{
										$reserved_class="";
										$reservation_id="";
										$mouse_over_function="onmouseover='hide_all_tooltip()'";
									}
									if(!empty($bungalows['reservation'][$current_date]['payment_status']))
									{
										$payment_st=$bungalows['reservation'][$current_date]['payment_status'];
									}
									else 
									{
										$payment_st="";
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
									<td id="<?php echo $unique_id."-".$current_date; ?>" align="left" valign="top" <?php echo $reserved_class; ?> <?php echo $cleaning_class; ?> <?php echo $mouse_over_function; ?>>&nbsp;
										<?php 
										
										
										if($payment_st=="PENDING")
										{
											if($k == 0)
											{
												$j++;
												$k=1;
											}
											$a1 = 1;
											//echo "PENDING";
											?>
											<!--<img class="pending" src="<?php echo base_url() ?>assets/images/pending_payment.png">-->
											<?php 
										}
										elseif($payment_st=="COMPLETED")
										{
											if($k == 0)
											{
												$j++;
												$k=1;
											}
											$a2 = 1;
											//echo "COMPLETED";
											?>
											<?php 
										}
										elseif($payment_st=="CANCELLED")
										{
											if($k == 0)
											{
												$j++;
												$k=1;
											}
											$a3 = 1;
											?>
											<!--<img class="cancelled" src="<?php echo base_url() ?>assets/images/cancelled_payment.png">-->
											<?php 
										}
										if(!empty($bungalows['reservation'][$current_date]['options_image']))
										{
											if($k == 0)
											{
												$j++;
												$k=1;
											}
											$a4 = 1;
											$options_img_arr=explode(",", $bungalows['reservation'][$current_date]['options_image']);
											/*foreach($options_img_arr as $options_img)
											{
												?>
												<!--<img src="<?php echo base_url() ?>assets/upload/option_icon/<?php echo $options_img ?>">-->
												<?php 
											}*/
											
										}
										?>
										<input type="hidden" id="date" name="date" value="<?php echo $current_date; ?>"/>
										<input type="hidden" id="bungalow_id" name="bungalow_id" value="<?php echo $bungalows['bunglow_id']; ?>"/>
										<input type="hidden" id="reservation_id" name="reservation_id" value="<?php echo $reservation_id; ?>"/>
										<input type="hidden" id="cleaning_date" name="cleaning_date" value="<?php echo $cleaning_date; ?>"/>
										<?php
										if($k==0)
										{
										if($j > 0)
										{
										//echo $j;
										if($j%2==0)
										{
										//echo $j/2;
										$val1=$j/2;
										$unique_row_id=$unique_id."-".$current_date;
										$unique_row_id1=explode("-",$unique_row_id); 
										
										$unique_row_id2=$unique_row_id1[3];
										
										$unique_row_id3=($unique_row_id1[3]-$val1);
										$unique_row_id4=$unique_row_id1[0]."-".$unique_row_id1[1]."-".$unique_row_id1[2]."-".$unique_row_id3;
										?>
										
										<script type="text/javascript" language="javascript">
											//alert("<?php //echo $current_date; ?>");
											
											var dt = "<?php echo $unique_row_id4; ?>";
											//$('#test_row').val("<?php //echo $unique_row_id4; ?>");
											<?php
												if($a1 == 1)
												{?>
													$('#'+dt).append('<img class="pending" src="<?php echo base_url() ?>assets/images/pending_payment.png">');
												<?php }
												elseif($a2 == 1)
												{ ?>
													$('#'+dt).append('<img class="completed" id="<?php echo $reservation_id; ?>" src="<?php echo base_url() ?>assets/images/completed_payment.png"><p>'+'<?php echo "COMPLETED"; ?>'+'</p>');
													  
												<?php }
												elseif($a3 == 1)
												{?>
													$('#'+dt).append('<img class="cancelled" src="<?php echo base_url() ?>assets/images/cancelled_payment.png">');
												<?php }
												if($a4 == 1)
												{?>
													var jsArrayPhp = <?php echo json_encode($options_img_arr); ?>;
													$.each( jsArrayPhp, function( key, value ) {
													  //alert( key + ": " + value );
													  $('#'+dt).append('<img src="'+'<?php echo base_url() ?>'+'assets/upload/option_icon/'+value+'">');
													});
													
														//$('#'+dt).append('<img src="'+'<?php //echo base_url() ?>'+'assets/upload/option_icon/'+'<?php //echo $options_img ?>'+">');
												<?php 
												}
												$a1 = 0;
												$a2 = 0;
												$a3 = 0;
												$a4 = 0;
											?>
										</script>
										<?php
	                                    //echo $date=$data[2]."-".$data[1]."-".$data[0];
										}
										else
										{
										//echo (int)($j/2)+1;
										$val1=(int)($j/2)+1;
										
										//$val1=$j/2;
										$unique_row_id=$unique_id."-".$current_date;
										$unique_row_id1=explode("-",$unique_row_id); 
										
										$unique_row_id2=$unique_row_id1[3];
										
										$unique_row_id3=($unique_row_id1[3]-$val1);
										$unique_row_id4=$unique_row_id1[0]."-".$unique_row_id1[1]."-".$unique_row_id1[2]."-".$unique_row_id3;?>
										
										<script type="text/javascript" language="javascript">
											//alert("<?php //echo $current_date; ?>");
											
											var dt = "<?php echo $unique_row_id4; ?>";
											//$('#test_row').val("<?php //echo $unique_row_id4; ?>");
											<?php
												if($a1 == 1)
												{?>
													$('#'+dt).append('<img class="pending" src="<?php echo base_url() ?>assets/images/pending_payment.png">');
												<?php }
												elseif($a2 == 1)
												{ ?>
													$('#'+dt).append('<img class="completed" id="<?php echo $reservation_id; ?>" src="<?php echo base_url() ?>assets/images/completed_payment.png">');
												<?php }
												elseif($a3 == 1)
												{?>
													$('#'+dt).append('<img class="cancelled" src="<?php echo base_url() ?>assets/images/cancelled_payment.png">');
												<?php }
												if($a4 == 1)
												{?>
													var jsArrayPhp = <?php echo json_encode($options_img_arr); ?>;
													$.each( jsArrayPhp, function( key, value ) {
													  //alert( key + ": " + value );
													  $('#'+dt).append('<img src="'+'<?php echo base_url() ?>'+'assets/upload/option_icon/'+value+'">');
													});
													
														//$('#'+dt).append('<img src="'+'<?php //echo base_url() ?>'+'assets/upload/option_icon/'+'<?php //echo $options_img ?>'+">');
												<?php 
												}
										$a1 = 0;
										$a2 = 0;
										$a3 = 0;
										$a4 = 0;
											?>
										</script>
										<?php
										}
										
										}
										$j=0;
										
										}
										//echo $j;
                                        ?>
										
										<?php
										$k=0;
										?>
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
			<!--<li><a class="prev_month" href="#"><img src="<?php echo base_url();?>assets/images/prev-icon.png" alt="" /></a></li>-->
			
			<li><?php echo anchor('admin/home/index/'.($currMonth-1).'/'.$currentYear,img(array('src'=>"assets/images/prev-icon.png")),'class=""');?></li>
			
			
			<?php /*?><?php
			if($currMonth-10)
			{
			?><?php */?>
			<li><?php echo anchor('admin/home/index/'.($currMonth+1).'/'.$currentYear,img(array('src'=>"assets/images/next-icon.png")),'class=""');?></li>
			<?php /*?><?php
			}
			?><?php */?>
			
			
			
			
		
			
		</ul>
</div>    
</div>   <!-- /.row -->
	<!--<div class="reserved reserved_div">
		<span>RESERVED</span>
	</div>-->
	<div class="cleaning cleaning_div">
		<span>CLEANING</span>
	</div>
	<div class="pending_payment payment_status_div">
		<span>PENDING</span>
	</div>
	<div class="completed_payment payment_status_div">
		<span>COMPLETED</span>
	</div>
	<div class="cancelled_payment payment_status_div">
		<span>CANCELLED</span>
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
<div id="full_details_div" style="display:none;" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade"></div>
<div id="ajax_progress" style="text-align:center; display:none; margin-top:325px;" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade"><img src="<?php echo base_url(); ?>assets/images/ajax-loader-big.gif"></div>
<div id="print_details_div" style="display:none;"></div>

<div id="ask_for_user_type_div" style="display:none;" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header" >
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><i class="fa fa-wheelchair"></i>User Type</h4>
				<div class="modal-body">
					<div class="box-body">
						<div class="form-group">
							<input type="hidden" id="hidden_bungalow_id" value="">
							<input type="hidden" id="hidden_arrival_date" value="">
							<label for="exampleInputPassword1" style="width:50%; float:left; text-align:center;">
								<input type="radio" name="user_type" value="R" checked>&nbsp;Registered User
							</label>
							<label for="exampleInputPassword1" style="width:50%; float:left; text-align:center;">
								<input type="radio" name="user_type" value="U">&nbsp;Unregistered User
							</label>
						</div>
						<div class="box-footer" align="center">
							<input type="button" class="btn btn-primary" name="proceed" value="Proceed" onclick="proceed_to_get_add_reservation_form()">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>





