<div class="row">
	<div class="inner-page-banner"> <img src="<?php echo base_url(); ?>assets/frontend/images/about-us-banner.jpg" alt=""></div>
</div>
<?php 
//echo "<pre>";
//print_r($this->session->userdata("payment"));
$reservation_session=$this->session->userdata("reservation");
?>
<!--banner end-->
<div class="row innerpage-section">
	<div class="container">
		<h2><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-left.png" alt=""><?php echo lang('CHOOSE_PAYMENT_TYPE'); ?><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-right.png" alt=""></h2>
		<div class="row inner-content">
			<div class="reservation_block">
				<form id="reservation_form" class="form-login form-horizontal" action="<?php echo base_url(); ?>reservation/payment_process" method="POST">
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
						 </div>
						<div class="form-row form-group">
							  <div class="col-md-2">
								<label><?php echo lang('Bungalow') ?> <?php echo lang('Rate') ?></label>
							  </div>
							  <div class="col-md-10">
								<div class="col-md-4">
									<label><?php echo $default_currency['currency_symbol'].$bungalow_rate; ?></label>
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
						 </div>
						
						
						<div class="form-row form-group">
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
											<input id="textinput" name="payment_submit" class="submit-button btn btn-default" type="submit" value="<?php echo lang('Submit'); ?>">
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
