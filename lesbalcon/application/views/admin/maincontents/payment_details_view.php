<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		
		<?php echo lang("Payment_Details"); ?>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url(); ?>admin"><i class="fa fa-dashboard"></i> <?php echo lang("Home"); ?></a></li>
		<li class="active"><?php echo lang("Payment_Details"); ?></li>
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
					<?php for ( $i = 0; $i < count($payment_details); $i++ ){ ?>
					<h3>Reservation #<?php echo ($i+1); ?></h3>
					<table class="table table-hover">
						<thead>
							<tr>
								<th width="300" bgcolor="#ccc"><?php echo lang("Payment_Details"); ?></th>
								<th bgcolor="#ccc"><?php echo lang("Payment_Details"); ?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td width="300"><?php echo lang("Invoice_Number"); ?>:</td>
								<td><?php echo $payment_details[$i]['invoice_number'] ?></td>
							</tr>
							<tr>
								<td><?php echo lang("User_Name"); ?>:</td>
								<td><?php echo $payment_details[$i]['user_name'] ?></td>
							</tr>
							<tr>
								<td><?php echo lang("User_Email"); ?>:</td>
								<td><?php echo $payment_details[$i]['user_email'] ?></td>
							</tr>
							<tr>
								<td><?php echo lang("Bungalow_Under_Booking"); ?>:</td>
								<td><?php echo $payment_details[$i]['bunglow_under_booking'] ?></td>
							</tr>
							<tr>
								<td><?php echo lang("Bungalow_Name"); ?>:</td>
								<td>								<?php 											
								$bungalow_name_part = explode("<span>", $payment_details[$i]['bungalow_name']);
								$bunglow_name = $bungalow_name_part[0];
								echo $bunglow_name; ?>
								</td>
							</tr>
							<tr>
								<td><?php echo lang("Arrival_Date"); ?>:</td>
								<td><?php echo date("d/m/Y", strtotime($payment_details[$i]['arrival_date'])); ?></td>
							</tr>
							<tr>
								<td><?php echo lang("Leave_Date"); ?>:</td>
								<td><?php echo date("d/m/Y", strtotime($payment_details[$i]['leave_date'])); ?></td>
							</tr>
							<tr>
								<td><?php echo lang("Accomodation"); ?>:</td>
								<td><?php echo $payment_details[$i]['accommodation']." ". lang("NIGHT"); ?></td>
							</tr>
							<!-- <tr>
								<td>Options:</td>
								<td>
									<?php 
									if(count($payment_details[$i]['options_rate'])>0)
									{
										foreach($payment_details[$i]['options_rate'] as $options_rate) 
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
							</tr> -->
							<tr>
								<td><?php echo lang("No_of_Adults"); ?>:</td>
								<td><?php echo $payment_details[$i]['no_of_adult']; ?></td>
							</tr>
							<?php if($payment_details[$i]['no_of_extra_real_adult'] > 0){ ?>
								<tr>
									<td><?php echo lang("no_of_extra_real_adult"); ?>:</td>
									<td><?php echo $payment_details[$i]['no_of_extra_real_adult']; ?></td>
								</tr>
							<?php } if($payment_details[$i]['no_of_extra_adult'] > 0){ ?>
								<tr>
									<td><?php echo lang("no_of_extra_adult"); ?>:</td>
									<td><?php echo $payment_details[$i]['no_of_extra_adult']; ?></td>
								</tr>
							<?php } if($payment_details[$i]['no_of_extra_kid'] > 0){ ?>
								<tr>
									<td><?php echo lang("No_of_extra_person_from_2_to_5yo"); ?>:</td>
									<td><?php echo $payment_details[$i]['no_of_extra_kid']; ?></td>
								</tr>
							<?php } if($payment_details[$i]['no_of_folding_bed_kid'] > 0){ ?>
								<tr>
									<td><?php echo lang("No_of_folding_bed_from_2_to_5yo"); ?>:</td>
									<td><?php echo $payment_details[$i]['no_of_folding_bed_kid']; ?></td>
								</tr>
							<?php } if($payment_details[$i]['no_of_folding_bed_adult'] > 0){ ?>
								<tr>
									<td><?php echo lang("No_of_folding_bed_from_6_to_12_yo"); ?>:</td>
									<td><?php echo $payment_details[$i]['no_of_folding_bed_adult']; ?></td>
								</tr>
							<?php } if($payment_details[$i]['no_of_baby_bed'] > 0){ ?>
								<tr>
									<td><?php echo lang("No_of_Babies_less_than_2yo"); ?>:</td>
									<td><?php echo $payment_details[$i]['no_of_baby_bed']; ?></td>
								</tr>
							<?php } ?>
							<tr>
								<td><?php echo lang("Bungalow_Rate"); ?>:</td>
								<td><?php echo $payment_details[$i]['bungalow_rate'] ?></td>
							</tr>
							<tr>
								<td><?php echo "Prix des personnes supplémentaires"; //lang("Bungalow_Rate"); ?>:</td>
								<td><?php echo "€".$payment_details[$i]['extra_person'] ?></td>
							</tr>
							<tr>
								<td>Taxe(4%):</td>
								<td><?php echo "€".number_format($payment_details[$i]['tax'], 2, '.', ',') ?></td>
							</tr>
							<tr>
								<td><?php echo lang("Discount"); ?>:</td>
								<td><?php echo $payment_details[$i]['discount']."%" ?></td>
							</tr>
							<tr>
								<td>Montant de la réservation:</td>
								<td><?php $total = str_replace("€","", $payment_details[$i]['reservation_amount']); echo "€".number_format($total * 4/100, 2, '.', ',') ?></td>
							</tr>
							<!-- <tr>
								<td><?php echo lang("Payment_Mode"); ?>:</td>
								<td><?php echo $payment_details[$i]['payment_mode']; ?></td>
							</tr> 
							<tr>
								<td><?php echo lang("Date_of_payment"); ?>:</td>
								<td><?php echo $payment_details[$i]['date_payment_mode']; ?></td>
							</tr>-->
							<tr>
								<td><?php echo lang("Total_Amount"); ?>:</td>
								<td><?php echo $payment_details[$i]['total']; ?></td>
							</tr>
							
							<?php 
							if($payment_details[$i]['payment_mode']=="FULL")
							{
								?>
								<tr>
									<td><?php echo lang("Paid_Amount"); ?>:</td>
									<td><?php echo $payment_details[$i]['paid_amount']; ?></td>
								</tr>
								<?php 
							}
							elseif($payment_details[$i]['payment_mode']=="PARTIAL")
							{
								?>
								<tr>
									<td><?php echo lang("Paid_Amount"); ?>:</td>
									<td><?php echo $payment_details[$i]['paid_amount']; ?></td>
								</tr>
								<tr>
									<td><?php echo lang("Due_Amount"); ?>:</td>
									<td><?php echo $payment_details[$i]['due_amount']; ?></td>
								</tr>
								<?php 
							}
							elseif($payment_details[$i]['payment_mode']=="ONARRIVAL")
							{
								?>
								<tr>
									<td><?php echo lang("Due_Amount"); ?>:</td>
									<td><?php echo $payment_details[$i]['due_amount']; ?></td>
								</tr>
								<?php 
							}
							?>
							<!-- <tr>
								<td><?php echo lang("Payment_Status"); ?>:</td>
								<td><?php echo $payment_details[$i]['payment_status'] ?></td>
							</tr>
							<tr>
								<td><?php echo lang("Reservation_Status"); ?>:</td>
								<td><?php echo $payment_details[$i]['reservation_status'] ?></td>
							</tr> -->
							<tr>
								<td><?php echo lang("More_Contact"); ?>:</td>
								<td><?php echo $payment_details[$i]['more_phone'] ?></td>
							</tr>
							<tr>
								<td><?php echo lang("More_Email"); ?>:</td>
								<td><?php echo $payment_details[$i]['more_email'] ?></td>
							</tr>
							
							<tr>
								<td><?php echo lang("User_Comments"); ?>:</td>
								<td><?php echo str_replace('\n', '<br/>',$payment_details[$i]['invoice_comments']) ?></td>
							</tr>
						</tbody>
					</table>					
					<br/><br/>
					<?php }?>
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