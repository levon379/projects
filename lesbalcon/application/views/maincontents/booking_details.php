<div class="row">
	<div class="inner-page-banner"><img src="<?php echo base_url(); ?>assets/frontend/images/about-us-banner.jpg" alt=""></div>
</div>
<!--banner end-->
<div class="row innerpage-section">
	<div class="container">
		<h2><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-left.png" alt=""><?php echo lang('My_Bookings'); ?><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-right.png" alt=""></h2>
		<div class="tabs-holder">
			<ul class="my_tab_menu">
				<li><a href="<?php echo base_url(); ?>user/my_profile"><?php echo lang('My_Profile'); ?></a></li>
				<li><a href="<?php echo base_url(); ?>user/my_booking"><?php echo lang('My_Bookings'); ?></a></li>
				<li><a href="<?php echo base_url(); ?>user/my_mails"><?php echo lang('My_Mails'); ?></a></li>
				<li><a href="<?php echo base_url(); ?>user/change_password"><?php echo lang('Change_Password'); ?></a></li>
				<li><a href="<?php echo base_url(); ?>user/logout"><?php echo lang('Logout'); ?></a></li>
			</ul>
		</div>
		<div class="row inner-content" id="my_profile_div">
            <div class="login_block">
				<form class="form-login form-horizontal" action="" onsubmit="return check_register_form()" method="POST">
                    <fieldset>
						<div class="form-row form-group">
						  <div class="col-md-4">
						  <label><?php echo lang('Invoice_Number'); ?></label>
						  </div>
						  <div class="col-md-8">
							<?php echo $payment_details['invoice_number'] ?>
							<div class="errormsg"></div>
						  </div>
						</div>

						<!-- Text input-->
						<div class="form-row form-group">
						  <div class="col-md-4">
						  <label><?php echo lang('User_Name'); ?></label>
						  </div>
						  <div class="col-md-8">
							<?php echo $payment_details['user_name'] ?>
							<div class="errormsg"></div>
						  </div>
						</div>
						
						 <!-- Text input-->
						<div class="form-row form-group">
						  <div class="col-md-4">
						  <label><?php echo lang('User_Email'); ?></label>
						  </div>
						  <div class="col-md-8">
							<?php echo $payment_details['user_email'] ?>
							<div class="errormsg"></div>
						  </div>
						</div>

						<div class="form-row form-group">
						  <div class="col-md-4">
						  <label><?php echo lang('Bungalow_Under_Booking'); ?></label>
						  </div>
						  <div class="col-md-8">
							<?php echo $payment_details['bunglow_under_booking'] ?>
						   <div class="errormsg"></div>
						  </div>
						</div>
                    
						<div class="form-row form-group">
						  <div class="col-md-4">
						  <label><?php echo lang('Bungalow_Name'); ?></label>
						  </div>
						  <div class="col-md-8">
						   <?php echo $payment_details['bungalow_name']; ?>
						   <div class="errormsg"></div>
						  </div>
						</div>
						
						<div class="form-row form-group">
						  <div class="col-md-4">
						  <label><?php echo lang('Arrival_Date'); ?></label>
						  </div>
						  <div class="col-md-8">
						   <?php echo date("d/m/Y", strtotime($payment_details['arrival_date'])); ?>
						   <div class="errormsg"></div>
						  </div>
						</div>
						
						<div class="form-row form-group">
						  <div class="col-md-4">
						  <label><?php echo lang('Leave_Date'); ?></label>
						  </div>
						  <div class="col-md-8">
						   <?php echo date("d/m/Y", strtotime($payment_details['leave_date'])); ?>
						   <div class="errormsg"></div>
						  </div>
						</div>
						
						<div class="form-row form-group">
						  <div class="col-md-4">
						  <label><?php echo lang('Accommodation'); ?></label>
						  </div>
						  <div class="col-md-8">
						   <?php echo $payment_details['accommodation']; ?>
						   <div class="errormsg"></div>
						  </div>
						</div>
						
						<div class="form-row form-group">
						  <div class="col-md-4">
						  <label><?php echo lang('Bungalow_Rate'); ?></label>
						  </div>
						  <div class="col-md-8">
						   <?php echo $payment_details['bungalow_rate'] ?>
						   <div class="errormsg"></div>
						  </div>
						</div>
						
						<!--<div class="form-row form-group">
						  <div class="col-md-4">
						  <label>Options</label>
						  </div>
						  <div class="col-md-8">
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
						   <div class="errormsg"></div>
						  </div>
						</div>-->
						<?php if($payment_details['options_rate'] > 0){ ?>
						 <div class="form-row form-group">
							  <div class="col-md-4">
								<label>Price of extra person</label>
							  </div>
							  <div class="col-md-8">
									<label><?php echo $default_currency['currency_symbol'].$payment_details['options_rate']; ?></label>
								<div class="errormsg"></div>
							  </div>
						 </div>
						<?php } ?>
						<div class="form-row form-group">
						  <div class="col-md-4">
						  <label><?php echo lang('Discount'); ?></label>
						  </div>
						  <div class="col-md-8">
						   <?php echo $payment_details['discount']."%" ?>
						   <div class="errormsg"></div>
						  </div>
						</div>

						<div class="form-row form-group">
						  <div class="col-md-4">
						  <label><?php echo lang('Tax'); ?></label>
						  </div>
						  <div class="col-md-8">
						  	<label>4%</label>
						   <div class="errormsg"></div>
						  </div>
						</div>
						
						<div class="form-row form-group">
						  <div class="col-md-4">
						  <label><?php echo lang('Payment_Mode'); ?></label>
						  </div>
						  <div class="col-md-8">
						   <?php 
								if( $payment_details['payment_mode']=="ONARRIVAL")
								{
									echo lang('ON_ARRIVAL');
								}
								else 
								{
									echo lang($payment_details['payment_mode']);
								}
								?>
						   <div class="errormsg"></div>
						  </div>
						</div>
						
						<div class="form-row form-group">
						  <div class="col-md-4">
						  <label>Total</label>
						  </div>
						  <div class="col-md-8">
						   <?php echo $payment_details['total']; ?>
						   <div class="errormsg"></div>
						  </div>
						</div>
						
						<?php 
						if($payment_details['payment_mode']=="FULL")
						{
							?>
							<div class="form-row form-group">
							  <div class="col-md-4">
							  <label><?php echo lang('Paid_Amount'); ?></label>
							  </div>
							  <div class="col-md-8">
							   <?php echo $payment_details['paid_amount']; ?>
							   <div class="errormsg"></div>
							  </div>
							</div>
							<?php 
						}
						elseif($payment_details['payment_mode']=="PARTIAL")
						{
							?>
							<div class="form-row form-group">
							  <div class="col-md-4">
							  <label><?php echo lang('Paid_Amount'); ?></label>
							  </div>
							  <div class="col-md-8">
							   <?php echo $payment_details['paid_amount']; ?>
							   <div class="errormsg"></div>
							  </div>
							</div>
							<div class="form-row form-group">
							  <div class="col-md-4">
							  <label><?php echo lang('Due_Amount'); ?></label>
							  </div>
							  <div class="col-md-8">
							   <?php echo $payment_details['due_amount']; ?>
							   <div class="errormsg"></div>
							  </div>
							</div>
							<?php 
						}
						elseif($payment_details['payment_mode']=="ONARRIVAL")
						{
							?>
							<div class="form-row form-group">
							  <div class="col-md-4">
							  <label><?php echo lang('Due_Amount'); ?></label>
							  </div>
							  <div class="col-md-8">
							   <?php echo $payment_details['due_amount']; ?>
							   <div class="errormsg"></div>
							  </div>
							</div>
							<?php 
						}
						?>
						
						<div class="form-row form-group">
						  <div class="col-md-4">
						  <label><?php echo lang('Payment_Status'); ?></label>
						  </div>
						  <div class="col-md-8">
						   <?php echo lang($payment_details['payment_status']); ?>
						   <div class="errormsg"></div>
						  </div>
						</div>
						
						<div class="form-row form-group">
						  <div class="col-md-4">
						  <label><?php echo lang('Reservation_Status'); ?></label>
						  </div>
						  <div class="col-md-8">
						   <?php echo lang($payment_details['reservation_status']); ?>
						   <div class="errormsg"></div>
						  </div>
						</div>
						
						<div class="form-row form-group">
						  <div class="col-md-4">
						  <label><?php echo lang('More_Contact'); ?></label>
						  </div>
						  <div class="col-md-8">
						   <?php echo $payment_details['more_phone'] ?>
						   <div class="errormsg"></div>
						  </div>
						</div>
						
						<div class="form-row form-group">
						  <div class="col-md-4">
						  <label><?php echo lang('More_Email'); ?></label>
						  </div>
						  <div class="col-md-8">
						   <?php echo $payment_details['more_email'] ?>
						   <div class="errormsg"></div>
						  </div>
						</div>
						<div class="form-row form-group">
						  <div class="col-md-12" >
							 <input id="textinput" class="submit-button btn btn-default" type="button" style="float:right" value="<?php echo lang("Back"); ?>" onclick="location.href='<?php echo base_url(); ?>user/my_booking'">
						  </div>
						</div>
                    </fieldset>
				</form>
			</div>
        </div>
	</div>
 </div>
