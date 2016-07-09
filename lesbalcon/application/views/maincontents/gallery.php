<div class="row">
	<div class="inner-page-banner"> <img class="img-responsive" src="<?php echo base_url(); ?>assets/frontend/images/about-us-banner.jpg" alt=""></div>
</div>
<!--banner end-->
<div class="row gallerypage-section">
	<div class="container">
		<h2 class="bunglow-heading"><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-2-left.png" alt=""><?php echo lang('GALLERY') ?><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-2-right.png" alt=""></h2>
		<div class="row topgap">
			<?php
			if(count($gallery)>0)
			{
				foreach($gallery as $array)
				{
					?>
					<a href="<?php echo base_url(); ?>assets/upload/gallery/<?php echo $array['image_file_name'] ?>" data-toggle="lightbox" data-gallery="multiimages" data-title="<?php echo $array['title'] ?>" class="col-sm-4 col-xs-6 gal-pic gap">
						<img src="<?php echo base_url(); ?>assets/upload/gallery/thumb/<?php echo $array['image_file_name'] ?>" class="img-responsive"> 
					</a>
					<?php 
				}
			}
			else 
			{
				?>
				<h2 class="bunglow-heading"><?php echo lang('No_Gallery_Found'); ?></h2>
				<?php 
			}
			?>
        </div>  
		<div class="row">
			<div class="pagination-block">
				<?php echo $pagination_link; ?>
			</div>
		</div>
    </div>
</div>