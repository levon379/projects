<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Payment Details
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url(); ?>admin"><i class="fa fa-dashboard"></i> <?php echo lang("Home"); ?></a></li>
		<li class="active">Payment Details</li>
	</ol>
</section>
<!-- Main content -->
<div class="box_horizontal">
	<a style="cursor:pointer" onclick="history.go(-1)" class="btn btn-primary btn-flat"><?php echo lang("Back"); ?></a>
</div>
		
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-body table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
								<th bgcolor="#ccc">Particulars</th>
								<th bgcolor="#ccc">Details</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Invoice Number:</td>
								<td><?php echo $payment_details['invoice_number'] ?></td>
							</tr>
							<tr>
								<td>User Name:</td>
								<td><?php echo $payment_details['user_name'] ?></td>
							</tr>
							<tr>
								<td>User Email:</td>
								<td><?php echo $payment_details['user_email'] ?></td>
							</tr>
							<tr>
								<td>Bungalow Under Booking:</td>
								<td><?php echo $payment_details['bunglow_under_booking'] ?></td>
							</tr>
							<tr>
								<td>Bungalow Name:</td>
								<td><?php echo $payment_details['bungalow_name']; ?></td>
							</tr>
							<tr>
								<td>Arrival Date:</td>
								<td><?php echo date("d/m/Y", strtotime($payment_details['arrival_date'])); ?></td>
							</tr>
							<tr>
								<td>Leave Date:</td>
								<td><?php echo date("d/m/Y", strtotime($payment_details['leave_date'])); ?></td>
							</tr>
							<tr>
								<td>Accomodation:</td>
								<td><?php echo $payment_details['accommodation']; ?></td>
							</tr>
							<tr>
								<td>Bungalow Rate:</td>
								<td><?php echo $payment_details['bungalow_rate'] ?></td>
							</tr>
							<tr>
								<td>Options:</td>
								<td>
									<?php 
									if(count($payment_details['options_rate'])>0)
									{
										foreach($payment_details['options_rate'] as $options_rate) 
										{
											echo $options_rate['option_name'].": ".$options_rate['option_rate']."<br>";
										}
									}
									else
									{
										echo "N/A";
									}
									?>
								</td>
							</tr>
							<tr>
								<td>Discount:</td>
								<td><?php echo $payment_details['discount']."%" ?></td>
							</tr>
							<tr>
								<td>Tax:</td>
								<td>
									<?php 
									if(count($payment_details['tax_rate'])>0)
									{
										foreach($payment_details['tax_rate'] as $tax_rate) 
										{
											echo $tax_rate['tax_name'].": ".$tax_rate['tax_rate']."<br>";
										}
									}
									else
									{
										echo "N/A";
									}
									?>
								</td>
							</tr>
							<tr>
								<td>Payment Mode:</td>
								<td><?php echo $payment_details['payment_mode']; ?></td>
							</tr>
							<tr>
								<td>Total:</td>
								<td><?php echo $payment_details['total']; ?></td>
							</tr>
							
							<?php 
							if($payment_details['payment_mode']=="FULL")
							{
								?>
								<tr>
									<td>Paid Amount:</td>
									<td><?php echo $payment_details['paid_amount']; ?></td>
								</tr>
								<?php 
							}
							elseif($payment_details['payment_mode']=="PARTIAL")
							{
								?>
								<tr>
									<td>Paid Amount:</td>
									<td><?php echo $payment_details['paid_amount']; ?></td>
								</tr>
								<tr>
									<td>Due Amount:</td>
									<td><?php echo $payment_details['due_amount']; ?></td>
								</tr>
								<?php 
							}
							elseif($payment_details['payment_mode']=="ONARRIVAL")
							{
								?>
								<tr>
									<td>Due Amount:</td>
									<td><?php echo $payment_details['due_amount']; ?></td>
								</tr>
								<?php 
							}
							?>
							<tr>
								<td>Payment Status:</td>
								<td><?php echo $payment_details['payment_status'] ?></td>
							</tr>
							<tr>
								<td>Reservation Status:</td>
								<td><?php echo $payment_details['reservation_status'] ?></td>
							</tr>
							<tr>
								<td>More Contact:</td>
								<td><?php echo $payment_details['more_phone'] ?></td>
							</tr>
							<tr>
								<td>More Email:</td>
								<td><?php echo $payment_details['more_email'] ?></td>
							</tr>
							
						</tbody>
					</table>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>
	</div>
</section><!-- /.content -->
<script type="text/javascript">
	$(function() {
		$("#data_table").dataTable(
			{
				"aoColumnDefs" : [ { "bSortable" : false, "aTargets" : [ "sorting_disabled" ] } ],
				"iDisplayLength": 5
			}
		);
		/*$('#example2').dataTable({
			"bPaginate": true,
			"bLengthChange": false,
			"bFilter": false,//For disabling Search Option
			"bSort": true,
			"bInfo": true,
			"bAutoWidth": false
		});*/
		});
</script>