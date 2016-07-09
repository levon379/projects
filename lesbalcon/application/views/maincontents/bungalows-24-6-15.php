<div class="row">
	<div class="inner-page-banner"> <img src="<?php echo base_url(); ?>assets/frontend/images/about-us-banner.jpg" alt=""></div>
</div>
<!--banner end-->
<div class="row innerpage-section">
	<div class="container">
		<h2><img class="img-responsive" src="<?php echo base_url() ?>assets/frontend/images/bracket-left.png" alt=""><?php echo lang('bungalow_listing'); ?><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-right.png" alt=""></h2>
		<div class="row inner-content">
			<?php
				if(count($bungalows)>0)
				{
					foreach($bungalows as $value)
					{
						?>
						<div class="col-xs-6 col-sm-4 col-md-4">
							<div class="property-holder newblok">
							<div class="img-box"><a href="<?php echo base_url(); ?>bungalows/<?php echo $value['slug']; ?>"><img src="<?php echo base_url(); ?>assets/upload/bunglow/thumb_large/<?php echo $value['image']; ?>" alt="" class="img-responsive"></a></div>
							<div class="content-box">
							<div class="view-details"><a href="<?php echo base_url(); ?>bungalows/<?php echo $value['slug']; ?>"><?php echo lang('VIEW_DETAILS'); ?></a></div>
							<div class="book-now"><a href="<?php echo base_url(); ?>reservation/<?php echo $value['slug']; ?>"><?php echo lang('BOOK_NOW'); ?></a></div>
							
							<?php /*?><div class="button"><p><a href="<?php echo base_url(); ?>bungalows/<?php echo $value['slug']; ?>"><?php echo lang('VIEW_DETAILS'); ?></a></p></div><?php */?>
							<h5><?php if(strlen($value['bunglow_name'])>70){ echo substr($value['bunglow_name'], 0, 90);  }else{ echo $value['bunglow_name']; } ?></h5>
							<div class="proprty_ttl">
								<?php/*  echo substr(strip_tags($value['bunglow_overview']),0, 70); ?>
								<?php
								if(strlen(strip_tags($value['bunglow_overview']))>80)
								{
									echo "...";
								} */
								?>
							</div>
							<div class="persons" style="word-wrap: break-word; width: 200px;text-align:center;">
							<?php
							echo $value['max_person'];
							if($value['max_person']==1)
							{
							echo "&nbsp;".lang("PERSON")."<br/>".lang("PERSON1");
							}
							else
							{
							echo "&nbsp;".lang("PERSONS")."<br/>".lang("PERSONS1");
							}
							?>
							</div>
							<div class="price" style="word-wrap: break-word; width: 83px;text-align:center;"><?php echo lang('FROM')." ".$value["rate_per_week_euro"]." Euros/".lang('WEEK'); ?></div>
							</div>
							</div>
						</div>
						<?php 
					}
				}
				else 
				{
					?>
					<h2><?php echo lang('No_Bungalow_Found'); ?></h2>
					<?php 
				}
			?>
      </div>
	  <?php 
	  /*if(count($bungalows)>0)
	  {
		?>
		<div class="row">
			<div class="pagination-block">
				<?php echo $pagination_link; ?>
			</div>
		</div>
			
		<?php 
	  }*/
	  ?>
	</div>
</div>

  
  
  
  
  
  