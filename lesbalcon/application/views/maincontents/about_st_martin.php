<div class="row">
	<div class="inner-page-banner"> 
		<img class="img-responsive" src="<?php echo base_url(); ?>assets/upload/page_banner/thumb/<?php echo $page_content[0]['page_banner']; ?>" alt="">
	</div>
</div>
<!--banner end-->
<div class="row innerpage-section">

	<div class="container">
    	<div class="col-md-12">
		<h2><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-left.png" alt=""><?php echo $page_content[0]['pages_title']; ?><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-right.png" alt=""></h2>
		<div class="row inner-content custom_font">
      		<?php echo $page_content[0]['pages_content']; ?>
		</div>
        </div>
	</div>
    
 </div>
 
 <div class="row bunglow">
    <div class="container">
      <div class="bunglow-gallery">
        <h2 class="bunglow-heading"><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-2-left.png" alt=""><?php echo lang('Bungalow'); ?><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-2-right.png" alt=""></h2>
		<?php 
		if(count($bungalow)>0)
		{
			?>
			<ul class="popup-gallery">
			<?php 
			$x=1;
			$z=1;
			foreach($bungalow as $bung)
			{
			?>
			  <li <?php if($x==$z){ echo "class='first'"; $z+=5;} ?> >
				<div class="popbox">
				  <div class="img-holder"><img src="<?php echo base_url(); ?>assets/upload/bunglow/thumb/<?php echo $bung['image']; ?>" alt="">
					<div class="mask">
					  <h2><?php echo substr(strip_tags($bung['bunglow_name']), 0, 25); if(strlen($bung['bunglow_name'])>25){ echo "..."; } ?></h2>
					  <a href="<?php echo base_url(); ?>bungalows/<?php echo $bung['slug'] ?>" class="info"><?php echo lang('Get_Details') ?></a> </div>
				  </div>
				  <div class="caption-text">
					<p class="caption">
					<?php if(strlen($bung['caption'])>40){ echo substr($bung['caption'], 0, 30)."..."; }else{ echo $bung['caption']; }?>
					</p>
				  </div>
				</div>
			  </li>
			<?php 
			$x++;
			}
			?>
			</ul>
			<div class="booknow">
			  <p><a href="<?php echo base_url(); ?>reservation"><?php echo lang('BOOK_NOW'); ?></a></p>
			</div>
			<?php 	
		}
		else 
		{
			?>
			<h2 class="bunglow-heading"><?php echo lang('No_Bungalow_Found'); ?></h2>
			<?php 
		}
		?>
      </div>
    </div>
  </div>
 
 
 <!--<div class="row properties">
    <div class="container">
      <h2><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-left.png" alt=""><?php echo lang('Properties'); ?><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-right.png" alt=""></h2>
	  <?php
	  if(count($property)>0)
	  {
			foreach($property as $pro)
			{
				?>
				<div class="col-md-6 col-sm-6 col-xs-6">
					<div class="property_box">
					  <div class="property_box_left"><img src="<?php echo base_url(); ?>assets/upload/bunglow/thumb_medium/<?php echo $pro['image']; ?>" alt=""></div>
					  <p class="property-title"><?php echo substr($pro['bunglow_name'], 0, 25); if(strlen($pro['bunglow_name'])>25){ echo "..."; } ?></p>
					  <?php echo substr(strip_tags($pro['bunglow_overview']), 0, 100); if(strlen($pro['bunglow_overview'])>100){ echo "..."; } ?>
					  <div class="readmore"><a href="<?php echo base_url(); ?>properties/<?php echo $pro['slug'] ?>"><img src="<?php echo base_url(); ?>assets/frontend/images/more-img.jpg" alt=""/></a></div>
					</div>
				  </div>
				<?php 
			}
	  }
	  else 
	  {
			echo "<h2>".lang('No_Properties_Found')."</h2>";
	  }
	  ?>
    </div>
  </div>-->
 