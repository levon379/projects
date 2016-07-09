<div class="row">
	<div class="inner-page-banner"><img src="<?php echo base_url(); ?>assets/frontend/images/about-us-banner.jpg" alt=""></div>
</div>
<!--banner end-->
<div class="row innerpage-section">
	<div class="container">
		<h2><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-left.png" alt=""><?php echo lang('My_Mails'); ?><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-right.png" alt=""></h2>
		<div class="tabs-holder">
			<ul class="my_tab_menu">
				<li><a href="<?php echo base_url(); ?>user/my_profile"><?php echo lang('My_Profile'); ?></a></li>
				<li><a href="<?php echo base_url(); ?>user/my_booking"><?php echo lang('My_Bookings'); ?></a></li>
				<li><a class="active_user" href="<?php echo base_url(); ?>user/my_mails"><?php echo lang('My_Mails'); ?></a></li>
				<li><a href="<?php echo base_url(); ?>user/change_password"><?php echo lang('Change_Password'); ?></a></li>
				<li><a href="<?php echo base_url(); ?>user/logout"><?php echo lang('Logout'); ?></a></li>
			</ul>
		</div>
		<div class="row inner-content">
			<?php 
			if(isset($_GET['deleted']))
			{
				?>
				<div align="center" style="color:red;">
					<label><?php echo lang('Data_Deleted_Successfully'); ?></label>
				</div>	
				<?php 
			}
			?>
      		<div class="table-body">
				<div id="flip-scroll">
					<?php $current_lang_id= $this->session->userdata('current_lang_id'); ?>
					<table class="table table-bordered table-responsive">
						<thead>
							<tr>
								<th>Sl. No</th>
								<th><?php echo lang('Date'); ?></th>
								<th><?php echo lang('From'); ?></th>
								<th><?php echo lang('Subject'); ?></th>
								<th style="text-align:right">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							if(count($my_emails)>0)
							{
								$i=1;
								foreach($my_emails as $email)
								{
									?>
									<tr>
										<td><?php echo $i; ?></td>
										<td><?php echo date("d/m/Y H:i:s", strtotime($email['time'])); ?></td>
										<td class="numeric"><?php echo $email['sender_email']; ?></td>
										<td class="numeric"><?php echo $email['subject']; ?></td>
										<td align="right">
											<a style="cursor:pointer;" data-popup-target="#example-popup<?php echo $email['id'] ?>" title="<?php echo lang('View_Message'); ?>"><img src="<?php echo base_url(); ?>assets/frontend/images/view.png" alt=""></a>&nbsp; 
											<a onclick="return confirm('<?php echo lang('Are_you_sure_to_delete') ?>?')" href="<?php echo base_url(); ?>user/delete_mails/<?php echo $email['id'] ?>" title="<?php echo lang('Delete'); ?>"><img src="<?php echo base_url(); ?>assets/frontend/images/delete.png" alt=""></a>
										</td>
									</tr>
									<div id="example-popup<?php echo $email['id'] ?>" class="popup">
										<div class="popup-body">	
										<span class="popup-exit"></span>
										<div class="popup-content">
											<h2 class="popup-title">Message</h2>
											<label style="margin-top:5px;"><?php echo $email['message']; ?></label>
										</div>
										</div>
									</div>
									<?php 
									$i++;
								}
							}
							else
							{
								?>
								<tr>
									<td colspan="5"><?php echo lang("No_records_found"); ?></td>
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
<div class="popup-overlay" style="z-index:999;"></div><!-- transparent div for light box -->
<script type='text/javascript'>//<![CDATA[ 
$(window).load(function(){
jQuery(document).ready(function ($) {

    $('[data-popup-target]').click(function () {
        $('html').addClass('overlay');
        var activePopup = $(this).attr('data-popup-target');
        $(activePopup).addClass('visible');

    });

    $(document).keyup(function (e) {
        if (e.keyCode == 27 && $('html').hasClass('overlay')) {
            clearPopup();
        }
    });

    $('.popup-exit').click(function () {
        clearPopup();

    });

    $('.popup-overlay').click(function () {
        clearPopup();
    });

    function clearPopup() {
        $('.popup.visible').addClass('transitioning').removeClass('visible');
        $('html').removeClass('overlay');

        setTimeout(function () {
            $('.popup').removeClass('transitioning');
        }, 200);
    }

});
});//]]>  

</script>
