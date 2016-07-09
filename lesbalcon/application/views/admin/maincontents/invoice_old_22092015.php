
<?php //print_r($invoice_details); ?>
<!-- This page is from dashboard page -->
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Invoice
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url(); ?>admin"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Invoice</li>
	</ol>
</section>
<!-- Main content -->
<script>
	function change_type(value)
	{
		if($("#payment_mode").val()!="ONARRIVAL")
		{
			$("#euro_invoice_form").hide();
			$("#dollar_invoice_form").show();
		}
		else 
		{
			if(value=="USD")
			{
				alert("$ currency is allowed only for offline payment")
				document.getElementById("change_type").selectedIndex = "0";
				return false;
			}
		}
	}
</script>
<?php
	if(isset($_GET['saved']))
	{
		?>
		<section class="content">
		<div class="alert alert-success alert-dismissable">
			<i class="fa fa-check"></i>
			<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
			<b>Data saved successfully</b>
		</div>
		</section>
		<?php
	}
	if(isset($_GET['mailsent']))
	{
		?>
		<section class="content">
		<div class="alert alert-success alert-dismissable">
			<i class="fa fa-check"></i>
			<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
			<b>Invoice sent successfully</b>
		</div>
		</section>
		<?php
	}
?>
<div class="box_horizontal">
	<!--<select name="change_type" id="change_type" style="float:left; width:25%;" class="form-control" onchange="change_type(this.value)">
		<option value="EUR">€</option>
		<option value="USD">$</option>
	</select>-->
	<a style="cursor:pointer;" onclick="history.go(-1)" class="btn btn-primary btn-flat">BACK</a>
