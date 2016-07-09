<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Send Invoice
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url(); ?>admin"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active"></li>
	</ol>
</section>
<!-- Main content -->
<script>
	function check_invoice_form()
	{
		if($("#payment_mode").val()!="ONARRIVAL")
		{
			if($("#currency_type").val()=="USD")
			{
				$("#currency_type_error").show();
				return false;
			}
			else 
			{
				$("#currency_type_error").hide();
			}
		}
	}
</script>
<section class="content">
	<?php
	if(isset($success_message))
	{
		?>
		<div class="alert alert-success alert-dismissable">
			<i class="fa fa-check"></i>
			<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
			<b><?php echo $success_message; ?></b>
		</div>
		
		<?php
	}
	?>
	<div class="row">
		<div class="col-md-11">
			<!-- general form elements -->
			<div class="box box-primary">
				<?php 
				//Change Date format for arrival date and leave date 
				$arrival_date_arr=explode("-", $reservation_payment_details['arrival_date']);
				$arrival_date=$arrival_date_arr[2]."/".$arrival_date_arr[1]."/".$arrival_date_arr[0];
				$leave_date_arr=explode("-", $reservation_payment_details['leave_date']);
				$leave_date=$leave_date_arr[2]."/".$leave_date_arr[1]."/".$leave_date_arr[0];
				$reservation_date=date("d/m/Y H:i:s", strtotime($reservation_payment_details['reservation_date']))
				?>
				<!-- form start -->
				<form role="form" id="form" action="" method="POST" onsubmit="return check_invoice_form()">
					<input type="hidden" name="site_setting_id" id="site_setting_id" value="">
					<div class="box-body">
						<input type="hidden" name="reservation_id" id="reservation_id" value="<?php echo $reservation_payment_details['reservation_id'] ?>">
						<div class="horizontal_div_full">
							User Details
						</div>
						<div class="form-group">
							<label for="exampleInputEmail1">USER FULL NAME</label>
							<input type="text" name="user_name" id="user_name" class="form-control" id="exampleInputEmail1" placeholder="User Name" readonly value="<?php echo $user_details[0]['name'] ?>">
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">EMAIL</label>
							<input type="text" name="email" id="email" class="form-control" id="exampleInputPassword1" placeholder="Email" readonly value="<?php echo $user_details[0]['email'] ?>">
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">ADDRESS</label>
							<input type="text" name="address" id="address" class="form-control" id="exampleInputPassword1" placeholder="Address" readonly value="<?php echo $user_details[0]['address'] ?>">
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">CONTACT NO.</label>
							<input type="text" name="contact_no" id="contact_no" class="form-control" id="exampleInputPassword1" placeholder="Contact No" readonly value="<?php echo $user_details[0]['contact_number'] ?>">
						</div>
						<div class="horizontal_div_full">
							Booking Details
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">INVOICE NUMBER</label>
							<input type="text" name="invoice_number" id="invoice_number" class="form-control" id="exampleInputPassword1" placeholder="Invoice Number" readonly value="<?php echo $reservation_payment_details['invoice_number'] ?>">
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">CUSTOMER NAME</label>
							<input type="text" name="customer_name" id="customer_name" class="form-control" id="exampleInputPassword1" placeholder="Bungalow Under Booking" readonly value="<?php echo $reservation_payment_details['user_name'] ?>">
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">RESERVATION DATE</label>
							<input type="text" name="reservation_date" id="reservation_date" class="form-control" id="exampleInputPassword1" placeholder="Reservation Date" readonly value="<?php echo $reservation_date; ?>">
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">ARRIVAL DATE</label>
							<input type="text" name="arrival_date" id="arrival_date" class="form-control" id="exampleInputPassword1" placeholder="Arrival Date" readonly value="<?php echo $arrival_date; ?>">
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">LEAVE DATE</label>
							<input type="text" name="leave_date" id="leave_date" class="form-control" id="exampleInputPassword1" placeholder="Leave Date" readonly value="<?php echo $leave_date; ?>">
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">ACCOMODATION(DAYS)</label>
							<input type="text" name="accomodation" id="accomodation" class="form-control" id="exampleInputPassword1" placeholder="Accomodation" readonly value="<?php echo $reservation_payment_details['accommodation'] ?>">
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">PAYMENT MODE</label>
							<input type="text" name="payment_mode" id="payment_mode" class="form-control" id="exampleInputPassword1" placeholder="Payment Mode" readonly value="<?php echo $reservation_payment_details['payment_mode'] ?>">
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">TOTAL</label>
							<input type="text" name="total" id="total" class="form-control" id="exampleInputPassword1" placeholder="Total" readonly value="<?php echo $reservation_payment_details['total'] ?>">
						</div>
						<?php 
						if($reservation_payment_details['payment_mode']=="FULL")
						{
							?>
							<div class="form-group">
								<label for="exampleInputPassword1">PAID AMOUNT</label>
								<input type="text" name="paid_amount" id="paid_amount" class="form-control" id="exampleInputPassword1" placeholder="Paid Amount" readonly value="<?php echo $reservation_payment_details['paid_amount']; ?>">
							</div>
							<?php 
						}
						elseif($reservation_payment_details['payment_mode']=="PARTIAL")
						{
							?>
							<div class="form-group">
								<label for="exampleInputPassword1">PAID AMOUNT</label>
								<input type="text" name="paid_amount" id="paid_amount" class="form-control" id="exampleInputPassword1" placeholder="Paid Amount" readonly value="<?php echo $reservation_payment_details['paid_amount']; ?>">
							</div>
							<div class="form-group">
								<label for="exampleInputPassword1">DUE AMOUNT</label>
								<input type="text" name="due_amount" id="due_amount" class="form-control" id="exampleInputPassword1" placeholder="Due Amount" readonly value="<?php echo $reservation_payment_details['due_amount']; ?>">
							</div>
							<?php 
						}
						elseif($reservation_payment_details['payment_mode']=="ONARRIVAL")
						{
							?>
							<div class="form-group">
								<label for="exampleInputPassword1">DUE AMOUNT</label>
								<input type="text" name="due_amount" id="due_amount" class="form-control" id="exampleInputPassword1" placeholder="Due Amount" readonly value="<?php echo $reservation_payment_details['due_amount']; ?>">
							</div>
							<?php 
						}
						?>
						<div class="form-group">
							<label for="exampleInputPassword1">PAYMENT STATUS</label>
							<input type="text" name="payment_status" id="payment_status" class="form-control" id="exampleInputPassword1" placeholder="Payment Status" readonly value="<?php echo $reservation_payment_details['payment_status']; ?>">
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">RESERVATION STATUS</label>
							<input type="text" name="reservation_status" id="reservation_status" class="form-control" id="exampleInputPassword1" placeholder="Payment Status" readonly value="<?php echo $reservation_payment_details['reservation_status']; ?>">
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">IS PAYMENT ACTIVE?</label>
							<input type="text" name="payment_active" id="payment_active" class="form-control" id="exampleInputPassword1" placeholder="Payment active or not" readonly value="<?php echo $reservation_payment_details['is_active']; ?>">
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">CHOOSE CURRENCY FOR INVOICE</label>
							<select name="currency_type" id="currency_type" class="form-control">
								<option value="EUR">&euro;</option>
								<option value="USD">&dollar;</option>
							</select>
							<div class="form-group has-error" id="currency_type_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> $ is allowed only for offline payment</i>
								</label>
							</div>
						</div>
					</div><!-- /.box-body -->
					<div class="box-footer">
						<input type="submit" class="btn btn-primary" name="send_invoice" value="Send Invoice">
					</div>
				</form>
			</div><!-- /.box -->
		</div>
	</div>   <!-- /.row -->
</section><!-- /.content -->