<?php
//Get Current Controller to set menu class active
$current_controller=$this->uri->segment(1);
?>
<script>
function check_newsletter_email()
{
	if($("#newsletter_email").val().trim()=="")
	{
		$("#newsletter_email").css("border", "1px solid red");
		$("#newsletter_email").focus();
		return false;
	}
	else if($("#newsletter_email").val()!="")
	{
		var email=$("#newsletter_email").val();
		var reg = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
		if (!reg.test(email)) 
		{	
			alert("<?php echo lang('Please_enter_valid_email_address') ?>");
			$("#newsletter_email").css("border", "1px solid red");
			$("#newsletter_email").focus();
			return false;
		}
		else
		{
			$.post("<?php echo base_url(); ?>home/save_email", { "email":email }, function(data){
				if(data.trim()=="exist")
				{
					alert("<?php echo lang('Email_already_exists'); ?>");
				}
				else 
				{
					alert("<?php echo lang('Your_email_submitted_successfully'); ?>");
				}
			});
		}
	}
	return false;
}
</script>
<div class="row footer">
    <div class="container">
      <div class="col-xs-12 col-sm-12 col-md-6">
        <h3 class="small-heading footerhd"><?php echo lang('SITE_MAP'); ?></h3>
        <div class="footer-blocks">
          <ul class="footer-links">
            <li><a href="<?php echo base_url(); ?>" <?php if($current_controller==""){ echo "class='active'"; } ?>><?php echo lang('Home'); ?></a></li>
            <li><a href="<?php echo base_url(); ?>situation" <?php if($current_controller=="situation"){ echo "class='active'"; } ?>><?php echo lang('Situation'); ?></a></li>
			<li><a href="<?php echo base_url(); ?>faq" <?php if($current_controller=="faq"){ echo "class='active'"; } ?>>FAQ</a></li>
          </ul>
        </div>
        <div class="footer-blocks">
          <ul class="footer-links">
            <li><a href="<?php echo base_url(); ?>rates" <?php if($current_controller=="rates"){ echo "class='active'"; } ?>><?php echo lang('Rates'); ?></a></li>
            <li><a href="<?php echo base_url(); ?>services" <?php if($current_controller=="services"){ echo "class='active'"; } ?>><?php echo lang('Services'); ?></a></li>
			<li><a target="_blank" style="text-transform: capitalize;" href="<?php echo base_url(); ?>admin"><?php echo lang('Back_end_login'); ?></a></li>
          </ul>
        </div>
        <div class="footer-blocks">
          <ul class="footer-links">
            <li><a href="<?php echo base_url(); ?>about-st-martin" <?php if($current_controller=="about-st-martin"){ echo "class='active'"; } ?>><?php echo lang('About_St_Martin'); ?></a></li>
            <li><a href="<?php echo base_url(); ?>gallery" <?php if($current_controller=="gallery"){ echo "class='active'"; } ?>><?php echo lang('Gallery'); ?></a></li>
          </ul>
        </div>
        <div class="footer-blocks">
          <ul class="footer-links">
            <li><a href="<?php echo base_url(); ?>contact-us" <?php if($current_controller=="contact-us"){ echo "class='active'"; } ?>><?php echo lang('Contact_Us'); ?></a></li>
			<li><a href="<?php echo base_url(); ?>reservation" <?php if($current_controller=="reservation"){ echo "class='active'"; } ?>><?php echo lang('Reservation'); ?> </a></li>
          </ul>
        </div>
      </div>
      <div class="col-xs-12 col-sm-6  col-md-3">
        <!--<h3 class="small-heading footerhd"><span>T</span>RIPADVISOR</h3>
        <div class="pic-blocks"> <a target="_blank" href="http://www.tripadvisor.com/Widgets-g1073588-d2623281-c7-a_widgetKey.cdsscrollingravenarrow-Aloha-Orient_Bay_Saint_Martin_St_Maarten_St_Martin.html"><img src="<?php echo base_url(); ?>assets/frontend/images/trip.png" alt=""><a> </div>-->
      </div>
      <div class="col-xs-12 col-sm-6 col-md-3">
        <h3 class="small-heading footerhd">NEWSLETTER<?php /* echo lang('NEWS_LETTER'); */ ?></h3>
        <div class="newsletter-blocks">
          <form class="form-newaletter" action="" method="POST" onsubmit="return check_newsletter_email()">
            <input name="newsletter_email" id="newsletter_email" type="text" placeholder="<?php echo lang('Enter_your_email'); ?>..." style="margin-right:10px; width:69%;">
            <input name="save_email" type="submit" value="<?php echo lang('Submiter'); ?>">
          </form>
        </div>
        <div class="newsletter-blocks" style="padding-left: 48px;">
          <img src="http://dev.caribwebservices.com/projects/lesbalcons/assets/images/tripadvisor.png" />
        </div>
      </div>
    </div>
  </div>
  <div class="row copyright">
    <div class="container">
      <div class="row">
        <div class="col-md-4 col-sm-4  col-xs-12">
          <p>Copyright 2014 Les Balcons. <?php echo lang('All_Rights_Reserved'); ?></p>
        </div>
        <div class="col-md-2 col-sm-2  col-xs-12 pull-right">
          <p class="social">
			<a target="_blank" href="http://www.facebook.com"><img src="<?php echo base_url(); ?>assets/frontend/images/fb-small.png" alt=""></a> 
			<a target="_blank" href="http://www.instagram.com"><img src="<?php echo base_url(); ?>assets/frontend/images/instagram.png" alt=""></a></p>
        </div>
      </div>
    </div>
  </div>
  
 <script type="text/javascript">
	$('pre').replaceWith(function(){
		return $("<p />", {html: $(this).html()});
	});
</script>