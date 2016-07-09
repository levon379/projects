<div class="row">
	<div class="inner-page-banner"> <img class="img-responsive" src="<?php echo base_url(); ?>assets/frontend/images/about-us-banner.jpg" alt=""></div>
</div><?php 

if($this->session->userdata("reservation")){
	$reservation_session=$this->session->userdata("reservation");
}

if($this->session->userdata("search_details")){
	$search_session=$this->session->userdata("search_details");
} ?>
 
 
<!--banner end-->
<link href="<?php echo base_url(); ?>assets/frontend/css/lightbox.css" rel="stylesheet"/><?php

/*
<a style="cursor:pointer;" data-popup-target="#example-popup123"><label style="cursor:pointer;">Test test test test</label></a>
<div id="example-popup123" class="popup visible">
	<div class="popup-body">	
		<span class="popup-exit"></span>
		<div class="popup-content">
			<h2 class="popup-title"></h2>
			<label style="margin-top:5px;">
				Test test test dk kdkjdjfkdj kd j 
				<span style="text-decoration:underline">
					<a href="mailto:j.willemin@caribwebservices.com?subject=Contact Les Balcons Website">Click here</a>
				</span>
			</label>
		</div>
	</div>
</div>
*/ ?>


<div class="row innerpage-section" id="reservation_form_div">
	<div class="container">
		<h2><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-left.png" alt=""><?php echo lang("Reservation"); ?><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-right.png" alt=""></h2>
		<div class="row inner-content">
			
			
			<!----------------   Show messages    ---------------->
			<div id="popup-for-show-msg" class="popup">
				<div class="popup-body">	
					<span class="popup-exit"></span>
					<div class="popup-content">
						<h2 class="popup-title"></h2>
						<label style="margin-top:5px; color:#ff0000;" id="popup-show-text"> </label>
					</div>
				</div>
			</div>
			<!---------------- End Show messages ---------------->
			
      		<div class="reservation_block">
                <form id="reservation_form" class="form-login form-horizontal" action="<?php echo base_url(); ?>reservation/reservation_process" method="POST">
                    <fieldset id="short_reservation_form" > 
                    
						<div class="form-row form-group">
							<div class="col-md-4">
								<label><?php echo lang('Arrival_Date'); ?> <span style="color:red;">*</span></label>
							</div>
							
							<div class="col-md-6">
								<div class='input-group date' id='datetimepicker9'><?php
									//print_r($options_arr);die;
									if(isset($search_session)){ ?>
										<input style="cursor:auto;" name="arrival_date" id="arrival_date" type='text' class="login-input testi-input form-control input-md"  readonly value="<?php echo $search_session['arrival_date']; ?>"/> <?php
									}else{ ?> 
										<input id="arrival_date" style="cursor:auto;" name="arrival_date" type='text' class="login-input testi-input form-control input-md" data-date-format="DD/MM/YYYY" readonly value="<?php if(isset($reservation_session)){ echo $reservation_session['arrival_date']; } ?>"/> <?php
									} ?>
									<span class="input-group-custom_2 input-group-addon">
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
								</div>
								<div class="errormsg" id="arrival_date_error_text"></div>
							</div>
						</div>
				
						<div class="form-row form-group">
							<div class="col-md-4">
								<label><?php echo lang('Leave_Date'); ?> <span style="color:red;">*</span></label>
							</div>
							
							<div class="col-md-6">
								<div class='input-group date' id='datetimepicker10'><?php
									//print_r($search_session);die;
									if(isset($search_session)){ ?>
										<input name="leave_date" style="cursor:auto;" id="leave_date" type='text' class="login-input testi-input form-control input-md"  readonly value="<?php echo $search_session['leave_date']; ?>"/> <?php
									}else{ ?>
										<input name="leave_date" style="cursor:auto;" id="leave_date" type='text' class="login-input testi-input form-control input-md" data-date-format="DD/MM/YYYY" readonly value="<?php if(isset($reservation_session)){ echo $reservation_session['leave_date']; } ?>"/> <?php
									} ?> 
									<span class="input-group-custom_2 input-group-addon">
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
								</div>
								<div class="errormsg" id="leave_date_error_text"></div>
							</div>
						</div>
                    
						<div class="form-row form-group">
							<div class="col-md-4">
								<label><?php echo lang("Choose_Bungalow_Property"); ?> <span style="color:red;">*</span></label>
							</div>
							
							<div class="col-md-6"><?php 
								if(isset($selected_bungalow_id)) { 
									$bungalow_id=$selected_bungalow_id; 
								}elseif(isset($reservation_session)){ 
									$bungalow_id=$reservation_session['bungalow_id']; 
								}else{ 
									$bungalow_id=''; 
								} ?>
								
								<input type="hidden" id="cat_type" value="<?php echo isset($selected_bungalow_cat_type)?$selected_bungalow_cat_type:''; ?>" />
								<input type="hidden" id="max_person" value="<?php echo isset($selected_bungalow_person)?$selected_bungalow_person:''; ?>" />
							
								<select name="bungalow" id="bungalow" class="login-input testi-input form-control input-md" onchange="get_max_person_by_bungalow_id(this.value);">
									<option value="">--<?php echo lang('Select'); ?>--</option> <?php
									if(count($properties_arr)>0){ ?>
										<optgroup style="color:#fff;" label="<?php echo lang('Properties') ?>"><?php 
										foreach($properties_arr as $properties){ ?>
											<option value="<?php echo $properties['id'] ?>"  <?php if($bungalow_id==$properties['id']){ echo "selected"; } ?> ><?php echo $properties['bunglow_name'] ?></option> <?php 
										}
									}  
									
									if(count($bungalows_arr)>0) { ?>
										<optgroup style="color:#000;" label="<?php echo lang('Bungalows') ?>"> <?php 
										foreach($bungalows_arr as $bungalow) { ?>
											<option value="<?php echo $bungalow['id'] ?>"  <?php if($bungalow_id==$bungalow['id']){ echo "selected"; } ?>><?php echo $bungalow['bunglow_name'] ?></option> <?php 
										}
									} ?>
								</select>
								
								<div class="errormsg" id="bungalow_error_text"></div>
							</div>
						</div>
						
						<div class="form-row form-group" id="options_div" style="<?php //if(isset($options_arr)){ echo ""; }else{ echo "display:none;"; } ?>">
							<!-- Div for options fetched by ajax -->
					 	
							<div class="">
								<div class="col-md-4">
									<label><?php echo lang('no_of_adult'); ?><span style="color:red;">*</span></label>
								</div>
								<div class="col-md-6">
									<select name="no_of_adult" id="no_of_adult" class="login-input testi-input form-control input-md" onchange="autoPopulateAdult();">
										<option value="">--<?php echo lang('Select_bungalow'); ?>--</option>
										<?php for($i = 1;$i<=2;$i++){?> 
											<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
										<?php } ?>
									</select>
									<div class="errormsg" id="error_no_of_adult"></div>
								</div>
							</div>
							
							<div id="div_no_of_extra_real_adult">
								<div class="col-md-4">
									<label><?php echo lang('no_of_extra_real_adult'); ?></label>
								</div>
								<div class="col-md-6">
									<select name="no_of_extra_real_adult" id="no_of_extra_real_adult" class="login-input testi-input form-control input-md" onchange="autoPopulateExtraRealAdult(this.value);">
										<option value="">--<?php echo lang('Select'); ?>--</option> 
									</select>
									<div class="errormsg" id=""></div>
								</div>
							</div>
							
							<div id="div_no_of_extra_adult">
								<div class="col-md-4">
									<label><?php echo lang('no_of_extra_adult'); ?></label>
								</div>
								<div class="col-md-6">
									<select name="no_of_extra_adult" id="no_of_extra_adult" class="login-input testi-input form-control input-md" onchange="autoPopulateExtraAdult(this.value);">
										<option value="">--<?php echo lang('Select'); ?>--</option> 
									</select>
									<div class="errormsg" id=""></div>
								</div>
							</div>
					
							<div id="div_no_of_extra_kid">
								<div class="col-md-4">
									<label><?php echo lang('no_of_extra_kid'); ?></label>
								</div>
								<div class="col-md-6">
									<select name="no_of_extra_kid" id="no_of_extra_kid" class="login-input testi-input form-control input-md" onchange="autoPopulateExtraKid(this.value);">
										<option value="">--<?php echo lang('Select'); ?>--</option> 
									</select>
									<div class="errormsg" id=""></div>
								</div>
							</div>
					
							<div id="div_no_of_folding_bed_kid">
								<div class="col-md-4">
									<label><?php echo lang('no_of_folding_bed_kid'); ?></label>
								</div>
								
								<div class="col-md-6">
									<select name="no_of_folding_bed_kid" id="no_of_folding_bed_kid" class="login-input testi-input form-control input-md" onchange="autoPopulateFoldingBedKid(this.value);">
										<option value="">--<?php echo lang('Select'); ?>--</option> 
									</select>
									<div class="errormsg" id=""></div>
								</div>
							</div>
							
							<div id="div_no_of_folding_bed_adult">
								  <div class="col-md-4">
									<label><?php echo lang('no_of_folding_bed_adult'); ?></label>
								  </div>
								  <div class="col-md-6">
									<select name="no_of_folding_bed_adult" id="no_of_folding_bed_adult" class="login-input testi-input form-control input-md" onchange="autoPopulateFoldingBedAdult(this.value);">
										<option value="">--<?php echo lang('Select'); ?>--</option> 
									</select>
									<div class="errormsg" id=""></div>
								  </div>
							</div>
					
							<div id="div_no_of_baby_bed">
								  <div class="col-md-4">
									<label><?php echo lang('no_of_baby_bed'); ?></label>
								  </div>
								  <div class="col-md-6">
									<select name="no_of_baby_bed" id="no_of_baby_bed" class="login-input testi-input form-control input-md">
										<option value="">--<?php echo lang('Select'); ?>--</option> 
									</select>
									<div class="errormsg" id=""></div>
								  </div>
							</div>
						</div>
					
				   
						<div class="errormsg"></div>
						<!-- Button -->
						<div class="form-row form-group">
							<div class="col-md-10">
								<div class="row">
									<div class="col-md-12">
										<div class="sub-btn">
											<input id="textinput" name="textinput" class="submit-button btn btn-default" type="button" value="<?php echo lang('CONTIUNE'); ?>" onclick="check_availability()" style="float:right">
										</div>
										<div class="sub-btn" id="reservation_progress" style="display:none;"> 
											<em style=" float:left ; padding-right:20px; padding-top:10px;"><?php echo lang('Please_wait') ?>.....</em> 
											<span style="margin-top:15px; float:left"><img  src="<?php echo base_url(); ?>assets/frontend/images/loading.gif" style=" float:left"></span>
										</div>
									</div>
								</div>       
							</div>
						</div>

						<div id="example-popup" class="popup">
							<div class="popup-body">	
								<span class="popup-exit" onclick='$("#example-popup").attr("class","popup"); $("html").attr("class","");'></span>
								<div class="popup-content">
									<h2 class="popup-title"></h2>
									<label style="margin-top:5px;"><?php echo lang('ReservationBungalowNotAvailable'); ?></label>
								</div>
							</div>
						</div>

					</fieldset>
					
                    <fieldset id="big_reservation_form" style="display: none;">
                    	
                    	<div class="form-row form-group">
	                      <div class="col-md-4">
							<label><?php echo lang("Bungalow_Property"); ?>:</label>
	                      </div>
	                      <div class="col-md-6">
	                      	<span id="selected_bungalow"></span>
	                      </div>
                      	</div>
                      	
                      	<div class="form-row form-group">
	                      <div class="col-md-4">
							<label><?php echo lang("Arrival_Date"); ?>:</label>
	                      </div>
	                      <div class="col-md-6">
	                      	<span id="selected_arrival_date"></span>
	                      </div>
                      	</div>
                      	
                      	<div class="form-row form-group">
	                      <div class="col-md-4">
							<label><?php echo lang("Leave_Date"); ?>:</label>
	                      </div>
	                      <div class="col-md-6">
	                      	<span id="selected_leave_date"></span>
	                      </div>
                      	</div>
                      	
                      	<div class="form-row form-group">
	                      <div class="col-md-4">
							<label><?php echo lang('no_of_adult'); ?><?php //echo lang("Person"); ?>:</label>
	                      </div>
	                      <div class="col-md-6">
	                      	<span id="selected_persons_adult"></span>
	                      </div>
                      	</div>
                      	
                      	<div class="form-row form-group" id="div_extra_real_adult">
	                      <div class="col-md-4">
							<label><?php echo lang('no_of_extra_real_adult'); ?>: </label>
	                      </div>
	                      <div class="col-md-6">
	                      	<span id="selected_person_extra_real_adult"></span>
	                      </div>
                      	</div>

						<div class="form-row form-group" id="div_extra_adult">
	                      <div class="col-md-4">
							<label><?php echo lang('no_of_extra_adult'); ?>: </label>
	                      </div>
	                      <div class="col-md-6">
	                      	<span id="selected_person_extra_adult"></span>
	                      </div>
                      	</div>
                      	
                      	<div class="form-row form-group" id="div_extra_kid">
	                      <div class="col-md-4">
							<label><?php echo lang('no_of_extra_kid'); ?>: </label>
	                      </div>
	                      <div class="col-md-6">
	                      	<span id="selected_person_extra_kid"></span>
	                      </div>
                      	</div>
                      	

						<div class="form-row form-group" id="div_folding_kid">
	                      <div class="col-md-4">
							<label><?php echo lang('no_of_folding_bed_kid'); ?>: </label>
	                      </div>
	                      <div class="col-md-6">
	                      	<span id="selected_person_folding_kid"></span>
	                      </div>
                      	</div>

						<div class="form-row form-group" id="div_folding_adult">
	                      <div class="col-md-4">
							<label><?php echo lang('no_of_folding_bed_adult'); ?>: </label>
	                      </div>
	                      <div class="col-md-6">
	                      	<span id="selected_person_folding_adult"></span>
	                      </div>
                      	</div>
                      	
                      	<div class="form-row form-group" id="div_baby_bed">
	                      <div class="col-md-4">
							<label><?php echo lang('no_of_baby_bed'); ?>: </label>
	                      </div>
	                      <div class="col-md-6">
	                      	<span id="selected_person_baby_bed"></span>
	                      </div>
                      	</div>

                      	<div class="form-row form-group">
	                      <div class="col-md-4">
							<label><?php echo lang('price_of_the_stay'); ?>: </label>
	                      </div>
	                      <div class="col-md-6">
	                      	<span id="stay_price"></span>
	                      </div>
                      	</div>
                      	
                      	<div class="form-row form-group" id="div_price">
	                      <div class="col-md-4">
							<label><?php echo lang('price_of_extra_person'); ?>: </label>
	                      </div>
	                      <div class="col-md-6">
	                      	<span id="option_price"></span>
	                      </div>
                      	</div>
                      	
                      	<div class="form-row form-group">
	                      <div class="col-md-4">
							<label><?php echo lang('tax'); ?>: </label>
	                      </div>
	                      <div class="col-md-6">
	                      	<span id="tax">4%</span>
	                      </div>
                      	</div>

                      	<div class="form-row form-group">
	                      <div class="col-md-4">
							<label><?php echo lang('Total'); ?>: </label>
	                      </div>
	                      <div class="col-md-6">
	                      	<span id="selected_price"></span>
	                      </div>
                      	</div>
                      	
                      	<div class="form-row form-group">
							<div class="col-md-10">
								<div class="row">
									<div class="col-md-6">
										<input id="textinput" name="textinput" class="submit-button btn btn-default" type="button" value="<?php echo lang('BACK'); ?>" style="float:left;" onclick="switch_forms_back();">
									</div>
									<div class="col-md-6">
										<div class="sub-btn">
											<input id="textinput" name="textinput" class="submit-button btn btn-default" type="submit" value="<?php echo lang('CONTIUNE'); ?>" style="float:right">
										</div>
									</div>
								  </div>       

							 </div>
	                   </div>
                      	
                    </fieldset>
                </form>
				
				<div class="popup-overlay" style="z-index:999;"></div>
            </div>
			
			<div style="margin-top:20px;">
			<?php 
				//session_start();
			//echo '<pre>';print_r($_SESSION);echo '</pre>';?>
				<?php echo $reservation_content[0]['pages_content']; ?>
			</div>
			
		</div>
	</div>
