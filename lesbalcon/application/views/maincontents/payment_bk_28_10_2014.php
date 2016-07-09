<div class="row">
	<div class="inner-page-banner"> <img src="<?php echo base_url(); ?>assets/frontend/images/about-us-banner.jpg" alt=""></div>
</div>
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
								<label><?php echo lang('Payment_Options'); ?> </label>
							</div>
							<div class="col-md-10">
								<div class="col-md-3">
									<input name="payment_type" type="radio" value="full" checked>&nbsp;<?php echo lang('Full_Payment') ?>
								</div>
								<div class="col-md-4">
									<input name="payment_type" type="radio" value="partial">&nbsp;<?php echo lang('Partial_Payment')." (".$partial_payment_rate."%)"; ?>
								</div>
								<div class="col-md-4">
									<input name="payment_type" type="radio" value="on_arrival">&nbsp;<?php echo lang('Payment_on_arrival') ?>
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
