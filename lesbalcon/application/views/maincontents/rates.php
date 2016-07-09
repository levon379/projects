<!--<div class="row">
  <div class="inner-page-banner"> <img src="<?php echo base_url(); ?>assets/frontend/images/about-us-banner.jpg" alt=""></div>
</div>-->
<?php 
//echo "<pre>";
//print_r($default_currency['currency_id']);
?>
<!--banner end-->
<div class="row ratespage-section" style="background-color:#C9AD64">
  <div class="container">
    <h2><img class="img-responsive" src="<?php echo base_url(); ?>assets/frontend/images/bracket-left.png" alt=""><?php echo lang('RATES') ?><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-right.png" alt=""></h2>
  </div>
</div>
<script type="text/javascript">
  $(window).scroll(function() {
    if($(window).scrollTop() < 500) {
      $( ".black-bg" ).attr( "style",'background-color:#C9AD64');
      $( ".table-bg-hd" ).removeAttr( "style");
    }else{
      /*$( ".black-bg" ).attr( "style","position: fixed; width: 1690px; z-index: 999; top: 1px;" );
      $( ".table-bg-hd" ).attr( "style","position: fixed; width: 1690px; z-index: 999; top: 200px;" );*/
	  $( ".black-bg" ).attr( "style","position: fixed; width: 100%; z-index: 999; top: 1px;" );
      $( ".table-bg-hd" ).attr( "style","position: fixed; width: 100%; z-index: 999; top: 200px;" );
    }
  });

