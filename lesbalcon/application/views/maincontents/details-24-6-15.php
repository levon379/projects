<div class="row">
  <div class="inner-page-banner"><?php echo $properties_details[0]['virtual_tour_code']; ?><!--<img class="img-responsive" src="<?php echo base_url(); ?>assets/frontend/images/about-us-banner.jpg" alt="">--></div>
</div>
<link href="http://dev.caribwebservices.com/projects/lesbalcons/assets/frontend/css/lightbox.css" rel="stylesheet"/>
<script>
function validate_testimonials_form()
{
	var error=0;
	if($("#test_name").val().trim()=="")
	{
		$("#test_name_error").html("<?php echo lang('Name_is_required') ?>");
		error++;
	}
	else
	{
		$("#test_name_error").html("");
	}
	if($("#test_email").val().trim()=="")
	{
		$("#test_email_error").html("<?php echo lang('Email_is_required') ?>");
		error++;
	}
	else if($("#test_email").val().trim()!="")
	{
		var email=$("#test_email").val();
		var reg = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
		if (!reg.test(email)) 
		{	
			$("#test_email_error").html("<?php echo lang('Please_enter_valid_email_address') ?>");
			error++;
		}
		else 
		{
			$("#test_email_error").html("");
		}
	}
	if($("#test_comment").val().trim()=="")
	{
		$("#test_comment_error").html("<?php echo lang('Description_is_required') ?>");
		error++;
	}
	else 
	{
		$("#test_comment_error").html("");
	}
	if(error>0)
	{
		return false;
	}
}
</script>

