<div class="row">
	<div class="inner-page-banner"><img src="<?php echo base_url(); ?>assets/frontend/images/about-us-banner.jpg" alt=""></div>
</div>
<script>
function validate_testimonials_form()
{
	if($("#test_name").val().trim()=="")
	{
		$("#test_name").focus();
		return false;
	}
	else if($("#test_email").val().trim()=="")
	{
		$("#test_email").focus();
		return false;
	}
	else if($("#test_email").val().trim()!="")
	{
		var email=$("#test_email").val();
		var reg = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
		if (!reg.test(email)) 
		{	
			alert("<?php echo lang('Please_enter_valid_email_address') ?>");
			$("#test_email").focus();
			return false;
		}
	}
	if($("#test_comment").val().trim()=="")
	{
		$("#test_comment").focus();
		return false;
	}
}
</script>
<!--banner end-->
<div class="row gallerypage-section">
	<div class="container">
		<h2 class="bunglow-heading-inner"><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-2-left.png" alt=""/><?php echo $properties_details[0]['bunglow_name']; ?><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-2-right.png" alt=""></h2>
		<div class="row topgap">
			<div class="col-md-12">
				<ul id="tabs" class="nav nav-tabs custom-tabs" data-tabs="tabs">
					<li class="active"><a href="#red" data-toggle="tab"><?php echo lang('OVERVIEW'); ?></a></li>
					<li><a href="#orange" data-toggle="tab"><?php echo lang('RATES'); ?></a></li>
				</ul>
				<div id="my-tab-content" class="tab-content">
					<div class="tab-pane active" id="red">
						<?php echo $properties_details[0]['bunglow_overview']; ?>
					</div>
					<div class="tab-pane" id="orange">
						<?php 
						if(count($properties_rates)>0)
						{
							foreach($properties_rates as $properties)
							{
								?>
								<h3><?php echo $properties['season_name'] ?></h3>
								<p>
									<?php
									if($default_currency['currency_id']==1)//$default_currency has been fetched globally in public_init_elements library 
									{
										echo $default_currency['currency_symbol']." ".$properties['rate_per_day_dollar'];
									}
									if($default_currency['currency_id']==2)
									{
										echo $default_currency['currency_symbol']." ".$properties['rate_per_day_euro'];
									}
									?>
								</p>
								<?php 
							}	
						}
						else 
						{
							echo lang('No_Rates_Found');
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
 
<div class="row main-bg">
	<div class="col-xs-12 col-sm-12 col-md-8 left-panel">
		<div class="col-xs-12 col-sm-12 col-md-11 pull-right">      
			<h2><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-left.png" alt=""/><?php echo lang('TESTIMONIALS'); ?><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-right.png" alt=""></h2>
            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
				<div class="carousel-inner">
				<?php 
				if(count($testimonials)>0)
				{
					$i=0;
					foreach($testimonials as $value)
					{
						?>
						<div class="cap item <?php if($i==0){ echo "active"; } ?>">
						  <div class="custom-cap carousel-caption">
							 <p align="center"><img src="<?php echo base_url(); ?>assets/frontend/images/profile.png" alt=""/></p>
							 <p class="captionstyle"><span><?php echo $value['content']; ?></span></p>
							 <p class="name">By- <?php echo $value['user_name']; ?></p>
						  </div>
						</div>
						<?php 
						$i++;
					}
				}
				else 
				{
					?>
					<div class="cap item active">
					  <div class="custom-cap carousel-caption">
						 <p align="center"><img src="<?php echo base_url(); ?>assets/frontend/images/profile.png" alt=""/></p>
						 <h2 style="text-align:center;"><span><?php echo lang('No_records_found'); ?></span></h2>
					  </div>
					</div>
					<?php 
				}
				?>
				</div>
				<?php 
				//If testimonials will be more than one the slide controller will be shown
				if(count($testimonials)>1)
				{
					?>
					<!-- Controls -->
					<a class="prev custom-control carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">prev</a>
					<a class="next custom-control carousel-control" href="#carousel-example-generic" role="button" data-slide="next">next</a>
					<?php 
				}
				?>
			</div>
		</div>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-4 right-panel">
		<div class="col-xs-12 col-sm-12 col-md-10 pull-left">
			<div class="row testimonial-form">
				<h4><?php echo lang('Testimonial_Post'); ?></h4>
				<form class="form-testimonial form-horizontal" action="" method="POST" onsubmit="return validate_testimonials_form()">
					<fieldset>
						<!-- Text input-->
						<input id="bungalow_id" name="bungalow_id" value="<?php echo $properties_details[0]['bunglow_id']; ?>" class="testi-input form-control input-md" type="hidden">
						<div class="form-row form-group">
						  <div class="col-md-12">
						  <input id="test_name" name="test_name" placeholder="<?php echo lang('Name'); ?>" class="testi-input form-control input-md" type="text">
						  </div>
						</div>
						<!-- Text input-->
						<div class="form-row form-group">
						  <div class="col-md-12">
						  <input id="test_email" name="test_email" placeholder="<?php echo lang('Email'); ?>" class="testi-input form-control input-md" type="text">
						  </div>
						</div>
						<!-- Textarea -->
						<div class="form-row form-group">
						  <div class="col-md-12">                     
							<textarea name="test_comment" id="test_comment" class="testi-textarea form-control" placeholder="<?php echo lang('Description'); ?>"></textarea>
						  </div>
						</div>
						<!-- Button -->
						<div class="form-row form-group">
						  <div class="col-md-4">
							<input type="submit" id="singlebutton" name="save_testimonials" class="submit-button btn btn-default" value="<?php echo lang('Post'); ?>">
						  </div>
						</div>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
</div>
  
<div class="row galbg">
	<div class="container">
		<h2 class="bunglow-heading"><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-2-left.png" alt=""><?php echo lang('GALLERY'); ?><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-2-right.png" alt=""></h2>
		<div class="row gallery-row">
			<div class="col-md-7">
				<div id="carousel-example-generic-1" class="carousel slide" data-ride="carousel">
					<!-- Wrapper for slides -->
					<div class="carousel-inner">
						<?php 
						$i=0;
						foreach($properties_images as $images)
						{
							?>
							<div class="item <?php if($i==0){ echo "active"; } ?>">
								<img src="<?php echo base_url(); ?>assets/upload/bunglow/thumb_big/<?php echo $images['image'] ?>" alt="">
							</div>	
							<?php 
							$i++;
						}
						?>
					</div>
					<!-- Controls -->
					<?php
					//If images will be more than one the slide controller will be shown
					if(count($properties_images)>1)
					{	
						?>
						<a class="icon-left btn-control carousel-control" href="#carousel-example-generic-1" role="button" data-slide="prev">
							prev
						</a>
						<a class="icon-right btn-control carousel-control" href="#carousel-example-generic-1" role="button" data-slide="next">
							next
						</a>
						<?php 
					}
					?>
				</div>
			</div>
			<div class="col-md-5">
				<div class="social-icon-holder">
					<ul class="social-links">
						<li><a href="#"><img src="<?php echo base_url(); ?>assets/frontend/images/facebook.png" alt=""></a></li>
						<li><a href="#"><img src="<?php echo base_url(); ?>assets/frontend/images/twitter.png" alt=""></a></li>
					</ul>
					<div class="reservation-btn"><p><a href="#"><span><img src="<?php echo base_url() ?>assets/frontend/images/reservation-icon.png" alt=""></span><?php echo lang("RESERVATION"); ?></a></p></div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row bunglow-search">
	<div class="container">
		<h2 class="bunglow-srch-heading"><img src="<?php echo base_url(); ?>assets/frontend/images/left-bracket-wt.png" alt=""><?php echo lang("Search"); ?><img src="<?php echo base_url(); ?>assets/frontend/images/right-bracket-wt.png" alt=""></h2>
		<div class="row">
			<form class="search-form form-horizontal">
				<fieldset>
					<div class="col-md-4">
						<input id="textinput" name="textinput" placeholder="<?php echo lang('Keyword'); ?>" class="search-input input-md" type="text">
					</div>
					<div class="col-md-3"> 
						<div class='section-cal input-group date' id='datetimepicker7'>
							<span class="input-group-custom input-group-addon">
								<span class="calender-icon glyphicon glyphicon-calendar"></span>
							</span>
							<input type='text' class="search-input-cal" data-date-format="YYYY-MM-DD" placeholder="<?php echo lang('Check_In'); ?>"/>
						</div>
					</div>
					<div class="col-md-3">
						<div class='section-cal input-group date' id='datetimepicker8'>
							<span class="input-group-custom input-group-addon">
								<span class="calender-icon glyphicon glyphicon-calendar"></span>
							</span>
							<input type='text' class="search-input-cal" data-date-format="YYYY-MM-DD" placeholder="<?php echo lang('Check_Out'); ?>"/>
						</div>
					</div>
					<div class="col-md-2">
						<input type='submit' class="search-submit-cal" value="<?php echo lang('SUBMIT'); ?>"/>
					</div>
				</fieldset>
			</form>
		</div>
	</div>
</div>
<?php 
if(isset($success_message))
{
	?>
	<script>
		alert('<?php echo $success_message; ?>');
	</script>
	<?php 
}
?>