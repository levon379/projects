<div class="row">
	<div class="inner-page-banner"> <img src="<?php echo base_url(); ?>assets/frontend/images/about-us-banner.jpg" alt=""></div>
</div>
<?php 
//echo "<pre>";
$reservation_session=$this->session->userdata("reservation");
$payment_session=$this->session->userdata("payment");
$user_data = $this->session->userdata("login_user_info");
/*
print_r($reservation_session);
print_r($payment_session);

echo "aaaaaaa";*/
?>
<script>
	function show_dollar_price()
	{
		$("#price_in_euro").hide();
		$("#price_in_dollar").show();
	}
	function show_euro_price()
	{
		$("#price_in_euro").show();
		$("#currency_type").val("EURO");
		$("#price_in_dollar").hide();
	}

	function cancelReservation(){
		<?php	?>
		window.location = "<?php echo base_url(); ?>reservation";
	}
</script>
<!--banner end-->
<div class="row innerpage-section">
	<div class="container">
		<h2><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-left.png" alt=""><?php echo lang('CHOOSE_PAYMENT_TYPE'); ?><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-right.png" alt=""></h2>
		<div class="row inner-content">
			<div class="reservation_block">
				<form id="price_in_euro" class="form-login form-horizontal" action="<?php echo base_url(); ?>reservation/payment_process" method="POST">
					<fieldset>
						<div class="form-row form-group">
							  <div class="col-md-4">
								<label><?php echo lang('FullName') ?></label>
							  </div>
							  <div class="col-md-6">
								<div class="col-md-4">
									<label><?php echo $user_data['full_name']; ?></label>
								</div>
								<div class="errormsg"></div>
							  </div>
						 </div>
						<div class="form-row form-group">
							  <div class="col-md-4">
								<label><?php echo lang('EmailPay') ?></label>
							  </div>
							  <div class="col-md-6">
								<div class="col-md-4">
									<label><?php echo $user_data['email']; ?></label>
								</div>
								<div class="errormsg"></div>
							  </div>
						 </div>
						<div class="form-row form-group">
							  <div class="col-md-4">
								<label><?php echo lang('AddressPay') ?></label>
							  </div>
							  <div class="col-md-6">
								<div class="col-md-4">
									<label><?php echo $user_data['address']; ?></label>
								</div>
								<div class="errormsg"></div>
							  </div>
						 </div>
						<div class="form-row form-group">
							  <div class="col-md-4">
								<label><?php echo lang('ContactNumber') ?></label>
							  </div>
							  <div class="col-md-6">
								<div class="col-md-4">
									<label><?php echo $user_data['contact_number']; ?></label>
								</div>
								<div class="errormsg"></div>
							  </div>
						 </div>
						 <div class="form-row form-group">
							  <div class="col-md-4">
								<label><?php echo lang('Arrival_Date') ?></label>
							  </div>
							  <div class="col-md-6">
								<div class="col-md-4">
									<label><?php echo $reservation_session['arrival_date']; ?></label>
								</div>
								<div class="errormsg"></div>
							  </div>
						 </div>
						 <div class="form-row form-group">
							  <div class="col-md-4">
								<label><?php echo lang('Leave_Date') ?></label>
							  </div>
							  <div class="col-md-6">
								<div class="col-md-4">
									<label><?php echo $reservation_session['leave_date']; ?></label>
								</div>
								<div class="errormsg"></div>
							  </div>
						 </div>						 
						<div class="form-row form-group">
							  <div class="col-md-4">
								<label><?php echo lang('Season') ?></label>
							  </div>
							  <div class="col-md-6">
								<div class="col-md-4">
									<label><?php echo $season_name[0]['season_name']; ?></label>
								</div>
								<div class="errormsg"></div>
							  </div>
						 </div>				 
						<div class="form-row form-group">
							  <div class="col-md-4">
								<label><?php echo lang('Bungalow_Name') ?></label>
							  </div>
							  <div class="col-md-8">
								<div class="col-md-10">
									<label><?php echo $reservation_session['bungalow_name']; ?></label>
								</div>
								<div class="errormsg"></div>
							  </div>
						 </div>
						 <div class="form-row form-group">
							  <div class="col-md-4">
								<label><?php echo lang('no_of_adult'); ?></label>
							  </div>
							  <div class="col-md-6">
								<div class="col-md-4">
									<label><?php echo $reservation_session['no_of_adult']; ?></label>
								</div>
								<div class="errormsg"></div>
							  </div>
						 </div>
						 <?php if($reservation_session['no_of_extra_real_adult'] != ""){ ?>
						 <div class="form-row form-group">
							  <div class="col-md-4">
								<label><?php echo lang('no_of_extra_real_adult'); ?></label>
							  </div>
							  <div class="col-md-6">
								<div class="col-md-4">
									<label><?php echo ($reservation_session['no_of_extra_real_adult'] != "") ? $reservation_session['no_of_extra_real_adult'] : "0"; ?></label>
								</div>
								<div class="errormsg"></div>
							  </div>
						 </div>
						 <?php } if($reservation_session['no_of_extra_adult'] != ""){ ?>
						 <div class="form-row form-group">
							  <div class="col-md-4">
								<label><?php echo lang('no_of_extra_adult'); ?></label>
							  </div>
							  <div class="col-md-6">
								<div class="col-md-4">
									<label><?php echo ($reservation_session['no_of_extra_adult'] != "") ?$reservation_session['no_of_extra_adult']:"0"; ?></label>
								</div>
								<div class="errormsg"></div>
							  </div>
						 </div>
						 <?php } if($reservation_session['no_of_extra_kid'] != ""){ ?>
						 <div class="form-row form-group">
							  <div class="col-md-4">
								<label><?php echo lang('no_of_extra_kid'); ?></label>
							  </div>
							  <div class="col-md-6">
								<div class="col-md-4">
									<label><?php echo ($reservation_session['no_of_extra_kid'] != "") ? $reservation_session["no_of_extra_kid"]:"0"; ?></label>
								</div>
								<div class="errormsg"></div>
							  </div>
						 </div>
						 <?php } if($reservation_session['no_of_folding_bed_kid'] != ""){ ?>
						 <div class="form-row form-group">
							  <div class="col-md-4">
								<label><?php echo lang('no_of_folding_bed_kid'); ?></label>
							  </div>
							  <div class="col-md-6">
								<div class="col-md-4">
									<label><?php echo ($reservation_session['no_of_folding_bed_kid'] != "") ? $reservation_session["no_of_folding_bed_kid"]:"0"; ?></label>
								</div>
								<div class="errormsg"></div>
							  </div>
						 </div>
						 <?php } if($reservation_session['no_of_folding_bed_adult'] != ""){ ?>
						 <div class="form-row form-group">
							  <div class="col-md-4">
								<label><?php echo lang('no_of_folding_bed_adult'); ?></label>
							  </div>
							  <div class="col-md-6">
								<div class="col-md-4">
									<label><?php echo ($reservation_session['no_of_folding_bed_adult'] != "") ?$reservation_session["no_of_folding_bed_adult"]:"0"; ?></label>
								</div>
								<div class="errormsg"></div>
							  </div>
						 </div>
						 <?php } if($reservation_session['no_of_baby_bed'] != ""){ ?>
						 <div class="form-row form-group">
							  <div class="col-md-4">
								<label><?php echo lang('no_of_baby_bed'); ?></label>
							  </div>
							  <div class="col-md-6">
								<div class="col-md-4">
									<label><?php echo ($reservation_session['no_of_baby_bed'] != "") ?$reservation_session['no_of_baby_bed']:"0"; ?></label>
								</div>
								<div class="errormsg"></div>
							  </div>
						 </div>
						 <?php } ?>
						 <div class="form-row form-group">
							  <div class="col-md-4">
								<label><?php echo lang('basic_stay'); ?></label>
							  </div>
							  <div class="col-md-6">
								<div class="col-md-4">
									<label><?php echo $default_currency['currency_symbol'].$reservation_session['stay_euro']; ?></label>
								</div>
								<div class="errormsg"></div>
							  </div>
						 </div>
						  <?php if($reservation_session['total'] != ""){ ?>
						 <div class="form-row form-group">
							  <div class="col-md-4">
								<label><?php echo lang('extra_price'); ?></label>
							  </div>
							  <div class="col-md-6">
								<div class="col-md-4">
									<label><?php echo $default_currency['currency_symbol'].$reservation_session['total']; ?></label>
								</div>
								<div class="errormsg"></div>
							  </div>
						 </div>
						 <?php } ?>
						 <div class="form-row form-group">
							  <div class="col-md-4">
								<label><?php echo lang('STAY_TAX'); ?></label>
							  </div>
							  <div class="col-md-6">
								<div class="col-md-4">
									<label>4%</label>
								</div>
								<div class="errormsg"></div>
							  </div>
						 </div>
						 <div class="form-row form-group">
							  <div class="col-md-4">
								<label><?php echo lang('total_price'); ?></label>
							  </div>
							  <div class="col-md-6">
								<div class="col-md-4">
									<label><?php echo $default_currency['currency_symbol'].$reservation_session['final_amount']; ?></label>
								</div>
								<div class="errormsg"></div>
							  </div>
						 </div>

						<!-- 
						<div class="form-row form-group">
							  <div class="col-md-2">
								<label><?php echo lang('Bungalow') ?> <?php echo lang('Rate') ?></label>
							  </div>
							  <div class="col-md-10">
								<div class="col-md-4">
									<label><?php echo $default_currency['currency_symbol'].$total; ?></label>
								</div>
								<div class="errormsg"></div>
							  </div>
						 </div>
						 <div class="form-row form-group">
							  <div class="col-md-2">
								<label>Options <?php echo lang('Rate') ?></label>
							  </div>
							  <div class="col-md-10">
								<?php 
								if(count($options_rate_arr)>0)
								{
									foreach($options_rate_arr as $options_rate)
									{
										?>
										<div class="col-md-4">
											<label><?php echo $options_rate['options_name']." : ".$default_currency['currency_symbol'].$options_rate['options_charges']; ?></label>
										</div>
										<?php 
									}
								}
								else
								{
									?>
									<div class="col-md-4">
										<label>N/A</label>
									</div>
									<?php 
								}
								?>
								<div class="errormsg"></div>
							  </div>
						 </div>
						 <div class="form-row form-group">
							  <div class="col-md-2">
								<label>
									<?php echo lang('Discount'); ?>
								</label>
							  </div>
							  <div class="col-md-10">
								<div class="col-md-4">
									<label><?php echo $discount_rate."%" ?></label>
								</div>
								<div class="errormsg"></div>
							  </div>
						 </div>
						<div class="form-row form-group">
							  <div class="col-md-2">
								<label><?php echo lang('Tax') ?> <?php echo lang('Rate') ?> </label>
							  </div>
							  <div class="col-md-10">
								<?php 
								if(count($tax_rate_arr)>0)
								{
									foreach($tax_rate_arr as $tax_rate)
									{
										?>
										<div class="col-md-4">
											<label><?php echo $tax_rate['tax_name']." (".$tax_rate['tax_rate']."%) : ".$default_currency['currency_symbol'].$tax_rate['tax_value']; ?></label>
										</div>
										<?php 
									}
								}
								else
								{
									?>
									<div class="col-md-4">
										<label>N/A</label>
									</div>
									<?php 
								}
								?>
								
								<div class="errormsg"></div>
							  </div>
						 </div>
						
						
						<div class="form-row form-group">
							  <div class="col-md-2">
								<label>
									Total
								</label>
							  </div>
							  <div class="col-md-10">
								<div class="col-md-4">
									<label><?php echo $default_currency['currency_symbol'].$total; ?></label>
								</div>
								<div class="errormsg"></div>
							  </div>
						 </div>-->
						
						
						<!--<div class="form-row form-group">
							<div class="col-md-2">
								<label><?php echo lang('Payment_Options'); ?> </label>
							</div>
							<div class="col-md-10">
								<div class="col-md-4">
									<label><input name="payment_type" type="radio" value="full" checked>&nbsp;<?php echo lang('Full_Payment') ?></label>
								</div>
								<div class="col-md-4">
									<label><input name="payment_type" type="radio" value="partial">&nbsp;<?php echo lang('Partial_Payment')." (".$partial_payment_rate."%)"; ?></label>
								</div>
								<div class="col-md-4">
									<label><input name="payment_type" type="radio" value="on_arrival">&nbsp;<?php echo lang('Payment_on_arrival') ?></label>
								</div>
								<div class="errormsg"></div>
							</div>
						</div>-->
						
						<!--<div class="form-row form-group">
							<div class="col-md-2">
								<label><?php echo lang('View_Price_In'); ?> </label>
							</div>
							<div class="col-md-10">
								<div class="col-md-4">
								<select name="currency_type" id="currency_type" class="login-input testi-input form-control input-md" onchange="show_dollar_price()">
									<option value="EURO" selected>EURO</option>
									<option value="DOLLAR">DOLLAR</option>
								</select>
								</div>
							</div>
						</div>-->
						
					<div class="form-row form-group">
						  <div class="col-md-4">
							<label>
								<?php echo lang('Comments'); ?>
							</label>
						  </div>
						  <div class="col-md-8">
							<div class="col-md-14">
								<textarea name="txt_comments" style="cursor:auto;height:200px;background:#C9AD64 none repeat scroll 0% 0% !important;border-radius:0px !important" id="txt_comments" class="login-input form-control input-md" rows="50" cols="50"></textarea>
							</div>
							<div class="errormsg"></div>
						  </div>
					 </div>
						<div class="form-row form-group">
							<div class="col-md-10">
								&nbsp;      
							 </div>
					   </div>
						<div class="form-row form-group">
							<div class="col-md-10">
								<div class="row">
									<div class="col-md-8">
										<div class="sub-btn">
											<input id="textinputback" name="payment_back" class="submit-button btn btn-default" type="button" value="<?php echo lang('CANCELLED'); ?>" onclick="cancelReservation();">
											<input id="textinput" name="payment_submit" class="submit-button btn btn-default" type="submit" value="<?php echo lang('Submit_payment'); ?>">
										</div>
									</div>
								  </div>       
							 </div>
					   </div>
					</fieldset>
				</form>
				
				<form id="price_in_dollar" style="display:none;" class="form-login form-horizontal" action="#" method="POST">
				<!-- Price Showing in dollar currency -->
				<fieldset>
					<div class="form-row form-group">
						  <div class="col-md-2">
							<label><?php echo lang('Arrival_Date') ?></label>
						  </div>
						  <div class="col-md-10">
							<div class="col-md-4">
								<label><?php echo $reservation_session['arrival_date']; ?></label>
							</div>
							<div class="errormsg"></div>
						  </div>
					 </div>
					 <div class="form-row form-group">
						  <div class="col-md-2">
							<label><?php echo lang('Leave_Date') ?></label>
						  </div>
						  <div class="col-md-10">
							<div class="col-md-4">
								<label><?php echo $reservation_session['leave_date']; ?></label>
							</div>
							<div class="errormsg"></div>
						  </div>
					 </div>
                                    <!--
					 <div class="form-row form-group">
						  <div class="col-md-2">
							<label><?php echo lang('Season') ?></label>
						  </div>
						  <div class="col-md-10">
							<div class="col-md-4">
								<label><?php echo $season_name[0]['season_name']; ?></label>
							</div>
							<div class="errormsg"></div>
						  </div>
					 </div>-->
					<div class="form-row form-group">
						  <div class="col-md-2">
							<label><?php echo lang('Bungalow') ?> <?php echo lang('Rate') ?></label>
						  </div>
						  <div class="col-md-10">
							<div class="col-md-4">
								<label><?php echo $dollar_currency.$payment_session['total_bungalow_rate_dollar']; ?></label>
							</div>
							<div class="errormsg"></div>
						  </div>
					 </div>
					 <div class="form-row form-group">
						  <div class="col-md-2">
							<label>Options <?php echo lang('Rate') ?></label>
						  </div>
						  <div class="col-md-10">
							<?php 
							if(count($options_rate_arr)>0)
							{
								foreach($options_rate_arr as $options_rate)
								{
									?>
									<div class="col-md-4">
										<label><?php echo $options_rate['options_name']." : ".$dollar_currency.$options_rate['options_charges_dollar']; ?></label>
									</div>
									<?php 
								}
							}
							else
							{
								?>
								<div class="col-md-4">
									<label>N/A</label>
								</div>
								<?php 
							}
							?>
							<div class="errormsg"></div>
						  </div>
					 </div>
					 <div class="form-row form-group">
						  <div class="col-md-2">
							<label>
								<?php echo lang('Discount'); ?>
							</label>
						  </div>
						  <div class="col-md-10">
							<div class="col-md-4">
								<label><?php echo $discount_rate."%" ?></label>
							</div>
							<div class="errormsg"></div>
						  </div>
					 </div>
					<div class="form-row form-group">
						  <div class="col-md-2">
							<label><?php echo lang('Tax') ?> <?php echo lang('Rate') ?> </label>
						  </div>
						  <div class="col-md-10">
							<?php 
							if(count($tax_rate_arr)>0)
							{
								foreach($tax_rate_arr as $tax_rate)
								{
									?>
									<div class="col-md-4">
										<label><?php echo $tax_rate['tax_name']." (".$tax_rate['tax_rate']."%) : ".$dollar_currency.$tax_rate['tax_value_dollar']; ?></label>
									</div>
									<?php 
								}
							}
							else
							{
								?>
								<div class="col-md-4">
									<label>N/A</label>
								</div>
								<?php 
							}
							?>
							
							<div class="errormsg"></div>
						  </div>
					 </div>
					
					
					<div class="form-row form-group">
						  <div class="col-md-2">
							<label>
								Total
							</label>
						  </div>
						  <div class="col-md-10">
							<div class="col-md-4">
								<label><?php echo $dollar_currency.$payment_session['total_charge_dollar']; ?></label>
							</div>
							<div class="errormsg"></div>
						  </div>
					 </div>

					
					<div class="form-row form-group">
						<div class="col-md-10">
							&nbsp;      
						 </div>
				   </div>
					<div class="form-row form-group">
						<div class="col-md-10">
							<div class="row">
								<div class="col-md-8">
									<div class="sub-btn">
										<input id="textinput" name="payment_submit" class="submit-button btn btn-default" type="button" value="<?php echo lang('Back'); ?>" onclick="show_euro_price()">
									</div>
								</div>
							  </div>       
						 </div>
				   </div>
				</fieldset>
				</form>
			</div>
		</div>
	</div>
 </div>
