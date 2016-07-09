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
	else if($("#arrival_date").val().trim()!="")
	{
		//Checking if arrival date is getting selected in past
		var arrival_date=$("#arrival_date").val();
		var arival_date_arr=$("#arrival_date").val().split("-");
		
		var valyear=arival_date_arr[0];
		var valmonth=arival_date_arr[1];
		var valday=arival_date_arr[2];
		var today = new Date()
		var new_arrival_date= new Date(valyear,(valmonth-1),valday);
		
		var date_after_18_month = new Date(new Date(today).setMonth(today.getMonth()+18));
		var year_after_18_months=date_after_18_month.getFullYear();
		var month_after_18_months=date_after_18_month.getMonth();
		var day_after_18_months=date_after_18_month.getDate();
		var new_date_after_18_month=new Date(year_after_18_months, month_after_18_months, day_after_18_months);
		
		var result=calcDate(today, new_arrival_date);
		
		if(result>0)
		{
			$("#arrival_date_error_text").html("<?php echo lang('Arrival_date_should_not_less_than_current_date'); ?>");
			error++;
		}
		else if(result>-2)
		{
			$("#arrival_date_error_text").html("<?php echo lang('Enter_the_date_of_after_2_days'); ?>");
			error++;
		}
		else 
		{
			//Checking if arrival date is within 18 months
			if(new_arrival_date > new_date_after_18_month)
			{
				$("#arrival_date_error_text").html("<?php echo lang('Reservation_is_allowed_only_within_18_months'); ?>");
				error++;
			}
			else 
			{
				$("#arrival_date_error_text").html("");
			}
		}
	}
	
	if($("#leave_date").val().trim()=="")
	{
		$("#leave_date_error_text").html("<?php echo lang('Leave_Date_is_required'); ?>");
		error++;
	}
	else 
	{
		//Checking if leave date is less than arrival date
		var arrival_date=$("#arrival_date").val();
		var arival_date_arr=$("#arrival_date").val().split("-");
		var arrival_year=arival_date_arr[0];
		var arrival_month=arival_date_arr[1];
		var arrival_day=arival_date_arr[2];
		var new_arrival_date= new Date(arrival_year,(arrival_month-1),arrival_day);

		var leave_date=$("#leave_date").val();
		var leave_date_arr=$("#leave_date").val().split("-");
		var leave_year=leave_date_arr[0];
		var leave_month=leave_date_arr[1];
		var leave_day=leave_date_arr[2];
		var new_leave_date= new Date(leave_year,(leave_month-1),leave_day);
		var result=calcDate(new_arrival_date, new_leave_date);
		if(result>0)
		{
			$("#leave_date_error_text").html("<?php echo lang('Leave_date_should_not_less_than_Arrival_date'); ?>");
			error++;
		}
		else 
		{
			$("#leave_date_error_text").html("");
		}
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
	else 
	{
		var arrival_date=$("#arrival_date").val();
		var leave_date=$("#leave_date").val();
		var bungalow_id=$("#bungalow").val();
		$("#reservation_progress").show();
		$.post("<?php echo base_url() ?>reservation/ajax_check_availability", { "bungalow_id":bungalow_id, "arrival_date":arrival_date, "leave_date":leave_date  }, function(data){
			$("#reservation_progress").hide();
			if(data.trim()=="available")
			{
				$("#reservation_form").submit();
			}
			else if(data.trim()=="notavailable")
			{
				alert("Bungalow/Property Not Available on these date");
			}
			else
			{
				var available_date_arr=data.split("^");
				var new_arr=available_date_arr.join(", ");
				$("#partial_availability_text").html(new_arr);
				$("#partial_availability").show();
				$(window).scrollTop($("#partial_availability").offset().top);
			}
		});
	}
}
function get_options(bungalow_id)
{
	$.post("<?php echo base_url() ?>reservation/ajax_get_options", { "bungalow_id":bungalow_id }, function(data){
		$("#options_div").html(data);
		$("#options_div").show();
	});
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
</script>

<div class="row">
	<div class="inner-page-banner"> <img src="<?php echo base_url(); ?>assets/frontend/images/about-us-banner.jpg" alt=""></div>
</div>
<?php 
if($this->session->userdata("reservation"))
{
	$reservation_session=$this->session->userdata("reservation");
}
?>
<!--banner end-->
<div class="row innerpage-section" id="reservation_form_div">
	<div class="container">
		<h2><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-left.png" alt=""><?php echo lang("Reservation"); ?><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-right.png" alt=""></h2>
		<div class="row inner-content">
      		<div class="reservation_block">
                <form id="reservation_form" class="form-login form-horizontal" action="<?php echo base_url(); ?>reservation/reservation_process" method="POST">
                    <fieldset>
                     
                    <!-- Text input-->
                    <div class="form-row form-group">
                      <div class="col-md-3">
						<label><?php echo lang("Name"); ?> <span style="color:red;">*<span></label>
                      </div>
                      <div class="col-md-7">
						<input id="name" name="name" class="login-input testi-input form-control input-md" type="text" value="<?php if(isset($reservation_session)){ echo $reservation_session['name']; } ?>">
						<div class="errormsg" id="name_error_text"></div>
                      </div>
                    </div>
                    
                    <div class="form-row form-group">
					  <div class="col-md-3">
						<label><?php echo lang("Contact_no"); ?> <span style="color:red;">*<span></label>
					  </div>
                      
					   <div class="input_fields_wrap col-md-7">
						   <input type="text" name="phone[]" class="login-input testi-input form-control input-md" onkeypress="return numbersonly(event)" value="<?php if(isset($reservation_session)){ echo $reservation_session['phone'][0]; } ?>">
						   <button class="add-button  add_field_button"><?php echo lang('Add_More') ?></button>
						   <div class="errormsg" id="phone_error_text"></div>
						   <?php 
						   if(isset($reservation_session))
						   {
								if(count($reservation_session['phone'])>1)
								{
									for($z=1; $z<count($reservation_session['phone']); $z++)
									{
										echo '<div><input type="text" class="login-input testi-input form-control input-md" name="phone[]" style="float:left;" onkeypress="return numbersonly(event)" value="'.$reservation_session['phone'][$z].'"/><a href="#" class="remove_field">'.lang('Remove').'</a></div>';
									}
									
								}
						   }
						   ?>
					   </div>
					   
                    </div>
                    
                    
                    <div class="form-row form-group">
                      <div class="col-md-3">
                      <label>Email <span style="color:red;">*<span></label>
                      </div>
                      
                      <div class="input_fields_wrap_email col-md-7">
                       <input type="text" name="email[]" class="login-input testi-input form-control input-md" value="<?php if(isset($reservation_session)){ echo $reservation_session['email'][0]; } ?>">
					   <button class="add-button  add_field_button_email"><?php echo lang('Add_More') ?></button>
					   <div class="errormsg" id="email_error_text"></div>
					   <?php 
						   if(isset($reservation_session))
						   {
								if(count($reservation_session['email'])>1)
								{
									for($z=1; $z<count($reservation_session['email']); $z++)
									{
										echo '<div><input type="text" class="login-input testi-input form-control input-md" name="email[]" style="float:left;" value="'.$reservation_session['email'][$z].'"><a href="#" class="remove_field_email">'.lang('Remove').'</a></div>';
									}
								}
						   }
						   ?>
					  </div>
                    </div>
                    
                    <div class="form-row form-group">
                      <div class="col-md-3">
                      <label><?php echo lang('Arrival_Date'); ?> <span style="color:red;">*<span></label>
                      </div>
                      <div class="col-md-7">
						<div class='input-group date' id='datetimepicker5'>
							<input id="arrival_date" name="arrival_date" type='text' class="login-input testi-input form-control input-md" data-date-format="YYYY-MM-DD" readonly value="<?php if(isset($reservation_session)){ echo $reservation_session['arrival_date']; } ?>"/>
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
						<input name="leave_date" id="leave_date" type='text' class="login-input testi-input form-control input-md" data-date-format="YYYY-MM-DD" readonly value="<?php if(isset($reservation_session)){ echo $reservation_session['leave_date']; } ?>"/>
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
								if(count($properties_arr)>0)
								{
									if(isset($reservation_session))
									{ $bungalow_id=$reservation_session['bungalow_id']; }
									else 
									{ $bungalow_id=''; }
									?>
									<optgroup label="<?php echo lang('Properties') ?>">
									<?php 
									foreach($properties_arr as $properties)
									{
										?>
										<option value="<?php echo $properties['id'] ?>" <?php if($bungalow_id==$properties['id']){ echo "selected"; } ?> ><?php echo $properties['bunglow_name'] ?></option>
										<?php 
									}
								}
							?>
							
							<?php
								if(count($bungalows_arr)>0)
								{
									?>
									<optgroup label="<?php echo lang('Bungalows') ?>">
									<?php 
									foreach($bungalows_arr as $bungalow)
									{
										?>
										<option value="<?php echo $bungalow['id'] ?>"><?php echo $bungalow['bunglow_name'] ?></option>
										<?php 
									}
								}
							?>
						</select>
						<div class="errormsg" id="bungalow_error_text"></div>
                      </div>
                    </div>
					
					
                   <div class="form-row form-group" id="options_div" style="<?php if(isset($options_arr)){ echo ""; }else{ echo "display:none;"; } ?>">
                     <!-- Div for options fetched by ajax -->
					  <?php 
						if(isset($options_arr))
						{
							$selected_options_ids=$reservation_session['options_id'];
							?>
							<div class="col-md-3">
								<label>Options  </label>
							</div>
							<div class="col-md-7">
							<?php 
							  foreach($options_arr as $options)
							  {
									$checked="";
									if($selected_options_ids!="")
									{
										if(in_array($options['options_id'], $selected_options_ids)){ $checked="checked"; }
									}
									echo '<div class="col-md-4"> <input id="options" name="options[]" type="checkbox" '.$checked.' value="'.$options['options_id'].'">&nbsp;'.$options['options_name'].'</div>';
							  }
							  ?>
							  </div>
							  <?php 
						}
					 ?>

                   </div>
				   
                   <div class="errormsg"></div>
				   
                    <div class="form-row form-group">
                      <div class="col-md-3">
                      <label><?php echo lang('Text'); ?>  </label>
                      </div>
                      <div class="col-md-7">
                      <textarea class="contact-textar testi-textarea form-control" name="description"><?php if(isset($reservation_session)){ echo $reservation_session['description']; } ?></textarea>
                      </div>
                    </div>
                    
                    
                    <!-- Button -->
                    <div class="form-row form-group">
						<div class="col-md-10">
							<div class="row">
								<div class="col-md-12">
									<div class="sub-btn">
										<input id="textinput" name="textinput" class="submit-button btn btn-default" type="button" value="<?php echo lang('Submit'); ?>" onclick="check_reservation_form()" style="float:right">
									</div>
									<div class="sub-btn" id="reservation_progress" style="display:none;"> 
										<em style=" float:left ; padding-right:20px; padding-top:10px;">Please Wait.....</em> 
										<span style="margin-top:15px; float:left"><img  src="<?php echo base_url(); ?>assets/frontend/images/loading.gif" style=" float:left"></span>
									</div>
								</div>
							  </div>       
						 </div>
                   </div>
				   
						<!-- if bungalow property is partially available then  it will be shown -->
					   <div class="form-row form-group" id="partial_availability" style="display:none;">
							<div class="col-md-3">
								<label><?php echo lang('Available_on'); ?></label>
							</div>
							<div class="col-md-7" id="partial_availability_text"></div>
					   </div>
                   
                    </fieldset>
                 </form>
            </div>
		</div>
	</div>
 </div>