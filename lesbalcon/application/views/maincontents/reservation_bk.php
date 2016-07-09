<script type="text/javascript">
function numbersonly(e)
{
	var unicode=e.charCode? e.charCode : e.keyCode
	if (unicode!=8)
	{ //if the key isn't the backspace key (which we should allow)
		if (unicode<48||unicode>57) //if not a number
		return false //disable key press
	}
}

function check_reservation_form()
{
	var error=0;
	if($("#name").val().trim()=="")
	{
		$("#name_error_text").html("<?php echo lang('Name_is_required'); ?>");
		error++;
	}
	else 
	{
		$("#name_error_text").html("");
	}
	
	var contact_nos=document.getElementsByName("phone[]");
	var total_contact=0;
	for(var i=0; i<contact_nos.length; i++)
	{
		if(contact_nos[i].value.trim()!="")
		{
			total_contact++;
		}
	}
	if(total_contact==0)
	{
		$("#phone_error_text").html("<?php echo lang('Contact_no_is_required'); ?>");
		error++;
	}
	else 
	{
		$("#phone_error_text").html("");
	}
	
	var email_ids=document.getElementsByName("email[]");
	var total_email=0;
	var invalid_email=0;
	for(var i=0; i<email_ids.length; i++)
	{
		if(email_ids[i].value.trim()!="")
		{
			total_email++;
			var email=email_ids[i].value;
			var reg = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
			if (!reg.test(email))
			{
				invalid_email++;
			}
		}
	}
	if(total_email==0)
	{
		$("#email_error_text").html("<?php echo lang('Email_is_required'); ?>");
		error++;
	}
	else if(invalid_email>0)
	{
		$("#email_error_text").html("<?php echo lang('Please_enter_valid_email_address'); ?>");
		error++;
	}
	else 
	{
		$("#email_error_text").html("");
	}
	
	if($("#arrival_date").val().trim()=="")
	{
		$("#arrival_date_error_text").html("<?php echo lang('Arrival_Date_is_required'); ?>");
		error++;
	}
	else 
	{
		$("#arrival_date_error_text").html("");
	}
	
	if($("#leave_date").val().trim()=="")
	{
		$("#leave_date_error_text").html("<?php echo lang('Leave_Date_is_required'); ?>");
		error++;
	}
	else 
	{
		$("#leave_date_error_text").html("");
	}
	if($("#bungalow").val()=="")
	{
		$("#bungalow_error_text").html("<?php echo lang('Choose_Bungalow_Property_is_required'); ?>");
		error++;
	}
	else 
	{
		$("#bungalow_error_text").html("");
	}
	
	
	if(error>0)
	{
		$(window).scrollTop($("#reservation_form_div").offset().top);
		return false;
	}
}
function get_options(bungalow_id)
{
	$.post("<?php echo base_url() ?>reservation/ajax_get_options", { "bungalow_id":bungalow_id }, function(data){
		$("#options_div").html(data);
		$("#options_div").show();
	});
}
</script>

<div class="row">
	<div class="inner-page-banner"> <img src="<?php echo base_url(); ?>assets/frontend/images/about-us-banner.jpg" alt=""></div>
