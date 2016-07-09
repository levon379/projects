<div class="row">
  <div class="inner-page-banner"><?php echo $properties_details[0]['virtual_tour_code']; ?><!--<img class="img-responsive" src="<?php echo base_url(); ?>assets/frontend/images/about-us-banner.jpg" alt="">--></div>
</div>

<link href="<?php echo base_url(); ?>assets/frontend/css/lightbox.css" rel="stylesheet"/>

<script>
	function validate_testimonials_form(){
		var error=0;
		if($("#test_name").val().trim()==""){
			$("#test_name_error").html("<?php echo lang('Name_is_required') ?>");
			error++;
		}else{
			$("#test_name_error").html("");
		}
		
		if($("#test_email").val().trim()==""){
			$("#test_email_error").html("<?php echo lang('Email_is_required') ?>");
			error++;
		}else if($("#test_email").val().trim()!=""){
			var email=$("#test_email").val();
			var reg = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
			if (!reg.test(email)){	
				$("#test_email_error").html("<?php echo lang('Please_enter_valid_email_address') ?>");
				error++;
			}else{
				$("#test_email_error").html("");
			}
		}
		
		if($("#test_comment").val().trim()==""){
			$("#test_comment_error").html("<?php echo lang('Description_is_required') ?>");
			error++;
		}else{
			$("#test_comment_error").html("");
		}
		
		if(error>0){
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
					<div class="back_toList"> <a href="<?php echo base_url(); ?>bungalows"><?php echo lang('BACK_TO_LIST') ?></a> </div>
					<div class="social-icon-holder"> 
						<div class="reservation-btn"> <?php 
							if($_GET["status"] == "partial"){ ?>
								<p><a onclick='$("#example-popup").attr("class","popup visible"); $("html").attr("class","overlay");'><span><img src="<?php echo base_url() ?>assets/frontend/images/reservation-icon.png" alt=""></span><?php echo lang("RESERVATION"); ?></a></p><?php 
							}else{ ?>
								<p><a href="<?php echo base_url(); ?>reservation/<?php echo $this->uri->segment(2); ?>"><span><img src="<?php echo base_url() ?>assets/frontend/images/reservation-icon.png" alt=""></span><?php echo lang("RESERVATION"); ?></a></p><?php 
							} ?>
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
				<div class="tab-pane active onetab" id="red"> <?php echo $properties_details[0]['bunglow_overview']; ?> </div>
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
										<div class="mobile_table_heading table-cell-one" style="display:block; width: 100%;">
											<a style="text-decoration:none;" href="">
												<div class="row# newbder">
													<div class="col-md-2 col-sm-2 col-xs-2 border_right ">
														<p><?php echo lang('PER_NIGHT') ?> <br/><?php echo lang('1or2People') ?> <!-- | $--></p>
													</div>
												
													<div class="col-md-2 col-sm-2 col-xs-2 border_right">
														<p><?php echo lang('PER_WEEK') ?> <br/><?php echo lang('1or2People') ?> <!--| $ --></p>
													</div>

													<div class="col-md-2 col-sm-2 col-xs-2 border_right">
														<p><?php echo lang('EXTRS_NIGHT_AFTER') ?><br/><?php echo lang('1or2People') ?> </p>
													</div>
													
													<div class="col-md-2 col-sm-2 col-xs-2 border_right">
														<p><?php echo lang('PER_NIGHT') ?> <br/><?php echo lang('1or2People') ?> <!--| $--></p>
													</div>
													
													<div class="col-md-2 col-sm-2 col-xs-2 border_right">
														<p><?php echo lang('PER_WEEK') ?> <br/><?php echo lang('1or2People') ?> <!--| $ --></p>
													</div>
													
													<div class="col-md-2 col-sm-2 col-xs-2 border_right">
														<p><?php echo lang('EXTRS_NIGHT_AFTER') ?><br/><?php echo lang('1or2People') ?> </p>
													</div>
												</div>
											</a> 
										</div>

										<div class="col-lg-12">
											<div class="autumn-block">
												<p class="heading-text"></p>
											</div>
										</div>
										
										<a style="text-decoration:none;" href=""> </a>
                        <div class="table-cell table-cell-one extra_person" style="width: 100%;"><a style="text-decoration:none;" href="">
							<div class="row#"><?php
                           //print_r($properties_rates);
							$j=0;
							foreach($properties_rates as $seasons_rate){ ?>
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
						<div class="carousel-inner"><?php 
							$i=0;
							foreach($properties_images as $images){ ?>
								<div class="item <?php if($i==0){ echo "active"; } ?>"> <img style="max-height:600px;" src="<?php echo base_url(); ?>assets/upload/bunglow/<?php echo $images['image'] ?>" alt=""> </div><?php 
								$i++;
							} ?>
						</div><?php
						/* -- Controls -- */
						//If images will be more than one the slide controller will be shown
						if(count($properties_images)>1){ ?>
							<a class="icon-left btn-control carousel-control" href="#carousel-example-generic-1" role="button" data-slide="prev"> prev </a> <a class="icon-right btn-control carousel-control" href="#carousel-example-generic-1" role="button" data-slide="next"> next </a> <?php 
						} ?>
					</div>
				</div>
			</div> 
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
	function validate_search(){
		$("#search_main_error_div").hide();
		
		var error=0;
		if($("#search_keyword").val().trim()=="" && $("#search_arrival_date").val().trim()=="" && $("#search_leave_date").val().trim()==""){
			$("#search_error").html("<?php echo lang('Enter_keyword_or_dates'); ?>");
			$("#search_error").show();
			error++;
		}else{
			$("#search_error").html("");
			$("#search_error").hide();
			
			if($("#search_arrival_date").val().trim()!=""){
				var arrival_date=$("#search_arrival_date").val();
				var arival_date_arr=$("#search_arrival_date").val().split("/");
				
				var valyear=arival_date_arr[2];
				var valmonth=arival_date_arr[1];
				var valday=arival_date_arr[0];
				var today = new Date()
				var new_arrival_date= new Date(valyear,(valmonth-1),valday);
				var result=calcDate(today, new_arrival_date);
				if(result>0){
					$("#search_arrival_date_error").html("<?php echo lang('Past_date_not_allowed'); ?>");
					error++;
				}else{
					$("#search_arrival_date_error").html("");
				}
				
				if($("#search_leave_date").val().trim()==""){
					$("#search_leave_date_error").html("<?php echo lang('Check_Out_is_required'); ?>");
					error++;
				}else{
					$("#search_leave_date_error").html("");
				}
			}
			
			
			if($("#search_leave_date").val().trim()!=""){
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
				
				if(result>0){
					$("#search_leave_date_error").html("<?php echo lang('Must_be_greater_than_Check_In'); ?>");
					error++;
				}else{
					$("#search_leave_date_error").html("");
				}
				
				if($("#search_arrival_date").val().trim()==""){
					$("#search_arrival_date_error").html("<?php echo lang('Check_In_is_required'); ?>");
					error++;
				}else{
					var arrival_date=$("#search_arrival_date").val();
					var arival_date_arr=$("#search_arrival_date").val().split("/");
					
					var valyear			= arival_date_arr[2];
					var valmonth		= arival_date_arr[1];
					var valday			= arival_date_arr[0];
					var today 			= new Date()
					var new_arrival_date= new Date(valyear,(valmonth-1),valday);
					var result			= calcDate(today, new_arrival_date);
					
					if(result>0){
						$("#search_arrival_date_error").html("<?php echo lang('Past_date_not_allowed'); ?>");
						error++;
					}else{
						$("#search_arrival_date_error").html("");
					}
				}
			}
		}
		
		if(error>0){
			return false;
		}else{ 
			if($("#search_arrival_date").val().trim()!=""){
				var arrival_date_val = $("#search_arrival_date").val();
				var valyear_val 	 = arival_date_arr[2];
				var valmonth_val 	 = arival_date_arr[1];
				var valday_val   	 = arival_date_arr[0]; 
				var arrival_date_val = new Date(valyear_val ,(valmonth_val -1),valday_val );

				var today 				 = new Date();
				var minimum_arrival_date = new Date(today);
				minimum_arrival_date.setDate(today.getDate()+3);
				
				var result_compare 	 = calcDate(minimum_arrival_date, arrival_date_val);
				
				if(result_compare>0){
					$("#search_main_error_div").show();
					$("#search_main_error").html("<?php echo lang('search_message_72_hour_error'); ?>"); 
					return false;
				}else{
					date_arrival = $("#search_arrival_date").val();
					date_leave 	 = $("#search_leave_date").val();
					
					$.ajax({
						type: "POST",
						url: "<?php echo base_url();?>search/search_validation",
						data: "arrival_date="+ date_arrival +"&leave_date="+ date_leave,
						success: function(rs){
							if(rs=='1'){
								$("#details_form_search").submit();
							}else if(rs=='2'){
								$("#search_main_error_div").show();
								$("#search_main_error").html("<?php echo lang('Minimum_Two_Days'); ?>"); 
							}else if(rs=='3'){
								$("#search_main_error_div").show();
								$("#search_main_error").html("<?php echo lang('Minimum_Three_Days'); ?>"); 
							}
						}
					}); 
				} 
			}else{
				$("#details_form_search").submit();
			}
		}
	}
	

	function calcDate(date1,date2){
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
						<select name="search_keyword" class="search-input input-md" id="search_keyword">
							<option value=""> <?php echo lang('please_select') ?> </option>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
							<option value="6">6</option>
							<option value="7">7</option> 
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
						<input type='button' style="width:185px!important;" class="search-submit-cal" value="<?php echo ucfirst(lang("Search")); ?>"  onclick="validate_search()"/>
					</div>
					 
					<div class="col-md-10" style="display:none; " id="search_main_error_div">
						<label style="color:red; padding:10px; width:100%; border:3px solid #ff0000;" id="search_main_error"></label>
					</div>  
					
				</fieldset>
			</form>
		</div>
	</div>
</div><?php 


if(isset($success_message)){ ?>
	<script>
		alert('<?php echo $success_message; ?>');
	</script> <?php 
} ?>
