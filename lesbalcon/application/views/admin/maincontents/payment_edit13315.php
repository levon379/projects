<!-- Content Header (Page header) -->
<script>
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
</script>
<section class="content-header">
	<h1>
		Edit Reservation
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url(); ?>admin"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Edit Reservation</li>
	</ol>
</section>
<!-- Main content -->

<div class="box_horizontal">
	<a href="<?php echo base_url(); ?>admin/payment/all" class="btn btn-primary btn-flat">BACK</a>
</div>
		
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<!-- general form elements -->
			<div class="box box-primary">
				<form id="reservation_add_form" action="" method="POST" onsubmit="return validate_edit_reservation()">
					<div class="box-body">
						<input type="hidden" name="bungalow_id" id="bungalow_id" value="<?php echo $reservation_details[0]['bunglow_id']; ?>">
						<input type="hidden" name="reservation_id" id="reservation_id" value="<?php echo $reservation_id; ?>">
						<div class="box-body">
						<div class="form-group">
							<label for="exampleInputPassword1">Bungalow/Property</label>
							<input type="text" name="bungalow_name" id="bungalow_name" class="form-control" readonly value="<?php echo $bungalow_details[0]['bunglow_name']; ?>">
						</div>
						<?php 
						if(count($bungalow_options_details)>0)
						{
							?>
							<div class="form-group">
								<label for="exampleInputPassword1">Options</label><br>
								<?php 
								foreach($bungalow_options_details as $options)
								{
									?>
									<input type="checkbox" name="options_id[]" value="<?php echo $options['options_id'] ?>" <?php if(in_array($options['options_id'], $options_ids)){ echo "checked"; } ?>>&nbsp;<?php echo $options['options_name']; ?>&nbsp;&nbsp;
									<?php 
								}
								?>
							</div>
							<?php 
						}
						?>
						
						<div class="form-group">
							<label for="exampleInputPassword1">User</label>
							<select name="user_id" id="user_id" class="form-control">
								<option value="">--Select--</option>
								<?php 
								foreach($users_list as $user)
								{
									?>
									<option value="<?php echo $user['id']; ?>" <?php if($reservation_details[0]['user_id']==$user['id']){ echo "selected"; }  ?>><?php echo $user['email']; ?></option>
									<?php 
								}
								?>
							</select>
							<div class="form-group has-error" id="user_id_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> User is required</i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">Name</label>
							<input type="text" name="reservation_name" id="reservation_name" class="form-control" value="<?php echo $reservation_details[0]['name']; ?>">
							<div class="form-group has-error" id="reservation_name_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> Name is required</i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">Contact No.</label>
							<input type="text" name="reservation_contact" id="reservation_contact" class="form-control" value="<?php echo $reservation_details[0]['phone']; ?>">
							<div class="form-group has-error" id="reservation_contact_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> Contact No is required</i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">Arrival Date</label>
							<div class='input-group date' id='reservation_arrival_date'>
								<input type="text" name="arrival_date" id="arrival_date" class="form-control" readonly value="<?php echo $arrival_date; ?>">
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-calendar"></span>
								</span>
							</div>
							<div class="form-group has-error" id="arrival_date_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o" id="arrival_date_error_text"> Arrival Date is required</i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">Leave Date</label>
							<div class='input-group date' id='reservation_leave_date'>
								<input type="text" name="leave_date" id="leave_date" class="form-control" readonly value="<?php echo $leave_date; ?>">
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-calendar"></span>
								</span>
							</div>
							<div class="form-group has-error" id="leave_date_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o" id="leave_date_error_text"> Leave Date is required</i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">Source</label>
							<select name="source" id="source" class="form-control">
								<option value="M" <?php if($source=="M"){ echo "selected";} ?>>MANUAL</option>
								<option value="D" <?php if($source=="D"){ echo "selected";} ?>>DIRECT</option>
								<option value="W" <?php if($source=="W"){ echo "selected";} ?>>WEBSITE</option>
							</select>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">Text</label>
							<textarea class="form-control" name="reservation_text" id="reservation_text"><?php echo $reservation_details[0]['comment']; ?></textarea>
						</div>
						</div>
						<div class="box-footer">
							<input type="submit" class="btn btn-primary" name="save" value="Submit">
						</div>
					</div>
				</form>
				
			</div><!-- /.box -->
		</div>
	</div>   <!-- /.row -->
</section><!-- /.content -->