<!--banner end-->
<div class="row gallerypage-section aaa">
  <div class="container">
    <h2 class="bunglow-heading-inner"><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-2-left.png" alt=""/><?php echo $properties_details[0]['bunglow_name']; ?><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-2-right.png" alt=""></h2>
    <div class="row topgap-social-box">
      <div class="col-md-12 preservation-btm-gap">
        <div class="social_new">
          <div class="back_toList"> <a href="<?php echo base_url(); ?>bungalows">Back to list</a> </div>
          <div class="social-icon-holder">
            <?php /*?><ul class="social-links">
						<li><a target="_blank" href="http://www.facebook.com/sharer.php?u=<?php echo base_url(uri_string()); ?>&t=<?php echo $properties_details[0]['bunglow_name']; ?>"><img src="<?php echo base_url(); ?>assets/frontend/images/facebook.png" alt=""></a></li>
						<li><a target="_blank" href="http://twitter.com/share?text=<?php echo $properties_details[0]['bunglow_name']; ?>&url=<?php echo urlencode(base_url(uri_string())); ?>&via=twitter&related=<?php echo urlencode("Les Balcons"); ?>" rel="nofollow"><img src="<?php echo base_url(); ?>assets/frontend/images/twitter.png" alt=""></a></li>
					</ul><?php */?>
            <div class="reservation-btn">
              <?php if($_GET["status"] == "partial"){ ?>
                <p><a onclick='$("#example-popup").attr("class","popup visible"); $("html").attr("class","overlay");'><span><img src="<?php echo base_url() ?>assets/frontend/images/reservation-icon.png" alt=""></span><?php echo lang("RESERVATION"); ?></a></p>
              <?php }else{ ?>
               <p><a href="<?php echo base_url(); ?>reservation/<?php echo $this->uri->segment(2); ?>"><span><img src="<?php echo base_url() ?>assets/frontend/images/reservation-icon.png" alt=""></span><?php echo lang("RESERVATION"); ?></a></p>
               <?php } ?>
          



            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <ul id="tabs" class="nav nav-tabs custom-tabs" data-tabs="tabs">
          <li class="active"><a href="#red" data-toggle="tab"><?php echo lang('OVERVIEW'); ?></a></li>
          <li><a href="#orange" data-toggle="tab"><?php echo lang('RATES'); ?></a></li>
        </ul>
        <div id="my-tab-content" class="tab-content">
          <div class="tab-pane active onetab" id="red"> <?php echo $properties_details[0]['bunglow_overview']; ?>


		<!--div class="master_div">
			<div class="table-cell table-cell-one new_detail"><a href="" style="text-decoration:none;">
                <div class="col-lg-12">
                  <div class="row">
                                      
                    <div class="col-md-2 col-sm-2 col-xs-2 border_right no-pad-left no-pad-right">
                      <p>
                       LOCALISATION                      </p>
                    </div>
                   <div class="col-md-1 col-sm-1 col-xs-1 border_right no-pad-left no-pad-right">
                      <p>
                        ACCES du PARKING                 </p>
                    </div>
                    <div class="col-md-1 col-sm-1 col-xs-1 border_right no-pad-left no-pad-right">
                      <p>
                        TERRASSE AVEC
                      </p>
                    </div>
                    <div class="col-md-1 col-sm-1 col-xs-1 border_right no-pad-left no-pad-right">
                      <p>
                        CLIMATISATION                     </p>
                    </div>
                  <div class="col-md-1 col-sm-1 col-xs-1 border_right no-pad-left no-pad-right">
                      <p>
                        VENTILATEUR INTERIEUR                    </p>
                    </div>
					
					<div class="col-md-1 col-sm-1 col-xs-1 border_right no-pad-left no-pad-right">
                      <p>
                       TV CNN ESPN
                   </p>
                    </div>
					
					<div class="col-md-1 col-sm-1 col-xs-1 border_right no-pad-left no-pad-right">
                      <p>
                        US DISH SATELLITE 
                  </p>
                    </div>
					
					<div class="col-md-1 col-sm-1 col-xs-1 border_right no-pad-left no-pad-right">
                      <p>
                       COFFRE FORT

                  </p>
                    </div>
					
					<div class="col-md-1 col-sm-1 col-xs-1 border_right no-pad-left no-pad-right">
                      <p>
                       WIFI
                  </p>
                    </div>
					<div class="col-md-1 col-sm-1 col-xs-1 border_right no-pad-left no-pad-right">
                      <p>
                       HIFI
                  </p>
                    </div>
					<div class="col-md-1 col-sm-1 col-xs-1 border_right no-pad-left no-pad-right">
                      <p>
                       LECTEUR DVD
                  </p>
                    </div>
                </div>
			    </div>
                </a> </div>	
			<div class="table-cell table-cell-one new_detail1"><a href="" style="text-decoration:none;">
                <div class="col-lg-12">
				   <div class="row">
                   
                    <div class="col-md-2 col-sm-2 col-xs-2 border_right no-pad-left no-pad-right">
                      <p>ALLEE DU HAUT </p>
                    </div>
                   <div class="col-md-1 col-sm-1 col-xs-1 border_right no-pad-left no-pad-right">
                       <p>1 marche</p>
                    </div>
                    <div class="col-md-1 col-sm-1 col-xs-1 border_right no-pad-left no-pad-right">
                       <p>LARGE</p>
                    </div>
                    <div class="col-md-1 col-sm-1 col-xs-1 border_right no-pad-left no-pad-right">
                       <p>OUI</p>
                    </div>
                  <div class="col-md-1 col-sm-1 col-xs-1 border_right no-pad-left no-pad-right">
                     <p>OUI </p>
                    </div>
					
					<div class="col-md-1 col-sm-1 col-xs-1 border_right no-pad-left no-pad-right">
                      <p>OUI</p>
                    </div>
					
					<div class="col-md-1 col-sm-1 col-xs-1 border_right no-pad-left no-pad-right">
                     <p>OUI</p>
                    </div>
					
					<div class="col-md-1 col-sm-1 col-xs-1 border_right no-pad-left no-pad-right">
                      <p>OUI </p>
                    </div>
					
					<div class="col-md-1 col-sm-1 col-xs-1 border_right no-pad-left no-pad-right">
                     <p>OUI </p>
                    </div>
					<div class="col-md-1 col-sm-1 col-xs-1 border_right no-pad-left no-pad-right">
                     <p>OUI </p>
                    </div>
					<div class="col-md-1 col-sm-1 col-xs-1 border_right no-pad-left no-pad-right">
                     <p>OUI </p>
                    </div>
                </div>
				
				
                </div>
                </a> 
			</div>
			
			
			
			
			
			<div class="table-cell table-cell-one new_detail"><a href="" style="text-decoration:none;">
                <div class="col-lg-12">
                  <div class="row">
                                      
                    <div class="col-md-1 col-sm-1 col-xs-1 border_right no-pad-left no-pad-right">
                      <p>
                       LITERIE </p>
                    </div>
                   <div class="col-md-2 col-sm-2 col-xs-2 border_right no-pad-left no-pad-right">
                      <p>
                       FRIGO/CONGELATEUR               </p>
                    </div>
                   <div class="col-md-2 col-sm-2 col-xs-2 border_right no-pad-left no-pad-right">
                      <p>
                        PLAQUES CUISSON
                      </p>
                    </div>
                    <div class="col-md-1 col-sm-1 col-xs-1 border_right no-pad-left no-pad-right">
                      <p>
                        MICRO ONDE                      </p>
                    </div>
                  <div class="col-md-1 col-sm-1 col-xs-1 border_right no-pad-left no-pad-right">
                      <p>
                        CAFETIERE                    </p>
                    </div>
					
					<div class="col-md-1 col-sm-1 col-xs-1 border_right no-pad-left no-pad-right">
                      <p>
                       GRILLE PAIN
                   </p>
                    </div>
					
					<div class="col-md-1 col-sm-1 col-xs-1 border_right no-pad-left no-pad-right">
                      <p>
                       BOUILLOIRE
                  </p>
                    </div>
					
					<div class="col-md-1 col-sm-1 col-xs-1 border_right no-pad-left no-pad-right">
                      <p>
                      BLENDER 

                  </p>
                    </div>
					
					<div class="col-md-1 col-sm-1 col-xs-1 border_right no-pad-left no-pad-right">
                      <p>
                      FOUR
                  </p>
                    </div>
					<div class="col-md-1 col-sm-1 col-xs-1 border_right no-pad-left no-pad-right">
                      <p>
                       LAVE LINGE
                  </p>
                    </div>
					
                </div>
			    </div>
                </a> </div>	
			<div class="table-cell table-cell-one new_detail2"><a href="" style="text-decoration:none;">
                <div class="col-lg-12">
				   <div class="row">
                   
                    <div class="col-md-1 col-sm-1 col-xs-1 border_right no-pad-left no-pad-right">
                      <p>King Size  </p>
                    </div>
                   <div class="col-md-2 col-sm-2 col-xs-2 border_right no-pad-left no-pad-right">
                       <p>OUI</p>
                    </div>
                  <div class="col-md-2 col-sm-2 col-xs-2 border_right no-pad-left no-pad-right">
                       <p>Electrique</p>
                    </div>
                    <div class="col-md-1 col-sm-1 col-xs-1 border_right no-pad-left no-pad-right">
                       <p>OUI</p>
                    </div>
                  <div class="col-md-1 col-sm-1 col-xs-1 border_right no-pad-left no-pad-right">
                     <p>OUI </p>
                    </div>
					
					<div class="col-md-1 col-sm-1 col-xs-1 border_right no-pad-left no-pad-right">
                      <p>OUI</p>
                    </div>
					
					<div class="col-md-1 col-sm-1 col-xs-1 border_right no-pad-left no-pad-right">
                     <p>OUI</p>
                    </div>
					
					<div class="col-md-1 col-sm-1 col-xs-1 border_right no-pad-left no-pad-right">
                      <p>OUI </p>
                    </div>
					
					<div class="col-md-1 col-sm-1 col-xs-1 border_right no-pad-left no-pad-right">
                     <p>OUI </p>
                    </div>
					<div class="col-md-1 col-sm-1 col-xs-1 border_right no-pad-left no-pad-right">
                     <p>OUI </p>
                    </div>
				
                </div>
				
				
                </div>
                </a> 
			</div>
			
			
			
			
			
			
			<div class="table-cell table-cell-one new_detail"><a href="" style="text-decoration:none;">
                <div class="col-lg-12">
                  <div class="row">
                    <div class="col-md-2 col-sm-2 col-xs-2 border_right no-pad-left no-pad-right">
                       <p>SECHE CHEVEUX</p>
                    </div>
					 <div class="col-md-2 col-sm-2 col-xs-2 border_right no-pad-left no-pad-right">
                       <p>BARBECUE AU GAZ</p>
                    </div>
					 <div class="col-md-2 col-sm-2 col-xs-2 border_right no-pad-left no-pad-right">
                       <p>VENTILATEUR TERRASSE </p>
                    </div>
					
					 <div class="col-md-2 col-sm-2 col-xs-2 border_right no-pad-left no-pad-right">
                       <p>CHAISES LONGUES</p>
                    </div>
					 <div class="col-md-2 col-sm-2 col-xs-2 border_right no-pad-left no-pad-right">
                       <p>TABLE ET CHAISES </p>
                    </div>
					 <div class="col-md-2 col-sm-2 col-xs-2 border_right no-pad-left no-pad-right">
                       <p>CANAPE EXTERIEUR</p>
                    </div>
                </div>
			    </div>
                </a> </div>	
			<div class="table-cell table-cell-one new_detail1"><a href="" style="text-decoration:none;">
                <div class="col-lg-12">
				   <div class="row">
                     <div class="col-md-2 col-sm-2 col-xs-2 border_right no-pad-left no-pad-right">
                       <p>OUI</p>
                    </div>
					 <div class="col-md-2 col-sm-2 col-xs-2 border_right no-pad-left no-pad-right">
                       <p>OUI</p>
                    </div>
					 <div class="col-md-2 col-sm-2 col-xs-2 border_right no-pad-left no-pad-right">
                       <p>OUI</p>
                    </div>
					
					 <div class="col-md-2 col-sm-2 col-xs-2 border_right no-pad-left no-pad-right">
                       <p>1</p>
                    </div>
					 <div class="col-md-2 col-sm-2 col-xs-2 border_right no-pad-left no-pad-right">
                       <p>OUI</p>
                    </div>
					 <div class="col-md-2 col-sm-2 col-xs-2 border_right no-pad-left no-pad-right">
                       <p>OUI</p>
                    </div>
                </div>
				
				
                </div>
                </a> 
			</div>
			
			
			
			
			
			
			
			
			</div-->




		  </div>
          <div class="tab-pane" id="orange">
            <div class="tab-text">
              <div class="row">
                <div class="container#">
                  <div class="row rates-inner-content" style="display:block;">
                    <div class="col-sm-12 col-md-12 col-xs-12">
                      <div class="row# col-lg-12 col-md-12 no-pad-left no-pad-right seasons-block">
                        <div class="col-sm-6 col-md-6 col-xs-6">
                          <div class="row">
                            <div class="high-season high-season_details">
                              <div class="summer-block">
                                <p align="center"><img alt="" src="<?php echo base_url(); ?>assets/upload/season_icon/summer.png"></p>
                                <p class="heading-text"><?php echo $all_seasons[0]['season_name'] ?></p>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-xs-6 no-pad-right">
                          <div class="row">
                            <div class="low-season high-season_details">
                              <div class="autumn-block">
                                <p align="center"><img alt="" src="<?php echo base_url(); ?>assets/upload/season_icon/autumn.png"></p>
                                <p class="heading-text"><?php echo $all_seasons[1]['season_name'] ?></p>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
					<div class="row#" style="clear: both;">
                             <div class="mobile_table_heading table-cell-one" style="display:block; width: 100%;"><a style="text-decoration:none;" href="">
                          <div class="row#">
                            <div class="col-md-2 col-sm-2 col-xs-2 border_right">
                              <p>Per night <br/>( 1 or 2 peoples )<br /> &euro;<!-- | $--></p>
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-2 border_right">
                              <p>Per week <br/>( 1 or 2 peoples )<br /> &euro; <!--| $ --></p>
                            </div>