</div>


 

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

	
	
	$(document).ready(function() {
		$("#div_no_of_extra_real_adult").hide();
		$("#div_no_of_extra_adult").hide();
		$("#div_no_of_extra_kid").hide();
		$("#div_no_of_folding_bed_kid").hide();
		$("#div_no_of_folding_bed_adult").hide();
		$("#div_no_of_baby_bed").hide();
	});
	
	
	function autoPopulateAdult(){
		var cattype = $("#cat_type").val();
		var bungalow_id = $("#bungalow").val();
		var max_person = $("#max_person").val();
		var str1 = str2 = str3 = str4 = str5 = str6 = '<option value="">--<?php echo lang('Select'); ?>--</option>';

		if(cattype == "A"){
			for(var i=0;i<2;i++) {
				str3 += "<option value='"+i+"'>"+i+"</option>";
				str4 += "<option value='"+i+"'>"+i+"</option>";	
			}		
			for(var i=0;i<3;i++) str5 += "<option value='"+i+"'>"+i+"</option>";

			$("#div_no_of_extra_real_adult").hide();
			$("#div_no_of_extra_adult").hide();
			$("#div_no_of_extra_kid").hide();
			$("#div_no_of_folding_bed_kid").show();
			$("#div_no_of_folding_bed_adult").show();
			$("#div_no_of_baby_bed").show();

			$("#no_of_folding_bed_kid").html(str3);
			$("#no_of_folding_bed_adult").html(str4);
			$("#no_of_baby_bed").html(str5);
		}
		if(cattype == "B"){
			for(var i=0;i<4;i++){
				str1 += "<option value='"+i+"'>"+i+"</option>";
				str2 += "<option value='"+i+"'>"+i+"</option>";
			}
			for(var i=0;i<2;i++){
				str5 += "<option value='"+i+"'>"+i+"</option>";
			}

			$("#div_no_of_extra_real_adult").hide();
			$("#div_no_of_extra_adult").show();
			$("#div_no_of_extra_kid").show();
			$("#div_no_of_folding_bed_kid").hide();
			$("#div_no_of_folding_bed_adult").hide();
			$("#div_no_of_baby_bed").show();

			$("#no_of_extra_adult").html(str1);
			$("#no_of_extra_kid").html(str2);
			
			$("#no_of_baby_bed").html(str5);
		}		
		if(cattype == "C"){
			for(var i=0;i<3;i++){
				str1 += "<option value='"+i+"'>"+i+"</option>";
				str2 += "<option value='"+i+"'>"+i+"</option>";
			}
			for(var i=0;i<2;i++){
				str3 += "<option value='"+i+"'>"+i+"</option>";
				str4 += "<option value='"+i+"'>"+i+"</option>";
				str5 += "<option value='"+i+"'>"+i+"</option>";
			}

			$("#div_no_of_extra_real_adult").hide();
			$("#div_no_of_extra_adult").show();
			$("#div_no_of_extra_kid").show();
			$("#div_no_of_folding_bed_kid").show();
			$("#div_no_of_folding_bed_adult").show();
			$("#div_no_of_baby_bed").show();

			$("#no_of_extra_adult").html(str1);
			$("#no_of_extra_kid").html(str2);
			$("#no_of_folding_bed_kid").html(str3);
			$("#no_of_folding_bed_adult").html(str4);
			$("#no_of_baby_bed").html(str5);
		}		
		if(cattype == "D"){
			for(var i=0;i<3;i++){
				str1 += "<option value='"+i+"'>"+i+"</option>";
				str2 += "<option value='"+i+"'>"+i+"</option>";
			}
			for(var i=0;i<2;i++){
				str6 += "<option value='"+i+"'>"+i+"</option>";
				str5 += "<option value='"+i+"'>"+i+"</option>";
			}				


			$("#div_no_of_extra_real_adult").show();
			$("#div_no_of_extra_adult").show();
			$("#div_no_of_extra_kid").show();
			$("#div_no_of_folding_bed_kid").hide();
			$("#div_no_of_folding_bed_adult").hide();
			$("#div_no_of_baby_bed").show();

			$("#no_of_extra_real_adult").html(str6);
			$("#no_of_extra_adult").html(str1);
			$("#no_of_extra_kid").html(str2);				
			$("#no_of_baby_bed").html(str5);
		}	
		if(cattype == "E"){
			for(var i=0;i<3;i++){
				str1 += "<option value='"+i+"'>"+i+"</option>";
				str2 += "<option value='"+i+"'>"+i+"</option>";
				str5 += "<option value='"+i+"'>"+i+"</option>";
			}
			for(var i=0;i<2;i++){
				str3 += "<option value='"+i+"'>"+i+"</option>";
				str4 += "<option value='"+i+"'>"+i+"</option>";
			}

			$("#div_no_of_extra_real_adult").hide();
			$("#div_no_of_extra_adult").show();
			$("#div_no_of_extra_kid").show();
			$("#div_no_of_folding_bed_kid").show();
			$("#div_no_of_folding_bed_adult").show();
			$("#div_no_of_baby_bed").show();

			$("#no_of_extra_adult").html(str1);
			$("#no_of_extra_kid").html(str2);
			$("#no_of_folding_bed_kid").html(str3);
			$("#no_of_folding_bed_adult").html(str4);
			$("#no_of_baby_bed").html(str5);
		}
		if(cattype == "F"){
			for(var i=0;i<3;i++) {
				str1 += "<option value='"+i+"'>"+i+"</option>";
				str2 += "<option value='"+i+"'>"+i+"</option>";	
			}		
			for(var i=0;i<2;i++) str5 += "<option value='"+i+"'>"+i+"</option>";

			$("#div_no_of_extra_real_adult").hide();
			$("#div_no_of_extra_adult").show();
			$("#div_no_of_extra_kid").show();
			$("#div_no_of_folding_bed_kid").hide();
			$("#div_no_of_folding_bed_adult").hide();
			$("#div_no_of_baby_bed").show();

			$("#no_of_extra_adult").html(str1);
			$("#no_of_extra_kid").html(str2);
			$("#no_of_baby_bed").html(str5);
		}
		if(cattype == "G"){
			$("#div_no_of_extra_real_adult").hide();
			$("#div_no_of_extra_adult").hide();
			$("#div_no_of_extra_kid").hide();
			$("#div_no_of_folding_bed_kid").hide();
			$("#div_no_of_folding_bed_adult").hide();
			$("#div_no_of_baby_bed").hide();
		}

		/*$("#no_of_extra_adult").html(str1);
		$("#no_of_extra_kid").html(str2);
		$("#no_of_folding_bed_kid").html(str3);
		$("#no_of_folding_bed_adult").html(str4);
		$("#no_of_baby_bed").html(str5);*/
	}

	function autoPopulateExtraRealAdult(value){
		var str1 = str2 = str3 = str4 = str5 = str6 = '<option value="">--<?php echo lang('Select'); ?>--</option>';
		if(value < 1){
			for(var i=0;i<3;i++) {
				str1 += "<option value='"+i+"'>"+i+"</option>";
				str2 += "<option value='"+i+"'>"+i+"</option>";	
			}
			for(var i=0;i<3;i++) str5 += "<option value='"+i+"'>"+i+"</option>";

			$("#div_no_of_extra_adult").show();
			$("#div_no_of_extra_kid").show();
			$("#div_no_of_folding_bed_kid").hide();
			$("#div_no_of_folding_bed_adult").hide();
			$("#div_no_of_baby_bed").show();

			$("#no_of_extra_adult").html(str1);
			$("#no_of_extra_kid").html(str2);
			$("#no_of_baby_bed").html(str5);
		} else {
			for(var i=0;i<2;i++) str5 += "<option value='"+i+"'>"+i+"</option>";
			$("#div_no_of_extra_adult").hide();
			$("#div_no_of_extra_kid").hide();
			$("#no_of_baby_bed").html(str5);
		}
	}

	function autoPopulateExtraAdult(value){
		var cattype = $("#cat_type").val();
		var bungalow_id = $("#bungalow").val();
		var max_person = $("#max_person").val();
		var str1 = str2 = str3 = str4 = str5 = str6 = '<option value="">--<?php echo lang('Select'); ?>--</option>';

		if(cattype == "A"){
			if(value < 1){
				for(var i=0;i<2;i++) str4 += "<option value='"+i+"'>"+i+"</option>";	

				$("#div_no_of_folding_bed_adult").show();
				$("#no_of_folding_bed_adult").html(str4);
			} else {
				for(var i=0;i<2;i++) str5 += "<option value='"+i+"'>"+i+"</option>";

				$("#div_no_of_folding_bed_adult").hide();
				
			}
		}
		if(cattype == "B"){
			for(var i=0;i<=(3-value);i++){
				str2 += "<option value='"+i+"'>"+i+"</option>";
			}
			for(var i=0;i<2;i++){
				str5 += "<option value='"+i+"'>"+i+"</option>";
			}

			$("#div_no_of_extra_kid").show();
			$("#div_no_of_baby_bed").show();

			$("#no_of_extra_kid").html(str2);
			$("#no_of_baby_bed").html(str5);
		}		
		if(cattype == "C"){
			for(var i=0;i<=(2-value);i++){
				str2 += "<option value='"+i+"'>"+i+"</option>";
			}
			for(var i=0;i<2;i++){
				str3 += "<option value='"+i+"'>"+i+"</option>";
				str4 += "<option value='"+i+"'>"+i+"</option>";
				str5 += "<option value='"+i+"'>"+i+"</option>";
			}

			if(value == 2) $("#div_no_of_extra_kid").hide();
			else $("#div_no_of_extra_kid").show();
			
			$("#div_no_of_folding_bed_kid").show();
			$("#div_no_of_folding_bed_adult").show();
			$("#div_no_of_baby_bed").show();

			$("#no_of_extra_kid").html(str2);
			$("#no_of_folding_bed_kid").html(str3);
			$("#no_of_folding_bed_adult").html(str4);
			$("#no_of_baby_bed").html(str5);
		}		
		if(cattype == "D"){
			for(var i=0;i<=(2-value);i++){
				str2 += "<option value='"+i+"'>"+i+"</option>";
			}
			for(var i=0;i<2;i++){
				str5 += "<option value='"+i+"'>"+i+"</option>";
			}

			$("#div_no_of_extra_kid").show();
			$("#div_no_of_baby_bed").show();

			$("#no_of_extra_kid").html(str2);
			$("#no_of_baby_bed").html(str5);
		}	
		if(cattype == "E"){
			for(var i=0;i<=(2-value);i++){
				str2 += "<option value='"+i+"'>"+i+"</option>";
			}
			for(var i=0;i<2;i++){
				str3 += "<option value='"+i+"'>"+i+"</option>";
				str4 += "<option value='"+i+"'>"+i+"</option>";
			}
			for(var i=0;i<3;i++) str5 += "<option value='"+i+"'>"+i+"</option>";

			$("#div_no_of_extra_kid").show();
			$("#div_no_of_folding_bed_kid").show();
			$("#div_no_of_folding_bed_adult").show();
			$("#div_no_of_baby_bed").show();

			$("#no_of_extra_kid").html(str2);
			$("#no_of_folding_bed_kid").html(str3);
			$("#no_of_folding_bed_adult").html(str4);
			$("#no_of_baby_bed").html(str5);
		}
		if(cattype == "F"){
			for(var i=0;i<=(2-value);i++){
				str2 += "<option value='"+i+"'>"+i+"</option>";
			}
			for(var i=0;i<2;i++) str5 += "<option value='"+i+"'>"+i+"</option>";

			$("#div_no_of_extra_kid").show();
			$("#div_no_of_baby_bed").show();

			$("#no_of_extra_kid").html(str2);
			$("#no_of_baby_bed").html(str5);
		}

		/*$("#no_of_extra_adult").html(str1);
		$("#no_of_extra_kid").html(str2);
		$("#no_of_folding_bed_kid").html(str3);
		$("#no_of_folding_bed_adult").html(str4);
		$("#no_of_baby_bed").html(str5);*/
	}

	function autoPopulateExtraKid(value){
		var cattype = $("#cat_type").val();
		var bungalow_id = $("#bungalow").val();
		var max_person = $("#max_person").val();
		var str1 = str2 = str3 = str4 = str5 = str6 = '<option value="">--<?php echo lang('Select'); ?>--</option>';

		if(cattype == "A"){
			if(value < 1){
				for(var i=0;i<3;i++) str5 += "<option value='"+i+"'>"+i+"</option>";		
			} else {
				for(var i=0;i<2;i++) str5 += "<option value='"+i+"'>"+i+"</option>";
			}

			$("#no_of_baby_bed").html(str5);
		}
		if(cattype == "B"){
			for(var i=0;i<2;i++){
				str5 += "<option value='"+i+"'>"+i+"</option>";
			}
			$("#no_of_baby_bed").html(str5);
		}		
		if(cattype == "C"){
			for(var i=0;i<2;i++){
				str3 += "<option value='"+i+"'>"+i+"</option>";
				str4 += "<option value='"+i+"'>"+i+"</option>";
				str5 += "<option value='"+i+"'>"+i+"</option>";
			}
			$("#no_of_folding_bed_kid").html(str3);
			$("#no_of_folding_bed_adult").html(str4);
			$("#no_of_baby_bed").html(str5);
		}		
		if(cattype == "D"){
			for(var i=0;i<2;i++){
				str5 += "<option value='"+i+"'>"+i+"</option>";
			}
			$("#no_of_baby_bed").html(str5);
		}	
		if(cattype == "E"){
			for(var i=0;i<2;i++){
				str3 += "<option value='"+i+"'>"+i+"</option>";
				str4 += "<option value='"+i+"'>"+i+"</option>";
			}			
			for(var i=0;i<3;i++) str5 += "<option value='"+i+"'>"+i+"</option>";

			$("#no_of_folding_bed_kid").html(str3);
			$("#no_of_folding_bed_adult").html(str4);
			$("#no_of_baby_bed").html(str5);
		}
		if(cattype == "F"){
			for(var i=0;i<2;i++){
				str5 += "<option value='"+i+"'>"+i+"</option>";
			}
			$("#no_of_baby_bed").html(str5);
		}

		/*$("#no_of_extra_adult").html(str1);
		$("#no_of_extra_kid").html(str2);
		$("#no_of_folding_bed_kid").html(str3);
		$("#no_of_folding_bed_adult").html(str4);
		$("#no_of_baby_bed").html(str5);*/
	}

	function autoPopulateFoldingBedKid(value){
		var cattype = $("#cat_type").val();
		var bungalow_id = $("#bungalow").val();
		var max_person = $("#max_person").val();
		var str1 = str2 = str3 = str4 = str5 = str6 = '<option value="">--<?php echo lang('Select'); ?>--</option>';

		if(cattype == "A"){
			if(value < 1){
				for(var i=0;i<2;i++) str4 += "<option value='"+i+"'>"+i+"</option>";	
				for(var i=0;i<3;i++) str5 += "<option value='"+i+"'>"+i+"</option>";		

				$("#div_no_of_folding_bed_adult").show();
				$("#no_of_folding_bed_adult").html(str4);
				$("#no_of_baby_bed").html(str5);
			} else {
				for(var i=0;i<2;i++) str5 += "<option value='"+i+"'>"+i+"</option>";

				$("#div_no_of_folding_bed_adult").hide();
				$("#no_of_baby_bed").html(str5);
			}
		}
		if(cattype == "B"){
			for(var i=0;i<(3-value);i++){
				str2 += "<option value='"+i+"'>"+i+"</option>";
			}
			for(var i=0;i<2;i++){
				str5 += "<option value='"+i+"'>"+i+"</option>";
			}

			$("#no_of_extra_kid").html(str2);
			$("#no_of_baby_bed").html(str5);
		}		
		if(cattype == "C"){
			if(value < 1){
				for(var i=0;i<2;i++){
					str4 += "<option value='"+i+"'>"+i+"</option>";
					str5 += "<option value='"+i+"'>"+i+"</option>";
					$("#div_no_of_folding_bed_adult").show();
					$("#no_of_folding_bed_adult").html(str4);
				}
			}else{
				for(var i=0;i<2;i++) str5 += "<option value='"+i+"'>"+i+"</option>";
				$("#div_no_of_folding_bed_adult").hide();
			}
			$("#no_of_baby_bed").html(str5);
		}		
		if(cattype == "D"){
			for(var i=0;i<3;i++){
				str1 += "<option value='"+i+"'>"+i+"</option>";
				str2 += "<option value='"+i+"'>"+i+"</option>";
			}
			for(var i=0;i<2;i++){
				str3 += "<option value='"+i+"'>"+i+"</option>";
				str4 += "<option value='"+i+"'>"+i+"</option>";
				str5 += "<option value='"+i+"'>"+i+"</option>";
			}
		}	
		if(cattype == "E"){
			if(value < 1){
				for(var i=0;i<2;i++) str4 += "<option value='"+i+"'>"+i+"</option>";	
				for(var i=0;i<3;i++) str5 += "<option value='"+i+"'>"+i+"</option>";		

				$("#div_no_of_folding_bed_adult").show();
				$("#no_of_folding_bed_adult").html(str4);
				$("#no_of_baby_bed").html(str5);
			} else {
				for(var i=0;i<2;i++) str5 += "<option value='"+i+"'>"+i+"</option>";

				$("#div_no_of_folding_bed_adult").hide();
				
				$("#no_of_baby_bed").html(str5);
			}
		}
		if(cattype == "F"){
		}

		/*$("#no_of_extra_adult").html(str1);
		$("#no_of_extra_kid").html(str2);
		$("#no_of_folding_bed_kid").html(str3);
		$("#no_of_folding_bed_adult").html(str4);
		$("#no_of_baby_bed").html(str5);*/
	}

	function autoPopulateFoldingBedAdult(value){
		var cattype = $("#cat_type").val();
		var bungalow_id = $("#bungalow").val();
		var max_person = $("#max_person").val();
		var str1 = str2 = str3 = str4 = str5 = str6 = '<option value="">--<?php echo lang('Select'); ?>--</option>';

		if(cattype == "A"){
			if(value < 1){
				for(var i=0;i<3;i++) str5 += "<option value='"+i+"'>"+i+"</option>";		
			} else {
				for(var i=0;i<2;i++) str5 += "<option value='"+i+"'>"+i+"</option>";
			}

			$("#no_of_baby_bed").html(str5);
		}
		if(cattype == "B"){
			for(var i=0;i<2;i++){
				str5 += "<option value='"+i+"'>"+i+"</option>";
			}
			$("#no_of_baby_bed").html(str5);
		}		
		if(cattype == "C"){
			for(var i=0;i<2;i++){
				str5 += "<option value='"+i+"'>"+i+"</option>";
			}
			$("#no_of_baby_bed").html(str5);
		}		
		if(cattype == "D"){
			for(var i=0;i<3;i++){
				str1 += "<option value='"+i+"'>"+i+"</option>";
				str2 += "<option value='"+i+"'>"+i+"</option>";
			}
			for(var i=0;i<2;i++){
				str3 += "<option value='"+i+"'>"+i+"</option>";
				str4 += "<option value='"+i+"'>"+i+"</option>";
				str5 += "<option value='"+i+"'>"+i+"</option>";
			}
		}	
		if(cattype == "E"){
			if(value < 1){
				for(var i=0;i<3;i++) str5 += "<option value='"+i+"'>"+i+"</option>";		
			} else {
				for(var i=0;i<2;i++) str5 += "<option value='"+i+"'>"+i+"</option>";
			}

			$("#no_of_baby_bed").html(str5);
		}
		if(cattype == "F"){
		}

		/*$("#no_of_extra_adult").html(str1);
		$("#no_of_extra_kid").html(str2);
		$("#no_of_folding_bed_kid").html(str3);
		$("#no_of_folding_bed_adult").html(str4);
		$("#no_of_baby_bed").html(str5);*/
	}

	function fill_reservation_form( price ){
		$("#div_extra_real_adult").hide();
		$("#div_extra_adult").hide();
		$("#div_extra_kid").hide();
		$("#div_folding_kid").hide();
		$("#div_folding_adult").hide();
		$("#div_baby_bed").hide();
		$("#div_price").hide();

		$('#selected_bungalow').html( $('#bungalow option:selected').text() );
		$('#selected_arrival_date').html( $('#arrival_date').val() );
		$('#selected_leave_date').html( $('#leave_date').val() ); 

		var val1 = ($('#no_of_adult option:selected').text() != "--Select--")?$('#no_of_adult option:selected').text():"0";
		var val2 = ($('#no_of_extra_real_adult option:selected').text() != "--Select--")?$('#no_of_extra_real_adult option:selected').text():"0";
		var val3 = ($('#no_of_extra_adult option:selected').text() != "--Select--")?$('#no_of_extra_adult option:selected').text():"0";
		var val4 = ($('#no_of_extra_kid option:selected').text() != "--Select--")?$('#no_of_extra_kid option:selected').text():"0";
		var val5 = ($('#no_of_folding_bed_kid option:selected').text()  != "--Select--")?$('#no_of_folding_bed_kid option:selected').text():"0";
		var val6 = ($('#no_of_folding_bed_adult option:selected').text()  != "--Select--")?$('#no_of_folding_bed_adult option:selected').text():"0";
		var val7 = ($('#no_of_baby_bed option:selected').text()  != "--Select--")?$('#no_of_baby_bed option:selected').text():"0";

		$('#selected_persons_adult').html( val1 );
		$('#selected_person_extra_real_adult').html( val2);
		$('#selected_person_extra_adult').html( val3 );
		$('#selected_person_extra_kid').html( val4 );
		$('#selected_person_folding_kid').html(val5);
		$('#selected_person_folding_adult').html( val6);
		$('#selected_person_baby_bed').html(val7);
		//$('#selected_persons_count').html( $('#max_person').val() );

		options = [];
		$('input.options').each( function(i,o){
		  if( this.checked ){
			  k = "#l_" + $(this).attr('id');
			  options.push( $(k).text() );
		  }
		} );

		var tot = 0;
		if(val2 > 0) tot = (parseInt(val2) * 15 * parseInt(price['day_diff']));
		if(val3 > 0) tot += (parseInt(val3) * 15 * parseInt(price['day_diff']));
		if(val6 > 0) tot += (parseInt(val6) * 15 * parseInt(price['day_diff']));
		var total = parseInt( price['stay_euro'] ) + tot + (( parseInt( price['stay_euro'] ) + tot ) * 4 / 100 );

		//$('#selected_options').html( options.join() );
		$('#stay_price').html( price['stay_euro'] + ' EUR');
		$('#option_price').html( tot + ' EUR');		
		$('#selected_price').html( total + ' EUR');

		if(val2 > 0) $("#div_extra_real_adult").show();
		if(val3 > 0) $("#div_extra_adult").show();
		if(val4 > 0) $("#div_extra_kid").show();
		if(val5 > 0) $("#div_folding_kid").show();
		if(val6 > 0) $("#div_folding_adult").show();
		if(val7 > 0) $("#div_baby_bed").show();
		if(tot > 0) $("#div_price").show();
	}

	function switch_forms_back(){
		$('#short_reservation_form').show();
		$('#big_reservation_form').hide();
	}

 
	function show_loading(){
		$('.sub-btn').first().hide()
		$('#reservation_progress').show();
	}
	
	function hide_loading(){
		$('#reservation_progress').hide();
		$('.sub-btn').first().show()
	}

	
	function calcDate(date1,date2) {
		var diff = Math.floor(date1.getTime() - date2.getTime());
		var day = 1000 * 60 * 60 * 24;
		var days = Math.floor(diff/day);
		var months = Math.floor(days/31);
		var years = Math.floor(months/12);
		return days;
	}

	function check_availability(){
		if($('#arrival_date').val() == "" || $('#leave_date').val() == "" || $('#bungalow').val() == "" || $('#no_of_adult').val() == ""){
			hide_loading();
			if($('#arrival_date').val() == "") $("#arrival_date_error_text").html("<?php echo lang("date_error_message"); ?>");
			if($('#leave_date').val() == "") $("#leave_date_error_text").html("<?php echo lang("date_error_message"); ?>");
			if($('#bungalow').val() == "") $("#bungalow_error_text").html("<?php echo lang("bungalow_error_message"); ?>");
			if($('#no_of_adult').val() == "") $("#error_no_of_adult").html("<?php echo lang("adult_error_message"); ?>");
			return;
			//alert( "This bungalow is unavailable. Please <span style='text-decoration:underline'><a href='mailto:j.willemin@caribwebservices.com?subject=Contact Les Balcons Website'>contact us</a></span> for more informations." );
		}else{
			var arrival_date_val = $("#arrival_date").val();
			var arival_date_arr	 = $("#arrival_date").val().split("/");
			var valyear_val 	 = arival_date_arr[2];
			var valmonth_val 	 = arival_date_arr[1];
			var valday_val   	 = arival_date_arr[0]; 
			var arrival_date_val = new Date(valyear_val ,(valmonth_val -1),valday_val );

			var today 				 = new Date();
			var minimum_arrival_date = new Date(today);
			minimum_arrival_date.setDate(today.getDate()+3);
			
			var result_compare 	 = calcDate(minimum_arrival_date, arrival_date_val);
			
			if(result_compare>0){ 
				$('html').addClass('overlay'); 
				$("#popup-for-show-msg").addClass('visible');  
				$("#popup-show-text").html("<?php echo lang('search_message_72_hour_error'); ?>"); 
				return;
			}else{
				date_arrival = $("#arrival_date").val();
				date_leave 	 = $("#leave_date").val();
				bungalow_id  = $('#bungalow').val();
				
				$.ajax({
					type: "POST",
					url: "<?php echo base_url();?>search/search_validation",
					data: "arrival_date="+ date_arrival +"&leave_date="+ date_leave +"&bungalow_id="+ bungalow_id,
					success: function(rs){
						if(rs=='1'){
							
							 
							show_loading();
							op = []
							$('input.options').each( function(i,o){
							  if( this.checked ){
								op.push( $(this).val() )
							  }
							})
							
							$.ajax({
								type: "POST",
								data: { 
									arrival_date: $('#arrival_date').val(),
									leave_date:   $('#leave_date').val(),
									bungalow_id:  $('#bungalow').val(),
									options: op.join()
								},
								dataType: 'json',
								url: '<?php echo base_url() ?>reservation/ajax_check_availability',
								success: function(msg){
									if(msg.success && msg.available != "no"){
										hide_loading();		
										if(msg.available == "partial"){ 
											//alert( "This bungalow is unavailable." );
											$("#example-popup").attr("class","popup visible");
											$("html").attr("class","overlay");
										}else{
											$('#short_reservation_form').hide();
											$('#big_reservation_form').show();
											$("#example-popup").hide();
											fill_reservation_form( msg.price );
										}
									}else {
										if($('#arrival_date').val() != "" && $('#leave_date').val() != "" && $('#bungalow').val() != "" && $('#no_of_adult').val() != ""){
											hide_loading();
											$("#example-popup").attr("class","popup visible");
											$("html").attr("class","overlay");
											//alert( "This bungalow is unavailable. Please <span style='text-decoration:underline'><a href='mailto:j.willemin@caribwebservices.com?subject=Contact Les Balcons Website'>contact us</a></span> for more informations." );
										}
										else{
											hide_loading();
											if($('#arrival_date').val() == "") $("#arrival_date_error_text").html("<?php echo lang("date_error_message"); ?>");
											if($('#leave_date').val() == "") $("#leave_date_error_text").html("<?php echo lang("date_error_message"); ?>");
											if($('#bungalow').val() == "") $("#bungalow_error_text").html("<?php echo lang("bungalow_error_message"); ?>");
											if($('#no_of_adult').val() == "") $("#error_no_of_adult").html("<?php echo lang("adult_error_message"); ?>");
										}
									}
								}
							});
							
						}else if(rs=='2'){
							$('html').addClass('overlay'); 
							$("#popup-for-show-msg").addClass('visible');  
							$("#popup-show-text").html("<?php echo lang('Minimum_Two_Days'); ?>"); 
							return; 
						}else if(rs=='3'){
							$('html').addClass('overlay'); 
							$("#popup-for-show-msg").addClass('visible');  
							$("#popup-show-text").html("<?php echo lang('Minimum_Three_Days'); ?>"); 
							return; 
						}else if(rs=='5'){
							$('html').addClass('overlay'); 
							$("#popup-for-show-msg").addClass('visible');  
							$("#popup-show-text").html("<?php echo lang('Minimum_Five_Days'); ?>"); 
							return; 
						}
					}
				}); 
				
			}
		}
	}

	function get_max_person_by_bungalow_id(id){

		$("#div_no_of_extra_real_adult").hide();
		$("#div_no_of_extra_adult").hide();
		$("#div_no_of_extra_kid").hide();
		$("#div_no_of_folding_bed_kid").hide();
		$("#div_no_of_folding_bed_adult").hide();
		$("#div_no_of_baby_bed").hide();
		$("#no_of_adult").val('');
		var str1 = str2 = str3 = str4 = str5 = str6 = '<option value="">--<?php echo lang('Select'); ?>--</option>';
		
		$("#no_of_extra_real_adult").html(str6);
		$("#no_of_extra_adult").html(str1);
		$("#no_of_extra_kid").html(str2);
		$("#no_of_folding_bed_kid").html(str3);
		$("#no_of_folding_bed_adult").html(str4);
		$("#no_of_baby_bed").html(str5);

		$.ajax({
			type:"GET",
			url:"<?=base_url()?>reservation/get_max_person",
			data:{'id':id},
			success:function(data){
				var val = data.split("-");
				$('#max_person').val(val[0]);
				$('#cat_type').val(val[1]);
			}
		});
	}

	function get_options(bungalow_id)
	{
		$.post("<?php echo base_url() ?>reservation/ajax_get_options", { "bungalow_id":bungalow_id }, function(data){
			$("#options_div").html(data);
			$("#options_div").show();
		});
	}
</script>