<!-- Search For Mobile--->
<div class="row search-container">
    <div class="container">
      <div class="row">
        <form class="form-horizontal">
          <fieldset>
          <div class="col-xs-12">
            <label class="bunglowhd"><?php echo lang('Bungalow') ?> <span><?php echo lang('Search') ?></span></label>
          </div>
          <div class="col-xs-12">
			<input id="searchinput" name="searchinput" placeholder="Search" class="form-control input-md" type="search">
          </div>
          <div class="col-xs-12">
            <label class="checkin"><?php echo lang('Check_In') ?></label>
            <div class='input-group date' id='datetimepicker5'>
					<input type='text' class="form-control" readonly data-date-format="DD/MM/YYYY"/>
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
          </div>
          <div class="col-xs-12">
            <label class="checkin"><?php echo lang('Check_Out') ?></label>
            <div class='input-group date' id='datetimepicker6'>
					<input type='text' class="form-control" readonly data-date-format="DD/MM/YYYY"/>
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
          </div>
          <div class="col-xs-4 pull-right">
            <label class="control-label" for="singlebutton"></label>
            <button id="singlebutton" name="singlebutton" class="btn btn-primary btn-custom"><?php echo lang('Submit') ?></button>
          </div>
          </fieldset>
        </form>
      </div>
    </div>
 </div>
  <!-- Search For Mobile End--->
  <!--banner start-->
  <div class="row">
    <div data-ride="carousel" class="carousel slide" id="myCarousel">
      <!-- Indicators -->
	  <?php
	  if(count($banners_arr)>1)
	  {
			?>
			<ol class="carousel-indicators">
				<?php
				$i=0;
				foreach($banners_arr as $banner)
				{	
					?>
					<li data-slide-to="<?php echo $i; ?>" data-target="#myCarousel" <?php if($i==0){ echo 'class="active"'; } ?>></li>
					<?php 
					$i++;
				}
				?>
			  </ol>
			<?php 
	  }
	  ?>
      
      <div class="carousel-inner">
		<!-- Search For Desktop--->
        <div class="container banner-search">
          <div class="search-box">
            <form class="form-horizontal">
              <fieldset>
              <!-- Search input-->
              <div class="form-group">
                <!-- Form Name -->
                <div class="col-md-12">
                  <legend><?php echo lang('Bungalow') ?> <span><?php echo lang('Search') ?></span></legend>
                </div>
                <div class="col-md-12">
                  <input id="searchinput" name="searchinput" placeholder="<?php echo lang('Search') ?>" class="form-control input-md" type="search">
                </div>
                <div class="col-xs-6">
            <label class="checkin"><?php echo lang('Check_In') ?></label>
            <div class='input-group date' id='datetimepicker7'>
					<input type='text' class="form-control" readonly data-date-format="DD/MM/YYYY"/>
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
          </div>
         		<div class="col-xs-6">
            <label class="checkin"><?php echo lang('Check_Out') ?></label>
            <div class='input-group date' id='datetimepicker8'>
					<input type='text' class="form-control" readonly data-date-format="DD/MM/YYYY"/>
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
          </div>
                <!-- Button -->
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="col-md-4 control-label" for="singlebutton"></label>
                    <div class="col-md-12">
                      <button id="singlebutton" name="singlebutton" class="btn btn-primary btn-custom"><?php echo lang('Submit') ?></button>
                    </div>
                  </div>
                </div>
              </div>
              
              </fieldset>
            </form>
          </div>
        </div>
		<!-- Search For Desktop--->
		<!--Banners Slider Area -->
		<?php
		if(count($banners_arr)>0)
		{
			$i=1;
			foreach($banners_arr as $banner)
			{	
				?>
				<div class="item <?php if($i==1){ echo "active"; } ?>" > <img src="<?php echo base_url(); ?>assets/upload/banner/thumb/<?php echo $banner['banner_image'] ?>" alt="<?php echo $banner['banner_alt'] ?>">
				  <div class="container">
					<div class="carousel-caption">
					  <h1><?php echo $banner['banner_title'] ?></h1>
					  <p><?php echo $banner['banner_desc'] ?></p>
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
			<div class="item active" > <img src="<?php echo base_url(); ?>assets/upload/banner/thumb/no_banner.jpg" alt="">
			  <div class="container">
			  </div>
			</div>
			<?php
		}
		?>
		<!--Banners Slider Area End -->
      </div>
     </div>
  </div>
  <!--banner end-->
  <div class="row content-area">
    <div class="container">
      <h2><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-left.png" alt=""><?php echo lang('WELCOME_TO'); ?> <span>Les Balcons</span><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-right.png" alt=""></h2>
      <?php echo $welcome_text; ?>
    </div>
    <div class="content_anchor"><img src="<?php echo base_url(); ?>assets/frontend/images/anchore.png" alt=""></div>
  </div>
  <!-- Properties listing area -->
  <div class="row properties">
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
  </div>
  <!-- Properties listing area end -->
  
  <!-- Bungalow listing area -->
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
					<p class="caption"><?php echo $bung['caption'];?></p>
				  </div>
				</div>
			  </li>
			<?php 
			$x++;
			}
			?>
			</ul>
			<div class="booknow">
			  <p><a href="#"><?php echo lang('BOOK_NOW'); ?></a></p>
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
   <!-- Bungalow listing area end -->
  <div class="row testimonial">
    <div class="container">
      <h2><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-left.png" alt=""/><?php echo lang('TESTIMONIALS'); ?><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-right.png" alt=""></h2>
      <?php 
	  if(count($testimonial)>0)
	  {
			?>
			<div class="pic-section"> <img src="<?php echo base_url(); ?>assets/frontend/images/profile.png" alt=""/> </div>
			  <div class="testimonial-section">
				<p class="testi-text">
					<span class="f-22">
						<img src="<?php echo base_url(); ?>assets/frontend/images/qute.png" alt="" />
					</span>
						<?php echo $testimonial[0]['content']; ?>
					<span class="f-22">
						<img src="<?php echo base_url(); ?>assets/frontend/images/qute.png" alt="" />
					</span><br>
				  <br>
				  <span><?php echo lang('By'); ?>- <?php echo $testimonial[0]['user_name']; ?></span> 
				</p>
			  </div>
			<?php 
	  }
	  else 
	  {
			?>
			<div class="pic-section"> <img src="<?php echo base_url(); ?>assets/frontend/images/profile.png" alt=""/> </div>
			<div class="testimonial-section">
				<h2 ><?php echo lang('No_Testimonials_Found'); ?></h2>
			</div>
			<?php 
	  }
	  ?>
    </div>
  </div>
  <div class="row gallery">
    <div class="container">
      <h2 class="bunglow-heading"><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-2-left.png" alt=""><?php echo lang('GALLERY'); ?><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-2-right.png" alt=""></h2>
      <div class="row img-gallery">
			<?php 
			if(count($galleries)>0)
			{
				foreach($galleries as $gallery)
				{
					?>
					<a href="<?php echo base_url(); ?>assets/upload/gallery/thumb/<?php echo $gallery['image_file_name']; ?>" data-toggle="lightbox" data-gallery="multiimages" data-title="<?php echo $gallery['title']; ?>" class="col-sm-4 col-xs-6 gal-pic">
						<img src="<?php echo base_url(); ?>assets/upload/gallery/thumb/<?php echo $gallery['image_file_name']; ?>" class="img-responsive"> 
					</a>
					<?php 
				}
				?>
				<div class="viewmore">
					<p><a href="<?php echo base_url(); ?>gallery"><?php echo lang('View_More'); ?></a></p>
				</div>
				<?php 
			}
			else 
			{
				?>
				<h2 class="bunglow-heading"><?php echo lang('No_Gallery_Found'); ?></h2>
				<?php 
			}
			?>
      </div>
      
    </div>
  </div>
  <div class="row location">
    <div class="container">
      <div class="row">
        <div class="col-md-4 col-sm-4  col-xs-12">
          <div class="location-block">
            <div class="text-holder">
              <h3 class="small-heading"><?php echo lang('Location'); ?></h3>
              <p class="location-text"></p>
            </div>
            <div class="map-holder">
				<iframe src="http://maps.google.fr/maps/ms?hl=fr&ie=UTF8&msa=0&msid=205972261200026991781.000498c37c43f30ded1f2&t=h&ll=18.055294,-63.015647&spn=0.012118,0.012875&z=15&output=embed" width="244" height="272" frameborder="0" style="border:0"></iframe>
			</div>
          </div>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-12">
          <div class="bunglow-block">
            <div class="text-holder">
              <h3 class="small-heading"><?php echo lang('Bungalow_situation'); ?></h3>
              <p class="location-text"></p>
            </div>
            <div class="map-holder"><img src="<?php echo base_url(); ?>assets/frontend/images/footer-img.png" alt=""></div>
          </div>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-12">
          <div class="activities-block">
            <div class="text-holder">
              <h3 class="small-heading"><?php echo lang('Activities'); ?></h3>
              <p class="activities-text">Contrary to popular belief, Lorem Ipsum is not simply random text. </p>
              <p class="activities-text">Contrary to popular belief, Lorem Ipsum is not simply random text. </p>
              <p class="activities-text">Contrary to popular belief, Lorem Ipsum is not simply random text. </p>
              <p class="activities-text">Contrary to popular belief, Lorem Ipsum is not simply random text. </p>
              <p class="activities-text">Contrary to popular belief, Lorem Ipsum is not simply random text. </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>