<div class="col-md-2 col-sm-2 col-xs-2 border_right">
                              <p>Extra night after week rental<br/>( 1 or 2 peoples ) </p>
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-2 border_right">
                              <p>Per night <br/>( 1 or 2 peoples )<br /> &euro; <!--| $--></p>
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-2 border_right">
                              <p>Per week <br/>( 1 or 2 peoples )<br /> &euro; <!--| $ --></p>
                            </div>
<div class="col-md-2 col-sm-2 col-xs-2 border_right">
                              <p>Extra night after week rental<br/>( 1 or 2 peoples ) </p>
                            </div>
                          </div>
                          </a> </div>

                        <div class="col-lg-12">
                          <div class="autumn-block">
                            <!--<p align="center"><img src="http://192.168.5.251/ruma/working_projects/les_balcons_new/assets/upload/season_icon/" alt=""></p>-->
                            <p class="heading-text"></p>
                          </div>
                        </div>
                        
                        <a style="text-decoration:none;" href=""> </a>
                        <div class="table-cell table-cell-one extra_person" style="width: 100%;"><a style="text-decoration:none;" href="">
                          <div class="row#">
						   <?php
                           //print_r($properties_rates);
							$j=0;
							foreach($properties_rates as $seasons_rate)
							{
							?>
                            <div class="col-md-2 col-sm-2 col-xs-2 border_right">
                              <p> <?php echo "&euro;"." ".$properties_rates[$j]['rate_per_day_euro'];?><!--&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                             <?php echo "$"." ".$properties_rates[$j]['rate_per_day_dollar'];?> </p>-->
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-2 border_right">
                              <p> <?php echo "&euro;"." ".$properties_rates[$j]['rate_per_week_euro'];?><!--&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                              <?php echo "$"." ".$properties_rates[$j]['rate_per_week_dollar'];?> </p>-->
                            </div>
<div class="col-md-2 col-sm-2 col-xs-2 border_right table-cell-one">
                              <p> <?php echo "&euro;"." ".$properties_rates[$j]['extranight_perday_europrice'];?><!--&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                              <?php echo "$"." ".$properties_rates[$j]['extranight_perday_dollerprice'];?> </p>-->
                            </div>
                              <?php
							$j++;
							}
							?>

                            <!--<div class="col-md-3 col-sm-3 col-xs-6 border_right">
                              <p> € 250&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;$ 260 </p>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-6 border_right">
                              <p> € 450&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;$ 460 </p>
                            </div>-->
                          </div>
                          </a> </div>
                          <div class="table-cell table-cell-one extra_person" style="width: 100%;">
                          <div class="row#">
                             <div class="col-md-12 col-sm-12 col-xs-12 border_right">
                              <p>
                              <?php echo lang("EXTRA_PERSON_PRICE"); ?>
                               </p>
                              </div>
                          </div>
                          </div>
                          <div class="table-cell table-cell-one extra_person" style="width: 100%;">
                          <div class="row#">
                             <div class="col-md-12 col-sm-12 col-xs-12 border_right">
                              <p>
                              <?php echo lang("STAY_TAX"); ?>
                               </p>
                              </div>
                          </div>
                          </div>
                      </div>                                       
                      
                    </div>
                  </div>
                </div>
              </div>
              <?php /*?><?php 
							if(count($properties_rates)>0)
							{
								?>
								<div class="row black-bg">
								<div class="container details_rate">
									<div class="row rates-inner-content rates_text">
									<div class="col-sm-12 col-md-12">
										<div class="row seasons-block">
											<?php
											foreach($all_seasons as $seasons)
											{
												if($seasons['id']==1)
												{
													$class1="bunglow-row-smr";
													$class2="summer-block";
												}
												elseif($seasons['id']==2)
												{
													$class1="bunglow-row-autumn";
													$class2="autumn-block";
												}
												elseif($seasons['id']==3)
												{
													$class1="bunglow-row-winter";
													$class2="winter-block";
												}
												elseif($seasons['id']==4)
												{
													$class1="bunglow-row-spring";
													$class2="spring-block";
												}
												?>
												<div class="col-sm-3 col-md-3">
													<div class="row">
														<div class="<?php echo $class1; ?>">
															<div class="<?php echo $class2; ?>">
																<p align="center"><img src="<?php echo base_url(); ?>assets/upload/season_icon/<?php echo $seasons['season_icon'] ?>" alt=""></p>
																<p class="heading-text"><?php echo $seasons['season_name'] ?></p>
															</div>
														</div>
													</div>
												</div>
												<?php 
											}
											?>
										</div>
									</div>
									</div>
								</div>
						  </div>
						  
						  <div class="row table-bg rates_text">
								<div class="container rates_text">
									<div class="row">
										<div class="col-sm-12 col-md-12">
											 <div class="row">
												<?php 
												$i=1;
												foreach($properties_rates as $seasons_rate)
												{
													if($seasons_rate['season_id']==1)
													{
														$class1="summer-block-2";
														$class2="summer-block";
													}
													elseif($seasons_rate['season_id']==2)
													{
														$class1="autumn-block-2";
														$class2="autumn-block";
													}
													/*elseif($seasons_rate['season_id']==3)
													{
														$class1="winter-block-2";
														$class2="winter-block";
													}
													elseif($seasons_rate['season_id']==4)
													{
														$class1="spring-block-2";
														$class2="spring-block";
													}*/
													?>
              <?php /*?>						<div class="col-sm-3 col-md-3">
														 <div class="row">  
															<div class="<?php echo $class1; ?>">
																<div class="<?php echo $class2; ?>">
																	<p align="center"><img src="<?php echo base_url(); ?>assets/upload/season_icon/<?php echo $seasons_rate['season_icon'] ?>" alt=""></p>
																	<p class="heading-text"><?php echo $seasons_rate['season_name']; ?></p>
																</div>
															</div>
															<div class="<?php if($i==1){ echo "table-cell2"; }else{ echo "table-cell-1"; } ?>">
																<p>
																	<?php
																	if($default_currency['currency_id']==1)//$default_currency has been fetched globally in public_init_elements library 
																	{
																		echo $default_currency['currency_symbol']." ".$seasons_rate['rate_per_day_dollar'];
																	}
																	if($default_currency['currency_id']==2)
																	{
																		echo $default_currency['currency_symbol']." ".$seasons_rate['rate_per_day_euro'];
																	}
																	?>
																</p>
															</div>
														  </div>
													</div>
													<?php 
													$i++;
												}
												?>
											</div>
										</div>
								  </div>
								</div>
							  </div>
							  <?php 
							}
							else 
							{
								echo lang('No_Rates_Found');
							}
							?>
                            
							<!--- Desktop view start ---->
                            <div class="row black-bg">
								<div class="container details_rate">
									<div class="row rates-inner-content rates_text">
									<div class="col-sm-12 col-md-12">
										<div class="row seasons-block">
										   <div class="col-sm-6 col-md-6">
													<div class="<?php //echo $class1; ?>high-season-new">
														<div class="<?php //echo $class2; ?>summer-block">
															<p align="center"><img src="<?php echo base_url(); ?>assets/upload/season_icon/<?php echo $seasons['season_icon'] ?>" alt=""></p>
															<p class="heading-text"><?php echo $seasons['season_name'] ?></p>
														</div>
													</div>
											</div>
											<div class="col-sm-6 col-md-6">
													<div class="<?php //echo $class1; ?>low-season-new">
														<div class="<?php //echo $class2; ?>summer-block">
															<p align="center"><img src="<?php echo base_url(); ?>assets/upload/season_icon/<?php echo $seasons['season_icon'] ?>" alt=""></p>
															<p class="heading-text"><?php echo $seasons['season_name'] ?></p>
														</div>
													</div>
											</div>
										</div>
									</div>
									</div>
								</div>
						  </div>
                           <!--- Desktop view end ---->
                           
                           <!--- Responsive view start ---->
                            <div class="row table-bg rates_text">
								<div class="container rates_text">
									<div class="row">
										<div class="col-sm-12 col-md-12">
											 <div class="row">
													<div class="col-sm-6 col-md-6">
															<div class="<?php //echo $class1; ?>summer-block-2">
																<div class="<?php //echo $class2; ?>summer-block">
																	<p align="center"><img src="<?php echo base_url(); ?>assets/upload/season_icon/<?php echo $seasons_rate['season_icon'] ?>" alt=""></p>
																	<p class="heading-text"><?php echo $seasons_rate['season_name']; ?></p>
																</div>
															</div>
															<div class="table_cell_new">
																<div class="row">
                                                                	<div class="col-md-4 col-sm-4 col-xs-4"><p>Per night</p></div>
                                                                    <div class="col-md-4 col-sm-4 col-xs-4"><p>Per week</p></div>
                                                                    <div class="col-md-4 col-sm-4 col-xs-4"><p>Extra night after 1 week rental</p></div>
                                                                </div>
															</div>
                                                            <div class="table_cell_new">
																<div class="row">
                                                                	<div class="col-md-4 col-sm-4 col-xs-4"><p>1</p></div>
                                                                    <div class="col-md-4 col-sm-4 col-xs-4"><p>2</p></div>
                                                                    <div class="col-md-4 col-sm-4 col-xs-4"><p>3</p></div>
                                                                </div>
															</div>
													</div>
                                                    <div class="col-sm-6 col-md-6">
															<div class="<?php //echo $class1; ?>summer-block-2">
																<div class="<?php //echo $class2; ?>summer-block">
																	<p align="center"><img src="<?php echo base_url(); ?>assets/upload/season_icon/<?php echo $seasons_rate['season_icon'] ?>" alt=""></p>
																	<p class="heading-text"><?php echo $seasons_rate['season_name']; ?></p>
																</div>
															</div>
															<div class="table_cell_new">
																<div class="row">
                                                                	<div class="col-md-4 col-sm-4 col-xs-4"><p>Per night</p></div>
                                                                    <div class="col-md-4 col-sm-4 col-xs-4"><p>Per week</p></div>
                                                                    <div class="col-md-4 col-sm-4 col-xs-4"><p>Extra night after 1 week rental</p></div>
                                                                </div>
															</div>
                                                            <div class="table_cell_new">
																<div class="row">
                                                                	<div class="col-md-4 col-sm-4 col-xs-4"><p>1</p></div>
                                                                    <div class="col-md-4 col-sm-4 col-xs-4"><p>2</p></div>
                                                                    <div class="col-md-4 col-sm-4 col-xs-4"><p>3</p></div>
                                                                </div>
															</div>
													</div>
											</div>
										</div>
								  </div>
								</div>
							  </div>
                            <!--- Responsive view end ----><?php */?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row galbg_new">
  <div class="container">
    <h2><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-left.png" alt=""><?php echo lang('GALLERY'); ?><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-right.png" alt=""></h2>
    <div class="row gallery-row">
      <div class="col-md-12">
        <div class="gallery_mdl">
          <div id="carousel-example-generic-1" class="carousel slide" data-ride="carousel">
            <!-- Wrapper for slides -->
            <div class="carousel-inner">
              <?php 
						$i=0;
						foreach($properties_images as $images)
						{
							?>
              <div class="item <?php if($i==0){ echo "active"; } ?>"> <img src="<?php echo base_url(); ?>assets/upload/bunglow/thumb_large/<?php echo $images['image'] ?>" alt=""> </div>
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
            <a class="icon-left btn-control carousel-control" href="#carousel-example-generic-1" role="button" data-slide="prev"> prev </a> <a class="icon-right btn-control carousel-control" href="#carousel-example-generic-1" role="button" data-slide="next"> next </a>
            <?php 
					}
					?>
          </div>
        </div>
      </div>
      <!--<div class="col-md-5">
				<div class="social-icon-holder">
					<ul class="social-links">
						<li><a target="_blank" href="http://www.facebook.com/sharer.php?u=<?php echo base_url(uri_string()); ?>&t=<?php echo $properties_details[0]['bunglow_name']; ?>"><img src="<?php echo base_url(); ?>assets/frontend/images/facebook.png" alt=""></a></li>
						<li><a target="_blank" href="http://twitter.com/share?text=<?php echo $properties_details[0]['bunglow_name']; ?>&url=<?php echo urlencode(base_url(uri_string())); ?>&via=twitter&related=<?php echo urlencode("Les Balcons"); ?>" rel="nofollow"><img src="<?php echo base_url(); ?>assets/frontend/images/twitter.png" alt=""></a></li>
					</ul>
					<div class="reservation-btn"><p><a href="<?php echo base_url(); ?>reservation/<?php echo $this->
      uri->segment(2); ?>"><span><img src="<?php echo base_url() ?>assets/frontend/images/reservation-icon.png" alt=""></span><?php echo lang("RESERVATION"); ?></a>
      </p>
    </div>
  </div>