</div>
<!--banner end-->
<div class="row innerpage-section" id="reservation_form_div">
	<div class="container">
		<h2><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-left.png" alt=""><?php echo lang("Reservation"); ?><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-right.png" alt=""></h2>
		<div class="row inner-content">
      		<div class="reservation_block">
                <form id="reservation_form" class="form-login form-horizontal" action="" method="POST">
                    <fieldset>
                     
                    <!-- Text input-->
                    <div class="form-row form-group">
                      <div class="col-md-3">
						<label><?php echo lang("Name"); ?> <span style="color:red;">*<span></label>
                      </div>
                      <div class="col-md-7">
						<input id="name" name="name" class="login-input testi-input form-control input-md" type="email" required="required">
						<div class="errormsg" id="name_error_text"></div>
                      </div>
                    </div>
                    
                    <div class="form-row form-group">
					  <div class="col-md-3">
						<label><?php echo lang("Contact_no"); ?> <span style="color:red;">*<span></label>
					  </div>
                      
					   <div class="input_fields_wrap col-md-7">
						   <input type="text" name="phone[]" class="login-input testi-input form-control input-md" onkeypress="return numbersonly(event)">
						   <button class="add-button  add_field_button"><?php echo lang('Add_More') ?></button>
						   <div class="errormsg" id="phone_error_text"></div>
					   </div>
					   
                    </div>
                    
                    
                    <div class="form-row form-group">
                      <div class="col-md-3">
                      <label>Email <span style="color:red;">*<span></label>
                      </div>
                      
                      <div class="input_fields_wrap_email col-md-7">
                       <input type="text" name="email[]" class="login-input testi-input form-control input-md">
					   <button class="add-button  add_field_button_email"><?php echo lang('Add_More') ?></button>
					   <div class="errormsg" id="email_error_text"></div>
					  </div>
                    </div>
                    
                    <div class="form-row form-group">
                      <div class="col-md-3">
                      <label><?php echo lang('Arrival_Date'); ?> <span style="color:red;">*<span></label>
                      </div>
                      <div class="col-md-7">
						<div class='input-group date' id='datetimepicker5'>
							<input id="arrival_date" name="arrival_date" type='text' class="login-input testi-input form-control input-md" data-date-format="YYYY-MM-DD"/>
							<div class="errormsg" id="arrival_date_error_text"></div>
							<span class="input-group-custom_2 input-group-addon">
								<span class="glyphicon glyphicon-calendar"></span>
							</span>
							
						</div>
                      </div>
                    </div>
					
                    
                    <div class="form-row form-group">
                      <div class="col-md-3">
                      <label><?php echo lang('Leave_Date'); ?> <span style="color:red;">*<span></label>
                      </div>
                      <div class="col-md-7">
                      <div class='input-group date' id='datetimepicker6'>
						<input name="leave_date" id="leave_date" type='text' class="login-input testi-input form-control input-md" data-date-format="YYYY-MM-DD"/>
						<div class="errormsg" id="leave_date_error_text"></div>
						<span class="input-group-custom_2 input-group-addon">
							<span class="glyphicon glyphicon-calendar"></span>
						</span>
						</div>
                      </div>
                   </div>
                    
					<div class="form-row form-group">
                      <div class="col-md-3">
						<label><?php echo lang("Choose_Bungalow_Property"); ?> <span style="color:red;">*<span></label>
                      </div>
                      <div class="col-md-7">
						<select name="bungalow" id="bungalow" class="login-input testi-input form-control input-md" onchange="get_options(this.value)">
							<option value="">--<?php echo lang('Select'); ?>--</option>
							<?php 
							foreach($bungalows_arr as $bungalow)
							{
								?>
								<option value="<?php echo $bungalow['id'] ?>"><?php echo $bungalow['bunglow_name'] ?></option>
								<?php 
							}
							?>
						</select>
						<div class="errormsg" id="bungalow_error_text"></div>
                      </div>
                    </div>
					
					
                   <div class="form-row form-group" id="options_div" style="display:none;">
                     <!-- Div for options fetched by ajax -->
                   </div>
				   
                   <div class="errormsg"></div>
				   
                    <div class="form-row form-group">
                      <div class="col-md-3">
                      <label><?php echo lang('Text'); ?>  </label>
                      </div>
                      <div class="col-md-7">
                      <textarea class="contact-textar testi-textarea form-control" name="description"></textarea>
                      </div>
                    </div>
                    
                    
                    <!-- Button -->
                    <div class="form-row form-group">
                      <div class="col-md-10">
                        <input id="textinput" name="textinput" class="submit-button btn btn-default" type="button" style="float:right" value="<?php echo lang('Submit'); ?>" onclick="check_reservation_form()">
                      </div>
                    </div>
                    
                    </fieldset>
                 </form>
            </div>
		</div>
	</div>
 </div>
 
