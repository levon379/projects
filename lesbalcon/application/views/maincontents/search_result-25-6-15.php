<div class="row">
	<div class="inner-page-banner"> <img src="<?php echo base_url(); ?>assets/frontend/images/about-us-banner.jpg" alt=""></div>
</div>
<!--banner end-->
<div class="row innerpage-section">
	<div class="container">
		<h2><img src="<?php echo base_url() ?>assets/frontend/images/bracket-left.png" alt=""><?php echo lang('Search_Result'); ?><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-right.png" alt=""></h2>
		<div class="row inner-content">
				<?php
			//print_r($search_result);
				//die;
				if(count($search_result)>0)
				{
					foreach($search_result as $value)
					{
						if($value['availability']!="notavailable"){

							//echo "<pre>";
							//echo $value['bunglow_rates'][1]['rate_per_day_euro'];
	//die;
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
								<div class="view-details">
								
								 <?php 
									if($value['type']=="P")
									{
										?>
										<a href="<?php echo base_url(); ?>properties/<?php echo $value['slug']; ?>"><?php echo lang('VIEW_DETAILS'); ?></a>
										<?php 
									}
									elseif($value['type']=="B")
									{
										if(isset($value['availability']) && $value['availability']!="available" && $value['availability']!="notavailable"){
											?>
											<a href="<?php echo base_url(); ?>bungalows/<?php echo $value['slug']; ?>?status=partial"><?php echo lang('VIEW_DETAILS'); ?></a>
											<?php
										}else{											
											?>
											<a href="<?php echo base_url(); ?>bungalows/<?php echo $value['slug']; ?>"><?php echo lang('VIEW_DETAILS'); ?></a>
											<?php
										}
									}
								?>
								
								</div>
								<?php if(isset($value['availability']) && $value['availability']!="available" && $value['availability']!="notavailable"){ ?>
									<div class="book-now"><a style="cursor:pointer;" data-popup-target="#example-popup<?php echo $value['id'] ?>"><?php echo lang('BOOK_NOW'); ?></a></div>
								<?php } else { ?>
									<div class="book-now"><a href="<?php echo base_url(); ?>reservation/<?php echo $value['slug']; ?>"><?php echo lang('BOOK_NOW'); ?></a></div>
								<?php } ?>
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
								<div class="persons">
								<?php
								echo $value['max_person'];
								if($value['max_person']==1)
								{
								echo "&nbsp;Person";
								}
								else
								{
								echo "&nbsp;Persons";
								}
								?>
								</div>
								<div class="price">
								<?php
								//print_r($season_result);

								$currency_symbol=$value['currency_symbol'];
	                            $currency_code=$value['currency_code'];

								$high_season_rate_per_day_euro = $all_rates[0][bunglow_rates][1][rate_per_day_euro];
								$high_season_rate_per_day_dollar = $all_rates[0][bunglow_rates][1][rate_per_day_dollar];
								$high_season_rate_per_week_euro = $all_rates[0][bunglow_rates][1][rate_per_week_euro];
								$high_season_rate_per_week_dollar = $all_rates[0][bunglow_rates][1][rate_per_week_dollar];
								$high_season_discount_night = $all_rates[0][bunglow_rates][1][discount_night];
								$high_season_discount_week = $all_rates[0][bunglow_rates][1][discount_week];
	                            $high_season_extranight_perday_europrice = $value['bunglow_rates'][1][extranight_perday_europrice];
								$high_season_extranight_perday_dollerprice = $value['bunglow_rates'][1][extranight_perday_dollerprice];
								
								$low_season_rate_per_day_euro = $all_rates[0][bunglow_rates][2][rate_per_day_euro];
								$low_season_rate_per_day_dollar = $all_rates[0][bunglow_rates][2][rate_per_day_dollar];
								$low_season_rate_per_week_euro = $all_rates[0][bunglow_rates][2][rate_per_week_euro];
								$low_season_rate_per_week_dollar = $all_rates[0][bunglow_rates][2][rate_per_week_dollar];
								$low_season_discount_night = $all_rates[0][bunglow_rates][2][discount_night];
								$low_season_discount_week = $all_rates[0][bunglow_rates][2][discount_week];
	                            $low_extranight_perday_europrice = $value['bunglow_rates'][2][extranight_perday_europrice];
								$low_extranight_perday_dollerprice = $value['bunglow_rates'][2][extranight_perday_dollerprice];
								
								$totaldays=$value['total_days'];
								
								$arrival_date=$value['arrival_date'];
								$date_format_arr=explode("/", $arrival_date); //date format is yyyy-mm-dd. so change it to dd/mm/yyyy
								$new_date_format=$date_format_arr[1]."/".$date_format_arr[0]."/".date("Y");

	                            $leave_date=$value['leave_date'];
								$date_format_arr1=explode("/", $leave_date); //date format is yyyy-mm-dd. so change it to dd/mm/yyyy
								$new_date_format_leave=$date_format_arr1[1]."/".$date_format_arr1[0]."/".date("Y");


								
								$high_season_months = $season_result[0][months];
								$low_season_months = $season_result[1][months];
								
								$date_format_highseason=explode(":", $high_season_months); //date format is yyyy-mm-dd. so change it to dd/mm/yyyy
								$high_season_months1=$date_format_highseason[0]."/".date("Y");
	                            $high_season_months3=$date_format_highseason[1]."/".date("Y");
								
								$date_format_lowseason=explode(":", $low_season_months); //date format is yyyy-mm-dd. so change it to dd/mm/yyyy
								$low_season_months1=$date_format_lowseason[0]."/".(date("Y")+1);
	                            $low_season_months3=$date_format_lowseason[1]."/".(date("Y")+1);
								
								
								$from_date = strtotime($high_season_months1);
								$to_date = strtotime($low_season_months1);

								
								$insert_from_date = strtotime($new_date_format);
	                            $insert_to_date = strtotime($new_date_format_leave);

								
								$m =  date("m",$insert_from_date);
								
								$d =  date("d",$insert_from_date);

	                           if($currency_code=="EUR" && $totaldays <= 6)
	                               {
	                           if($m == 12){
							   if($d > 14){
	                                
							   $totalprice=$currency_symbol."&nbsp;".$totaldays*$value['bunglow_rates'][1]['rate_per_day_euro'];
							   $this->data = array();
			
			                   $season_session=array("season_name"=>"High");
							   $this->session->set_userdata("season_session", $season_session);
								}
							  else{
							   $totalprice=$currency_symbol."&nbsp;".$totaldays*$value['bunglow_rates'][2]['rate_per_day_euro'];
							   $this->data = array();
			
			                   $season_session=array("season_name"=>"Low");
							   $this->session->set_userdata("season_session", $season_session);
								} 	
							 }
							 else
							 {
							if($m < 5){
							if($m == 4){
							if($d > 14){
							$totalprice=$currency_symbol."&nbsp;".$totaldays*$value['bunglow_rates'][2]['rate_per_day_euro'];
							$this->data = array();
			
			                $season_session=array("season_name"=>"Low");
							//$season_session="Low";
							$this->session->set_userdata("season_session", $season_session);
							}
							else
							{
							$totalprice=$currency_symbol."&nbsp;".$totaldays*$value['bunglow_rates'][1]['rate_per_day_euro'];
							$this->data = array();
			
			                $season_session=array("season_name"=>"High");
							$this->session->set_userdata("season_session", $season_session);
							}
							}
							else{
							$totalprice=$currency_symbol."&nbsp;".$totaldays*$value['bunglow_rates'][1]['rate_per_day_euro'];
							$this->data = array();
			
			                $season_session=array("season_name"=>"High");
							$this->session->set_userdata("season_session", $season_session);
							}		
							}
							else
							{
							$totalprice=$currency_symbol."&nbsp;".$totaldays*$value['bunglow_rates'][2]['rate_per_day_euro'];
							$this->data = array();
			
			                $season_session=array("season_name"=>"Low");
							$this->session->set_userdata("season_session", $season_session);
							}
							}
				            }
							elseif($currency_code=="EUR" && $totaldays > 6)
							{
	                           //echo "fdhgfhfh".$totaldays.'gg'.$low_extranight_perday_europrice;

	                           if($m == 12){
							   if($d > 14){
	                                
							   $totalprice=$currency_symbol."&nbsp;".$totaldays*$high_season_extranight_perday_europrice;
							   $this->data = array();
			
			                   $season_session=array("season_name"=>"High");
							   $this->session->set_userdata("season_session", $season_session);
								}
							  else{
							   $totalprice=$currency_symbol."&nbsp;".$totaldays*$low_extranight_perday_europrice;
							   $this->data = array();
			
			                   $season_session=array("season_name"=>"Low");
							   $this->session->set_userdata("season_session", $season_session);
								} 	
							 }
							 else
							 {
							if($m < 5){
							if($m == 4){
							if($d > 14){
							$totalprice=$currency_symbol."&nbsp;".$totaldays*$low_extranight_perday_europrice;
							$this->data = array();
			
			                $season_session=array("season_name"=>"Low");
							//$season_session="Low";
							$this->session->set_userdata("season_session", $season_session);
							}
							else
							{
							$totalprice=$currency_symbol."&nbsp;".$totaldays*$high_season_extranight_perday_europrice;
							$this->data = array();
			
			                $season_session=array("season_name"=>"High");
							$this->session->set_userdata("season_session", $season_session);
							}
							}
							else{
							$totalprice=$currency_symbol."&nbsp;".$totaldays*$high_season_extranight_perday_europrice;
							$this->data = array();
			
			                $season_session=array("season_name"=>"High");
							$this->session->set_userdata("season_session", $season_session);
							}		
							}
							else
							{
							$totalprice=$currency_symbol."&nbsp;".$totaldays*$low_extranight_perday_europrice;
							$this->data = array();
			
			                $season_session=array("season_name"=>"Low");
							$this->session->set_userdata("season_session", $season_session);
							}
							}
	                        }
							elseif($currency_code!="EUR" && $totaldays <= 6)
							{
							if($m == 12){
							if($d > 14){
	                                
							$totalprice=$currency_symbol."&nbsp;".$totaldays*$value['bunglow_rates'][1]['rate_per_day_dollar'];
							$this->data = array();
			
			                $season_session=array("season_name"=>"High");
							$this->session->set_userdata("season_session", $season_session);
	                        }
							else
							{
							$totalprice=$currency_symbol."&nbsp;".$totaldays*$value['bunglow_rates'][2]['rate_per_day_dollar'];
							$this->data = array();
			
			                $season_session=array("season_name"=>"Low");
							$this->session->set_userdata("season_session", $season_session);
							} 	
							}
							else
							{
							if($m < 5){
							if($m == 4){
							if($d > 14){
							$totalprice=$currency_symbol."&nbsp;".$totaldays*$value['bunglow_rates'][2]['rate_per_day_dollar'];
							$this->data = array();
			
			                $season_session=array("season_name"=>"Low");
							$this->session->set_userdata("season_session", $season_session);
							}
							else
							{
							$totalprice=$currency_symbol."&nbsp;".$totaldays*$value['bunglow_rates'][1]['rate_per_day_dollar'];
							$this->data = array();
			
			                $season_session=array("season_name"=>"High");
							$this->session->set_userdata("season_session", $season_session);
							}
							}
							else
							{
							$totalprice=$currency_symbol."&nbsp;".$totaldays*$value['bunglow_rates'][1]['rate_per_day_dollar'];
							$this->data = array();
			
			                $season_session=array("season_name"=>"High");
							$this->session->set_userdata("season_session", $season_session);
							}		
							}
							else
							{
							$totalprice=$currency_symbol."&nbsp;".$totaldays*$value['bunglow_rates'][2]['rate_per_day_dollar'];
							$this->data = array();
			
			                $season_session=array("season_name"=>"Low");
							$this->session->set_userdata("season_session", $season_session);
							}
							}
	                        }
				            else
				            {
							if($m == 12){
							if($d > 14){
	                                
							$totalprice=$currency_symbol."&nbsp;".$totaldays*$high_season_extranight_perday_dollerprice;
							$this->data = array();
			
			                $season_session=array("season_name"=>"High");
							$this->session->set_userdata("season_session", $season_session);
	                        }
							else
							{
							$totalprice=$currency_symbol."&nbsp;".$totaldays*$low_extranight_perday_dollerprice;
							$this->data = array();
			
			                $season_session=array("season_name"=>"Low");
							$this->session->set_userdata("season_session", $season_session);
							} 	
							}
							else
							{
							if($m < 5){
							if($m == 4){
							if($d > 14){
							$totalprice=$currency_symbol."&nbsp;".$totaldays*$low_extranight_perday_dollerprice;
							$this->data = array();
			
			                $season_session=array("season_name"=>"Low");
							$this->session->set_userdata("season_session", $season_session);
							}
							else
							{
							$totalprice=$currency_symbol."&nbsp;".$totaldays*$high_season_extranight_perday_dollerprice;
							$this->data = array();
			
			                $season_session=array("season_name"=>"High");
							$this->session->set_userdata("season_session", $season_session);
							}
							}
							else
							{
							$totalprice=$currency_symbol."&nbsp;".$totaldays*$high_season_extranight_perday_dollerprice;
							$this->data = array();
			
			                $season_session=array("season_name"=>"High");
							$this->session->set_userdata("season_session", $season_session);
							}		
							}
							else
							{
							$totalprice=$currency_symbol."&nbsp;".$totaldays*$low_extranight_perday_dollerprice;
							$this->data = array();
			
			                $season_session=array("season_name"=>"Low");
							$this->session->set_userdata("season_session", $season_session);
							}
							}
	                        }



	                       /*if(($from_date <= $insert_from_date && $to_date >= $insert_from_date) || ($from_date <= $insert_to_date && $to_date >= $insert_to_date))
								 {
	                           if($currency_code=="EUR")
	                               {
	                           echo "high€";
	                           echo $currency_symbol.$all_rates[0][bunglow_rates][1][rate_per_week_euro];
	                            }
								else
								{
	                            echo "high$"
								echo $currency_symbol.$all_rates[0][bunglow_rates][1][rate_per_week_dollar];
								}
								}
								else
								{
								if($currency_code=="EUR")
	                            {
	                           echo "low€";
	                           echo $currency_symbol.$all_rates[0][bunglow_rates][2][rate_per_week_euro];
	                            }
								else
								{
	                          echo "low$";
							  echo $currency_symbol.$all_rates[0][bunglow_rates][2][rate_per_week_dollar];
								}
								}*/
								?>
								<?php echo $totalprice;?>
								</div>
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
													<h2 class="popup-title"><?php echo lang('Partial_Available') ?> <?php //echo lang('Available_On') ?></h2>
													<!--<label style="margin-top:5px;">This bungalow is available on <?php echo $value['availability']; ?>. Please <span style="text-decoration:underline"><a href="mailto:j.willemin@caribwebservices.com?subject=Contact Les Balcons Website">contact us</a></span> for more informations.</label>-->
													<label style="margin-top:5px;"><?php echo lang('available_on_date') ?>   <?php echo lang('contact_info') ?> <span style="text-decoration:underline"><a href="mailto:j.willemin@caribwebservices.com?subject=Contact Les Balcons Website">Click here</a></span></label>
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