</div>
-->
</div>
</div>
</div>
<div class="row main-bg">
  <div class="col-xs-12 col-sm-12 col-md-12 left-panel">
    <div class="col-xs-12 col-sm-12 col-md-12">
      <h2 class="bunglow-heading"><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-2-left.png" alt=""/><?php echo lang('TESTIMONIALS'); ?><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-2-right.png" alt=""></h2>
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
              <p class="captionstyle"><span class="left_com"></span><span class="right_com"><?php echo $value['content']; ?></span></p>
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
              <h2 style="text-align:center;"><span><?php echo lang('No_Testimonials_Found'); ?></span></h2>
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
        <a class="prev custom-control carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">prev</a> <a class="next custom-control carousel-control" href="#carousel-example-generic" role="button" data-slide="next">next</a>
        <?php 
				}
				?>
      </div>
    </div>
  </div>
  <?php /*?><div class="col-xs-12 col-sm-12 col-md-4 right-panel">
		<div class="col-xs-12 col-sm-12 col-md-10 pull-left">
			<div class="row testimonial-form">
				<h4><?php echo lang('Testimonial_Post'); ?></h4>
				<form class="form-testimonial form-horizontal" action="" method="POST" onsubmit="return validate_testimonials_form()">
					<fieldset>
						<!-- Text input-->
						<input id="bungalow_id" name="bungalow_id" value="<?php echo $properties_details[0]['bunglow_id']; ?>" class="testi-input form-control input-md" type="hidden">
						<div class="form-row form-group">
						  <div class="col-md-12">
						  <input id="test_name" name="test_name" placeholder="<?php echo lang('Name'); ?>" class="testi-input form-control input-md" type="text" style="margin-bottom:3px !important;">
						  <label id="test_name_error" style="color:red;"></label>
						  </div>
						</div>
						<!-- Text input-->
						<div class="form-row form-group">
						  <div class="col-md-12">
						  <input id="test_email" name="test_email" placeholder="<?php echo lang('Email'); ?>" class="testi-input form-control input-md" type="text" style="margin-bottom:3px !important;">
						  <label id="test_email_error" style="color:red;"></label>
						  </div>
						</div>
						<!-- Textarea -->
						<div class="form-row form-group">
						  <div class="col-md-12"> 
							<textarea maxlength="250" name="test_comment" id="test_comment" class="testi-textarea form-control" placeholder="<?php echo lang('Description'); ?>" name="<?php echo lang('Description'); ?>" style="margin-bottom:3px !important;"></textarea>
							<label id="test_comment_error" style="color:red;"></label><label style="float:right; padding:0px 18px;">Max: 250</label>
						  </div>
						</div>
						<!-- Button -->
						<div class="form-row form-group">
						  <div class="col-md-4">
							<input type="submit" id="singlebutton" name="save_testimonials" class="submit-button1 btn btn-default" value="<?php echo lang('Post'); ?>">
						  </div>
						</div>
					</fieldset>
				</form>
			</div>
		</div>
	</div><?php */?>
  <div id="example-popup" class="popup">
    <div class="popup-body">  
    <span class="popup-exit" onclick='$("#example-popup").attr("class","popup"); $("html").attr("class","");'></span>
    <div class="popup-content">
      <h2 class="popup-title">Availability Status</h2>
      <label style="margin-top:5px;">This bungalow is unavailable. Please <span style="text-decoration:underline"><a href="mailto:j.willemin@caribwebservices.com?subject=Contact Les Balcons Website">contact us</a></span> for more informations.</label>
    </div>
    </div>
  </div>
  <div class="popup-overlay" style="z-index:999;"></div>
