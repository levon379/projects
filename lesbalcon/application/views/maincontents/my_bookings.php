<div class="row">
	<div class="inner-page-banner"><img src="<?php echo base_url(); ?>assets/frontend/images/about-us-banner.jpg" alt=""></div>
</div>
<!--banner end-->
<div class="row innerpage-section">
	<div class="container">
		<h2><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-left.png" alt=""> My Bookings<img src="<?php echo base_url(); ?>assets/frontend/images/bracket-right.png" alt=""></h2>
		<div class="tabs-holder">
			<ul class="my_tab_menu">
				<li><a href="<?php echo base_url(); ?>user/my_profile"><?php echo lang('My_Profile'); ?></a></li>
				<li><a class="active_user" href="<?php echo base_url(); ?>user/my_booking"><?php echo lang('My_Bookings'); ?></a></li>
				<li><a href="<?php echo base_url(); ?>user/my_mails"><?php echo lang('My_Mails'); ?></a></li>
				<li><a href="<?php echo base_url(); ?>user/change_password"><?php echo lang('Change_Password'); ?></a></li>
				<li><a href="<?php echo base_url(); ?>user/logout"><?php echo lang('Logout'); ?></a></li>
			</ul>
		</div>
		<div class="row inner-content">
      		<div class="table-body">
				<div id="flip-scroll">
					<table class="table table-bordered table-responsive">
						<thead>
							<tr>
								<th>Sl. No</th>
								<th><?php echo lang('Bungalow_Property'); ?></th>
								<th><?php echo lang('Reservation_Date'); ?></th>
								<th><?php echo lang('Arrival_Date'); ?></th>
								<th><?php echo lang('Leave_Date'); ?></th>
								<th><?php echo lang('Reservation_Status'); ?></th>
								<th><?php echo lang('Payment_Status'); ?></th>
								<th>Action</th>
							</tr>
						</thead>

						<tbody>
							<?php 
							$sl_no=1;
							if(count($all_rows)>0)
							{
								foreach($all_rows as $rows)
								{
									?>
									<tr>
										<td><?php echo $sl_no; ?></td>
										<td><?php echo $rows['bunglow_name']; ?></td>
										<td><?php echo date("d/m/Y H:i:s", strtotime($rows['reservation_date'])); ?></td>
										<td><?php echo date("d/m/Y", strtotime($rows['arrival_date'])); ?></td>
										<td><?php echo date("d/m/Y", strtotime($rows['leave_date'])); ?></td>
										<td><?php echo lang($rows['reservation_status']); ?></td>
										<td><?php echo lang($rows['payment_status']); ?></td>
										<td>
											<a href="<?php echo base_url(); ?>user/booking_details/<?php echo $rows['id']; ?>" title="<?php echo lang('View_Details'); ?>"><img src="<?php echo base_url(); ?>assets/frontend/images/view.png" alt=""></a>&nbsp; 
										</td>
									</tr>
									<?php 
									$sl_no++;
								}
							}
							else 
							{
								?>
								<tr>
									<td colspan="8" align="center">
										<?php echo lang("No_records_found"); ?>
									</td>
								</tr>
								<?php 
							}
							?>
						</tbody>
					</table>
				</div>
            </div>
		</div>
		<div class="row">
			<div class="pagination-block">
				<?php echo $pagination_link; ?>
			</div>
		</div>
	</div>
 </div>
