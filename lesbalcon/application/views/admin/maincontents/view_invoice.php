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

<div class="box_horizontal">
	<a style="cursor:pointer;" onclick="history.go(-1)" class="btn btn-primary btn-flat">BACK</a>
</div>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<!-- general form elements -->
			<div class="box box-primary">
				<!-- form start -->
					<div class="box-body table-responsive">
						<table class="table table-hover">
							<tr bgcolor="#f5e8c8">
								<td style="border-top:1px solid #C9AD64; width:30%; padding:5px;"><b>Invoice Code: </b></td >
								<td style="border-top:1px solid #C9AD64; width:70%; padding:5px; border-left:1px solid #C9AD64;">
									<?php echo $invoice_details['invoice_number'] ?>
								</td>
							</tr>
							<tr>
								<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Customer Name: </b></td>
								<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
									<?php echo $invoice_details['customer_name'] ?>
								</td>
							</tr>
							<tr bgcolor="#f5e8c8">
								<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Reservation Date: </b></td >
								<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
									<?php echo $invoice_details['reservation_date'] ?>
								</td>
							</tr>
							<tr>
								<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Arrival Date: </b></td>
								<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
									<?php echo $invoice_details['arrival_date'] ?>
								</td>
							</tr>
							<tr bgcolor="#f5e8c8">
								<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Departure Date: </b></td >
								<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
									<?php echo $invoice_details['leave_date'] ?>
								</td>
							</tr>
							<tr>
								<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Accommodation(days): </b></td>
								<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
									<?php echo $invoice_details['accommodation']." ".lang("NIGHT"); ?>
								</td>
							</tr>
							<tr bgcolor="#f5e8c8">
								<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Bungalow: </b></td >
								<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
									<?php 											
									$bungalow_name_part = explode("<span>", $invoice_details['bungalow_name']);
									$bunglow_name = $bungalow_name_part[0];
									echo $bunglow_name; ?>
								</td>
							</tr>
							<tr>
								<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Total Bungalow Rate: </b></td >
								<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
									<?php echo $invoice_details['bungalow_rate'] ?>
								</td>
							</tr>
							<tr bgcolor="#f5e8c8">
									<td style="border-top:1px solid #C9AD64; padding:5px;"><b>No of Adults:</b></td>
									<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;"><?php echo $invoice_details['no_of_adult']; ?></td>
								</tr>
								<?php if($invoice_details['no_of_extra_real_adult'] > 0){ ?>
									<tr bgcolor="#f5e8c8">
										<td style="border-top:1px solid #C9AD64; padding:5px;"><b>No. of extra person from 12yo:</b></td>
										<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;"><?php echo $invoice_details['no_of_extra_real_adult']; ?></td>
									</tr>\
								<?php } if($invoice_details['no_of_extra_adult'] > 0){ ?>
									<tr bgcolor="#f5e8c8">
										<td style="border-top:1px solid #C9AD64; padding:5px;"><b>No. of extra person from 6yo:</b></td>
										<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;"><?php echo $invoice_details['no_of_extra_adult']; ?></td>
									</tr>
								<?php } if($invoice_details['no_of_extra_kid'] > 0){ ?>
									<tr bgcolor="#f5e8c8">
										<td style="border-top:1px solid #C9AD64; padding:5px;"><b>No of extra person from 2 to 5yo:</b></td>
										<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;"><?php echo $invoice_details['no_of_extra_kid']; ?></td>
									</tr>
								<?php } if($invoice_details['no_of_folding_bed_kid'] > 0){ ?>
									<tr bgcolor="#f5e8c8">
										<td style="border-top:1px solid #C9AD64; padding:5px;"><b>No of folding bed from 2 to 5yo:</b></td>
										<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;"><?php echo $invoice_details['no_of_folding_bed_kid']; ?></td>
									</tr>
								<?php } if($invoice_details['no_of_folding_bed_adult'] > 0){ ?>
									<tr bgcolor="#f5e8c8">
										<td style="border-top:1px solid #C9AD64; padding:5px;"><b>No of folding bed from 6 to 12 yo:</b></td>
										<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;"><?php echo $invoice_details['no_of_folding_bed_adult']; ?></td>
									</tr>
								<?php } if($invoice_details['no_of_baby_bed'] > 0){ ?>
									<tr bgcolor="#f5e8c8">
										<td style="border-top:1px solid #C9AD64; padding:5px;"><b>No of Babies less than 2yo:</b></td>
										<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;"><?php echo $invoice_details['no_of_baby_bed']; ?></td>
									</tr>
								<?php } ?>

							<tr>
								<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Discount(%): </b></td >
								<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
									<?php echo $invoice_details['discount']; ?>
								</td>
							</tr>
							<tr bgcolor="#f5e8c8">
								<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Tax: </b></td >
								<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
									<?php echo $invoice_details['tax_text_for_mail']; ?>
								</td>
							</tr>
							<tr>
								<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Total Amount: </b></td >
								<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
									<?php echo $invoice_details['total']; ?>
								</td>
							</tr>
							<?php 
							if($invoice_details['paid_amount']!='')
							{
								?>
								<tr bgcolor="#f5e8c8">
									<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Paid Amount: </b></td >
									<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
										<?php echo $invoice_details['paid_amount']; ?>
									</td>
								</tr>
								<tr>
									<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Due Amount: </b></td >
									<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
										<?php echo $invoice_details['due_amount']; ?>
									</td>
								</tr>
								<tr bgcolor="#f5e8c8">
									<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Payment Mode: </b></td >
									<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
										<?php echo $invoice_details['payment_mode']; ?>
									</td>
								</tr>
								<tr>
									<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Date of payment: </b></td >
									<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
										<?php echo $invoice_details['date_payment_mode']; ?>
									</td>
								</tr>
								<tr bgcolor="#f5e8c8">
									<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Payment Status: </b></td >
									<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
										<?php echo $invoice_details['payment_status']; ?>
									</td>
								</tr>
								<tr>
									<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Reservation Status: </b></td >
									<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
										<?php echo $invoice_details['reservation_status']; ?>
									</td>
								</tr>
								<?php 
							}
							else 
							{
								?>
								<tr bgcolor="#f5e8c8">
									<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Due Amount: </b></td >
									<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
										<?php echo $invoice_details['due_amount']; ?>
									</td>
								</tr>
								<tr>
									<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Payment Mode: </b></td >
									<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
										<?php echo $invoice_details['payment_mode']; ?>
									</td>
								</tr>
								<tr bgcolor="#f5e8c8">
									<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Date of payment: </b></td >
									<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
										<?php echo $invoice_details['date_payment_mode']; ?>
									</td>
								</tr>
								<tr>
									<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Payment Status: </b></td >
									<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
										<?php echo $invoice_details['payment_status']; ?>
									</td>
								</tr>
								<tr bgcolor="#f5e8c8">
									<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Reservation Status: </b></td >
									<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
										<?php echo $invoice_details['reservation_status']; ?>
									</td>
								</tr>
								<?php 
							}
							?>
							
						</table>
					</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>
	</div>   <!-- /.row -->
</section><!-- /.content -->