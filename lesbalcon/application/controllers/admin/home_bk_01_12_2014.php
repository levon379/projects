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
	}
	function index()
	{
		$unique_years=$this->home_model->get_unique_years_from_reservation();
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
	/*function mobile()
	{
		$unique_years=$this->home_model->get_unique_years_from_reservation();
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
	} */
	
	
	
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
		
		$users_list=$this->home_model->get_all_users();
		$bungalow_details=$this->home_model->get_bungalow_details($bungalow_id);
		$bungalow_options_details=$this->home_model->get_options_details($bungalow_id);
		?>
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
				<form id="reservation_add_form" action="<?php echo base_url(); ?>admin/home/add_reservation" method="POST" onsubmit="return validate_add_reservation()">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title"><i class="fa fa-wheelchair"></i>Add Reservation</h4>
					<div class="modal-body" style="min-height:100px;">
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
								<input type="text" name="arrival_date" id="arrival_date" class="form-control" readonly value="<?php echo $new_arrival_date; ?>">
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
								<input type="text" name="leave_date" id="leave_date" class="form-control" readonly value="">
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
		$users_list=$this->home_model->get_all_users();
		$bungalow_details=$this->home_model->get_bungalow_details($reservation_details[0]['bunglow_id']);
		$bungalow_options_details=$this->home_model->get_options_details($reservation_details[0]['bunglow_id']);
		?>
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
				<form id="reservation_add_form" action="<?php echo base_url(); ?>admin/home/edit_reservation" method="POST" onsubmit="return validate_edit_reservation()">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title"><i class="fa fa-wheelchair"></i>Edit Reservation</h4>
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
}
?>