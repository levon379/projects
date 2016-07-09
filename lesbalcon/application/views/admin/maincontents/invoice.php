
<?php //print_r($invoice_details[0]); ?>
<!-- This page is from dashboard page -->
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php echo lang("Invoice"); ?>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url(); ?>admin"><i class="fa fa-dashboard"></i> <?php echo lang("Home"); ?></a></li>
		<li class="active"><?php echo lang("Invoice"); ?></li>
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
			<b><?php echo lang("Data_saved_successfully") ?></b>
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
			<b><?php echo lang("Invoice_sent_successfully") ?></b>
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
	<a style="cursor:pointer;" onclick="history.go(-1)" class="btn btn-primary btn-flat"><?php echo lang("BACK"); ?></a>
</div>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<!-- general form elements -->
			<div class="box box-primary">
				<!-- form start -->
					<div class="box-body table-responsive">
						<!-- Table for euro currency -->
						<form action="<?php echo base_url()."admin/users/invoice/". $this->uri->segment(4); ?>" method="POST" id="euro_invoice_form">
							<?php for ( $i = 0; $i < count($invoice_details); $i++ ){ ?>
							<h3>Reservation #<?php echo ($i+1); ?></h3>
							<table class="table table-hover">
								<tr bgcolor="#f5e8c8">
									<td style="border-top:1px solid #C9AD64; width:30%; padding:5px;"><b><?php echo lang("Invoice_code"); ?>: </b></td >
									<td style="border-top:1px solid #C9AD64; width:70%; padding:5px; border-left:1px solid #C9AD64;">
										<?php echo $invoice_details[$i]['invoice_number'] ?>
									</td>
								</tr>
								<tr>
									<td style="border-top:1px solid #C9AD64; padding:5px;"><b><?php echo lang("Name"); ?>: </b></td>
									<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
										<?php echo $invoice_details[$i]['bunglow_under_booking'] ?>
									</td>
								</tr>
								<tr bgcolor="#f5e8c8">
									<td style="border-top:1px solid #C9AD64; padding:5px;"><b><?php echo lang("Reservation_Date"); ?>: </b></td >
									<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
										<?php echo $invoice_details[$i]['reservation_date'] ?>
									</td>
								</tr>
								<tr>
									<td style="border-top:1px solid #C9AD64; padding:5px;"><b><?php echo lang("Arrival_Date"); ?>: </b></td>
									<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
										<?php echo $invoice_details[$i]['arrival_date'] ?>
									</td>
								</tr>
								<tr bgcolor="#f5e8c8">
									<td style="border-top:1px solid #C9AD64; padding:5px;"><b><?php echo lang("Leave_Date"); ?>: </b></td >
									<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
										<?php echo $invoice_details[$i]['leave_date'] ?>
									</td>
								</tr>
								<tr>
									<td style="border-top:1px solid #C9AD64; padding:5px;"><b><?php echo lang("Accommodation"); ?>(<?php echo lang("NIGHT"); ?>): </b></td>
									<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
										<?php echo $invoice_details[$i]['accommodation']." ".lang("NIGHT") ?>
									</td>
								</tr>
								<tr bgcolor="#f5e8c8">
									<td style="border-top:1px solid #C9AD64; padding:5px;"><b><?php echo lang("Bungalow_Name"); ?>: </b></td >
									<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
										<?php 											
										$bungalow_name_part = explode("<span>", $invoice_details[$i]['bungalow_name']);
										$bunglow_name = $bungalow_name_part[0];
										echo $bunglow_name; ?>
									</td>
								</tr>
								<tr>
									<td style="border-top:1px solid #C9AD64; padding:5px;"><b><?php echo lang("no_of_adult"); ?>:</b></td>
									<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;"><?php echo $invoice_details[$i]['no_of_adult']; ?></td>
								</tr>
								<?php if($invoice_details[$i]['no_of_extra_real_adult'] > 0){ ?>
									<tr>
										<td style="border-top:1px solid #C9AD64; padding:5px;"><b><?php echo lang("no_of_extra_real_adult"); ?>:</b></td>
										<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;"><?php echo $invoice_details[$i]['no_of_extra_real_adult']; ?></td>
									</tr>\
								<?php } if($invoice_details[$i]['no_of_extra_adult'] > 0){ ?>
									<tr>
										<td style="border-top:1px solid #C9AD64; padding:5px;"><b><?php echo lang("no_of_extra_adult"); ?>:</b></td>
										<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;"><?php echo $invoice_details[$i]['no_of_extra_adult']; ?></td>
									</tr>
								<?php } if($invoice_details[$i]['no_of_extra_kid'] > 0){ ?>
									<tr>
										<td style="border-top:1px solid #C9AD64; padding:5px;"><b><?php echo lang("no_of_extra_kid"); ?>:</b></td>
										<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;"><?php echo $invoice_details[$i]['no_of_extra_kid']; ?></td>
									</tr>
								<?php } if($invoice_details[$i]['no_of_folding_bed_kid'] > 0){ ?>
									<tr>
										<td style="border-top:1px solid #C9AD64; padding:5px;"><b><?php echo lang("no_of_folding_bed_kid"); ?>:</b></td>
										<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;"><?php echo $invoice_details[$i]['no_of_folding_bed_kid']; ?></td>
									</tr>
								<?php } if($invoice_details[$i]['no_of_folding_bed_adult'] > 0){ ?>
									<tr>
										<td style="border-top:1px solid #C9AD64; padding:5px;"><b><?php echo lang("no_of_folding_bed_adult"); ?>:</b></td>
										<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;"><?php echo $invoice_details[$i]['no_of_folding_bed_adult']; ?></td>
									</tr>
								<?php } if($invoice_details[$i]['no_of_baby_bed'] > 0){ ?>
									<tr>
										<td style="border-top:1px solid #C9AD64; padding:5px;"><b><?php echo lang("no_of_baby_bed"); ?>:</b></td>
										<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;"><?php echo $invoice_details[$i]['no_of_baby_bed']; ?></td>
									</tr>
								<?php } ?>
								<tr bgcolor="#f5e8c8">
									<td style="border-top:1px solid #C9AD64; padding:5px;"><b><?php echo lang("Bungalow_Rate"); ?>: </b></td >
									<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
										<?php echo $invoice_details[$i]['bungalow_rate'];
                                                                                $_banglowrate= str_replace('€','', $invoice_details[$i]['bungalow_rate']);
                                                                                ?> 
									</td>
								</tr>
								<tr>
									<td style="border-top:1px solid #C9AD64; padding:5px;"><b><?php echo "Prix des personnes supplémentaires"; //lang("Bungalow_Rate"); ?>: </b></td >
									<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
										<?php echo "€".$_extra_person=$invoice_details[$i]['extra_person'] ?>
									</td>
								</tr>
								<tr bgcolor="#f5e8c8">
									<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Taxe(4%): </b></td >
									<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
										<?php echo "€".number_format($invoice_details[$i]['tax'], 2, '.', ',') ;
                                                                                        $_tax=$invoice_details[$i]['tax'];?>
									</td>
								</tr>
								<tr>
									<td style="border-top:1px solid #C9AD64; padding:5px;"><b><?php echo lang("Discount"); ?>(%): </b></td >
									<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
										<?php echo $invoice_details[$i]['discount']; ?>
									</td>
								</tr>
								<tr bgcolor="#f5e8c8">
									<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Montant de la réservation: </b></td >
									<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
										<?php echo "€".number_format($invoice_details[$i]['reservation_amount'], 2, '.', ',') ?>
									</td>
								</tr>
								<tr>
									<td style="border-top:1px solid #C9AD64; padding:5px;"><b><?php echo lang("Total_Amount"); ?>: </b></td >
									<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
										€<?php //echo $invoice_details[$i]['total']; 
                                                                                echo $_tax+$_extra_person+$_banglowrate;
                                                                                ?>
									</td>
								</tr>
								<?php 
								if($invoice_details[$i]['paid_amount']!='')
								{
									?>
									<tr bgcolor="#f5e8c8">
										<td style="border-top:1px solid #C9AD64; padding:5px;"><b><?php echo lang("Paid_Amount"); ?>: </b></td >
										<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
											<?php echo $invoice_details[$i]['paid_amount']; ?>
										</td>
									</tr>
									<tr>
										<td style="border-top:1px solid #C9AD64; padding:5px;"><b><?php echo lang("Due_Amount"); ?>: </b></td >
										<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
											<?php echo $invoice_details[$i]['due_amount']; ?>
										</td>
									</tr>
									<!-- <tr bgcolor="#f5e8c8">
										<td style="border-top:1px solid #C9AD64; padding:5px;"><b><?php echo lang("Payment_Mode"); ?>: </b></td >
										<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
											<?php echo $invoice_details[$i]['payment_mode']; ?>
										</td>
									</tr> 
									<tr>
										<td style="border-top:1px solid #C9AD64; padding:5px;"><b><?php echo lang("date_of_payment"); ?>: </b></td >
										<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
											<?php echo $invoice_details[$i]['date_payment_mode']; ?>
										</td>
									</tr>
									<tr bgcolor="#f5e8c8">
										<td style="border-top:1px solid #C9AD64; padding:5px;"><b><?php echo lang("Payment_Status"); ?>: </b></td >
										<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
											<?php echo $invoice_details[$i]['payment_status']; ?>
										</td>
									</tr>
									<tr>
										<td style="border-top:1px solid #C9AD64; padding:5px;"><b><?php echo lang("Reservation_Status"); ?>: </b></td >
										<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
											<?php echo $invoice_details[$i]['reservation_status']; ?>
										</td>
									</tr>	-->
									<tr bgcolor="#f5e8c8">
										<td style="border-top:1px solid #C9AD64; padding:5px;"><b><?php echo lang("User_Comments"); ?>: </b></td >
										<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
											<?php //echo $invoice_details[$i]['comments'];
                                                                                        echo $invoice_details[$i]['invoice_comments'];?>
										</td>
									</tr>	
									<?php 
								}
								else 
								{
									?>
									<tr bgcolor="#f5e8c8">
										<td style="border-top:1px solid #C9AD64; padding:5px;"><b>><?php echo lang("Due_Amount"); ?>: </b></td >
										<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
											<?php echo $invoice_details[$i]['due_amount']; ?>
										</td>
									</tr>
									<!-- <tr>
										<td style="border-top:1px solid #C9AD64; padding:5px;"><b><?php echo lang("Payment_Mode"); ?>: </b></td >
										<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
											<?php echo $invoice_details[$i]['payment_mode']; ?>
										</td>
									</tr>
									<tr bgcolor="#f5e8c8">
										<td style="border-top:1px solid #C9AD64; padding:5px;"><b><?php echo lang("date_of_payment"); ?>: </b></td >
										<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
											<?php echo $invoice_details[$i]['date_payment_mode']; ?>
										</td>
									</tr>
									<tr>
										<td style="border-top:1px solid #C9AD64; padding:5px;"><b><?php echo lang("Payment_Status"); ?>: </b></td >
										<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
											<?php echo $invoice_details[$i]['payment_status']; ?>
										</td>
									</tr>
									<tr bgcolor="#f5e8c8">
										<td style="border-top:1px solid #C9AD64; padding:5px;"><b><?php echo lang("Reservation_Status"); ?>: </b></td >
										<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
											<?php echo $invoice_details[$i]['reservation_status']; ?>
										</td>
									</tr>	 -->
									<tr>
										<td style="border-top:1px solid #C9AD64; padding:5px;"><b><?php echo lang("User_Comments"); ?>: </b></td >
										<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
											<?php //echo $invoice_details[$i]['comments'];
                                                                                        //echo 'wasim :'.$invoice_details[$i]['invoice_comments'];
                                                                                        ?>
										</td>
									</tr>	
									<?php 
								}
								?>					
								<!-- <tr>
									<td colspan="2" align="center">
										<input type="hidden" name="res_id" value="<?php echo $invoice_details[$i]['reservation_id'] ?>">
										<input type="submit" class="btn btn-primary" name="save" value="<?php echo lang('Save'); ?>">
										<a class="btn btn-primary" href="<?php echo base_url()."admin/send_email_to_users?".$invoice_details[$i]['reservation_id']; ?>"><?php echo lang('Send'); ?></a>
									</td>
								</tr> -->
							</table>
							<br/><br/>
							<?php }?>
							<center>
								<input type="hidden" name="res_id" value="<?php echo $this->uri->segment(4); ?>">
								<input type="submit" class="btn btn-primary" name="save" value="<?php echo lang('Save'); ?>">
								<a class="btn btn-primary" href="<?php echo base_url()."admin/send_email_to_users?".$this->uri->segment(4); ?>"><?php echo lang('Send'); ?></a>
							</center>
						</form>
					</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>
	</div>   <!-- /.row -->
</section><!-- /.content -->