</div>
<script>
function validate_search()
{
	var error=0;
	if($("#search_keyword").val().trim()=="" && $("#search_arrival_date").val().trim()=="" && $("#search_leave_date").val().trim()=="")
	{
		$("#search_error").html("<?php echo lang('Enter_keyword_or_dates'); ?>");
		$("#search_error").show();
		error++;
	}
	else
	{
		$("#search_error").html("");
		$("#search_error").hide();
		
		if($("#search_arrival_date").val().trim()!="")
		{
			var arrival_date=$("#search_arrival_date").val();
			var arival_date_arr=$("#search_arrival_date").val().split("/");
			
			var valyear=arival_date_arr[2];
			var valmonth=arival_date_arr[1];
			var valday=arival_date_arr[0];
			var today = new Date()
			var new_arrival_date= new Date(valyear,(valmonth-1),valday);
			var result=calcDate(today, new_arrival_date);
			if(result>0)
			{
				$("#search_arrival_date_error").html("<?php echo lang('Past_date_not_allowed'); ?>");
				error++;
			}
			else 
			{
				$("#search_arrival_date_error").html("");
			}
			if($("#search_leave_date").val().trim()=="")
			{
				$("#search_leave_date_error").html("<?php echo lang('Check_Out_is_required'); ?>");
				error++;
			}
			else 
			{
				$("#search_leave_date_error").html("");
			}
		}
		if($("#search_leave_date").val().trim()!="")
		{
			var arrival_date=$("#search_arrival_date").val();
			var arival_date_arr=$("#search_arrival_date").val().split("/");
			var valyear=arival_date_arr[2];
			var valmonth=arival_date_arr[1];
			var valday=arival_date_arr[0];
			var today = new Date()
			var new_arrival_date= new Date(valyear,(valmonth-1),valday);
			
			var leave_date=$("#search_leave_date").val();
			var leave_date_arr=$("#search_leave_date").val().split("/");
			var leave_year=leave_date_arr[2];
			var leave_month=leave_date_arr[1];
			var leave_day=leave_date_arr[0];
			var new_leave_date= new Date(leave_year,(leave_month-1),leave_day);
			
			var result=calcDate(new_arrival_date, new_leave_date);
			
			if(result>0)
			{
				$("#search_leave_date_error").html("<?php echo lang('Must_be_greater_than_Check_In'); ?>");
				error++;
			}
			else 
			{
				$("#search_leave_date_error").html("");
			}
			
			if($("#search_arrival_date").val().trim()=="")
			{
				$("#search_arrival_date_error").html("<?php echo lang('Check_In_is_required'); ?>");
				error++;
			}
			else 
			{
				var arrival_date=$("#search_arrival_date").val();
				var arival_date_arr=$("#search_arrival_date").val().split("/");
				
				var valyear=arival_date_arr[2];
				var valmonth=arival_date_arr[1];
				var valday=arival_date_arr[0];
				var today = new Date()
				var new_arrival_date= new Date(valyear,(valmonth-1),valday);
				var result=calcDate(today, new_arrival_date);
				if(result>0)
				{
					$("#search_arrival_date_error").html("<?php echo lang('Past_date_not_allowed'); ?>");
					error++;
				}
				else 
				{
					$("#search_arrival_date_error").html("");
				}
			}
		}
	}
	if(error>0)
	{
		return false;
	}
	else
	{
		$("#details_form_search").submit();
	}
}
function calcDate(date1,date2) 
{
    var diff = Math.floor(date1.getTime() - date2.getTime());
    var day = 1000 * 60 * 60 * 24;
    var days = Math.floor(diff/day);
    var months = Math.floor(days/31);
    var years = Math.floor(months/12);
    return days;
}


