<?php
ob_start();
class Home extends CI_Controller
{
	function  __construct() 
	{
		parent::__construct();
		$this->load->library('admin_init_elements');
		$this->admin_init_elements->init_elements();
		$this->admin_init_elements->is_admin_logged_in();
		$this->load->model("home_model");
		$this->load->model("payment_model");
		$this->load->library('user_agent');
		$this->load->model('language_model');
	}
	function index()
	{
		
		$unique_years=$this->home_model->get_unique_years_from_reservation();
		$this->data['latest_booking']=$this->home_model->get_latest_booking();
		$this->data['years_with_months']=$this->home_model->get_years_with_months($unique_years);
		$this->data['bungalows_arr']=$this->home_model->get_bungalows();
		$mobile_browser = '0';
		if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) 
		{
			$mobile_browser++;
		}
		 
		if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) 
		{
			$mobile_browser++;
		}    
		 
		$mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
		$mobile_agents = array(
			'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
			'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
			'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
			'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
			'newt','noki','oper','palm','pana','pant','phil','play','port','prox',
			'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
			'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
			'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
			'wapr','webc','winw','winw','xda ','xda-');
		 
		if (in_array($mobile_ua,$mobile_agents)) 
		{
			$mobile_browser++;
		}
		 
		if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'OperaMini') > 0) 
		{
			$mobile_browser++;
		}
		 
		if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'windows') > 0) 
		{
			$mobile_browser = 0;
		}
		 
		if ($mobile_browser > 0)
		{
			//$this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
			$this->data['head'] = $this->load->view('admin/elements/head_mobile', $this->data, true);
			$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
			$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
			//$this->data['content'] = $this->load->view('admin/maincontents/home', $this->data, true);
			$this->data['content'] = $this->load->view('admin/maincontents/home_mobile', $this->data, true);
			$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
			$this->load->view('admin/layout_home', $this->data);
		}
		else 
		{
			$this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
			//$this->data['head'] = $this->load->view('admin/elements/head_mobile', $this->data, true);
			$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
			$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
			$this->data['content'] = $this->load->view('admin/maincontents/home', $this->data, true);
			//$this->data['content'] = $this->load->view('admin/maincontents/home_mobile', $this->data, true);
			$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
			$this->load->view('admin/layout_home', $this->data);
		}   
	}
	
	
	//Function for Testing. Delete This after completing mobile version
	function mobile()
	{
		$unique_years=$this->home_model->get_unique_years_from_reservation();
		$this->data['latest_booking']=$this->home_model->get_latest_booking();
		$this->data['years_with_months']=$this->home_model->get_years_with_months($unique_years);
		$this->data['bungalows_arr']=$this->home_model->get_bungalows();
		//$this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['head'] = $this->load->view('admin/elements/head_mobile', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		//$this->data['content'] = $this->load->view('admin/maincontents/home', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/home_mobile', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
	}
	
	
	
	//These Functions for calendar (BOTH DESKTOP VIEW AND MOBILE VIEW ALSO)
	//Function for set date for cleaning
	function ajax_mark_for_cleaning()
	{
		$bungalow_id=$_POST['bungalow_id'];
		$date_for_cleaning=$_POST['date'];
		$result=$this->home_model->ajax_mark_for_cleaning($bungalow_id, $date_for_cleaning);
	}
	
	//function for removing cleaning class
	function ajax_remove_cleaning()
	{
		$bungalow_id=$_POST['bungalow_id'];
		$cleaning_date=$_POST['cleaning_date'];
		$result=$this->home_model->ajax_removing_cleaning($bungalow_id, $cleaning_date);
	}
	
	//Function for getting add reservation form
	function ajax_get_add_reservation_form()
	{
		$bungalow_id=$_POST['bungalow_id'];
		$arrival_date_arr=explode("-", $_POST['arrival_date']);
		$new_arrival_date=$arrival_date_arr[2]."/".$arrival_date_arr[1]."/".$arrival_date_arr[0];
		
		$users_list=$this->home_model->get_registered_user();
		$bungalow_details=$this->home_model->get_bungalow_details($bungalow_id);
		$bungalow_options_details=$this->home_model->get_options_details($bungalow_id);
		?>
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
				<form id="reservation_add_form" action="<?php echo base_url(); ?>admin/home/add_reservation" method="POST" onsubmit="return validate_add_reservation()">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title"><i class="fa fa-bars"></i>Add Reservation</h4>
					<div class="modal-body" style="min-height:100px;">
						<input type="hidden" name="user_type" id="user_type" value="R">
						<input type="hidden" name="bungalow_id" id="bungalow_id" value="<?php echo $bungalow_id; ?>">
						<div class="box-body">
						<div class="form-group">
							<label for="exampleInputPassword1">Bungalow/Property</label>
							<input type="text" name="bungalow_name" id="bungalow_name" style="width:80%;" class="form-control" readonly value="<?php echo $bungalow_details[0]['bunglow_name']; ?>">
						</div>
						
						<?php 
						if(count($bungalow_options_details)>0)
						{
							?>
							<div class="form-group">
								<label for="exampleInputPassword1">Options</label><br>
								<?php 
								foreach($bungalow_options_details as $options)
								{
									?>
									<input type="checkbox" name="options_id[]" value="<?php echo $options['options_id'] ?>">&nbsp;<?php echo $options['options_name']; ?>&nbsp;&nbsp;
									<?php 
								}
								?>
							</div>
							<?php 
						}
						?>
						
						<div class="form-group">
							<label for="exampleInputPassword1">User</label>
							<select name="user_id" id="user_id" style="width:80%;" class="form-control">
								<option value="">--Select--</option>
								<?php 
								foreach($users_list as $user)
								{
									?>
									<option value="<?php echo $user['id']; ?>"><?php echo $user['email']; ?></option>
									<?php 
								}
								?>
							</select>
							<div class="form-group has-error" id="user_id_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> User is required</i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">Name</label>
							<input type="text" name="reservation_name" id="reservation_name" style="width:80%;" class="form-control" value="">
							<div class="form-group has-error" id="reservation_name_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> Name is required</i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">Contact No.</label>
							<input type="text" name="reservation_contact" id="reservation_contact" style="width:80%;" class="form-control" value="">
							<div class="form-group has-error" id="reservation_contact_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> Contact No is required</i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">Arrival Date</label>
							<div class='input-group date' id='reservation_arrival_date' style="width:80%;">
								<input type="text" name="arrival_date" id="arrival_date" class="form-control" readonly value="<?php echo $new_arrival_date; ?>" style="cursor:auto;">
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-calendar"></span>
								</span>
							</div>
							<div class="form-group has-error" id="arrival_date_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o" id="arrival_date_error_text"> Arrival Date is required</i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">Leave Date</label>
							<div class='input-group date' id='reservation_leave_date' style="width:80%;">
								<input type="text" name="leave_date" id="leave_date" class="form-control" readonly value="" style="cursor:auto;">
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-calendar"></span>
								</span>
							</div>
							<div class="form-group has-error" id="leave_date_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o" id="leave_date_error_text"> Leave Date is required</i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">Source</label>
							<select name="source" id="source" style="width:80%;" class="form-control">
								<option value="M">MANUAL</option>
								<option value="D">DIRECT</option>
								<option value="W">WEBSITE</option>
							</select>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">Text</label>
							<textarea style="width:80%;" class="form-control" name="reservation_text" id="reservation_text"></textarea>
						</div>
						</div>
						<div class="box-footer">
							<input type="submit" class="btn btn-primary" name="save" value="Submit">
						</div>
					</div>
				</form>
				</div>
			</div>
		</div>
		<script>
			$('#reservation_arrival_date').datetimepicker({
				format:'dd/mm/yyyy',
				language:  'En',
				weekStart: 1,
				todayBtn:  1,
				autoclose: 1,
				todayHighlight: 1,
				startView: 2,
				minView: 2,
				forceParse: 0
			});
			$('#reservation_leave_date').datetimepicker({
				format:'dd/mm/yyyy',
				language:  'En',
				weekStart: 1,
				todayBtn:  1,
				autoclose: 1,
				todayHighlight: 1,
				startView: 2,
				minView: 2,
				forceParse: 0
			});
		</script>
		<?php 
	}
	
	//function for getting add reservation form for unregistered user
	function ajax_get_add_reservation_form_unregistered()
	{
		$bungalow_id=$_POST['bungalow_id'];
		$arrival_date_arr=explode("-", $_POST['arrival_date']);
		$new_arrival_date=$arrival_date_arr[2]."/".$arrival_date_arr[1]."/".$arrival_date_arr[0];
		
		$users_list=$this->home_model->get_all_users();
		$bungalow_details=$this->home_model->get_bungalow_details($bungalow_id);
		$bungalow_options_details=$this->home_model->get_options_details($bungalow_id);
		$language_arr = $this->language_model->get_rows();
		?>
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
				<form id="reservation_add_form" action="<?php echo base_url(); ?>admin/home/add_reservation" method="POST" onsubmit="return validate_add_reservation()">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title"><i class="fa fa-bars"></i>Add Reservation</h4>
					<div class="modal-body" style="min-height:100px;">
						<input type="hidden" name="user_type" id="user_type" value="U">
						<input type="hidden" name="bungalow_id" id="bungalow_id" value="<?php echo $bungalow_id; ?>">
						<div class="box-body">
						<div class="form-group">
							<label for="exampleInputPassword1">User Language</label>
							<select name="user_language" id="user_language" class="form-control" style="width:80%;">
								<?php 
								foreach($language_arr as $language)
								{
									?>
									<option value="<?php echo $language['id'] ?>"><?php echo $language['language_name']; ?></option>	
									<?php 
								}
								?>
							</select>
							<div class="form-group has-error" id="user_language_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"></i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">Name</label>
							<input type="text" name="reservation_name" id="reservation_name" style="width:80%;" class="form-control" value="">
							<div class="form-group has-error" id="reservation_name_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> Name is required</i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">Email</label>
							<input type="text" name="reservation_email" id="reservation_email" style="width:80%;" class="form-control" value="">
							<div class="form-group has-error" id="reservation_email_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> Email is required</i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">Contact No.</label>
							<input type="text" name="reservation_contact" id="reservation_contact" style="width:80%;" class="form-control" value="">
							<div class="form-group has-error" id="reservation_contact_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> Contact No. is required</i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">Address</label>
							<textarea name="reservation_address" id="reservation_address" style="width:80%;" class="form-control"></textarea>
							<div class="form-group has-error" id="reservation_address_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> Address is required</i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">Bungalow/Property</label>
							<input type="text" name="bungalow_name" id="bungalow_name" style="width:80%;" class="form-control" readonly value="<?php echo $bungalow_details[0]['bunglow_name']; ?>">
						</div>
						<?php 
						if(count($bungalow_options_details)>0)
						{
							?>
							<div class="form-group">
								<label for="exampleInputPassword1">Options</label><br>
								<?php 
								foreach($bungalow_options_details as $options)
								{
									?>
									<input type="checkbox" name="options_id[]" value="<?php echo $options['options_id'] ?>">&nbsp;<?php echo $options['options_name']; ?>&nbsp;&nbsp;
									<?php 
								}
								?>
							</div>
							<?php 
						}
						?>
						<div class="form-group">
							<label for="exampleInputPassword1">Arrival Date</label>
							<div class='input-group date' id='reservation_arrival_date' style="width:80%;">
								<input type="text" name="arrival_date" id="arrival_date" class="form-control" readonly value="<?php echo $new_arrival_date; ?>" style="cursor:auto;">
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-calendar"></span>
								</span>
							</div>
							<div class="form-group has-error" id="arrival_date_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o" id="arrival_date_error_text"> Arrival Date is required</i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">Leave Date</label>
							<div class='input-group date' id='reservation_leave_date' style="width:80%;">
								<input type="text" name="leave_date" id="leave_date" class="form-control" readonly value="" style="cursor:auto;">
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-calendar"></span>
								</span>
							</div>
							<div class="form-group has-error" id="leave_date_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o" id="leave_date_error_text"> Leave Date is required</i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">Source</label>
							<select name="source" id="source" style="width:80%;" class="form-control">
								<option value="M">MANUAL</option>
								<option value="D">DIRECT</option>
								<option value="W">WEBSITE</option>
							</select>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">Text</label>
							<textarea style="width:80%;" class="form-control" name="reservation_text" id="reservation_text"></textarea>
						</div>
						</div>
						<div class="box-footer">
							<input type="submit" class="btn btn-primary" name="save" value="Submit">
						</div>
					</div>
				</form>
				</div>
			</div>
		</div>
		<script>
			$('#reservation_arrival_date').datetimepicker({
				format:'dd/mm/yyyy',
				language:  'En',
				weekStart: 1,
				todayBtn:  1,
				autoclose: 1,
				todayHighlight: 1,
				startView: 2,
				minView: 2,
				forceParse: 0
			});
			$('#reservation_leave_date').datetimepicker({
				format:'dd/mm/yyyy',
				language:  'En',
				weekStart: 1,
				todayBtn:  1,
				autoclose: 1,
				todayHighlight: 1,
				startView: 2,
				minView: 2,
				forceParse: 0
			});
		</script>
		<?php
	}
	
	//Function for add reservation from calendar
	function add_reservation()
	{
		$result=$this->home_model->add_reservation();
		redirect("admin/home?addsuccess");
	}
	
	//Function for getting edit reservation form
	function ajax_get_edit_reservation_form()
	{
		$reservation_id=$_POST['reservation_id'];
		$reservation_details=$this->home_model->get_reservation_details($reservation_id);
		$options_ids=array();
		if(!empty($reservation_details[0]['options_id']))
		{
			$options_ids=explode(",",$reservation_details[0]['options_id']);
		}
		$arrival_date_array=explode("-", $reservation_details[0]['arrival_date']);
		$arrival_date=$arrival_date_array[2]."/".$arrival_date_array[1]."/".$arrival_date_array[0];
		$leave_date_array=explode("-", $reservation_details[0]['leave_date']);
		$leave_date=$leave_date_array[2]."/".$leave_date_array[1]."/".$leave_date_array[0];
		$source=$reservation_details[0]['source'];
		$users_list=$this->home_model->get_all_users();
		$bungalow_details=$this->home_model->get_bungalow_details($reservation_details[0]['bunglow_id']);
		$bungalow_options_details=$this->home_model->get_options_details($reservation_details[0]['bunglow_id']);
		?>
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
				<form id="reservation_add_form" action="<?php echo base_url(); ?>admin/home/edit_reservation" method="POST" onsubmit="return validate_edit_reservation()">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title"><i class="fa fa-bars"></i>Edit Reservation</h4>
					<div class="modal-body" style="min-height:100px;">
						<input type="hidden" name="bungalow_id" id="bungalow_id" value="<?php echo $reservation_details[0]['bunglow_id']; ?>">
						<input type="hidden" name="reservation_id" id="reservation_id" value="<?php echo $reservation_id; ?>">
						<div class="box-body">
						<div class="form-group">
							<label for="exampleInputPassword1">Bungalow/Property</label>
							<input type="text" name="bungalow_name" id="bungalow_name" style="width:80%;" class="form-control" readonly value="<?php echo $bungalow_details[0]['bunglow_name']; ?>">
						</div>
						
						<?php 
						if(count($bungalow_options_details)>0)
						{
							?>
							<div class="form-group">
								<label for="exampleInputPassword1">Options</label><br>
								<?php 
								foreach($bungalow_options_details as $options)
								{
									?>
									<input type="checkbox" name="options_id[]" value="<?php echo $options['options_id'] ?>" <?php if(in_array($options['options_id'], $options_ids)){ echo "checked"; } ?>>&nbsp;<?php echo $options['options_name']; ?>&nbsp;&nbsp;
									<?php 
								}
								?>
							</div>
							<?php 
						}
						?>
						
						<div class="form-group">
							<label for="exampleInputPassword1">User</label>
							<select name="user_id" id="user_id" style="width:80%;" class="form-control">
								<option value="">--Select--</option>
								<?php 
								foreach($users_list as $user)
								{
									?>
									<option value="<?php echo $user['id']; ?>" <?php if($reservation_details[0]['user_id']==$user['id']){ echo "selected"; }  ?>><?php echo $user['email']; ?></option>
									<?php 
								}
								?>
							</select>
							<div class="form-group has-error" id="user_id_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> User is required</i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">Name</label>
							<input type="text" name="reservation_name" id="reservation_name" style="width:80%;" class="form-control" value="<?php echo $reservation_details[0]['name']; ?>">
							<div class="form-group has-error" id="reservation_name_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> Name is required</i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">Contact No.</label>
							<input type="text" name="reservation_contact" id="reservation_contact" style="width:80%;" class="form-control" value="<?php echo $reservation_details[0]['phone']; ?>">
							<div class="form-group has-error" id="reservation_contact_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> Contact No is required</i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">Arrival Date</label>
							<div class='input-group date' id='reservation_arrival_date' style="width:80%;">
								<input type="text" name="arrival_date" id="arrival_date" class="form-control" readonly value="<?php echo $arrival_date; ?>">
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-calendar"></span>
								</span>
							</div>
							<div class="form-group has-error" id="arrival_date_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o" id="arrival_date_error_text"> Arrival Date is required</i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">Leave Date</label>
							<div class='input-group date' id='reservation_leave_date' style="width:80%;">
								<input type="text" name="leave_date" id="leave_date" class="form-control" readonly value="<?php echo $leave_date; ?>">
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-calendar"></span>
								</span>
							</div>
							<div class="form-group has-error" id="leave_date_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o" id="leave_date_error_text"> Leave Date is required</i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">Source</label>
							<select name="source" id="source" style="width:80%;" class="form-control">
								<option value="M" <?php if($source=="M"){ echo "selected";} ?>>MANUAL</option>
								<option value="D" <?php if($source=="D"){ echo "selected";} ?>>DIRECT</option>
								<option value="W" <?php if($source=="W"){ echo "selected";} ?>>WEBSITE</option>
							</select>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">Text</label>
							<textarea style="width:80%;" class="form-control" name="reservation_text" id="reservation_text"><?php echo $reservation_details[0]['comment']; ?></textarea>
						</div>
						</div>
						<div class="box-footer">
							<input type="submit" class="btn btn-primary" name="save" value="Submit">
						</div>
					</div>
				</form>
				</div>
			</div>
		</div>
		<script>
			$('#reservation_arrival_date').datetimepicker({
				format:'dd/mm/yyyy',
				language:  'En',
				weekStart: 1,
				todayBtn:  1,
				autoclose: 1,
				todayHighlight: 1,
				startView: 2,
				minView: 2,
				forceParse: 0
			});
			$('#reservation_leave_date').datetimepicker({
				format:'dd/mm/yyyy',
				language:  'En',
				weekStart: 1,
				todayBtn:  1,
				autoclose: 1,
				todayHighlight: 1,
				startView: 2,
				minView: 2,
				forceParse: 0
			});
		</script>
		<?php 
	}
	
	
	//function for editing reservation 
	function edit_reservation()
	{
		$result=$this->home_model->edit_reservation();
		redirect("admin/home?editsuccess");
	}
	
	
	
	//Function for sending invoice
	function send_invoice($reservation_id)
	{
		if(isset($_POST['send_invoice']))
		{
			$result=$this->home_model->send_invoice();
			redirect('admin/home?sent');
		}
		$reservation_payment_details=$this->payment_model->get_payment_details($reservation_id);
		$user_id=$reservation_payment_details['user_id'];
		$user_details=$this->home_model->get_user_details($user_id);
		$this->data['reservation_payment_details']=$reservation_payment_details;
		$this->data['user_details']=$user_details;
		$this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/send_invoice', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
	}
	
	
	
	
	//Function to get full details while mouseclick calendar 25-11-2014
	function ajax_get_reservation_details()
	{
		$reservation_id=$_POST['reservation_id'];
		$reservation_details=$this->payment_model->get_payment_details($reservation_id);
		?>
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title"><i class="fa fa-bars"></i>Reservation Details</h4>
					<table class="table table-hover">
						<th>Particulars</th>
						<th>Details</th>
						<tr>
							<td>Name:</td>
							<td><?php echo $reservation_details['user_name'] ?></td>
						</tr>
						<tr>
							<td>Email:</td>
							<td><?php echo $reservation_details['user_email'] ?></td>
						</tr>
						<tr>
							<td>Bungalow Name:</td>
							<td><?php echo $reservation_details['bungalow_name'] ?></td>
						</tr>
						<tr>
							<td>Reservation Date:</td>
							<td><?php echo date("d/m/Y H:i:s", strtotime($reservation_details['reservation_date'])); ?></td>
						</tr>
						<tr>
							<td>Arrival Date:</td>
							<td><?php echo date("d/m/Y", strtotime($reservation_details['arrival_date'])); ?></td>
						</tr>
						<tr>
							<td>Leave Date:</td>
							<td><?php echo date("d/m/Y", strtotime($reservation_details['leave_date'])); ?></td>
						</tr>
						<tr>
							<td>Accommodation:</td>
							<td><?php echo $reservation_details['accommodation']." days"; ?></td>
						</tr>
						<tr>
							<td>Bungalow Rate:</td>
							<td><?php echo $reservation_details['bungalow_rate']." (". $reservation_details['accommodation']." days)"; ?></td>
						</tr>
						<tr>
							<td>Options:</td>
							<td>
								<?php 
								if(count($reservation_details['options_rate'])>0)
								{
									foreach($reservation_details['options_rate'] as $options_rate)
									{
										echo $options_rate['option_name'].": ".$options_rate['option_rate']."(".$reservation_details['accommodation']." days)<br>";
									}
								}
								else 
								{
									echo "N/A";
								}
								?>
							</td>
						</tr>
						<tr>
							<td>Discount(%):</td>
							<td><?php echo $reservation_details['discount']."%"; ?></td>
						</tr>
						<tr>
							<td>Tax:</td>
							<td>
								<?php 
								if(count($reservation_details['tax_rate'])>0)
								{
									foreach($reservation_details['tax_rate'] as $tax_rate)
									{
										echo $tax_rate['tax_name'].": ".$tax_rate['tax_rate']."<br>";
									}
								}
								else 
								{
									echo "N/A";
								}
								?>
							</td>
						</tr>
						<tr>
							<td>Total:</td>
							<td><?php echo $reservation_details['total']; ?></td>
						</tr>
						<tr>
							<td>Paid Amount:</td>
							<td><?php echo $reservation_details['paid_amount']; ?></td>
						</tr>
						<tr>
							<td>Due Amount:</td>
							<td><?php echo $reservation_details['due_amount']; ?></td>
						</tr>
						<tr>
							<td>Payment Mode:</td>
							<td><?php echo $reservation_details['payment_mode']; ?></td>
						</tr>
						<tr>
							<td>Payment Status:</td>
							<td><?php echo $reservation_details['payment_status']; ?></td>
						</tr>
						<tr>
							<td>Reservation Status:</td>
							<td><?php echo $reservation_details['reservation_status']; ?></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<?php 
	}
	
	
	function ajax_get_details_for_tooltip()
	{
		$reservation_id=$_POST['reservation_id'];
		$reservation_details=$this->payment_model->get_payment_details($reservation_id);
		?>
		<div class="box box-solid bg-light-blue">
			<div class="box-body">
				<table width="100%">
					<tr>
						<td height="30px" width="30%" valign="top" align="left">Name: </td>
						<td height="30px" width="70%" valign="top" align="left"><?php echo $reservation_details['user_name'] ?></td>
					</tr>
					<tr>
						<td height="30px" width="30%" valign="top" align="left">Options: </td>
						<td height="30px" width="70%" valign="top" align="left">
							<?php 
								if(count($reservation_details['options_rate'])>0)
								{
									foreach($reservation_details['options_rate'] as $options_rate)
									{
										echo $options_rate['option_name'].": ".$options_rate['option_rate']."(".$reservation_details['accommodation']." days)<br>";
									}
								}
								else 
								{
									echo "N/A";
								}
							?>
						</td>
					</tr>
					<tr>
						<td height="30px" width="30%" valign="top" align="left">Payment: </td>
						<td height="30px" width="70%" valign="top" align="left"><?php echo $reservation_details['payment_status']; ?></td>
					</tr>
				</table>
			</div>
		</div>
		<?php 
	}
	
	
	//Function fot getting data for print details
	function ajax_get_print_details()
	{
		$reservation_id=$_POST['reservation_id'];
		$reservation_details=$this->payment_model->get_payment_details($reservation_id);
		?>
		<table width="650" align="center" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" style="border:1px solid #C9AD64; font-family:arial; font-size:12px;">
			<tr>
				<td colspan='2' align='center'><h2>Reservation Details</h2></td>
			</tr>
			<tr bgcolor="#ccc">
				<th style="border-top:1px solid #C9AD64; padding:5px;">Particulars</th>
				<th style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">Details</th>
			</tr>
			<tr>
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Name:</b></td>
				<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;"><?php echo $reservation_details['user_name'] ?></td>
			</tr>
			<tr bgcolor="#f5e8c8">
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Email:</b></td>
				<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;"><?php echo $reservation_details['user_email'] ?></td>
			</tr>
			<tr>
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Bungalow Name:</b></td>
				<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;"><?php echo $reservation_details['bungalow_name'] ?></td>
			</tr>
			<tr bgcolor="#f5e8c8">
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Reservation Date:</b></td>
				<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;"><?php echo date("d/m/Y H:i:s", strtotime($reservation_details['reservation_date'])); ?></td>
			</tr>
			<tr>
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Arrival Date:</b></td>
				<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;"><?php echo date("d/m/Y", strtotime($reservation_details['arrival_date'])); ?></td>
			</tr>
			<tr bgcolor="#f5e8c8">
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Leave Date:</b></td>
				<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;"><?php echo date("d/m/Y", strtotime($reservation_details['leave_date'])); ?></td>
			</tr>
			<tr>
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Accommodation:</b></td>
				<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;"><?php echo $reservation_details['accommodation']." days"; ?></td>
			</tr>
			<tr bgcolor="#f5e8c8">
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Bungalow Rate:</b></td>
				<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;"><?php echo $reservation_details['bungalow_rate']." (". $reservation_details['accommodation']." days)"; ?></td>
			</tr>
			<tr>
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Options:</b></td>
				<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
					<?php 
					if(count($reservation_details['options_rate'])>0)
					{
						foreach($reservation_details['options_rate'] as $options_rate)
						{
							echo $options_rate['option_name'].": ".$options_rate['option_rate']."(".$reservation_details['accommodation']." days)<br>";
						}
					}
					else 
					{
						echo "N/A";
					}
					?>
				</td>
			</tr>
			<tr bgcolor="#f5e8c8">
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Discount(%):</b></td>
				<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;"><?php echo $reservation_details['discount']."%"; ?></td>
			</tr>
			<tr>
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Tax:</b></td>
				<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
					<?php 
					if(count($reservation_details['tax_rate'])>0)
					{
						foreach($reservation_details['tax_rate'] as $tax_rate)
						{
							echo $tax_rate['tax_name'].": ".$tax_rate['tax_rate']."<br>";
						}
					}
					else 
					{
						echo "N/A";
					}
					?>
				</td>
			</tr>
			<tr bgcolor="#f5e8c8">
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Total:</b></td>
				<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;"><?php echo $reservation_details['total']; ?></td>
			</tr>
			<tr>
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Paid Amount:</b></td>
				<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;"><?php echo $reservation_details['paid_amount']; ?></td>
			</tr>
			<tr bgcolor="#f5e8c8">
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Due Amount:</b></td>
				<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;"><?php echo $reservation_details['due_amount']; ?></td>
			</tr>
			<tr>
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Payment Mode:</b></td>
				<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;"><?php echo $reservation_details['payment_mode']; ?></td>
			</tr>
			<tr bgcolor="#f5e8c8">
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Payment Status:</b></td>
				<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;"><?php echo $reservation_details['payment_status']; ?></td>
			</tr>
			<tr>
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Reservation Status:</b></td>
				<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;"><?php echo $reservation_details['reservation_status']; ?></td>
			</tr>
		</table>
		<?php 
	}
	
	
	//Function for getting print details of cleaning date
	function ajax_get_print_cleaning_details()
	{
		$cleaning_date=$_POST['cleaning_date'];
		$cleaning_details=$this->home_model->get_cleaning_print_details($cleaning_date);
		echo $cleaning_details;
	}
}
?>