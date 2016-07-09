<script>
function change_language(lang_id)
{
	$.post("<?php echo base_url(); ?>home/set_language", { "lang_id":lang_id }, function(data){
		location.href="<?php echo base_url(uri_string()); ?>";
	});
}
</script>
<div class="row top_wrapper">
    <div class="container">
      <div class="row">
	<div class="col-md-2 col-sm-2 col-xs-12">
	  <div class="login"><a target="_blank" href="<?php echo base_url(); ?>admin"><?php echo lang('Back_end_login'); ?></a></div>
	</div>
    <div class="col-md-2 col-xs-12 pull-right col-sm-2 ">
    	<div class="header-img">
			<!--<a href="http://www.tripadvisor.com/Hotel_Review-g1723175-d583624-Reviews-Les_Balcons_d_Oyster_Pond-Oyster_Pond_Saint_Martin_St_Maarten_St_Martin.html" target="_blank">
			<img alt="" src="http://192.168.5.251/ruma/working_projects/les_balcons_new/assets/frontend/images/trip.png"></a>-->
	
			
			
			<div id="TA_certificateOfExcellence394" class="TA_certificateOfExcellence">

<ul id="5wBVvBx7b" class="TA_links 4FAL4W">

<li id="JQSg3BPLeh" class="dSTR2QrHcljq">

<a target="_blank"
href="http://www.tripadvisor.com/Hotel_Review-g1723175-d583624-Reviews-Les_B
alcons_d_Oyster_Pond-Oyster_Pond_Sint_Maarten_St_Maarten_St_Martin.html"><img
src="http://www.tripadvisor.com/img/cdsi/img2/awards/CoE2015_WidgetAsset-143
48-2.png" alt="TripAdvisor" class="widCOEImg" id="CDSWIDCOELOGO" style="height:70px;"/></a>

</li>

</ul>

</div>

<script
src="http://www.jscache.com/wejs?wtype=certificateOfExcellence&amp;uniq=394&
amp;locationId=583624&amp;lang=en_US&amp;year=2015&amp;display_version=2">
</script>

		</div>
    </div>
    
    <div class="social-login-sec" style="text-align:right;">
	   <ul class="login-section">
			<?php
			if($this->session->userdata("login_user_info"))
			{
				$login_user_info=$this->session->userdata("login_user_info");
				?>
				<li><font ><u><?php echo lang('Welcome') ?></u> <a class="login_style" href="<?php echo base_url(); ?>user/my_profile"> <?php echo $login_user_info['full_name']; ?></a> </font></li>
				<?php 
				if($login_user_info['user_type']=="N")
				{
					?>
					<li><a class="login_style" href="<?php echo base_url(); ?>user/logout" title="<?php echo lang('Logout') ?>"><img src="<?php echo base_url(); ?>assets/frontend/images/logout.png" width="24px" height="24px" alt=""></a></li>
					<?php 
				}
				elseif($login_user_info['user_type']=="F")
				{
					?>
					<li><a style="cursor:pointer;" onclick="FBLogout()" title="<?php echo lang('Logout') ?>"><img src="<?php echo base_url(); ?>assets/frontend/images/logout.png" width="24px" height="24px" alt=""></a></li>
					<?php
				}
			}
			else
			{
				?>
				<!--<li><a style="cursor:pointer;color:#222222"  id="facebook_login" title="<?php echo lang('Facebook_Login') ?>"><img src="<?php echo base_url(); ?>assets/frontend/images/facebook-login.png" alt=""> <?php echo lang('Facebook_Login') ?></a></li>
				<li><a style="color:#222222" href="<?php echo base_url(); ?>user/login" title="<?php echo lang('User_Login') ?>"><img src="<?php echo base_url(); ?>assets/frontend/images/user-login.png" alt=""> <?php echo lang('User_Login') ?></a></li>-->
				<li><a style="color:#222222" href="<?php echo base_url(); ?>user/login" title="<?php echo lang('User_Login') ?>"><img src="<?php echo base_url(); ?>assets/frontend/images/user-login.png" alt=""> <?php echo lang('User_Login') ?></a></li>
				<!--li><a style="cursor:pointer;color:#222222"  href="<?php echo base_url(); ?>user/registration" title="<?php echo lang('Registration') ?>"><img src="<?php echo base_url(); ?>assets/frontend/images/registration.png" alt=""> <?php echo lang('Registration') ?></a></li-->
				<?php 
			}
			?>
        </ul>
    </div>
	<div class="language">
	  <ul>
		<form method="post" id="language_form" action="<?php echo base_url(); ?>home/set_language">
			<!--li><a style="cursor:pointer;"><?php echo lang('Language'); ?></a></li-->
			<?php
			//all_lang is fetching in public_init_elements library
			foreach($all_lang as $lang)
			{
				?>
				<li <?php if($this->session->userdata("current_lang_name")==$lang['language_name']){ echo "class='active'"; } ?>><a style="cursor:pointer;" onclick="change_language('<?php echo $lang['id'] ?>')"><?php //echo lang($lang['language_name']); ?><span><img src="<?php echo base_url(); ?>assets/upload/flag/<?php echo $lang['flag_image_name'] ?>" alt=""></span></a></li>
				<?php 
			}
			?>
		</form>
	  </ul>
	</div>
	</div>
	<div class="row">
	<div class="col-md-4 col-xs-12 col-sm-3 logo"> <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>assets/frontend/images/logo.png" alt=""></a> </div>
	<div class="col-md-2 col-xs-12 col-sm-3"></div>
	<div class="col-md-6 col-xs-12 col-sm-6">
      
	  <div class="socialmedia"> 
		<a target="_blank" href="http://www.facebook.com"><i class="fa fa-facebook fb fa-lg"></i></a> 
		<a target="_blank" href="http://www.instagram.com"><i class="fa fa-instagram tw fa-lg"></i></a> </div>
	  <div class="contact_details">
		<ul>
		  <li><img src="<?php echo base_url(); ?>assets/frontend/images/baloon.png" alt="">&nbsp;15 avenue du lagon Oyster-Pond 97150 Saint -Martin</li>
		  <li><img src="<?php echo base_url(); ?>assets/frontend/images/phone.png" alt="">&nbsp;(01159) or (0059) | 0590 29 43 39 </li>
		</ul>
	  </div>
	</div>
</div>

</div>
</div>
<script>
//Javascript function for facebook login
window.fbAsyncInit = function() {
  //Initiallize the facebook using the facebook javascript sdk
 FB.init({ 
   appId:'<?php echo $this->config->item('appID'); ?>', // App ID 
   cookie:true, // enable cookies to allow the server to access the session
   status:true, // check login status
   xfbml:true, // parse XFBML
   oauth : true //enable Oauth 
 });
};
//Read the baseurl from the config.php file
(function(d){
	   var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
	   if (d.getElementById(id)) {return;}
	   js = d.createElement('script'); js.id = id; js.async = true;
	   js.src = "//connect.facebook.net/en_US/all.js";
	   ref.parentNode.insertBefore(js, ref);
	 }(document));
	//Onclick for fb login
 $('#facebook_login').click(function(e) 
 {
	FB.login(function(response) 
	{
	  if(response.authResponse) 
	  {
		  parent.location ='<?php echo base_url(); ?>user/facebook_login'; //redirect uri after closing the facebook popup
	  }
 },{scope: 'email,read_stream,publish_stream,user_birthday,user_location,user_work_history,user_hometown,user_photos'}); //permissions for facebook
});
function FBLogout()
{
	FB.logout(function(response) {
		location.href = "<?php echo base_url(); ?>user/logout";
	});
}
</script>