$(document).ready(function(e) {
	
    $('#parent_popup').click(function(){
		$('.modal-backdrop').eq(0).remove();
		$('modal-backdrop').css('display','none');
		$('#myModal').css('display','none');
			
		
		});
});
</script>
<div class="row bunglow-search">
  <div class="container">
    <h2 class="bunglow-srch-heading"><img src="<?php echo base_url(); ?>assets/frontend/images/left-bracket-wt.png" alt=""><?php echo lang("Search"); ?><img src="<?php echo base_url(); ?>assets/frontend/images/right-bracket-wt.png" alt=""></h2>
    <div class="row">
      <form class="search-form form-horizontal" id="details_form_search" action="<?php echo base_url() ?>search" method="post">
        <fieldset>
        <div class="col-md-12">
          <label style="color:red; display:none;" id="search_error"></label>
        </div>
        <div class="col-md-4">
          <?php /*?><input id="search_keyword" name="search_keyword" placeholder="<?php echo lang('Keyword'); ?>" class="search-input input-md" type="text"><?php */?>
          <select name="search_keyword" class="search-input input-md" id="search_keyword">
            <option value="">Please select Persons</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
          </select>
          <label style="color:red;" id="search_keyword_error"></label>
        </div>
        <div class="col-md-3">
          <div class='section-cal input-group date' id='datetimepicker7'> <span class="input-group-custom input-group-addon"> <span class="calender-icon glyphicon glyphicon-calendar"></span> </span>
            <input type='text' name="search_arrival_date" id="search_arrival_date"  class="search-input-cal" readonly data-date-format="DD/MM/YYYY" placeholder="<?php echo lang('Check_In'); ?>"/>
          </div>
          <label style="color:red;" id="search_arrival_date_error"></label>
        </div>
        <div class="col-md-3">
          <div class='section-cal input-group date' id='datetimepicker8'> <span class="input-group-custom input-group-addon"> <span class="calender-icon glyphicon glyphicon-calendar"></span> </span>
            <input type='text' name="search_leave_date" id="search_leave_date" class="search-input-cal" readonly data-date-format="DD/MM/YYYY" placeholder="<?php echo lang('Check_Out'); ?>"/>
          </div>
          <label style="color:red;" id="search_leave_date_error"></label>
        </div>
        <div class="col-md-2">
          <input type='button' class="search-submit-cal" value="<?php echo lang('SUBMIT'); ?>"  onclick="validate_search()"/>
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
