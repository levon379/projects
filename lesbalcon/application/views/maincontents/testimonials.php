<div class="row">
	<div class="inner-page-banner"> <img class="img-responsive" src="<?php echo base_url(); ?>assets/frontend/images/about-us-banner.jpg" alt=""></div>
</div>
<!--banner end-->
<div class="row innerpage-section">
	<div class="container">
		<h2><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-left.png" alt=""><?php echo lang('TESTIMONIALS'); ?><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-right.png" alt=""></h2>
		<div class="row inner-content">
      		<div class="col-md-12">
				<?php 
				if(count($testimonials_arr)>0)
				{
					foreach($testimonials_arr as $testimonials)
					{
						?>
						<div class="testimonial-row">
							<div class="testimonial-content">
								<div class="testimonial-holder">
								<p>
									<span class="f-22"><img alt="" src="<?php echo base_url(); ?>assets/frontend/images/qute.png"></span> 
									<?php echo $testimonials['content']; ?>
									<span class="f-22"><img alt="" src="<?php echo base_url(); ?>assets/frontend/images/qute.png"></span>
								</p>
								</div>
								<div class="triangle"><img src="<?php echo base_url(); ?>assets/frontend/images/triangle.png"alt=""></div>
								<div class="name-text"><p>~ <em><?php echo $testimonials['user_name']; ?></em><!--<br />simply dummy text of the printing--></p></div>
							</div>	
						</div>
						<?php 
					}
				}
				else
				{
					?>
					<div class="testimonial-row">
						<div class="testimonial-content">
							<div class="testimonial-holder">
								<p>
									<h2 style="text-align:center;"><span><?php echo lang('No_Testimonials_Found'); ?></span></h2>
								</p>
							</div>
						</div>
					</div>
					<?php 
				}
				?>
            </div>
		</div>
		<div class="row">
			<div class="pagination-block">
				<?php echo $pagination_link; ?>
			</div>
		</div>
	</div>
 </div>
