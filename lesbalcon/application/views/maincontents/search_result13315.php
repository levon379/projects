<div class="row">
	<div class="inner-page-banner"> <img src="<?php echo base_url(); ?>assets/frontend/images/about-us-banner.jpg" alt=""></div>
</div>
<!--banner end-->
<div class="row innerpage-section">
	<div class="container">
		<h2><img src="<?php echo base_url() ?>assets/frontend/images/bracket-left.png" alt=""><?php echo lang('Search_Result'); ?><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-right.png" alt=""></h2>
		<div class="row inner-content">
				<?php
				if(count($search_result)>0)
				{
					foreach($search_result as $value)
					{
						?>
						<div class="col-xs-6 col-sm-4 col-md-4">
							<div class="property-holder">
							<div class="img-box">
								<?php 
								if($value['type']=="P")
								{
									?>
									<a href="<?php echo base_url(); ?>properties/<?php echo $value['slug']; ?>">
										<img src="<?php echo base_url(); ?>assets/upload/bunglow/thumb_large/<?php echo $value['image']; ?>" alt="" class="img-responsive">
									</a>
									<?php 
								}
								elseif($value['type']=="B")
								{
									?>
									<a href="<?php echo base_url(); ?>bungalows/<?php echo $value['slug']; ?>">
										<img src="<?php echo base_url(); ?>assets/upload/bunglow/thumb_large/<?php echo $value['image']; ?>" alt="" class="img-responsive">
									</a>	
									<?php 
								}
								?>
								
							</div>
							<div class="content-box">
							<div class="button">
							<p>
							<?php 
								if($value['type']=="P")
								{
									?>
									<a href="<?php echo base_url(); ?>properties/<?php echo $value['slug']; ?>"><?php echo lang('VIEW_DETAILS'); ?></a>
									<?php 
								}
								elseif($value['type']=="B")
								{
									?>
									<a href="<?php echo base_url(); ?>bungalows/<?php echo $value['slug']; ?>"><?php echo lang('VIEW_DETAILS'); ?></a>
									<?php
								}
							?>
							</p>
							</div>
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
							<?php
								if(isset($value['availability']))
								{
									if($value['availability']=="available")
									{
										?>
										<a><label><?php echo lang('AVAILABLE') ?></label></a>
										<?php 
									}
									elseif($value['availability']=="notavailable")
									{
										?>
										<a><label><?php echo lang('NOT_AVAILABLE') ?></label></a>
										<?php 
									}
									else
									{
										?>
										<a style="cursor:pointer;" data-popup-target="#example-popup<?php echo $value['id'] ?>"><label style="cursor:pointer;"><?php echo lang("PARTIAL_AVAILABLE"); ?></label></a>
										<div id="example-popup<?php echo $value['id'] ?>" class="popup">
											<div class="popup-body">	
											<span class="popup-exit"></span>
											<div class="popup-content">
												<h2 class="popup-title"><?php echo lang('Available_On') ?></h2>
												<label style="margin-top:5px;"><?php echo $value['availability']; ?></label>
											</div>
											</div>
										</div>
										<?php 
									}
								}
							?>
								
							</div>
							</div>
						</div>
						<?php 
					}
				}
				else 
				{
					?>
					<h2><?php echo lang('No_records_found'); ?></h2>
					<?php 
				}
			?>
		</div>
	</div>
</div>
<div class="popup-overlay" style="z-index:999;"></div>
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


  
  
  
  
  
  