</script>
<style>
.black-bg{background-color:#C9AD64;}
</style>
<!-- style="position: fixed; width: 1690px; z-index: 999; top: 200px;" -->
<div class="row black-bg" style="background-color:#C9AD64">
  <div class="container">
    <div class="row rates-inner-content">
      <div class="col-sm-3 col-md-3">
        <div class="bunglow-row rates">
          <div class="rates-block">
            <p align="center"><img alt="" src="<?php echo base_url(); ?>assets/upload/season_icon/rates.png" width="104" style=" background: none repeat scroll 0% 0% #2ABAA4; border-radius: 55px;"></p>
            <p class="heading-text"><?php echo lang('Rates') ?></p>
            <?php if($this->session->userdata('current_lang_id') == "1") echo '<p style="font-size: 16px; color: #FFF; text-align: center; padding-top: 3px;">For one or two persons</p>'; else echo '<p style="font-size: 16px; color: #FFF; text-align: center; padding-top: 3px;">Pour 1 ou 2 personnes</p>'; ?>            
          </div>
        </div>
      </div>
      <div class="col-sm-9 col-md-9">
        <div class="row seasons-block">
          <?php
                    $i=1;
					foreach($all_seasons as $seasons)
					{
						if($seasons['id']==1)
						{
							$class1="high-season";
							$class2="summer-block";
							$datecontent = "(du 15 Décembre au 14 Avril)";
							$datecontent_en = "(from December 15th to April 14th )";
						}
						elseif($seasons['id']==2)
						{
							$class1="low-season";
							$class2="autumn-block";
							$datecontent = "(Du 15 Avril au 14 Décembre)";
							$datecontent_en = "(from April 15th to December 14th)";
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
						
						if($i<=2)
						{
							?>
          <div class="col-sm-6 col-md-6">
            <div class="row">
              <div class="<?php echo $class1; ?>">
                <div class="<?php echo $class2; ?>">
                  <p align="center"><img src="<?php echo base_url(); ?>assets/upload/season_icon/<?php echo $seasons['season_icon'] ?>" alt=""></p>
                  <p class="heading-text"><?php echo $seasons['season_name'] ?></p>
                  <?php if($this->session->userdata('current_lang_id') == "1") echo '<p style="font-size: 16px; color: #FFF; text-align: center; padding-top: 3px;">+4% Additional Stay Tax<br>'.$datecontent_en.'</p>'; else echo '<p style="font-size: 16px; color: #FFF; text-align: center; padding-top: 3px;">+4% Taxe de séjour<br>'.$datecontent.'</p>'; ?>
                </div>
              </div>
            </div>
          </div>
          <?php
						}
						$i++;
					}
					?>
					
        </div>
		
      </div>
	  
    </div>
  </div>
</div>
<div class="row table-bg-hd">
  <div class="container">
    <div class="row">
      <div class="col-sm-3 col-md-3">
        <!--<div class="bunglow-cell">
						<p>Bungalow with terrace situated at the marina or pool level 444</p>
					   </div>-->
        <div class="table-cell table-cell-heding hding-block">
          <!-- <p>Bungalow11 with terrace situated at the marina or pool level </p>-->
        </div>
      </div>
      <div class="col-sm-9 col-md-9">
        <div class="row">
          <div class="col-sm-12 col-md-12 col-xs-12">
            <div class="row">
              <div class="col-lg-12">
                <div class="autumn-block">
                  <!--<p align="center"><img src="http://dev.caribwebservices.com/projects/lesbalcons/assets/upload/season_icon/" alt=""></p>-->
                  <p class="heading-text"></p>
                </div>
              </div>
              <div class="row">
                <div class="mobile_table_heading">
                  <div class="col-md-3 col-sm-3 col-xs-3">
                    <p><?php echo lang('PER_NIGHT') ?> <br>
                      € </p>
                  </div>
                  <div class="col-md-3 col-sm-3 col-xs-3">
                    <p><?php echo lang('PER_WEEK') ?> <br>
                      €  </p>
                  </div>
                  <div class="col-md-3 col-sm-3 col-xs-3">
                    <p><?php echo lang('PER_NIGHT') ?><br>
                      € </p>
                  </div>
                  <div class="col-md-3 col-sm-3 col-xs-3">
                    <p><?php echo lang('PER_WEEK') ?> <br>
                      €  </p>
                  </div>
                </div>
              </div>
              <a style="text-decoration:none;" href=""> </a>
              <div class="table-cell table-cell-one" style="height: 100px;"><a style="text-decoration:none;" href="">
                <div class="col-lg-12">
                  <div class="row">
                    <div class="col-md-2 col-sm-2 col-xs-2 border_right no-pad-left no-pad-right top_rates_page">
                       <p>
					   <?php echo lang('PER_NIGHT') ?>
					</p>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-2 border_right no-pad-left no-pad-right top_rates_page">
                      <p><?php echo lang('PER_WEEK') ?>
					</p>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-2 border_right no-pad-left no-pad-right top_rates_page">
                      <p><?php echo lang('EXTRA_NIGHT') ?></p>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-2 border_right no-pad-left no-pad-right top_rates_page">
                      <p><?php echo lang('PER_NIGHT') ?>
					</p>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-2 border_right no-pad-left no-pad-right top_rates_page">
                      <p><?php echo lang('PER_WEEK') ?>
					 </p>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-2 border_right no-pad-left no-pad-right top_rates_page">
                      <p><?php echo lang('EXTRA_NIGHT') ?></p>
                    </div>
                  </div>
                </div>
                </a> </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row table-bg">
  <div class="container">
    <div class="row">
      <?php 
		if(count($all_rates)>0)
		{
			//echo '<pre>';print_r($all_rates);echo '</pre>';exit;
			foreach($all_rates as $rates)
			{
			
				?> 
      <div class="col-sm-3 col-md-3">
        <div class="bunglow-cell# table-cell pricepage">
          <div class="row">
            <p class="bunglow-name" style="width:123px;">
              <?php //if(strlen($rates['bunglow_name'])>15){ echo substr($rates['bunglow_name'], 0, 15)."..."; }else{ echo $rates['bunglow_name']; } 
							/*$bunglow_name = explode('<span>',htmlentities($rates['bunglow_name']));
							echo '<pre>';print_r($bunglow_name);echo '</pre>';exit;
							echo $bunglow_name[0];*/
							echo $rates['bunglow_name'];
						?>
            </p>
          </div>
        </div>
      </div>
      <div class="col-sm-9 col-md-9">
        <div class="row">
          <?php 
							/*$i=1;
							foreach($rates['bunglow_rates'] as $seasons_rate)
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
								elseif($seasons_rate['season_id']==3)
								{
									$class1="winter-block-2";
									$class2="winter-block";
								}
								elseif($seasons_rate['season_id']==4)
								{
									$class1="spring-block-2";
									$class2="spring-block";
								}
								if($rates['type']=="B")
								{
									$link=base_url()."bungalows/".$rates['slug'];
								}
								if($rates['type']=="P")
								{
									$link=base_url()."properties/".$rates['slug'];
								}
								if($i<=2)
								{*/
									?>
          <div class="col-sm-12 col-md-12 col-xs-12">
            <div class="row">
              <div class="col-lg-12">
                <div class="<?php echo $class2; ?>">
                  <!--<p align="center"><img src="<?php echo base_url(); ?>assets/upload/season_icon/<?php echo $seasons_rate['season_icon']; ?>" alt=""></p>-->
                  <p class="heading-text"><?php echo $rates['bunglow_rates']['season_name']; ?></p>
                </div>
              </div>
              <div class="row">
                <div class="mobile_table_heading">
                  <div class="col-md-3 col-sm-3 col-xs-3">
                    <p><?php echo lang('PER_NIGHT') ?> <br />
                      € </p>
                  </div>
                  <div class="col-md-3 col-sm-3 col-xs-3">
                    <p><?php echo lang('PER_WEEK') ?><br />
                      €  </p>
                  </div>
                  <div class="col-md-3 col-sm-3 col-xs-3">
                    <p><?php echo lang('PER_NIGHT') ?> <br />
                      € </p>
                  </div>
                  <div class="col-md-3 col-sm-3 col-xs-3">
                    <p><?php echo lang('PER_WEEK') ?> <br />
                      €  </p>
                  </div>
                </div>
              </div>
              <a href="<?php echo $link; ?>" style="text-decoration:none;">
              <div class="table-cell table-cell-one">
                <div class="col-lg-12">
                  <div class="row">
                    <?php
                                                 $j=1;
												foreach($rates['bunglow_rates'] as $seasons_rate)
												{
                                                ?>
                    <div class="col-md-2 col-sm-2 col-xs-2 border_right no-pad-left no-pad-right">
                      <p>
                        <?php
													//echo "&euro;"." ".$rates['bunglow_rates'][$j]['rate_per_day_euro']."&nbsp;|&nbsp;"
													//."$"." ".$rates['bunglow_rates'][$j]['rate_per_day_dollar'];
													echo "&euro;"." ".$rates['bunglow_rates'][$j]['rate_per_day_euro'];
													?>
                      </p>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-2 border_right no-pad-left no-pad-right">
                      <p>
                        <?php
                                                    echo "&euro;"." ".$rates['bunglow_rates'][$j]['rate_per_week_euro'];
													?>
                      </p>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-2 border_right no-pad-left no-pad-right">
                      <p>
                        <?php
                                                    echo "&euro;"." ".$rates['bunglow_rates'][$j]['extranight_perday_europrice'];
													?>
                      </p>
                    </div>
                    <?php
                                                $j++;
												}
												?>
                    <?php /*?><div class="col-md-6 col-sm-6 col-xs-6 border_right">
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
                                                    </div><?php */?>
                    <?php /*?><div class="col-md-4 col-sm-4 col-xs-4 border_right">
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
                                                    </div></div><?php */?>
													
						
													
                  </div>
                </div>
                </a> </div>
            </div>
            <?php
								//}
								$i++; 
							//}
							?>
							
          </div>
        </div>
      </div>

      <?php 
			}
			?>
			<!--div class="col-md-12 col-sm-12 col-xs-12 belowprice">
						<p><?php echo lang('taxe_ser') ?>4% Taxe de séjour</p>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 belowprice">
						<p><?php echo lang('taxe_rate') ?>4% Taxe de séjour</p>
						</div-->
			<?php
		}
		else 
		{
			?>
      <div class="row">
        <div class="col-sm-12 col-md-12">
          <div class="row" align="center">
            <h3><?php echo lang('No_Bungalow_Found'); ?></h3>
          </div>
        </div>
      </div>
      <?php 
		}
		?>
    </div>
  </div>
  <div style="margin-top:20px;">
				<?php echo $reservation_content[0]['pages_content']; ?>
			</div>
</div>