</div>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<!-- general form elements -->
			<div class="box box-primary">
				<!-- form start -->
					<div class="box-body table-responsive">
						<!-- Table for euro currency -->
						<form action="<?php echo base_url()."admin/users/invoice/".$reservation_id; ?>" method="POST" id="euro_invoice_form">
							<table class="table table-hover">
								<input type="hidden" name="reservation_id" id="reservation_id" value="<?php echo $reservation_id; ?>">
								<input type="hidden" name="user_id" id="reservation_id" value="<?php echo $user_id; ?>">
								<input type="hidden" name="currency_type" id="currency_type" value="EUR">
								<tr bgcolor="#f5e8c8">
									<td style="border-top:1px solid #C9AD64; width:30%; padding:5px;"><b>Invoice Code: </b></td >
									<td style="border-top:1px solid #C9AD64; width:70%; padding:5px; border-left:1px solid #C9AD64;">
										<input style="width:100%;" type="text" name="invoice_code" id="invoice_code" value="<?php echo $invoice_details[0]['invoice_number'] ?>">
									</td>
								</tr>
								<tr>
									<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Customer Name: </b></td>
									<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
										<input style="width:100%;" type="text" name="customer_name" id="customer_name" value="<?php echo $invoice_details[0]['bunglow_under_booking'] ?>">
									</td>
								</tr>
								<tr bgcolor="#f5e8c8">
									<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Reservation Date: </b></td >
									<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
										<input style="width:100%;" type="text" name="reservation_date" id="reservation_date" value="<?php echo $invoice_details[0]['reservation_date'] ?>">
									</td>
								</tr>
								<tr>
									<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Arrival Date: </b></td>
									<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
										<input style="width:100%;" type="text" name="arrival_date" id="arrival_date" value="<?php echo $invoice_details[0]['arrival_date'] ?>">
									</td>
								</tr>
								<tr bgcolor="#f5e8c8">
									<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Departure Date: </b></td >
									<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
										<input style="width:100%;" type="text" name="leave_date" id="leave_date" value="<?php echo $invoice_details[0]['leave_date'] ?>">
									</td>
								</tr>
								<tr>
									<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Accommodation(days): </b></td>
									<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
										<input style="width:100%;" type="text" name="accommodation" id="accommodation" value="<?php echo $invoice_details[0]['accommodation'] ?>">
									</td>
								</tr>
								<tr bgcolor="#f5e8c8">
									<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Bungalow: </b></td >
									<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
										<?php 											
										$bungalow_name_part = explode("<span>", $invoice_details[0]['bungalow_name']);
										$bunglow_name = $bungalow_name_part[0];
										?>
										<input style="width:100%;" type="text" name="bungalow_name" id="bungalow_name" value="<?php echo $bunglow_name; ?>">
									</td>
								</tr>
								<tr>
									<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Total Bungalow Rate: </b></td >
									<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
										<input style="width:100%;" type="text" name="bungalow_rate" id="bungalow_rate" value="<?php echo $invoice_details[0]['bungalow_rate'] ?>">
									</td>
								</tr>
								<!-- <tr bgcolor="#f5e8c8">
									<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Options: </b></td >
									<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
										<input style="width:100%;" type="text" name="options_text_for_mail" id="options_text_for_mail" value="<?php echo $invoice_details[0]['options_text_for_mail'] ?>">
									</td>
								</tr> -->
								<tr bgcolor="#f5e8c8">
									<td style="border-top:1px solid #C9AD64; padding:5px;"><b>No of Adults:</b></td>
									<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;"><?php echo $invoice_details[0]['no_of_adult']; ?></td>
								</tr>
								<?php if($invoice_details[0]['no_of_extra_real_adult'] > 0){ ?>
									<tr bgcolor="#f5e8c8">
										<td style="border-top:1px solid #C9AD64; padding:5px;"><b>No. of extra person from 12yo:</b></td>
										<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;"><?php echo $invoice_details[0]['no_of_extra_real_adult']; ?></td>
									</tr>\
								<?php } if($invoice_details[0]['no_of_extra_adult'] > 0){ ?>
									<tr bgcolor="#f5e8c8">
										<td style="border-top:1px solid #C9AD64; padding:5px;"><b>No. of extra person from 6yo:</b></td>
										<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;"><?php echo $invoice_details[0]['no_of_extra_adult']; ?></td>
									</tr>
								<?php } if($invoice_details[0]['no_of_extra_kid'] > 0){ ?>
									<tr bgcolor="#f5e8c8">
										<td style="border-top:1px solid #C9AD64; padding:5px;"><b>No of extra person from 2 to 5yo:</b></td>
										<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;"><?php echo $invoice_details[0]['no_of_extra_kid']; ?></td>
									</tr>
								<?php } if($invoice_details[0]['no_of_folding_bed_kid'] > 0){ ?>
									<tr bgcolor="#f5e8c8">
										<td style="border-top:1px solid #C9AD64; padding:5px;"><b>No of folding bed from 2 to 5yo:</b></td>
										<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;"><?php echo $invoice_details[0]['no_of_folding_bed_kid']; ?></td>
									</tr>
								<?php } if($invoice_details[0]['no_of_folding_bed_adult'] > 0){ ?>
									<tr bgcolor="#f5e8c8">
										<td style="border-top:1px solid #C9AD64; padding:5px;"><b>No of folding bed from 6 to 12 yo:</b></td>
										<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;"><?php echo $invoice_details[0]['no_of_folding_bed_adult']; ?></td>
									</tr>
								<?php } if($invoice_details[0]['no_of_baby_bed'] > 0){ ?>
									<tr bgcolor="#f5e8c8">
										<td style="border-top:1px solid #C9AD64; padding:5px;"><b>No of Babies less than 2yo:</b></td>
										<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;"><?php echo $invoice_details[0]['no_of_baby_bed']; ?></td>
									</tr>
								<?php } ?>
								<tr>
									<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Discount(%): </b></td >
									<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
										<input style="width:100%;" type="text" name="discount" id="discount" value="<?php echo $invoice_details[0]['discount']; ?>">
									</td>
								</tr>
								<tr bgcolor="#f5e8c8">
									<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Tax: </b></td >
									<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
										<input style="width:100%;" type="text" name="tax_text_for_mail" id="tax_text_for_mail" value="4%">
									</td>
								</tr>
								<tr>
									<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Total Amount: </b></td >
									<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
										<input style="width:100%;" type="text" name="total" id="total" value="<?php echo $invoice_details[0]['total']; ?>">
									</td>
								</tr>
								<tr bgcolor="#f5e8c8">
									<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Paid Amount: </b></td >
									<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
										<input style="width:100%;" type="text" name="paid_amount" id="paid_amount" value="<?php echo $invoice_details[0]['paid_amount']; ?>">
									</td>
								</tr>
								<tr>
									<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Due Amount: </b></td >
									<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
										<input style="width:100%;" type="text" name="due_amount" id="due_amount" value="<?php echo $invoice_details[0]['due_amount']; ?>">
									</td>
								</tr>
								<tr bgcolor="#f5e8c8">
									<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Payment Mode: </b></td >
									<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
										<input style="width:100%;" type="text" name="payment_mode" id="payment_mode" value="<?php echo $invoice_details[0]['payment_mode']; ?>">
									</td>
								</tr>
								<tr>
									<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Date of payment: </b></td >
									<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
										<input style="width:100%;" type="text" name="date_payment_mode" id="date_payment_mode" value="<?php echo $invoice_details[0]['date_payment_mode']; ?>">
									</td>
								</tr>
								<tr bgcolor="#f5e8c8">
									<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Payment Status: </b></td >
									<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
										<!-- <input style="width:100%;" type="text" name="payment_status" id="payment_status" value="<?php echo $invoice_details[1]['payment_status']; ?>"> -->
										<select id="payment_status" name="payment_status" style="width:100%;">
											<option value="">--Select--</option>
											<option value="En Attente" <?php if($invoice_details[0]['payment_status']=="En Attente"){ echo "selected"; } ?>>En Attente</option>
											<option value="Acompte Payé" <?php if($invoice_details[0]['payment_status']=="Acompte Payé"){ echo "selected"; } ?>>Acompte Payé</option>
											<option value="Réglé" <?php if($invoice_details[0]['payment_status']=="Réglé"){ echo "selected"; } ?>>Réglé</option>
										</select>
									</td>
								</tr>
								<tr>
									<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Reservation Status: </b></td >
									<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
										<!-- <input style="width:100%;" type="text" name="reservation_status" id="reservation_status" value="<?php echo $invoice_details[1]['reservation_status']; ?>"> -->
										<select id="reservation_status" name="reservation_status" style="width:100%;">
											<option value="">--Select--</option>
											<option value="En attente" <?php if($invoice_details[0]['reservation_status']=="En Attente"){ echo "selected"; } ?>>En Attente</option>
											<option value="Confirmé" <?php if($invoice_details[0]['reservation_status']=="Confirmé"){ echo "selected"; } ?>>Confirmé</option>
											<option value="Payé" <?php if($invoice_details[0]['reservation_status']=="Payé"){ echo "selected"; } ?>>Payé</option>
											<option value="Annulé" <?php if($invoice_details[0]['reservation_status']=="Annulé"){ echo "selected"; } ?>>Annulé</option>
										</select>
									</td>
								</tr>
								<tr>
									<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Comments: </b></td >
									<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
										<textarea style="width:100%;height:200px" name="txt_comments" id="txt_comments"><?php echo str_ireplace("<br />", "\n", $invoice_details[0]['comments']); ?></textarea>
									</td>
								</tr>

								<tr>
									<td colspan="2" align="center">
										<?php 
											if($invoice_details[0]['send_status']=="N")
											{
												?>
												<input type="submit" class="btn btn-primary" name="send_invoice" value="Send">
												<?php 
											}
											else 
											{
												?>
												<input type="submit" class="btn btn-primary" name="view_invoice" value="View">
												<?php 
											}
										?>
										<input type="submit" class="btn btn-primary" name="save" value="Save">
									</td>
								</tr>
								<!-- Hidden field for dollar currency -->
								<input style="width:100%;" type="hidden" name="bungalow_rate_dollar" id="bungalow_rate_dollar" value="<?php echo $invoice_details[1]['bungalow_rate'] ?>">
								<input style="width:100%;" type="hidden" name="options_text_for_mail_dollar" id="options_text_for_mail_dollar" value="<?php echo $invoice_details[1]['options_text_for_mail'] ?>">
								<input style="width:100%;" type="hidden" name="tax_text_for_mail_dollar" id="tax_text_for_mail_dollar" value="<?php echo $invoice_details[1]['tax_text_for_mail'] ?>">
								<input style="width:100%;" type="hidden" name="total_dollar" id="total_dollar" value="<?php echo $invoice_details[1]['total'] ?>">
								<input style="width:100%;" type="hidden" name="paid_amount_dollar" id="paid_amount_dollar" value="0">
								<input style="width:100%;" type="hidden" name="due_amount_dollar" id="due_amount_dollar" value="<?php echo $invoice_details[1]['due_amount'] ?>">
							</table>
						</form>
						<?php 
							if($invoice_details[1]['send_status']=="N")
							{
								$form_action=base_url()."admin/users/invoice/".$reservation_id;
							}
							else 
							{
								$form_action=base_url()."admin/users/view_invoice";
							}
						?>
						<!-- Invoice Table for dollar currency bu default it will be hidden -->
						<form action="<?php echo $form_action; ?>" method="POST" id="dollar_invoice_form" style="display:none;">
							<table class="table table-hover">
								<input type="hidden" name="reservation_id" id="reservation_id" value="<?php echo $reservation_id; ?>">
								<input type="hidden" name="user_id" id="reservation_id" value="<?php echo $user_id; ?>">
								<input type="hidden" name="currency_type" id="currency_type" value="USD">
								<tr bgcolor="#f5e8c8">
									<td style="border-top:1px solid #C9AD64; width:30%; padding:5px;"><b>Invoice Code: </b></td >
									<td style="border-top:1px solid #C9AD64; width:70%; padding:5px; border-left:1px solid #C9AD64;">
										<input style="width:100%;" type="text" name="invoice_code" id="invoice_code" value="<?php echo $invoice_details[1]['invoice_number'] ?>">
									</td>
								</tr>
								<tr>
									<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Customer Name: </b></td>
									<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
										<input style="width:100%;" type="text" name="customer_name" id="customer_name" value="<?php echo $invoice_details[1]['bunglow_under_booking'] ?>">
									</td>
								</tr>
								<tr bgcolor="#f5e8c8">
									<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Reservation Date: </b></td >
									<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
										<input style="width:100%;" type="text" name="reservation_date" id="reservation_date" value="<?php echo $invoice_details[1]['reservation_date'] ?>">
									</td>
								</tr>
								<tr>
									<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Arrival Date: </b></td>
									<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
										<input style="width:100%;" type="text" name="arrival_date" id="arrival_date" value="<?php echo $invoice_details[1]['arrival_date'] ?>">
									</td>
								</tr>
								<tr bgcolor="#f5e8c8">
									<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Departure Date: </b></td >
									<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
										<input style="width:100%;" type="text" name="leave_date" id="leave_date" value="<?php echo $invoice_details[1]['leave_date'] ?>">
									</td>
								</tr>
								<tr>
									<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Accommodation(days): </b></td>
									<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
										<input style="width:100%;" type="text" name="accommodation" id="accommodation" value="<?php echo $invoice_details[1]['accommodation'] ?>">
									</td>
								</tr>
								<tr bgcolor="#f5e8c8">
									<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Bungalow: </b></td >
									<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
										<input style="width:100%;" type="text" name="bungalow_name" id="bungalow_name" value="<?php echo $invoice_details[1]['bungalow_name'] ?>">
									</td>
								</tr>
								<tr>
									<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Total Bungalow Rate: </b></td >
									<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
										<input style="width:100%;" type="text" name="bungalow_rate" id="bungalow_rate" value="<?php echo $invoice_details[1]['bungalow_rate'] ?>">
									</td>
								</tr>
								<tr bgcolor="#f5e8c8">
									<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Options: </b></td >
									<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
										<input style="width:100%;" type="text" name="options_text_for_mail" id="options_text_for_mail" value="<?php echo $invoice_details[1]['options_text_for_mail'] ?>">
									</td>
								</tr>
								<tr>
									<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Discount(%): </b></td >
									<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
										<input style="width:100%;" type="text" name="discount" id="discount" value="<?php echo $invoice_details[1]['discount']; ?>">
									</td>
								</tr>
								<tr bgcolor="#f5e8c8">
									<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Tax: </b></td >
									<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
										<input style="width:100%;" type="text" name="tax_text_for_mail" id="tax_text_for_mail" value="<?php echo $invoice_details[1]['tax_text_for_mail']; ?>">
									</td>
								</tr>
								<tr>
									<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Total Amount: </b></td >
									<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
										<input style="width:100%;" type="text" name="total" id="total" value="<?php echo $invoice_details[1]['total']; ?>">
									</td>
								</tr>
								
								<tr bgcolor="#f5e8c8">
									<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Due Amount: </b></td >
									<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
										<input style="width:100%;" type="text" name="due_amount" id="due_amount" value="<?php echo $invoice_details[1]['due_amount']; ?>">
									</td>
								</tr>
								<tr>
									<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Payment Status: </b></td >
									<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
										<!-- <input style="width:100%;" type="text" name="payment_status" id="payment_status" value="<?php echo $invoice_details[1]['payment_status']; ?>"> -->
										<select id="payment_status" name="payment_status" style="width:100%;">
											<option value="">--Select--</option>
											<option value="En Attente" <?php if($invoice_details[1]['payment_status']=="En Attente"){ echo "selected"; } ?>>En Attente</option>
											<option value="Acompte Payé" <?php if($invoice_details[1]['payment_status']=="Acompte Payé"){ echo "selected"; } ?>>Acompte Payé</option>
											<option value="Réglé" <?php if($invoice_details[1]['payment_status']=="Réglé"){ echo "selected"; } ?>>Réglé</option>
										</select>
									</td>
								</tr>
								<tr bgcolor="#f5e8c8">
									<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Reservation Status: </b></td >
									<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
										<!-- <input style="width:100%;" type="text" name="reservation_status" id="reservation_status" value="<?php echo $invoice_details[1]['reservation_status']; ?>"> -->
										<select id="reservation_status" name="reservation_status" style="width:100%;">
											<option value="">--Select--</option>
											<option value="En attente" <?php if($invoice_details[1]['reservation_status']=="En attente"){ echo "selected"; } ?>>En attente</option>
											<option value="Confirmé" <?php if($invoice_details[1]['reservation_status']=="Confirmé"){ echo "selected"; } ?>>Confirmé</option>
											<option value="Payé" <?php if($invoice_details[1]['reservation_status']=="Payé"){ echo "selected"; } ?>>Payé</option>
											<option value="Annulé" <?php if($invoice_details[1]['reservation_status']=="Annulé"){ echo "selected"; } ?>>Annulé</option>
										</select>
									</td>
								</tr>
								<tr>
									<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Payment Mode: </b></td >
									<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
										<input style="width:100%;" type="text" name="payment_mode" id="payment_mode" value="<?php echo $invoice_details[1]['payment_mode']; ?>">
									</td>
								</tr>
								<tr>
									<td colspan="2" align="center">
										<?php 
											if($invoice_details[1]['send_status']=="N")
											{
												?>
												<input type="submit" class="btn btn-primary" name="send_invoice" value="Send">
												<?php 
											}
											else 
											{
												?>
												<input type="submit" class="btn btn-primary" name="view_invoice" value="View">
												<?php 
											}
										?>
										<input type="submit" class="btn btn-primary" name="save" value="Save">
									</td>
								</tr>
								<!-- Hidden field for dollar currency -->
								<input style="width:100%;" type="hidden" name="bungalow_rate_euro" id="bungalow_rate_euro" value="<?php echo $invoice_details[0]['bungalow_rate'] ?>">
								<input style="width:100%;" type="hidden" name="options_text_for_mail_euro" id="options_text_for_mail_euro" value="<?php echo $invoice_details[0]['options_text_for_mail'] ?>">
								<input style="width:100%;" type="hidden" name="tax_text_for_mail_euro" id="tax_text_for_mail_euro" value="<?php echo $invoice_details[0]['tax_text_for_mail'] ?>">
								<input style="width:100%;" type="hidden" name="total_euro" id="total_euro" value="<?php echo $invoice_details[0]['total'] ?>">
								<input style="width:100%;" type="hidden" name="paid_amount_euro" id="paid_amount_euro" value="<?php echo $invoice_details[0]['paid_amount'] ?>">
								<input style="width:100%;" type="hidden" name="due_amount_euro" id="due_amount_euro" value="<?php echo $invoice_details[0]['due_amount'] ?>">
							</table>
						</form>
					</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>
	</div>   <!-- /.row -->
</section><!-- /.content -->