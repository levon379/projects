<div class="row">
	<div class="inner-page-banner"> <img src="<?php echo base_url(); ?>assets/frontend/images/about-us-banner.jpg" alt=""></div>
</div>
<!--banner end-->
<div class="row innerpage-section">
	<div class="container">
		<h2><img src="<?php echo base_url() ?>assets/frontend/images/bracket-left.png" alt=""><?php echo lang('property_listing'); ?><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-right.png" alt=""></h2>
		<div class="row inner-content">
			<?php
				if(count($properties)>0)
				{
					foreach($properties as $value)
					{
						?>
						<div class="col-xs-6 col-sm-4 col-md-4">
							<div class="property-holder">
							<div class="img-box"><a href="<?php echo base_url(); ?>properties/<?php echo $value['slug']; ?>"><img src="<?php echo base_url(); ?>assets/upload/bunglow/thumb_large/<?php echo $value['image']; ?>" alt="" class="img-responsive"></a></div>
							<div class="content-box">
							<div class="button"><p><a href="<?php echo base_url(); ?>properties/<?php echo $value['slug']; ?>"><?php echo lang('VIEW_DETAILS'); ?></a></p></div>
							<h5><?php if(strlen($value['bunglow_name'])>70){ echo substr($value['bunglow_name'], 0, 70)."...";  }else{ echo $value['bunglow_name']; } ?></h5>
							<p>
								<?php echo substr(strip_tags($value['bunglow_overview']),0, 80); ?>
								<?php
								if(strlen(strip_tags($value['bunglow_overview']))>80)
								{
									echo "...";
								}
								?>
							</p>
							</div>
							</div>
						</div>
						<?php 
					}
				}
				else 
				{
					?>
					<h2><?php echo lang('No_Properties_Found'); ?></h2>
					<?php 
				}
			?>
      </div>
	  <?php 
	  if(count($properties)>0)
	  {
		?>
		<div class="row">
			<div class="pagination-block">
				<?php echo $pagination_link; ?>
			</div>
		</div>
			
		<?php 
	  }
	  ?>
	</div>
</div>

  
  
  
  
  
  