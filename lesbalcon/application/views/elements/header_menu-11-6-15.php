<?php
//Get Current Controller to set menu class active
$current_controller=$this->uri->segment(1);
?>

<div class="container">
	<div role="navigation" class="navbar navbar-inverse navbar-static-top">
	  <div class="navbar-header" id="dev_menu">
		<button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button" onclick="scroll_to_menu()"> 
			<span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> 
		</button>
	  </div>
	  <div class="navbar-collapse collapse menubg">
		<ul class="nav navbar-nav">
		  <li><a href="<?php echo base_url(); ?>" <?php if($current_controller==""){ echo "class='active'"; } ?>><?php echo lang('Home'); ?></a></li>
		  <li class="dropdown">
			<a style="cursor:pointer;" class="dropdown-toggle <?php if($current_controller=="properties" || $current_controller=="bungalows" || $current_controller=="testimonials"){ echo "active"; } ?>" data-toggle="dropdown1" href="<?php echo base_url(); ?>our-residence" ><?php echo lang('Our_Residence'); ?>
			<!--<span class="caret"></span>-->
			</a>
			<ul class="dropdown-menu" role="menu">
			  <li><a href="<?php echo base_url(); ?>situation" ><?php echo lang('Situation'); ?></a></li>
			  <li><a href="<?php echo base_url(); ?>rates"><?php echo lang('Rates'); ?></a></li>
			  <li><a href="<?php echo base_url(); ?>testimonials"><?php echo lang('Testimonials'); ?></a></li>
			</ul>
		  </li>
		  
		   <li><a href="<?php echo base_url(); ?>bungalows" <?php if($current_controller=="bungalows"){ echo "class='active'"; } ?>><?php echo lang('Bungalows'); ?></a></li>
		  <!--li><a href="<?php echo base_url(); ?>rates" <?php if($current_controller=="rates"){ echo "class='active'"; } ?>><?php echo lang('Rates'); ?></a></li-->
		  <li class="dropdown">
		  <a style="cursor:pointer;" class="dropdown-toggle <?php if($current_controller=="services" || $current_controller=="Rental_car"){ echo "active"; } ?>" data-toggle="dropdown1" href="<?php echo base_url(); ?>services"><?php echo lang('Services'); ?></a>
		  <ul class="dropdown-menu" role="menu">
			  <li><a href="<?php echo base_url(); ?>rental-car" ><?php echo lang('Rental_car'); ?></a></li>
			</ul>
		  
		  
		  </li>
		  <li><a href="<?php echo base_url(); ?>gallery" <?php if($current_controller=="gallery"){ echo "class='active'"; } ?>><?php echo lang('Gallery'); ?></a></li>
		  <li><a href="<?php echo base_url(); ?>about-st-martin" <?php if($current_controller=="about-st-martin"){ echo "class='active'"; } ?>>St Martin</a></li>
		  <li><a href="<?php echo base_url(); ?>reservation" <?php if($current_controller=="reservation"){ echo "class='active'"; } ?>><?php echo lang('Reservation'); ?></a></li>
		  <li><a href="<?php echo base_url(); ?>faq" <?php if($current_controller=="faq"){ echo "class='active'"; } ?>>FAQ</a></li>
		  <li><a href="<?php echo base_url(); ?>contact-us" <?php if($current_controller=="contact-us"){ echo "class='active'"; } ?>><?php echo lang('Contact_Us'); ?></a></li>
		  
		</ul>
	  </div>
	</div>
</div>
<script>
	function scroll_to_menu()
	{
		$("html, body").scrollTop($("#dev_menu").offset().top); 
	}
</script>