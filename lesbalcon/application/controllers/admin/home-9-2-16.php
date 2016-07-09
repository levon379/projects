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
		$this->load->model('users_model');
		$this->load->model("payment_model");
		$this->load->library('user_agent');
		$this->load->model('language_model');
	}
	
	function index()
	{

		if( strstr($_SERVER["QUERY_STRING"],"res_id")){
			$part = explode("=", $_SERVER["QUERY_STRING"]);
			$this->users_model->download_invoice( $part[1] );
		}
		setlocale (LC_TIME, 'fr_FR.utf8','fra'); 

		// current month by default
		$arrival_date = date('Y-m-d', mktime(0,0,0,date('n'),1, date('Y'))); 
		$leave_date	 = date('Y-m-d', mktime(23,59,59,date('n'),date('t'), date('Y')));
		$Year = date('Y');
		$Month = date('n');
		$Month_name = ucfirst(strftime('%B')); //date('F');
		$date_data = array();
		if( !empty($_SERVER["QUERY_STRING"]) && preg_match('/([0-9]{4})-([0-9]{1,2})/', $_SERVER["QUERY_STRING"], $date_data)){
			$Year = $date_data[1];
			$Month = $date_data[2];
			$Month_name = strftime('%B', mktime(0,0,0,$Month,1, $Year));
			$arrival_date = date('Y-m-d', mktime(0,0,0,$Month,1, $Year));
			$leave_date	 = date('Y-m-d', mktime(23,59,59,$Month,date('t', mktime(0,0,0,$Month, 1, $Year) ), $Year));
		}	
	
		$days_count_in_current_month = date('t', mktime(0,0,0,$Month, 1, $Year) );
		
		//$this->output->enable_profiler(TRUE);
		$this->data['latest_booking']=$this->home_model->get_latest_booking();
		$this->data['bungalows_arr']=$this->home_model->get_bungalows($arrival_date, $leave_date);
		//print_r($this->data['bungalows_arr']); exit;
		$this->data['month_no'] = $Month;
		$this->data['year_no'] = $Year;
		$this->data['month_name'] = ucfirst($Month_name);
		$this->data['days_count_in_current_month'] = $days_count_in_current_month;
		
		$this->data['month_start_date'] = $arrival_date;
		$this->data['month_end_date'] = $leave_date;
		
		$this->data['next_month_link'] = base_url() . 'admin/home' .  date('?Y-m', 2+ mktime(23,59,59,$Month,$days_count_in_current_month, $Year));
		$this->data['prev_month_link'] = base_url() . 'admin/home' .  date('?Y-m', mktime(0,0,0,$Month,1,$Year) - 5 );

		if ( $this->mobile_browser() )
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
	
	private function mobile_browser (){
		
		$mobile_browser = 0;
		
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
		return $mobile_browser;
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
	
	
	function get_userdetails($u_id ='')
	{
		//echo $u_id; die;
	    //$u_id=$_GET['u_id'];	
		$result=$this->home_model->get_user_name($u_id);
		
		print_r($result);
	}
	

	
	function get_userdetails_new($u_id ='')
	{
		//echo $u_id; die;
	    $u_id=$_POST['u_id'];	
		$result=$this->home_model->get_user_name_new($u_id);
		
		print_r($result);
	}
	
	function ajax_get_bungalow_details_yr()
	{
		$bungalow_id = $_POST['bungalow_id'];
		$bungalow_details=$this->home_model->get_bungalow_details($bungalow_id);
		$bungalow_options_details=$this->home_model->get_options_details($bungalow_id);
		
		$selected_bungalow_cat_type=$this->home_model->get_bungalow_catergory_type($bungalow_id);
		$selected_bungalow_person=$this->home_model->get_bungalow_max_personbyID($bungalow_id);
		echo $selected_bungalow_cat_type."/".$selected_bungalow_person;
	}
	
	//Function for getting add reservation form
	function ajax_get_add_reservation_form()
	{
		if($_POST['task']=="extraRes")
		{
			$user_id = $_POST['user_id'];
			$user_details = $this->db->get_where("lb_users", array("id"=>$user_id))->result_array();	;
			
			$name = $user_details[0]["name"];
			$contact = $user_details[0]["contact_number"];
			$address = $user_details[0]["address"];
			$email = $user_details[0]["email"];
			
			$this->session->set_userdata("last_reservation_id", $_POST['parent_id']);
			$this->session->set_userdata("user_idd", $user_id);
			$this->session->set_userdata("name", $name);
			$this->session->set_userdata("phone", $contact);
			$this->session->set_userdata("email", $email);
			$this->session->set_userdata("address", $address);
			
		}
		
		$bungalow_id="";
		$new_arrival_date = $bunglow_name = "";

		$users_list=$this->home_model->get_registered_user();
		$bunglow_list=$this->home_model->get_all_bunglow();


		if($_POST['arrival_date']){
			$bungalow_id=$_POST['bungalow_id'];
			$bungalow_details=$this->home_model->get_bungalow_details($bungalow_id);
			$bungalow_options_details=$this->home_model->get_options_details($bungalow_id);
			//$user_rows= $this->home_model->get_user_name();

			$selected_bungalow_cat_type=$this->home_model->get_bungalow_catergory_type($bungalow_id);
			$selected_bungalow_person=$this->home_model->get_bungalow_max_personbyID($bungalow_id);

			$arrival_date_arr=explode("-", $_POST['arrival_date']);
			$new_arrival_date=$arrival_date_arr[2]."/".$arrival_date_arr[1]."/".$arrival_date_arr[0];

			$bungalow_name_part = explode("<span>",$bungalow_details[0]['bunglow_name']);
			$bunglow_name = $bungalow_name_part[0];
		}
		else{
			$selected_bungalow_cat_type=$this->session->userdata('cat_type');
			$selected_bungalow_person=$this->session->userdata('max_person');
		}
	
		?>
		 <script type="text/javascript">
			$(document).ready(function(){
				$('input.user_id').typeahead({
				  name: 'user_id',
				  remote : '<?php echo base_url(); ?>assets/autocomplete/data.php?query=%QUERY'
				});

				$(".tt-dropdown-menu").click(function(){
					getUserDetails();
				});

				$("#div_no_of_extra_real_adult").hide();
				$("#div_no_of_extra_adult").hide();
				$("#div_no_of_extra_kid").hide();
				$("#div_no_of_folding_bed_kid").hide();
				$("#div_no_of_folding_bed_adult").hide();
				$("#div_no_of_baby_bed").hide();

			
		});
		function getUserDetails(){
			var u_id=$("#user_idd").val();

			$.ajax({
				type: "post",
				url: "<?php echo base_url(); ?>admin/home/get_userdetails_new",
				data: { u_id: u_id },
				success: function(msg){
					var myString = msg;
					var arr=myString.split("^");
					var name = arr[0].replace('"','');
					var contact = arr[1]; 

					$("#reservation_name").val(name);
					$("#reservation_contact").val(contact);
					$("#user_id").val(arr[2].replace('"',''));
			     }								  
			});
	}
	
	function getBungalowDetails(bungalow_id)
	{
		$("#bungalow_ids").val(bungalow_id);
		filename = "ajax_get_bungalow_details_yr";
		$.post("<?php echo base_url(); ?>admin/home/"+filename, { "bungalow_id" : bungalow_id}, function(data){
					var x = data.split("/");
					$("#cat_type").val(x[0]);
					$("#max_person").val(x[1]);
				});
		
		
				
	}
		</script>
		
		
		

		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
				<form id="reservation_add_form" action="<?php echo base_url(); ?>admin/home/add_reservation" method="POST">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="window.location.reload();">&times;</button>
					<h4 class="modal-title"><i class="fa fa-bars"></i><?php echo lang("add_reservation"); ?></h4>
					<div class="modal-body" style="min-height:100px;">
						<input type="hidden" name="parent_id" id="parent_id" value="<?php echo $this->session->userdata('last_reservation_id'); ?>" />
						<input type="hidden" name="user_type" id="user_type" value="R">
						<input type="hidden" name="bungalow_id" id="bungalow_ids" value="<?php echo $bungalow_id; ?>">
						<input type="hidden" id="cat_type" value="<?php echo $selected_bungalow_cat_type; ?>" />
						<input type="hidden" id="max_person" value="<?php echo $selected_bungalow_person; ?>" />
						<div class="box-body">
						<div class="form-group">
							<label for="exampleInputPassword1"><?php echo lang("Bungalows") ?></label>
							<?php if($_POST['arrival_date']){ ?>
								<input type="text" name="bungalow_name" id="bungalow_name" style="width:80%;" class="form-control" value="<?php echo $bunglow_name; ?>">
							<?php } else { ?> 
								<?php /*?><select name="bungalow_name" id="bungalow_name" style="width:80%;" class="form-control test" onchange="$('#bungalow_ids').val(this.value);"><?php */?>
                                <select name="bungalow_name" id="bungalow_name" style="width:80%;" class="form-control test" onchange="getBungalowDetails(this.value);">
									<option value="">--Sélectionner--</option>
									<?php 
									foreach($bunglow_list as $bunglow)
									{
									?>
									<option value="<?php echo $bunglow['id']; ?>"><?php echo $bunglow['bunglow_name']; ?></option>
									<?php 
									}
									?>
								</select>
								<div class="form-group has-error" id="user_id_error" style="display:none;">
									<label class="control-label" for="inputError">
									<i class="fa fa-times-circle-o"> <?php echo lang("Bungalow_is_required"); ?></i>
									</label>
								</div>
							<?php } ?>
						</div>
						
						
						
						<div class="form-group">
							<label for="exampleInputPassword1"><?php echo lang("user"); ?></label><br/>
							<input type="hidden" name="user_id" id="user_id" value="<?php echo $this->session->userdata('user_idd'); ?>">
							<input type="text" name="user_idd" id="user_idd" class="form-control user_id" value="<?php echo $this->session->userdata('name'); ?>">
							<!-- <select name="user_id" id="user_id" style="width:80%;" class="form-control test">
								<option value="">--Sélectionner--</option>
								<?php 
								foreach($users_list as $user)
								{
								?>
								<option value="<?php echo $user['id']; ?>" <?php if($this->session->userdata('user_idd') == $user['id']) echo 'selected="selected"'; ?>><?php echo $user['name']."&nbsp;&nbsp;[".$user['email']."&nbsp;]"; ?></option>
									
							
								<?php 
								}
								?>
							</select> -->
							<div class="form-group has-error" id="user_id_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> <?php echo lang("User_is_required"); ?></i>
								</label>
							</div>
						</div>
						<div id="department">
						<div class="form-group">
							<label for="exampleInputPassword1"><?php echo lang("Email"); ?></label>
							<input type="text" name="reservation_name" id="reservation_name" style="width:80%;" class="form-control" value="<?php echo $this->session->userdata('email'); ?>">
							<div class="form-group has-error" id="reservation_name_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> <?php echo lang("Email_is_required"); ?></i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1"><?php echo lang("Contact_no"); ?>.</label>
							<input type="text" name="reservation_contact" id="reservation_contact" style="width:80%;" class="form-control" value="<?php echo $this->session->userdata('phone'); ?>">
							<div class="form-group has-error" id="reservation_contact_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> <?php echo lang("Contact_No_is_required") ?></i>
								</label>
							</div>
						</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1"><?php echo lang("Arrival_Date"); ?></label>
							<div class='input-group date' id='reservation_arrival_date' style="width:80%;">
								<input type="text" name="arrival_date" id="arrival_date" class="form-control" readonly value="<?php echo $new_arrival_date; ?>" style="cursor:auto;">
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-calendar"></span>
								</span>
							</div>
							<div class="form-group has-error" id="arrival_date_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o" id="arrival_date_error_text"> <?php echo lang("Arrival_Date_is_required"); ?> </i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1"><?php echo lang("Leave_Date"); ?></label>
							<div class='input-group date' id='reservation_leave_date' style="width:80%;">
								<input type="text" name="leave_date" id="leave_date" class="form-control" readonly value="" style="cursor:auto;">
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-calendar"></span>
								</span>
							</div>
							<div class="form-group has-error" id="leave_date_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o" id="leave_date_error_text"> <?php echo lang("Leave_Date_is_required"); ?></i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">Source</label>
							<select name="source" id="source" style="width:80%;" class="form-control">
								<option value="Amis">Amis</option>
								<option value="Amis Recommandation">Amis Recommandation</option>
								<option value="Antilles Location">Antilles Location</option>
								<option value="Direct">Direct</option>
								<option value="Gaia Voyages">Gaia Voyages</option>
								<option value="Lonely Planet">Lonely Planet</option>
								<option value="Manual" selected="selected">Manual</option>
								<option value="Mireille Voyage Malavey">Mireille Voyage Malavey</option>
								<option value="Nadige Melt">Nadige Melt</option>
								<option value="Office du tourisme">Office du tourisme</option>
								<option value="Paul and Susie Hammersky">Paul and Susie Hammersky</option>
								<option value="Propriétaire">Propriétaire</option>
								<option value="Repeat">Repeat</option>
								<option value="Repeat SC">Repeat SC</option>
								<option value="Ron and Andy Stein">Ron and Andy Stein</option>
								<option value="St Martin Vacation">St Martin Vacation</option>
								<option value="TripAdvisor">TripAdvisor</option>
								<option value="VRBO SC">VRBO SC</option>
								<option value="Website">Website</option>
							</select>
						</div>
						

						<div class="form-group">
							<label for="exampleInputPassword1"><?php echo lang('no_of_adult'); ?></label>
							<select name="no_of_adult" id="no_of_adult" style="width:80%;" class="form-control test" onchange="autoPopulateAdult();">
								<option value="">--Sélectionner--</option>
								<?php for($i = 1;$i<=2;$i++){?> 
								<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
							<?php } ?>
							</select>
							<div class="form-group has-error" id="no_of_adult_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> <?php echo lang('no_of_adul_is_required'); ?> </i>
								</label>
							</div>
						</div>


						<div class="form-group" id="div_no_of_extra_real_adult">
							<label><?php echo lang('no_of_extra_real_adult'); ?></label>
							<select name="no_of_extra_real_adult" id="no_of_extra_real_adult" style="width:80%;" class="form-control test" onchange="autoPopulateExtraRealAdult(this.value);">
								<option value="">--Sélectionner--</option>
							</select>
						</div>
						<div class="form-group" id="div_no_of_extra_adult">
							<label><?php echo lang('no_of_extra_adult'); ?></label>
							<select name="no_of_extra_adult" id="no_of_extra_adult" style="width:80%;" class="form-control test" onchange="autoPopulateExtraAdult(this.value);">
								<option value="">--Sélectionner--</option>
							</select>
						</div>
						<div class="form-group" id="div_no_of_extra_kid">
							<label><?php echo lang('no_of_extra_kid'); ?></label>
							<select name="no_of_extra_kid" id="no_of_extra_kid" style="width:80%;" class="form-control test" onchange="autoPopulateExtraKid(this.value);">
								<option value="">--Sélectionner--</option>
							</select>
						</div>
						<div class="form-group" id="div_no_of_folding_bed_kid">
							<label><?php echo lang('no_of_folding_bed_kid'); ?></label>
							<select name="no_of_folding_bed_kid" id="no_of_folding_bed_kid" style="width:80%;" class="form-control test" onchange="autoPopulateFoldingBedKid(this.value);"> 
								<option value="">--Sélectionner--</option> 
							</select>
						</div>
						<div class="form-group" id="div_no_of_folding_bed_adult">
							<label><?php echo lang('no_of_folding_bed_adult'); ?></label>
							<select name="no_of_folding_bed_adult" id="no_of_folding_bed_adult" style="width:80%;" class="form-control test" onchange="autoPopulateFoldingBedAdult(this.value);">
								<option value="">--Sélectionner--</option>
							</select>
						</div>
						<div class="form-group" id="div_no_of_baby_bed">
							<label><?php echo lang('no_of_baby_bed'); ?></label>
							<select name="no_of_baby_bed" id="no_of_baby_bed" style="width:80%;" class="form-control test">
								<option value="">--Sélectionner--</option>
							</select>
						</div>

						<?php
						//print_r($bungalow_options_details); 
						/*if(count($bungalow_options_details)>0)
						{
							?>
							<div class="form-group">
								<label for="exampleInputPassword1">Options</label><br>
								<?php 
								foreach($bungalow_options_details as $options)
								{
									?>
									<input type="checkbox" name="options_id[]" value="<?php echo $options['options_id'] ?>">&nbsp;<?php echo $options['options_name']."&nbsp;(&euro;".$options['charge_in_euro'].")"; ?>&nbsp;&nbsp;
									<?php 
								}
								?>
							</div>
							<?php 
						}*/
						?>
						<div class="form-group">
							<label for="exampleInputPassword1"><?php echo lang("Discount"); ?>(%)</label>
							<input type="text" name="reservation_discount" id="reservation_discount" style="width:80%;" class="form-control" value="0" onkeypress="return IsNumeric(event);" onblur="return MaxLength(this.value);">
							<div class="form-group has-error" id="reservation_discount_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> <?php echo lang("Discount_is_required")?></i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1"><?php echo lang("Admin_Comments"); ?></label>
							<textarea style="width:80%;" class="form-control" name="admin_comments" id="admin_comments"></textarea>
						</div>						
						<div class="form-group">
							<label for="exampleInputPassword1"><?php echo lang("User_Comments"); ?></label>
							<textarea style="width:80%;" class="form-control" name="invoice_comments" id="invoice_comments"></textarea>
						</div>
						</div>
						<div class="box-footer">
							<input type="button" class="btn btn-primary" name="save" id="btn_save" value="<?php echo lang("Submit"); ?>" disabled="true" onclick="return validate_add_reservation()">
							<input type="button" class="btn btn-primary" name="calculate" value="<?php echo lang("Calculate"); ?>" onclick="calculatePrice();">
						</div>
					</div>
				</form>
				</div>
			</div>
		</div>
		<script>
		

			$('#reservation_arrival_date').datetimepicker({
				format:'dd/mm/yyyy',
				language:  'fr',
				weekStart: 1,
				todayBtn:  1,
				autoclose: 1,
				todayHighlight: 1,
				startView: 2,
				minView: 2,
				forceParse: 0
			}).on('changeDate', function(e){
		       $('#reservation_leave_date').datetimepicker('setStartDate', $("#arrival_date").val());
		    });
			$('#reservation_leave_date').datetimepicker({
				format:'dd/mm/yyyy',
                                startDate:'<?php echo $new_arrival_date; ?>',
				language:  'fr',
				weekStart: 1,
				todayBtn:  1,
				autoclose: 1,
				todayHighlight: 1,
				startView: 2,
				minView: 2,
				forceParse: 0
			}).on('changeDate', function(e){
			    $.ajax({
					type: "POST",
					data: { arrival_date: $('#arrival_date').val(),
							leave_date:   $('#leave_date').val(),
							bungalow_id:  $('#bungalow_ids').val()
						  },
					dataType: 'json',
					url: '<?php echo base_url() ?>reservation/ajax_check_availability',
					success: function(msg){
						if(msg.success){
							if(msg.available == "partial"){
								alert( "<?php echo lang('partial_available'); ?>" );
								$("#btn_save").attr('disabled','true');
							}
							else{
								$("#btn_save").removeAttr('disabled');
							}
						}else {
							alert( "<?php echo lang('unavailable'); ?>" );
							$("#btn_save").attr('disabled','true');
						}
					}
				});
		    });

	function calculatePrice(){
		$.ajax({
			type: "POST",
			data: { arrival_date: $('#arrival_date').val(),
					leave_date:   $('#leave_date').val(),
					bungalow_id:  $('#bungalow_ids').val()
				  },
			dataType: 'json',
			url: '<?php echo base_url() ?>reservation/ajax_check_availability',
			success: function(msg){
				if(msg.success && msg.available != "no"){
					if(msg.available == "partial"){
						alert( "<?php echo lang('partial_available'); ?>" );
						$("#btn_save").attr('disabled','true');
					}
					else{
						$("#btn_save").removeAttr('disabled');
						var val1 = ($('#no_of_adult option:selected').text() != "--Sélectionner--")?$('#no_of_adult option:selected').text():"0";
						var val2 = ($('#no_of_extra_real_adult option:selected').text() != "--Sélectionner--")?$('#no_of_extra_real_adult option:selected').text():"0";
						var val3 = ($('#no_of_extra_adult option:selected').text() != "--Sélectionner--")?$('#no_of_extra_adult option:selected').text():"0";
						var val4 = ($('#no_of_extra_kid option:selected').text() != "--Sélectionner--")?$('#no_of_extra_kid option:selected').text():"0";
						var val5 = ($('#no_of_folding_bed_kid option:selected').text()  != "--Sélectionner--")?$('#no_of_folding_bed_kid option:selected').text():"0";
						var val6 = ($('#no_of_folding_bed_adult option:selected').text()  != "--Sélectionner--")?$('#no_of_folding_bed_adult option:selected').text():"0";
						var val7 = ($('#no_of_baby_bed option:selected').text()  != "--Sélectionner--")?$('#no_of_baby_bed option:selected').text():"0";
						var tot = 0;
						var price = msg.price;
						if(val2 > 0) tot = (parseFloat(val2) * 15 * parseFloat(price['day_diff']));
						if(val3 > 0) tot += (parseFloat(val3) * 15 * parseFloat(price['day_diff']));
						if(val6 > 0) tot += (parseFloat(val6) * 15 * parseFloat(price['day_diff']));
						tot = parseFloat( price['stay_euro'] ) + tot;
						var disc = ($('#reservation_discount').val() != "")?$('#reservation_discount').val():"0";
						if(disc != "0") tot = tot - (tot * disc/100);

						var total =  tot + (tot * 4 / 100 );
						alert("<?php echo lang('price_of_the_stay'); ?> = "+price['stay_euro'] + " EUR, <?php echo lang('price_of_extra_stay'); ?> = "+tot + " EUR, <?php echo lang('total_prices'); ?> = "+total + " EUR");
					}
				}else {
					alert( "<?php echo lang('unavailable'); ?>" );
					$("#btn_save").attr('disabled','true');
				}
			}
		});
	}

	function autoPopulateAdult(){
			var cattype = $("#cat_type").val();
			var bungalow_id = $("#bungalow_id").val();
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
		var bungalow_id = $("#bungalow_id").val();
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
		var bungalow_id = $("#bungalow_id").val();
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
		var bungalow_id = $("#bungalow_id").val();
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
		var bungalow_id = $("#bungalow_id").val();
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
	</script>
	<?php } 
	
	//function for getting add reservation form for unregistered user
	function ajax_get_add_reservation_form_unregistered()
	{
		
		$new_arrival_date = "";
		if($_POST['arrival_date']){
			$arrival_date_arr=explode("-", $_POST['arrival_date']);
			$new_arrival_date=$arrival_date_arr[2]."/".$arrival_date_arr[1]."/".$arrival_date_arr[0];
			$bungalow_id=$_POST['bungalow_id'];
			$users_list=$this->home_model->get_all_users();
			$bungalow_details=$this->home_model->get_bungalow_details($bungalow_id);
			$bungalow_options_details=$this->home_model->get_options_details($bungalow_id);
			$language_arr = $this->language_model->get_rows();

			$selected_bungalow_cat_type=$this->home_model->get_bungalow_catergory_type($bungalow_id);
			$selected_bungalow_person=$this->home_model->get_bungalow_max_personbyID($bungalow_id);


			$bungalow_name_part = explode("<span>",$bungalow_details[0]['bunglow_name']);
			$bunglow_name = $bungalow_name_part[0];
		}				
		else{
			$selected_bungalow_cat_type=$this->session->userdata('cat_type');
			$selected_bungalow_person=$this->session->userdata('max_person');
		}
	
		$bunglow_list=$this->home_model->get_all_bunglow();
		$language_arr = $this->language_model->get_rows();
		?>
		<script type="text/javascript">
			$(document).ready(function(){
				$("#div_no_of_extra_real_adult").hide();
				$("#div_no_of_extra_adult").hide();
				$("#div_no_of_extra_kid").hide();
				$("#div_no_of_folding_bed_kid").hide();
				$("#div_no_of_folding_bed_adult").hide();
				$("#div_no_of_baby_bed").hide();
			});
		</script>
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
				<form id="reservation_add_form" action="<?php echo base_url(); ?>admin/home/add_reservation" method="POST">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title"><i class="fa fa-bars"></i><?php echo lang("add_reservation") ?></h4>
					<div class="modal-body" style="min-height:100px;">
						<input type="hidden" name="parent_id" id="parent_id" value="<?php echo $this->session->userdata('last_reservation_id'); ?>" />
						<input type="hidden" name="user_type" id="user_type" value="U">
						<input type="hidden" name="bungalow_id" id="bungalow_ids" value="<?php echo $bungalow_id; ?>">
						<input type="hidden" id="cat_type" value="<?php echo $selected_bungalow_cat_type; ?>" />
						<input type="hidden" id="max_person" value="<?php echo $selected_bungalow_person; ?>" />
						<input type="hidden" name="user_language" id="user_language" value="2" />
						<div class="box-body">
						<div class="form-group">
							<label for="exampleInputPassword1"><?php echo lang("User_Language")?></label>
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
							<label for="exampleInputPassword1"><?php echo lang("Name"); ?></label>
							<input type="text" name="reservation_name" id="reservation_name" style="width:80%;" class="form-control" value="<?php echo $this->session->userdata('name'); ?>">
							<div class="form-group has-error" id="reservation_name_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> <?php echo lang("Name_is_required"); ?></i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1"><?php echo lang("Email"); ?></label>
							<input type="text" name="reservation_email" id="reservation_email" style="width:80%;" class="form-control" value="<?php echo $this->session->userdata('email'); ?>">
							<div class="form-group has-error" id="reservation_email_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> <?php echo lang("Email_is_required"); ?></i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1"><?php echo lang("Contact_no"); ?></label>
							<input type="text" name="reservation_contact" id="reservation_contact" style="width:80%;" class="form-control" value="<?php echo $this->session->userdata('phone'); ?>">
							<div class="form-group has-error" id="reservation_contact_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> <?php echo lang("Contact_No_is_required"); ?></i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1"><?php echo lang("Address") ?></label>
							<textarea name="reservation_address" id="reservation_address" style="width:80%;" class="form-control"><?php echo $this->session->userdata('address'); ?></textarea>
							<div class="form-group has-error" id="reservation_address_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> <?php echo lang("Address_is_required") ?></i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1"><?php echo lang("Bungalows") ?></label>
							<?php if($_POST['arrival_date']){ ?>
								<input type="text" name="bungalow_name" id="bungalow_name" style="width:80%;" class="form-control" readonly value="<?php echo $bunglow_name; ?>">
							<?php } else { ?> 
								<select name="bungalow_name" id="bungalow_name" style="width:80%;" class="form-control test" onchange="$('#bungalow_ids').val(this.value);">
									<option value="">--Sélectionner--</option>
									<?php 
									foreach($bunglow_list as $bunglow)
									{
									?>
									<option value="<?php echo $bunglow['id']; ?>"><?php echo $bunglow['bunglow_name']; ?></option>
									<?php 
									}
									?>
								</select>
								<div class="form-group has-error" id="user_id_error" style="display:none;">
									<label class="control-label" for="inputError">
									<i class="fa fa-times-circle-o"> <?php echo lang("Bungalow_is_required"); ?></i>
									</label>
								</div>
							<?php } ?>
						</div>
						<?php 
						/*if(count($bungalow_options_details)>0)
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
						}*/
						?>
						<div class="form-group">
							<label for="exampleInputPassword1"><?php echo lang("Arrival_Date"); ?></label>
							<div class='input-group date' id='reservation_arrival_date' style="width:80%;">
								<input type="text" name="arrival_date" id="arrival_date" class="form-control" readonly value="<?php echo $new_arrival_date; ?>" style="cursor:auto;">
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-calendar"></span>
								</span>
							</div>
							<div class="form-group has-error" id="arrival_date_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o" id="arrival_date_error_text"> <?php echo lang("Arrival_Date_is_required"); ?></i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1"><?php echo lang("Leave_Date"); ?></label>
							<div class='input-group date' id='reservation_leave_date' style="width:80%;">
								<input type="text" name="leave_date" id="leave_date" class="form-control" readonly value="" style="cursor:auto;">
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-calendar"></span>
								</span>
							</div>
							<div class="form-group has-error" id="leave_date_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o" id="leave_date_error_text"> <?php echo lang("Leave_Date_is_required"); ?></i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">Source</label>
							<select name="source" id="source" style="width:80%;" class="form-control">
								<option value="Amis">Amis</option>
								<option value="Amis Recommandation">Amis Recommandation</option>
								<option value="Antilles Location">Antilles Location</option>
								<option value="Direct">Direct</option>
								<option value="Gaia Voyages">Gaia Voyages</option>
								<option value="Lonely Planet">Lonely Planet</option>
								<option value="Manual" selected="selected">Manual</option>
								<option value="Mireille Voyage Malavey">Mireille Voyage Malavey</option>
								<option value="Nadige Melt">Nadige Melt</option>
								<option value="Office du tourisme">Office du tourisme</option>
								<option value="Paul and Susie Hammersky">Paul and Susie Hammersky</option>
								<option value="Propriétaire">Propriétaire</option>
								<option value="Repeat">Repeat</option>
								<option value="Repeat SC">Repeat SC</option>
								<option value="Ron and Andy Stein">Ron and Andy Stein</option>
								<option value="St Martin Vacation">St Martin Vacation</option>
								<option value="TripAdvisor">TripAdvisor</option>
								<option value="VRBO SC">VRBO SC</option>
								<option value="Website">Website</option>
							</select>
						</div>

						<div class="form-group">
							<label for="exampleInputPassword1"><?php echo lang('no_of_adult'); ?></label>
							<select name="no_of_adult" id="no_of_adult" style="width:80%;" class="form-control test" onchange="autoPopulateAdult();">
								<option value="">--Sélectionner--</option>
								<?php for($i = 1;$i<=2;$i++){?> 
								<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
							<?php } ?>
							</select>
							<div class="form-group has-error" id="no_of_adult_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> <?php echo lang("no_of_adult_is_required"); ?></i>
								</label>
							</div>
						</div>


						<div class="form-group" id="div_no_of_extra_real_adult">
							<label><?php echo lang('no_of_extra_real_adult'); ?></label>
							<select name="no_of_extra_real_adult" id="no_of_extra_real_adult" style="width:80%;" class="form-control test" onchange="autoPopulateExtraRealAdult(this.value);">
								<option value="">--Sélectionner--</option>
							</select>
						</div>
						<div class="form-group" id="div_no_of_extra_adult">
							<label><?php echo lang('no_of_extra_adult'); ?></label>
							<select name="no_of_extra_adult" id="no_of_extra_adult" style="width:80%;" class="form-control test" onchange="autoPopulateExtraAdult(this.value);">
								<option value="">--Sélectionner--</option>
							</select>
						</div>
						<div class="form-group" id="div_no_of_extra_kid">
							<label><?php echo lang('no_of_extra_kid'); ?></label>
							<select name="no_of_extra_kid" id="no_of_extra_kid" style="width:80%;" class="form-control test" onchange="autoPopulateExtraKid(this.value);">
								<option value="">--Sélectionner--</option>
							</select>
						</div>
						<div class="form-group" id="div_no_of_folding_bed_kid">
							<label><?php echo lang('no_of_folding_bed_kid'); ?></label>
							<select name="no_of_folding_bed_kid" id="no_of_folding_bed_kid" style="width:80%;" class="form-control test" onchange="autoPopulateFoldingBedKid(this.value);"> 
								<option value="">--Sélectionner--</option> 
							</select>
						</div>
						<div class="form-group" id="div_no_of_folding_bed_adult">
							<label><?php echo lang('no_of_folding_bed_adult'); ?></label>
							<select name="no_of_folding_bed_adult" id="no_of_folding_bed_adult" style="width:80%;" class="form-control test" onchange="autoPopulateFoldingBedAdult(this.value);">
								<option value="">--Sélectionner--</option>
							</select>
						</div>
						<div class="form-group" id="div_no_of_baby_bed">
							<label><?php echo lang('no_of_baby_bed'); ?></label>
							<select name="no_of_baby_bed" id="no_of_baby_bed" style="width:80%;" class="form-control test">
								<option value="">--Sélectionner--</option>
							</select>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1"><?php echo lang("Discount"); ?>(%)</label>
							<input type="text" name="reservation_discount" id="reservation_discount" style="width:80%;" class="form-control" value="0" onkeypress="return IsNumeric(event);" onblur="return MaxLength(this.value);">
							<div class="form-group has-error" id="reservation_discount_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> <?php echo lang("Discount_is_required"); ?></i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1"><?php echo lang("Admin_Comments"); ?></label>
							<textarea style="width:80%;" class="form-control" name="admin_comments" id="admin_comments"></textarea>
						</div>						
						<div class="form-group">
							<label for="exampleInputPassword1"><?php echo lang("User_Comments"); ?></label>
							<textarea style="width:80%;" class="form-control" name="invoice_comments" id="invoice_comments"></textarea>
						</div>
						</div>
						<div class="box-footer">
							<input type="button" class="btn btn-primary" name="save" id="btn_save" value="<?php echo lang("Submit"); ?>" disabled="true" onclick="return validate_add_reservation()">
							<input type="button" class="btn btn-primary" name="calculate" value="<?php echo lang("Calculate"); ?>" onclick="calculatePrice();">
						</div>
					</div>
				</form>
				</div>
			</div>
		</div>
		<script>
			$('#reservation_arrival_date').datetimepicker({
				format:'dd/mm/yyyy',
				language:  'fr',
				weekStart: 1,
				todayBtn:  1,
				autoclose: 1,
				todayHighlight: 1,
				startView: 2,
				minView: 2,
				forceParse: 0
			}).on('changeDate', function(e){
		       $('#reservation_leave_date').datetimepicker('setStartDate', $("#arrival_date").val());
		    });
			$('#reservation_leave_date').datetimepicker({
				format:'dd/mm/yyyy',
                                startDate:'<?php echo $new_arrival_date; ?>',
				language:  'fr',
				weekStart: 1,
				todayBtn:  1,
				autoclose: 1,
				todayHighlight: 1,
				startView: 2,
				minView: 2,
				forceParse: 0
			}).on('changeDate', function(e){
			    $.ajax({
					type: "POST",
					data: { arrival_date: $('#arrival_date').val(),
							leave_date:   $('#leave_date').val(),
							bungalow_id:  $('#bungalow_ids').val()
						  },
					dataType: 'json',
					url: '<?php echo base_url() ?>reservation/ajax_check_availability',
					success: function(msg){
						if(msg.success){
							if(msg.available == "partial"){
								alert( "<?php echo lang('partial_available'); ?>" );
								$("#btn_save").attr('disabled','true');
							}
							else{
								$("#btn_save").removeAttr('disabled');
							}
						}else {
							alert( "<?php echo lang('unavailable'); ?>" );
							$("#btn_save").attr('disabled','true');
						}
					}
				});
			});


		function calculatePrice(){
			$.ajax({
				type: "POST",
				data: { arrival_date: $('#arrival_date').val(),
						leave_date:   $('#leave_date').val(),
						bungalow_id:  $('#bungalow_ids').val()
					  },
				dataType: 'json',
				url: '<?php echo base_url() ?>reservation/ajax_check_availability',
				success: function(msg){
					if(msg.success && msg.available != "no"){
						if(msg.available == "partial"){
							alert( "<?php echo lang('partial_available'); ?>" );
							$("#btn_save").attr('disabled','true');
						}
						else{
							$("#btn_save").removeAttr('disabled');
							var val1 = ($('#no_of_adult option:selected').text() != "--Sélectionner--")?$('#no_of_adult option:selected').text():"0";
							var val2 = ($('#no_of_extra_real_adult option:selected').text() != "--Sélectionner--")?$('#no_of_extra_real_adult option:selected').text():"0";
							var val3 = ($('#no_of_extra_adult option:selected').text() != "--Sélectionner--")?$('#no_of_extra_adult option:selected').text():"0";
							var val4 = ($('#no_of_extra_kid option:selected').text() != "--Sélectionner--")?$('#no_of_extra_kid option:selected').text():"0";
							var val5 = ($('#no_of_folding_bed_kid option:selected').text()  != "--Sélectionner--")?$('#no_of_folding_bed_kid option:selected').text():"0";
							var val6 = ($('#no_of_folding_bed_adult option:selected').text()  != "--Sélectionner--")?$('#no_of_folding_bed_adult option:selected').text():"0";
							var val7 = ($('#no_of_baby_bed option:selected').text()  != "--Sélectionner--")?$('#no_of_baby_bed option:selected').text():"0";
							var tot = 0;
							var price = msg.price;
							if(val2 > 0) tot = (parseFloat(val2) * 15 * parseFloat(price['day_diff']));
							if(val3 > 0) tot += (parseFloat(val3) * 15 * parseFloat(price['day_diff']));
							if(val6 > 0) tot += (parseFloat(val6) * 15 * parseFloat(price['day_diff']));

							tot = parseFloat( price['stay_euro'] ) + tot;
							var disc = ($('#reservation_discount').val() != "")?$('#reservation_discount').val():"0";
							if(disc != "0") tot = tot - (tot * disc/100);							
							var total =  tot + (tot * 4 / 100 );
							alert("<?php echo lang('price_of_the_stay'); ?> = "+price['stay_euro'] + " EUR, <?php echo lang('price_of_extra_stay'); ?> = "+tot + " EUR, <?php echo lang('total_prices'); ?> = "+total + " EUR");
						}
					}else {
						alert( "<?php echo lang('unavailable'); ?>" );
						$("#btn_save").attr('disabled','true');
					}
				}
			});
		}

		function autoPopulateAdult(){
		var cattype = $("#cat_type").val();
		var bungalow_id = $("#bungalow_id").val();
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
			var bungalow_id = $("#bungalow_id").val();
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
			var bungalow_id = $("#bungalow_id").val();
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
			var bungalow_id = $("#bungalow_id").val();
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
		var bungalow_id = $("#bungalow_id").val();
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
	</script>
	<?php
}

	//Function for add reservation from calendar
	function add_reservation()
	{
		$this->home_model->add_reservation();
		//redirect("admin/home?addsuccess");
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

		$selected_bungalow_cat_type=$this->home_model->get_bungalow_catergory_type($reservation_details[0]['bunglow_id']);
		$selected_bungalow_person=$this->home_model->get_bungalow_max_personbyID($reservation_details[0]['bunglow_id']);

		$bungalow_name_part = explode("<span>",$bungalow_details[0]['bunglow_name']);
		$bunglow_name = $bungalow_name_part[0];
		?>
		<script type="text/javascript">
			$(document).ready(function(){
				$("#div_no_of_extra_real_adult").hide();
				$("#div_no_of_extra_adult").hide();
				$("#div_no_of_extra_kid").hide();
				$("#div_no_of_folding_bed_kid").hide();
				$("#div_no_of_folding_bed_adult").hide();
				$("#div_no_of_baby_bed").hide();
			});
		</script>
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
				<form id="reservation_add_form" action="<?php echo base_url(); ?>admin/home/edit_reservation" method="POST" onsubmit="return validate_edit_reservation()">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title"><i class="fa fa-bars"></i>Edit Reservation</h4>
					<div class="modal-body" style="min-height:100px;">
						<input type="hidden" name="bungalow_id" id="bungalow_ids" value="<?php echo $reservation_details[0]['bunglow_id']; ?>">
						<input type="hidden" name="reservation_id" id="reservation_id" value="<?php echo $reservation_id; ?>">
						<input type="hidden" id="cat_type" value="<?php echo $selected_bungalow_cat_type; ?>" />
						<input type="hidden" id="max_person" value="<?php echo $selected_bungalow_person; ?>" />
						<div class="box-body">
						<div class="form-group">
							<label for="exampleInputPassword1">Bungalow/Property</label>
							<input type="text" name="bungalow_name" id="bungalow_name" style="width:80%;" class="form-control" readonly value="<?php echo $bunglow_name; ?>">
						</div>
						
						<?php 
						/*if(count($bungalow_options_details)>0)
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
						}*/
						?>
						
						<div class="form-group">
							<label for="exampleInputPassword1">User</label>
							<select name="user_id" id="user_id" style="width:80%;" class="form-control">
								<option value="">--Sélectionner--</option>
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
							<label for="exampleInputPassword1"><?php echo lang("Name"); ?></label>
							<input type="text" name="reservation_name" id="reservation_name" style="width:80%;" class="form-control" value="<?php echo $reservation_details[0]['name']; ?>">
							<div class="form-group has-error" id="reservation_name_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> <?php echo lang("Name_is_required"); ?></i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1"><?php echo lang("Contact_no"); ?>.</label>
							<input type="text" name="reservation_contact" id="reservation_contact" style="width:80%;" class="form-control" value="<?php echo $reservation_details[0]['phone']; ?>">
							<div class="form-group has-error" id="reservation_contact_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> Contact No is required</i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1"><?php echo lang("Arrival_Date"); ?></label>
							<div class='input-group date' id='reservation_arrival_date' style="width:80%;">
								<input type="text" name="arrival_date" id="arrival_date" class="form-control" readonly value="<?php echo $arrival_date; ?>">
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-calendar"></span>
								</span>
							</div>
							<div class="form-group has-error" id="arrival_date_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o" id="arrival_date_error_text"> <?php echo lang("Arrival_Date_is_required"); ?></i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1"><?php echo lang("Leave_Date"); ?></label>
							<div class='input-group date' id='reservation_leave_date' style="width:80%;">
								<input type="text" name="leave_date" id="leave_date" class="form-control" readonly value="<?php echo $leave_date; ?>">
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-calendar"></span>
								</span>
							</div>
							<div class="form-group has-error" id="leave_date_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o" id="leave_date_error_text"> <?php echo lang("Leave_Date_is_required"); ?></i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">Source</label>
							<select name="source" id="source" style="width:80%;" class="form-control">
								<option value="Amis" <?php if($source=="Amis"){ echo "selected";} ?>>Amis</option>
								<option value="Amis Recommandation" <?php if($source=="Amis Recommandation"){ echo "selected";} ?>>Amis Recommandation</option>
								<option value="Antilles Location" <?php if($source=="Antilles Location"){ echo "selected";} ?>>Antilles Location</option>
								<option value="Direct" <?php if($source=="Direct"){ echo "selected";} ?>>Direct</option>
								<option value="Gaia Voyages" <?php if($source=="Gaia Voyages"){ echo "selected";} ?>>Gaia Voyages</option>
								<option value="Lonely Planet" <?php if($source=="Lonely Planet"){ echo "selected";} ?>>Lonely Planet</option>
								<option value="Manual" <?php if($source=="Manual" || $source==''){ echo "selected";} ?>>Manual</option>
								<option value="Mireille Voyage Malavey" <?php if($source=="Mireille Voyage Malavey"){ echo "selected";} ?>>Mireille Voyage Malavey</option>
								<option value="Nadige Melt" <?php if($source=="Nadige Melt"){ echo "selected";} ?>>Nadige Melt</option>
								<option value="Office du tourisme" <?php if($source=="Office du tourisme"){ echo "selected";} ?>>Office du tourisme</option>
								<option value="Paul and Susie Hammersky" <?php if($source=="Paul and Susie Hammersky"){ echo "selected";} ?>>Paul and Susie Hammersky</option>
								<option value="Propriétaire" <?php if($source=="Propriétaire"){ echo "selected";} ?>>Propriétaire</option>
								<option value="Repeat" <?php if($source=="Repeat"){ echo "selected";} ?>>Repeat</option>
								<option value="Repeat SC" <?php if($source=="Repeat SC"){ echo "selected";} ?>>Repeat SC</option>
								<option value="Ron and Andy Stein" <?php if($source=="Ron and Andy Stein"){ echo "selected";} ?>>Ron and Andy Stein</option>
								<option value="St Martin Vacation" <?php if($source=="St Martin Vacation"){ echo "selected";} ?>>St Martin Vacation</option>
								<option value="TripAdvisor" <?php if($source=="TripAdvisor"){ echo "selected";} ?>>TripAdvisor</option>
								<option value="VRBO SC" <?php if($source=="VRBO SC"){ echo "selected";} ?>>VRBO SC</option>
								<option value="Website" <?php if($source=="Website"){ echo "selected";} ?>>Website</option>
							</select>
						</div>
						<div id="saved_persons">
								<div class="form-group">
									<label for="exampleInputPassword1"><?php echo lang('no_of_adult'); ?>: </label>
									<a href="javascript:void(0)" onclick="var r = confirm('<?php echo lang('do_you_want_to_update'); ?>');
																		  if (r == true) {
																		  	$('#saved_persons').hide(); $('#new_persons').show(); 
																		  }else {
																		  	$('#saved_persons').show(); $('#new_persons').hide(); 																		  	
																		  }">Change</a>
									<input type="text" onkeypress="return false" name="no_of_adult" style="width:80%;" class="form-control" value="<?php echo $reservation_details[0]['no_of_adult']; ?>" />
								</div>
								<?php if($reservation_details[0]['no_of_extra_real_adult'] > 0){ ?>
									<div class="form-group">
										<label for="exampleInputPassword1"><?php echo lang('no_of_extra_real_adult'); ?>: </label>
										<input type="text" onkeypress="return false" name="no_of_extra_real_adult" style="width:80%;" class="form-control" value="<?php echo $reservation_details[0]['no_of_extra_real_adult']; ?>" />
									</div>
								<?php } if($reservation_details[0]['no_of_extra_adult'] > 0){ ?>
									<div class="form-group">
										<label for="exampleInputPassword1"><?php echo lang('no_of_extra_adult'); ?>: </label>
										<input type="text" onkeypress="return false" name="no_of_extra_adult" style="width:80%;" class="form-control" value="<?php echo $reservation_details[0]['no_of_extra_adult']; ?>" />
									</div>
								<?php } if($reservation_details[0]['no_of_extra_kid'] > 0){ ?>
									<div class="form-group">
										<label for="exampleInputPassword1"><?php echo lang('no_of_extra_kid'); ?>: </label>
										<input type="text" onkeypress="return false" name="no_of_extra_kid" style="width:80%;" class="form-control" value="<?php echo $reservation_details[0]['no_of_extra_kid']; ?>" />
									</div>
								<?php } if($reservation_details[0]['no_of_folding_bed_kid'] > 0){ ?>
									<div class="form-group">
										<label for="exampleInputPassword1"><?php echo lang('no_of_folding_bed_kid'); ?>: </label>
										<input type="text" onkeypress="return false" name="no_of_folding_bed_kid" style="width:80%;" class="form-control" value="<?php echo $reservation_details[0]['no_of_folding_bed_kid']; ?>" />
									</div>
								<?php } if($reservation_details[0]['no_of_folding_bed_adult'] > 0){ ?>
									<div class="form-group">
										<label for="exampleInputPassword1"><?php echo lang('no_of_folding_bed_adult'); ?>: </label>
										<input type="text" onkeypress="return false" name="no_of_folding_bed_adult" style="width:80%;" class="form-control" value="<?php echo $reservation_details[0]['no_of_folding_bed_adult']; ?>" />
									</div>
								<?php } if($reservation_details[0]['no_of_baby_bed'] > 0){ ?>
									<div class="form-group">
										<label for="exampleInputPassword1"><?php echo lang('no_of_baby_bed'); ?>: </label>
										<input type="text" onkeypress="return false" name="no_of_baby_bed" style="width:80%;" class="form-control" value="<?php echo $reservation_details[0]['no_of_baby_bed']; ?>" />
									</div>
								<?php } ?>
							</div>
							<div class="form-group" id="new_persons" style="display:none;">
								<label for="exampleInputPassword1"><?php echo lang('no_of_adult'); ?></label>
								<select name="no_of_adult" id="no_of_adult" style="width:80%;" class="form-control test" onchange="autoPopulateAdult();">
									<option value="">--Sélectionner--</option>
									<?php for($i = 1;$i<=2;$i++){?> 
									<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
								<?php } ?>
								</select>
								<div class="form-group has-error" id="no_of_adult_error" style="display:none;">
									<label class="control-label" for="inputError">
									<i class="fa fa-times-circle-o"> <?php echo lang("no_of_adult_is_required"); ?></i>
									</label>
								</div>
							</div>


							<div class="form-group" id="div_no_of_extra_real_adult" style="display:none;">
								<label><?php echo lang('no_of_extra_real_adult'); ?></label>
								<select name="no_of_extra_real_adult" style="width:80%;" id="no_of_extra_real_adult" class="form-control test" onchange="autoPopulateExtraRealAdult(this.value);">
									<option value="">--Sélectionner--</option>
								</select>
							</div>
							<div class="form-group" id="div_no_of_extra_adult" style="display:none;">
								<label><?php echo lang('no_of_extra_adult'); ?></label>
								<select name="no_of_extra_adult" style="width:80%;" id="no_of_extra_adult" class="form-control test" onchange="autoPopulateExtraAdult(this.value);">
									<option value="">--Sélectionner--</option>
								</select>
							</div>
							<div class="form-group" id="div_no_of_extra_kid" style="display:none;">
								<label><?php echo lang('no_of_extra_kid'); ?></label>
								<select name="no_of_extra_kid" style="width:80%;" id="no_of_extra_kid" class="form-control test" onchange="autoPopulateExtraKid(this.value);">
									<option value="">--Sélectionner--</option>
								</select>
							</div>
							<div class="form-group" id="div_no_of_folding_bed_kid" style="display:none;">
								<label><?php echo lang('no_of_folding_bed_kid'); ?></label>
								<select name="no_of_folding_bed_kid" style="width:80%;" id="no_of_folding_bed_kid" class="form-control test" onchange="autoPopulateFoldingBedKid(this.value);"> 
									<option value="">--Sélectionner--</option> 
								</select>
							</div>
							<div class="form-group" id="div_no_of_folding_bed_adult" style="display:none;">
								<label><?php echo lang('no_of_folding_bed_adult'); ?></label>
								<select name="no_of_folding_bed_adult" style="width:80%;" id="no_of_folding_bed_adult" class="form-control test" onchange="autoPopulateFoldingBedAdult(this.value);">
									<option value="">--Sélectionner--</option>
								</select>
							</div>
							<div class="form-group" id="div_no_of_baby_bed" style="display:none;">
								<label><?php echo lang('no_of_baby_bed'); ?></label>
								<select name="no_of_baby_bed" style="width:80%;" id="no_of_baby_bed" class="form-control test">
									<option value="">--Sélectionner--</option>
								</select>
							</div>

							<div class="form-group">
								<label for="exampleInputPassword1">Text</label>
								<textarea class="form-control" style="width:80%;" name="reservation_text" id="reservation_text"><?php echo $reservation_details[0]['comment']; ?></textarea>
							</div>
							<div class="form-group">
								<label for="exampleInputPassword1">Comments</label>
								<textarea class="form-control" style="width:80%;" name="txt_comments" id="txt_comments" style="height:200px;"><?php echo str_ireplace("<br />", "\n", $reservation_details[0]['comments']); ?></textarea>
							</div>
							<div class="form-group">
								<label for="exampleInputPassword1">Amount Summary: </label><br/>
								Total Amount: <?php echo $reservation_details[0]["amount_to_be_paid"]; ?><br/>
								Paid Amount: <?php echo $reservation_details[0]["paid_amount"]; ?><br/>
								Due Amount: <?php echo $reservation_details[0]["due_amount"]; ?><br/>
								<input type="hidden" id="hid_due_amount" name="hid_due_amount" value="<?php echo str_replace("€", "", $reservation_details[0]["due_amount"]); ?>">
								<input type="hidden" id="hid_paid_amount" name="hid_paid_amount" value="<?php echo str_replace("€", "", $reservation_details[0]["paid_amount"]); ?>">
								<?php if($reservation_details[0]["due_amount"] != 0){ ?><input type="text" style="width:80%;" id="txt_amount_paid" name="txt_amount_paid" class="form-control" onblur="checkAmount($('#hid_due_amount').val(),this.value);" /> <?php } ?>
							</div>
							<div class="form-group" id="div_payment_mode">
								<label><?php echo lang("Payment_Mode"); ?></label>
								<select name="payment_mode" id="payment_mode" style="width:80%;" class="form-control test">
									<option value="">--Sélectionner--</option>
									<option value="Carte de Credit" <?php if($reservation_details[0]['payment_mode']=="Carte de Credit"){ echo "selected"; } ?>>Carte de Credit</option>
									<option value="Cash" <?php if($reservation_details[0]['payment_mode']=="Cash"){ echo "selected"; } ?>>Cash</option>
									<option value="Paypal" <?php if($reservation_details[0]['payment_mode']=="Paypal"){ echo "selected"; } ?>>Paypal</option>
									<option value="Virement" <?php if($reservation_details[0]['payment_mode']=="Virement"){ echo "selected"; } ?>>Virement</option>
								</select>
							</div>							
							<div class="form-group" id="div_date_payment_mode">
								<label>Date of payment</label>
								<div class='input-group date' id='datetimepickerpayment' style="width:200px">
									<input type='text' name="search_arrival_date_p" id="search_arrival_date_p" class="form-control" style="cursor:auto;" readonly data-date-format="DD/MM/YYYY" value="<?php echo $reservation_details[0]['date_payment_mode']; ?>" />
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
								</div>
								<label style="color:red;" id="search_arrival_date_error"></label>		
							</div>
							<div class="form-group" id="div_pending_status">
								<label><?php echo lang("Payment_Status");?></label>
								<select name="sel_pending_status" id="sel_pending_status" style="width:80%;" class="form-control test">
									<option value="En Attente" <?php if($reservation_details[0]['payment_status']=="En Attente" || $reservation_details[0]['payment_status']==""){ echo "selected"; } ?>>En Attente</option>
									<option value="Acompte Payé" <?php if($reservation_details[0]['payment_status']=="Acompte Payé"){ echo "selected"; } ?>>Acompte Payé</option>
									<option value="Réglé" <?php if($reservation_details[0]['payment_status']=="Réglé"){ echo "selected"; } ?>>Réglé</option>
								</select>
							</div>
							<div class="form-group" id="div_reservation_status">
								<label><?php echo lang("Reservation_Status"); ?></label>
								<select name="sel_resrevation_status" id="sel_resrevation_status" style="width:80%;" class="form-control test">
									<option value="En Attente" <?php if($reservation_details[0]['reservation_status']=="En Attente" || $reservation_details[0]['reservation_status'] == ''){ echo "selected"; } ?>>En Attente</option>
									<option value="Confirmée" <?php if($reservation_details[0]['reservation_status']=="Confirmée"){ echo "selected"; } ?>>Confirmée</option>
									<option value="Payée" <?php if($reservation_details[0]['reservation_status']=="Payée"){ echo "selected"; } ?>>Payée</option>
									<option value="Annulée" <?php if($reservation_details[0]['reservation_status']=="Annulée"){ echo "selected"; } ?>>Annulée</option>
								</select>
							</div>
						</div>
						<div class="box-footer">
							<input type="submit" class="btn btn-primary" name="save" id="btn_save" value="<?php echo lang("Submit"); ?>">
							<input type="button" class="btn btn-primary" name="calculate" value="<?php echo lang("Calculate"); ?>" onclick="calculatePrice();">	
							<a class="btn btn-primary" href="send_email_to_users?<?php echo $reservation_id; ?>">Send Mail</a>	
											
						</div>
					</div>
				</form>
				</div>
			</div>
		</div>
		<script>
			$('#reservation_arrival_date').datetimepicker({
				format:'dd/mm/yyyy',
				language:  'fr',
				weekStart: 1,
				todayBtn:  1,
				autoclose: 1,
				todayHighlight: 1,
				startView: 2,
				minView: 2,
				forceParse: 0
			}).on('changeDate', function(e){
		       $('#reservation_leave_date').datetimepicker('setStartDate', $("#arrival_date").val());
		    });
			$('#reservation_leave_date').datetimepicker({
				format:'dd/mm/yyyy',
                                startDate:'<?php echo $new_arrival_date; ?>',
				language:  'fr',
				weekStart: 1,
				todayBtn:  1,
				autoclose: 1,
				todayHighlight: 1,
				startView: 2,
				minView: 2,
				forceParse: 0
			}).on('changeDate', function(e){
			    $.ajax({
					type: "POST",
					data: { arrival_date: $('#arrival_date').val(),
							leave_date:   $('#leave_date').val(),
							bungalow_id:  $('#bungalow_ids').val()
						  },
					dataType: 'json',
					url: '<?php echo base_url() ?>reservation/ajax_check_availability',
					success: function(msg){
						if(msg.success){
							if(msg.available == "partial"){
								alert( "<?php echo lang('partial_available'); ?>" );
							}
						}else {
							alert( "<?php echo lang('unavailable'); ?>" );
						}
					}
				});
			});

	function calculatePrice(){
		$.ajax({
			type: "POST",
			data: { arrival_date: $('#arrival_date').val(),
					leave_date:   $('#leave_date').val(),
					bungalow_id:  $('#bungalow_ids').val(),
					reservation_id:  $('#reservation_id').val()
				  },
			dataType: 'json',
			url: '<?php echo base_url() ?>reservation/ajax_check_availability',
			success: function(msg){
				if(msg.success && msg.available != "no"){
					if(msg.available == "partial"){
						alert( "<?php echo lang('partial_available'); ?>" );
					}
					else{
						var val1 = ($('#no_of_adult option:selected').text() != "--Sélectionner--")?$('#no_of_adult option:selected').text():"0";
						var val2 = ($('#no_of_extra_real_adult option:selected').text() != "--Sélectionner--")?$('#no_of_extra_real_adult option:selected').text():"0";
						var val3 = ($('#no_of_extra_adult option:selected').text() != "--Sélectionner--")?$('#no_of_extra_adult option:selected').text():"0";
						var val4 = ($('#no_of_extra_kid option:selected').text() != "--Sélectionner--")?$('#no_of_extra_kid option:selected').text():"0";
						var val5 = ($('#no_of_folding_bed_kid option:selected').text()  != "--Sélectionner--")?$('#no_of_folding_bed_kid option:selected').text():"0";
						var val6 = ($('#no_of_folding_bed_adult option:selected').text()  != "--Sélectionner--")?$('#no_of_folding_bed_adult option:selected').text():"0";
						var val7 = ($('#no_of_baby_bed option:selected').text()  != "--Sélectionner--")?$('#no_of_baby_bed option:selected').text():"0";
						var tot = 0;
						var price = msg.price;
						if(val2 > 0) tot = (parseFloat(val2) * 15 * parseFloat(price['day_diff']));
						if(val3 > 0) tot += (parseFloat(val3) * 15 * parseFloat(price['day_diff']));
						if(val6 > 0) tot += (parseFloat(val6) * 15 * parseFloat(price['day_diff']));
						var total = parseFloat( price['stay_euro'] ) + tot + (( parseFloat( price['stay_euro'] ) + tot ) * 4 / 100 );
						alert("<?php echo lang('price_of_the_stay'); ?> = "+price['stay_euro'] + " EUR, <?php echo lang('price_of_extra_stay'); ?> = "+tot + " EUR, <?php echo lang('total_prices'); ?> = "+total + " EUR");
					}
				}else {
					alert( "<?php echo lang('unavailable'); ?>" );
				}
			}
		});
	}

	function autoPopulateAdult(){
		var r = confirm("<?php echo lang('do_you_want_to_update'); ?>");
		if (r == true) {
			var cattype = $("#cat_type").val();
			var bungalow_id = $("#bungalow_id").val();
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
		}
		else{
			$("#no_of_adult").val('');
		}
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
		var bungalow_id = $("#bungalow_id").val();
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
		var bungalow_id = $("#bungalow_id").val();
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
		var bungalow_id = $("#bungalow_id").val();
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
		var bungalow_id = $("#bungalow_id").val();
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
	</script>
	<?php } 
	
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
		$reservation_details=$this->payment_model->get_payment_details_old($reservation_id);
		$linked_reservation_details=$this->home_model->get_linked_reservations($reservation_id);
		$bungalow_name_part = explode("<span>", $reservation_details['bungalow_name']);
		$bunglow_name = $bungalow_name_part[0];
		?>
		<script type="text/javascript">
			function change_status(id, pstatus,rstatus)
			{

				var payment_mode = $("#payment_mode").val();
				var date_payment_mode = $("#search_arrival_date_p").val();


				if(rstatus){
					$.post("<?php echo base_url(); ?>admin/payment/ajax_change_reservation_status", { "id":id, "status":rstatus }, function(data){});
				}
				if(pstatus){
					$.post("<?php echo base_url(); ?>admin/payment/ajax_change_payment_status", { "id":id, "status":pstatus }, function(data){});
				}
				var paid_amount = $('#hid_paid_amount').val();
				var due_amount = $('#hid_due_amount').val();
				var pay_amount = $('#txt_amount_paid').val();
				if(pay_amount){
					$.post("<?php echo base_url(); ?>admin/payment/ajax_change_amount", { "id":id, "paid_amount":paid_amount,"due_amount":due_amount,"pay_amount":pay_amount, "payment_mode":payment_mode,"date_payment_mode":date_payment_mode , "reservation_status" :$('#reservation_status').val(),"payment_status":$('#payment_status').val()}, function(data){});
				}else{
					var txt_discount = $('#txt_discount').val();
					var txt_total = $('#txt_total').val();
					var txt_paid_amount = $('#txt_paid_amount').val();
					var txt_due_amount = $('#txt_due_amount').val();
					var admin_comments = $('#admin_comments').val();
					var invoice_comments = $('#invoice_comments').val();
					var source = $('#source').val();

					if(txt_discount || txt_total || txt_paid_amount || txt_due_amount || admin_comments || invoice_comments || source){
						$.post("<?php echo base_url(); ?>admin/payment/ajax_edit_amount", { "id":id, "txt_discount":txt_discount,"txt_total":txt_total,"txt_paid_amount":txt_paid_amount , "txt_due_amount" :txt_due_amount,"admin_comments":admin_comments,"invoice_comments":invoice_comments , "source" :source}, function(data){});
					}
				}
				setTimeout(function() { /*alert('Changements sauvegardés avec succès'); */window.location.reload(); },8000);
			}

			function checkAmount(due_amount,paid_amount){
				due_amount = paid_amount.replace("€","");

				var error_count = 0;
				due_amount = parseFloat(due_amount);
				paid_amount1 = parseFloat(paid_amount);
				if(paid_amount.indexOf('.') >= 0){
					var val_part = paid_amount.split('.');
					var val2 = val_part[1];
					if(val2.length > 2){
						//alert("<?php echo lang('enter_anount_is_more'); ?>");
						alert("You cannot add more than 2 integer after decimal.");
						$('#txt_amount_paid').val('');
						error_count++;
					}
				}
				if(paid_amount1 > due_amount){
					alert("<?php echo lang('enter_anount_is_more') ?>");
					$('#txt_amount_paid').val('');
					error_count++;
				}

				if(error_count > 0){
					return false;
				}else{
					return true;
				}
			}

			function checkDigitAfterDecimal(field_name){
				var amount = $('#'+field_name+'').val();
				if(amount.indexOf('.') >= 0){
					var val_part = amount.split('.');
					var val2 = val_part[1];
					if(val2.length > 2){
						alert("You cannot add more than 2 integer after decimal.");
						$('#'+field_name+'').val('');
						return false;
					}
				}else{
					return true;
				}
			}

			$(function () {
				var date = new Date();
				date.setDate(date.getDate());
						
				$('#datetimepickerpayment').datetimepicker({
					format:'dd/mm/yyyy',
					language:  'fr',
					weekStart: 1,
					todayBtn:  1,
					autoclose: 1,
					todayHighlight: 1,
					startView: 2,
					minView: 2,
					forceParse: 0
				});

				$('#search_arrival_date_p').on('click', function(){
					$('#datetimepickerpayment').find('.glyphicon-calendar').trigger('click');
				});
			});
		</script>
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" onclick="window.location.reload();" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title"><i class="fa fa-bars"></i><?php echo lang("reservation_details"); ?></h4>
					<table class="table table-hover">
						<tr>
							<td><?php echo lang("Name"); ?>:</td>
							<td><?php echo $reservation_details['user_name'] ?></td>
						</tr>
						<tr>
							<td><?php echo lang("Email"); ?>:</td>
							<td><?php echo $reservation_details['user_email'] ?></td>
						</tr>
						<tr>
							<td><?php echo lang("Contact_no"); ?>:</td>
							<td><?php echo $reservation_details['user_phone'] ?></td>
						</tr>
						<tr>
							<td><?php echo lang("Bungalow_Name"); ?>:</td>
							<td><?php echo $bunglow_name; ?></td>
						</tr>
						<tr>
							<td>Source:</td>
							<td>
								<select name="source" id="source" style="width:80%;" class="form-control">
									<option value="Amis" <?php if($reservation_details['source']=="Amis"){ echo "selected";} ?>>Amis</option>
									<option value="Amis Recommandation" <?php if($reservation_details['source']=="Amis Recommandation"){ echo "selected";} ?>>Amis Recommandation</option>
									<option value="Antilles Location" <?php if($reservation_details['source']=="Antilles Location"){ echo "selected";} ?>>Antilles Location</option>
									<option value="Direct" <?php if($reservation_details['source']=="Direct"){ echo "selected";} ?>>Direct</option>
									<option value="Gaia Voyages" <?php if($reservation_details['source']=="Gaia Voyages"){ echo "selected";} ?>>Gaia Voyages</option>
									<option value="Lonely Planet" <?php if($reservation_details['source']=="Lonely Planet"){ echo "selected";} ?>>Lonely Planet</option>
									<option value="Manual" <?php if($reservation_details['source']=="Manual" || $source==''){ echo "selected";} ?>>Manual</option>
									<option value="Mireille Voyage Malavey" <?php if($reservation_details['source']=="Mireille Voyage Malavey"){ echo "selected";} ?>>Mireille Voyage Malavey</option>
									<option value="Nadige Melt" <?php if($reservation_details['source']=="Nadige Melt"){ echo "selected";} ?>>Nadige Melt</option>
									<option value="Office du tourisme" <?php if($reservation_details['source']=="Office du tourisme"){ echo "selected";} ?>>Office du tourisme</option>
									<option value="Paul and Susie Hammersky" <?php if($reservation_details['source']=="Paul and Susie Hammersky"){ echo "selected";} ?>>Paul and Susie Hammersky</option>
									<option value="Propriétaire" <?php if($reservation_details['source']=="Propriétaire"){ echo "selected";} ?>>Propriétaire</option>
									<option value="Repeat" <?php if($reservation_details['source']=="Repeat"){ echo "selected";} ?>>Repeat</option>
									<option value="Repeat SC" <?php if($reservation_details['source']=="Repeat SC"){ echo "selected";} ?>>Repeat SC</option>
									<option value="Ron and Andy Stein" <?php if($reservation_details['source']=="Ron and Andy Stein"){ echo "selected";} ?>>Ron and Andy Stein</option>
									<option value="St Martin Vacation" <?php if($reservation_details['source']=="St Martin Vacation"){ echo "selected";} ?>>St Martin Vacation</option>
									<option value="TripAdvisor" <?php if($reservation_details['source']=="TripAdvisor"){ echo "selected";} ?>>TripAdvisor</option>
									<option value="VRBO SC" <?php if($reservation_details['source']=="VRBO SC"){ echo "selected";} ?>>VRBO SC</option>
									<option value="Website" <?php if($reservation_details['source']=="Website"){ echo "selected";} ?>>Website</option>
								</select>
							</td>
						</tr>
						<tr>
							<td><?php echo lang("Reservation_Date"); ?>:</td>
							<td><?php echo date("d/m/Y H:i:s", strtotime($reservation_details['reservation_date'])); ?></td>
						</tr>
						<tr>
							<td><?php echo lang("Arrival_Date"); ?>:</td>
							<td><?php echo date("d/m/Y", strtotime($reservation_details['arrival_date'])); ?></td>
						</tr>
						<tr>
							<td><?php echo lang("Leave_Date"); ?>:</td>
							<td><?php echo date("d/m/Y", strtotime($reservation_details['leave_date'])); ?></td>
						</tr>
						<tr>
							<td><?php echo lang("Accommodation"); ?>:</td>
							<td><?php echo $reservation_details['accommodation']." ".lang("NIGHT"); ?></td>
						</tr>
						<tr>
							<td><?php echo lang("no_of_adult"); ?>:</td>
							<td><?php echo $reservation_details['no_of_adult']; ?></td>
						</tr>
						<?php if($reservation_details['no_of_extra_real_adult'] > 0){ ?>
							<tr>
								<td><?php echo lang("no_of_extra_real_adult"); ?>:</td>
								<td><?php echo $reservation_details['no_of_extra_real_adult']; ?></td>
							</tr>
						<?php } if($reservation_details['no_of_extra_adult'] > 0){ ?>
							<tr>
								<td><?php echo lang("no_of_extra_adult"); ?>:</td>
								<td><?php echo $reservation_details['no_of_extra_adult']; ?></td>
							</tr>
						<?php } if($reservation_details['no_of_extra_kid'] > 0){ ?>
							<tr>
								<td><?php echo lang("no_of_extra_kid"); ?>:</td>
								<td><?php echo $reservation_details['no_of_extra_kid']; ?></td>
							</tr>
						<?php } if($reservation_details['no_of_folding_bed_kid'] > 0){ ?>
							<tr>
								<td><?php echo lang("no_of_folding_bed_kid"); ?>:</td>
								<td><?php echo $reservation_details['no_of_folding_bed_kid']; ?></td>
							</tr>
						<?php } if($reservation_details['no_of_folding_bed_adult'] > 0){ ?>
							<tr>
								<td><?php echo lang("no_of_folding_bed_adult"); ?>:</td>
								<td><?php echo $reservation_details['no_of_folding_bed_adult']; ?></td>
							</tr>
						<?php } if($reservation_details['no_of_baby_bed'] > 0){ ?>
							<tr>
								<td><?php echo lang("no_of_baby_bed"); ?>:</td>
								<td><?php echo $reservation_details['no_of_baby_bed']; ?></td>
							</tr>
						<?php } ?>
						<tr>
							<td><?php echo lang("Bungalow_Rate"); ?>:</td>
							<td><?php echo $reservation_details['bungalow_rate']; ?></td> 
							<!-- <td><input type="text" id="txt_bungalow_rate" name="txt_bungalow_rate" onblur="checkDigitAfterDecimal('txt_bungalow_rate');" value="<?php echo $reservation_details['bungalow_rate']; ?>" /></td> -->
						</tr>
						<tr>
							<td><?php echo "Prix des personnes supplémentaires";//lang("price_of_extra_stay"); ?>:</td>
							<td>
								<?php 
								$extra_person = 0;
								$val2 = $reservation_details['no_of_extra_real_adult'];
								$val3 = $reservation_details['no_of_extra_adult'];
								$val6 = $reservation_details['no_of_folding_bed_adult'];
								if($val2 > 0) $tot = ($val2 * 15 * $reservation_details['accommodation']);
								if($val3 > 0) $tot += ($val3 * 15 * $reservation_details['accommodation']);
								if($val6 > 0) $tot += ($val6 * 15 * $reservation_details['accommodation']);
								$b_rate = str_replace("€","", $reservation_details['bungalow_rate']);
								$extra_person = $tot;
								$tot = ($b_rate + $tot);
								
								if($reservation_details['discount']!=0 && $reservation_details['discount']!='')
								$discount = ($tot * $reservation_details['discount']/100);
								else
								$discount=0;
								
								$tot = $tot-$discount;
								
								$tax = ($tot * 4/100);
								echo "€".$extra_person; 
								
								
								
								$totalAmt = $tot+$tax;
								$paidAmt = str_replace("€","", $reservation_details['paid_amount']);
								$dueAmt = $totalAmt-$paidAmt;
								?>
							</td> 
							<!-- <td><input type="text" id="txt_bungalow_rate" name="txt_bungalow_rate" onblur="checkDigitAfterDecimal('txt_bungalow_rate');" value="<?php echo $reservation_details['bungalow_rate']; ?>" /></td> -->
						</tr>

						<tr>
							<td><?php echo lang("Discount"); ?>(%):</td>
							<!-- <td><?php echo $reservation_details['discount']."%"; ?></td> -->
							<td><input type="text" id="txt_discount" name="txt_discount" onblur="checkDigitAfterDecimal('txt_discount');" value="<?php echo $reservation_details['discount']; ?>" /> %</td>
						</tr>
						<tr>
							<td><?php echo lang("tax"); ?>:</td>
							<td>4%</td>
						</tr>
						<tr>
							<td>Total du taxe:</td>
							<td><?php /*$total = str_replace("€","", $reservation_details['bungalow_rate']);*/ echo "€".number_format($tax, 2, '.', ',') ?></td>
						</tr>
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr>
							<td><?php echo lang("Amount_Summary"); ?>:</td><td></td>
						</tr>
						<tr>
							<td><?php echo lang("Total_Amount"); ?>: </td>
							<!-- <td><?php echo $reservation_details["total"]; ?></td> -->
							<td><input type="text" id="txt_total" name="txt_total" onblur="checkDigitAfterDecimal('txt_total');" value="<?php echo number_format($totalAmt, 2, '.', ','); ?>" /></td>
						</tr>
						<tr>
							<td><?php echo lang("Paid_Amount"); ?>: </td>
							<!-- <td><?php echo $reservation_details["paid_amount"]; ?></td> -->
							<td><input type="text" id="txt_paid_amount" onblur="checkDigitAfterDecimal('txt_paid_amount');" name="txt_paid_amount" value="<?php echo number_format($paidAmt, 2, '.', ','); ?>" /></td>
						</tr>								
						<tr>
							<td><?php echo lang("Due_Amount"); ?>: </td>
							<!-- <td><?php echo $reservation_details["due_amount"]; ?></td> -->
							<td><input type="text" id="txt_due_amount" onblur="checkDigitAfterDecimal('txt_due_amount');" name="txt_due_amount" value="<?php echo number_format($dueAmt, 2, '.', ','); ?>" /></td>
						</tr>
						<tr style="background-color:#ccc">
							<td><?php echo "Paiement Acompte";//lang("Amount"); ?>:</td>
							<td>
								<input type="hidden" id="hid_due_amount" name="hid_due_amount" value="<?php echo $reservation_details["due_amount"]; ?>">
								<input type="hidden" id="hid_paid_amount" name="hid_paid_amount" value="<?php echo $reservation_details["paid_amount"]; ?>">
								<?php if($reservation_details["due_amount"] != "€0"){ ?><input type="text" id="txt_amount_paid" name="txt_amount_paid" onblur="checkAmount('<?php echo $reservation_details["due_amount"]; ?>',this.value);" /> <?php } ?>
							</td>
						</tr>
						<tr>
							<td><?php echo lang("Payment_Mode"); ?>:</td>
							<td>
								<select id="payment_mode">
									<option value="">--Sélectionner--</option>
									<option value="Carte de Credit" <?php if($reservation_details['payment_mode']=="Carte de Credit"){ echo "selected"; } ?>>Carte de Credit</option>
									<option value="Cash" <?php if($reservation_details['payment_mode']=="Cash"){ echo "selected"; } ?>>Cash</option>
									<option value="Paypal" <?php if($reservation_details['payment_mode']=="Paypal"){ echo "selected"; } ?>>Paypal</option>
									<option value="Virement" <?php if($reservation_details['payment_mode']=="Virement"){ echo "selected"; } ?>>Virement</option>
								</select>
							</td>
						</tr>
						<tr>
							<td><?php echo lang("date_of_payment"); ?>:</td>
							<td>
								<div class='input-group date' id='datetimepickerpayment' style="width:200px">
									<input type='text' name="search_arrival_date_p" id="search_arrival_date_p" class="form-control" style="cursor:auto;" readonly data-date-format="DD/MM/YYYY" value="<?php echo $reservation_details['date_payment_mode']; ?>" />
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
								</div>
								<label style="color:red;" id="search_arrival_date_error"></label>						
							</td>
						</tr>
						<tr>
							<td><?php echo lang("Payment_Status").$reservation_details['payment_status'] ?>:</td>
							<td>
								<select id="payment_status">
									<option value="En Attente" <?php if($reservation_details['payment_status']=="En Attente" || $reservation_details['payment_status']==""){ echo "selected"; } ?>>En Attente</option>
									<option value="Acompte Payé" <?php if($reservation_details['payment_status']=="Acompte Payé"){ echo "selected"; } ?>>Acompte Payé</option>
									<option value="Réglé" <?php if($reservation_details['payment_status']=="Réglé"){ echo "selected"; } ?>>Réglé</option>
								</select>
							</td>
						</tr>
						<tr>
							<td><?php echo lang("Reservation_Status").$reservation_details['reservation_status']; ?>:</td>
							<td>
								<select id="reservation_status">
									<option value="En Attente" <?php if($reservation_details['reservation_status']=="En Attente" || $reservation_details['reservation_status'] == ''){ echo "selected"; } ?>>En Attente</option>
									<option value="Confirmée" <?php if($reservation_details['reservation_status']=="Confirmée"){ echo "selected"; } ?>>Confirmée</option>
									<option value="Payée" <?php if($reservation_details['reservation_status']=="Payée"){ echo "selected"; } ?>>Payée</option>
									<option value="Annulée" <?php if($reservation_details['reservation_status']=="Annulée"){ echo "selected"; } ?>>Annulée</option>
								</select>
							</td>
						</tr>
						<tr>
							<td><?php echo lang("Admin_Comments"); ?>: </td><!-- <td><?php echo $reservation_details["admin_comments"]; ?></td> -->
						</tr>
						<tr>
							<td colspan="2"><textarea style="resize:vertical; height:150px;" cols="50" class="form-control" name="admin_comments" id="admin_comments"><?php  echo strip_tags($reservation_details["admin_comments"]); ?></textarea></td>
						</tr>	
						<tr>
							<td><?php echo lang("User_Comments"); ?>: </td>
						</tr>
						<tr>
							<td colspan="2"><textarea style="resize:vertical; height:150px;" cols="50" class="form-control" name="invoice_comments" id="invoice_comments"><?php  echo strip_tags($reservation_details["invoice_comments"]); ?></textarea></td>
						</tr>	
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr>
							<td>
								<a class="btn btn-primary" id="btn_insta_save" onclick="$('#btn_insta_save').attr('disabled','true'); change_status('<?php echo $reservation_details['reservation_id'] ?>',$('#payment_status').val(),$('#reservation_status').val() )"><?php echo lang("Save")  ?></a>
                                
                                <?php if($reservation_details['parent_id']!='')
										$parent_id = $reservation_details['parent_id'];
										else
										$parent_id = $reservation_details['reservation_id'];
								 ?>
                                
                                <a class="btn btn-primary" onclick="extraReservation('<?=trim($reservation_details['reservation_id'])?>','R','<?=$parent_id?>','<?=$reservation_details['user_id']?>');">Extra Reservation</a>
							</td>
						</tr>
						<?php if(count($linked_reservation_details)){ ?>
						<tr>
							<td colspan="2" style="background-color:#ccc">Réservations liées: </td>
						</tr>
						<tr>
							<td colspan="2">
								<ul>
									<?php for($i=0;$i<count($linked_reservation_details);$i++){ ?>							
										<li>Reservation #<?php echo ($i+1).": ".$linked_reservation_details[$i]["bunglow_name"]."( ".$linked_reservation_details[$i]["arrival_date"]." à ".$linked_reservation_details[$i]["leave_date"]." )"; ?>&nbsp;&nbsp;<a target="_blank" href="<?php echo base_url(); ?>admin/payment/payment_edit/<?php echo $linked_reservation_details[$i]["id"]; ?>">Modifier</a></li>							
									<?php } ?>
								</ul>
							</td>
						</tr>
						<?php } ?>
						<tr>
							<td colspan="2">
								<a class="btn btn-primary" href="<?php echo base_url(); ?>admin/payment/payment_edit/<?php echo $reservation_id; ?>"><?php echo lang("edit_reservation"); ?></a>
								<a class="btn btn-primary" href="send_email_to_users?<?php echo $reservation_id; ?>"><?php echo lang("send_mail"); ?></a>
								<a class="btn btn-primary" target="_blank" href="?res_id=<?php echo $reservation_id; ?>"><?php echo lang("download"); ?></a>	
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<?php 
	}

	//function to get season array
	function getSeasons($day,$month,$year,$output=""){
		$cur_date = date('Y-m-d', mktime(0,0,0,$month,$day,$year));
		$high_start_date = date('Y-m-d', mktime(0,0,0,12,15,$year));
		$high_end_date = date('Y-m-d', mktime(0,0,0,4,14,($year+1)));

		$low_start_date = date('Y-m-d', mktime(0,0,0,4,15,$year));
		$low_end_date = date('Y-m-d', mktime(0,0,0,12,14,$year));
		$season_id = 0;
		if($cur_date >= $low_start_date && $cur_date <= $low_end_date) { $season_id = "2"; $season_name = lang("low_season"); }
		else {$season_id = "1";  $season_name = lang("high_season"); }

//echo $cur_date."*".$high_start_date."*".$high_end_date."*".$low_start_date."*".$low_end_date."---".$season_id;
		if($output == "") return $season_id;
		else return $season_name;
	}

	function ajax_get_details_for_tooltip()
	{
		$reservation_id=$_POST['reservation_id'];
		$reservation_details=$this->payment_model->get_payment_details_old($reservation_id);
		//print_r($reservation_details); die;

		$q_val = explode("-",$reservation_details['arrival_date']);		 
		$season_id = $this->getSeasons($q_val[2],$q_val[1],$q_val[0],"name");

		$q_val1 = explode("-",$reservation_details['leave_date']);		 
		$another_season_id = $this->getSeasons($q_val1[2],$q_val1[1],$q_val1[0],"name");

		if($season_id != $another_season_id){
			$season_name = $season_id."-".$another_season_id;
		}else{
			$season_name = $season_id;
		}		

		$admin_arr=$this->db->get_where("mast_admin_info", array('id'=>$reservation_details['created_by']))->result_array();
		$creator= ucfirst($admin_arr[0]['username']);

		$persons = (int)($reservation_details['no_of_adult']) + (int)($reservation_details['no_of_extra_adult']) + (int)($reservation_details['no_of_extra_real_adult']) + (int)($reservation_details['no_of_extra_kid']) + (int)($reservation_details['no_of_folding_bed_kid']) + (int)($reservation_details['no_of_folding_bed_adult']) + (int)($reservation_details['no_of_baby_bed']);
		?>
                <div class="box box-solid bg-light-blue" >
			<div class="box-body" style=" background: #000; ">
				<table width="320" style=" background: #000; ">
					<tr>
						<td height="30px" width="120" valign="top" align="left"><?php echo lang("Name"); ?> </td>
						<td height="30px"  valign="top" align="left"><?php echo $reservation_details['user_name'] ?></td>
					</tr>
					<tr>
						<td height="30px" width="120" valign="top" align="left"><?php echo lang("Comments"); ?>: </td>
						<td height="30px"  valign="top" align="left"><?php echo str_ireplace("<br />", "\n", $reservation_details['admin_comments']); ?></td>
					</tr>
					<!-- <tr>
						<td height="30px" width="120" valign="top" align="left"><?php echo lang("creator"); ?>: </td>
						<td height="30px"  valign="top" align="left"><?php echo $creator; ?></td>
					</tr> -->
					<tr>
						<td height="30px" width="120" valign="top" align="left"><?php echo lang("Arrival_Date"); ?>: </td>
						<td height="30px"  valign="top" align="left"><?php echo $reservation_details['arrival_date']; ?></td>
					</tr>
					<tr>
						<td height="30px" width="120" valign="top" align="left"><?php echo lang("Leave_Date"); ?>: </td>
						<td height="30px"  valign="top" align="left"><?php echo $reservation_details['leave_date']; ?></td>
					</tr>
					<tr>
						<td height="30px" width="120" valign="top" align="left"><?php echo lang("Accomodation"); ?>: </td>
						<td height="30px"  valign="top" align="left"><?php echo $reservation_details['accommodation']." ".lang("NIGHT"); ?></td>
					</tr>
					<!-- <tr>
						<td height="30px" width="120" valign="top" align="left"><?php echo lang("Payment_Status"); ?>: </td>
						<td height="30px"  valign="top" align="left"><?php echo $reservation_details['payment_status']; ?></td>
					</tr>
					<tr>
						<td height="30px" width="120" valign="top" align="left"><?php echo lang("Reservation_Status"); ?>: </td>
						<td height="30px"  valign="top" align="left"><?php echo $reservation_details['reservation_status']; ?></td>
					</tr>
					<tr>
						<td height="30px" width="120" valign="top" align="left"><?php echo lang("Season"); ?>: </td>
						<td height="30px"  valign="top" align="left"><?php echo $season_name; ?></td>
					</tr> -->
					<tr>
						<td height="30px" width="120" valign="top" align="left"><?php echo lang("no_of_adult"); ?>:</td>
						<td height="30px"  valign="top" align="left"><?php echo $reservation_details['no_of_adult']; ?></td>
					</tr>
					<?php if($reservation_details['no_of_extra_real_adult'] > 0){ ?>
						<tr>
							<td height="30px" width="120" valign="top" align="left"><?php echo lang("no_of_extra_real_adult"); ?>:</td>
							<td height="30px"  valign="top" align="left"><?php echo $reservation_details['no_of_extra_real_adult']; ?></td>
						</tr>
					<?php } if($reservation_details['no_of_extra_adult'] > 0){ ?>
						<tr>
							<td height="30px" width="120" valign="top" align="left"><?php echo lang("no_of_extra_adult"); ?>:</td>
							<td height="30px"  valign="top" align="left"><?php echo $reservation_details['no_of_extra_adult']; ?></td>
						</tr>
					<?php } if($reservation_details['no_of_extra_kid'] > 0){ ?>
						<tr>
							<td height="30px" width="120" valign="top" align="left"><?php echo lang("no_of_extra_kid"); ?>:</td>
							<td height="30px"  valign="top" align="left"><?php echo $reservation_details['no_of_extra_kid']; ?></td>
						</tr>
					<?php } if($reservation_details['no_of_folding_bed_kid'] > 0){ ?>
						<tr>
							<td height="30px" width="120" valign="top" align="left"><?php echo lang("no_of_folding_bed_kid"); ?>:</td>
							<td height="30px"  valign="top" align="left"><?php echo $reservation_details['no_of_folding_bed_kid']; ?></td>
						</tr>
					<?php } if($reservation_details['no_of_folding_bed_adult'] > 0){ ?>
						<tr>
							<td height="30px" width="120" valign="top" align="left"><?php echo lang("no_of_folding_bed_adult"); ?>:</td>
							<td height="30px"  valign="top" align="left"><?php echo $reservation_details['no_of_folding_bed_adult']; ?></td>
						</tr>
					<?php } if($reservation_details['no_of_baby_bed'] > 0){ ?>
						<tr>
							<td height="30px" width="120" valign="top" align="left"><?php echo lang("no_of_baby_bed"); ?>:</td>
							<td height="30px"  valign="top" align="left"><?php echo $reservation_details['no_of_baby_bed']; ?></td>
						</tr>
					<?php } ?>
					<!-- <tr>
						<td height="30px" width="120" valign="top" align="left"><?php echo lang("Bungalow_Rate"); ?>: </td>
						<td height="30px"  valign="top" align="left"><?php echo $reservation_details['bungalow_rate']; ?></td>
					</tr>
					<tr>
						<td height="30px" width="120" valign="top" align="left"><?php echo lang("Total_Amount"); ?>: </td>
						<td height="30px"  valign="top" align="left"><?php echo $reservation_details['total']; ?></td>
					</tr> -->
					<tr>
						<td height="30px" width="120" valign="top" align="left">Source: </td>
						<td height="30px"  valign="top" align="left"><?php echo $reservation_details['source']; ?></td>
					</tr>
				</table>
			</div>
		</div>
		<?php 
	}

	function ajax_get_details_for_tooltip_old()
	{
		$reservation_id=$_POST['reservation_id'];
		$reservation_details=$this->payment_model->get_payment_details($reservation_id);
		?>
		<div class="box box-solid bg-light-blue">
			<div class="box-body">
				<table width="100%">
					<tr>
						<td height="30px" width="30%" valign="top" align="left"><?php echo lang("Name"); ?> </td>
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
		$parent_info=$this->db->get_where("lb_reservation", array("parent_id"=>$_POST['reservation_id']))->result_array();
		if(count($parent_info)>0) //If invoice is not available
		{
			$msg_text2 =  $this->users_model->send_invoice_multi($_POST['reservation_id']);	
		}else{
			$msg_text2 =  $this->users_model->send_invoice($_POST['reservation_id']);	
		}
		echo $msg_text2;
	/*
		$reservation_id=$_POST['reservation_id'];
		$reservation_details=$this->payment_model->get_payment_details_old($reservation_id);
		$bungalow_name_part = explode("<span>", $reservation_details['bungalow_name']);
		$bunglow_name = $bungalow_name_part[0];
		?>
		<table width="650" align="center" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" style="border:1px solid #C9AD64; font-family:arial; font-size:12px;">
			<tr>
				<td colspan='2' align='center'><h2><?php echo lang("reservation_details"); ?></h2></td>
			</tr>
			<tr>
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b><?php echo lang("Name"); ?></b></td>
				<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;"><?php echo $reservation_details['user_name'] ?></td>
			</tr>
			<tr bgcolor="#f5e8c8">
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b><?php echo lang("Email"); ?>:</b></td>
				<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;"><?php echo $reservation_details['user_email'] ?></td>
			</tr>
			<tr>
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Bungalow <?php echo lang("Name"); ?></b></td>
				<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;"><?php echo $bunglow_name; ?></td>
			</tr>
			<tr bgcolor="#f5e8c8">
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b><?php echo lang("Reservation_Date"); ?>:</b></td>
				<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;"><?php echo date("d/m/Y H:i:s", strtotime($reservation_details['reservation_date'])); ?></td>
			</tr>
			<tr>
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b><?php echo lang("Arrival_Date"); ?>:</b></td>
				<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;"><?php echo date("d/m/Y", strtotime($reservation_details['arrival_date'])); ?></td>
			</tr>
			<tr bgcolor="#f5e8c8">
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b><?php echo lang("Leave_Date"); ?>:</b></td>
				<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;"><?php echo date("d/m/Y", strtotime($reservation_details['leave_date'])); ?></td>
			</tr>
			<tr>
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b><?php echo lang("Accommodation"); ?>:</b></td>
				<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;"><?php echo $reservation_details['accommodation']." days"; ?></td>
			</tr>
			<tr bgcolor="#f5e8c8">
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b><?php echo lang("Bungalow_Rate"); ?>:</b></td>
				<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;"><?php echo $reservation_details['bungalow_rate']." (". $reservation_details['accommodation']." days)"; ?></td>
			</tr>
			<!-- <tr>
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
			</tr> -->
			<tr>
				<td style="border-top:1px solid #C9AD64; padding:5px;"><?php echo lang("no_of_adult"); ?>:</td>
				<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;"><?php echo $reservation_details['no_of_adult']; ?></td>
			</tr>
			<?php if($reservation_details['no_of_extra_real_adult'] > 0){ ?>
				<tr bgcolor="#f5e8c8">
					<td style="border-top:1px solid #C9AD64; padding:5px;"><?php echo lang("no_of_extra_real_adult"); ?>:</td>
					<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;"><?php echo $reservation_details['no_of_extra_real_adult']; ?></td>
				</tr>
			<?php } if($reservation_details['no_of_extra_adult'] > 0){ ?>
				<tr>
					<td style="border-top:1px solid #C9AD64; padding:5px;"><?php echo lang("no_of_extra_adult"); ?>:</td>
					<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;"><?php echo $reservation_details['no_of_extra_adult']; ?></td>
				</tr>
			<?php } if($reservation_details['no_of_extra_kid'] > 0){ ?>
				<tr bgcolor="#f5e8c8">
					<td style="border-top:1px solid #C9AD64; padding:5px;"><?php echo lang("no_of_extra_kid"); ?>:</td>
					<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;"><?php echo $reservation_details['no_of_extra_kid']; ?></td>
				</tr>
			<?php } if($reservation_details['no_of_folding_bed_kid'] > 0){ ?>
				<tr>
					<td style="border-top:1px solid #C9AD64; padding:5px;">><?php echo lang("no_of_folding_bed_kid"); ?>:</td>
					<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;"><?php echo $reservation_details['no_of_folding_bed_kid']; ?></td>
				</tr>
			<?php } if($reservation_details['no_of_folding_bed_adult'] > 0){ ?>
				<tr bgcolor="#f5e8c8">
					<td style="border-top:1px solid #C9AD64; padding:5px;">><?php echo lang("no_of_folding_bed_adult"); ?>:</td>
					<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;"><?php echo $reservation_details['no_of_folding_bed_adult']; ?></td>
				</tr>
			<?php } if($reservation_details['no_of_baby_bed'] > 0){ ?>
				<tr>
					<td style="border-top:1px solid #C9AD64; padding:5px;"><?php echo lang("no_of_baby_bed"); ?>:</td>
					<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;"><?php echo $reservation_details['no_of_baby_bed']; ?></td>
				</tr>
			<?php } ?>
			<tr bgcolor="#f5e8c8">
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b><?php echo lang("Discount"); ?>(%):</b></td>
				<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;"><?php echo $reservation_details['discount']."%"; ?></td>
			</tr>
			<tr>
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b><?php echo lang("tax"); ?>:</b></td>
				<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">4%</td>
			</tr>
			<tr bgcolor="#f5e8c8">
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b><?php echo lang("Total_Amount"); ?>:</b></td>
				<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;"><?php echo $reservation_details['total']; ?></td>
			</tr>
			<tr>
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b><?php echo lang("Paid_Amount"); ?>:</b></td>
				<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;"><?php echo $reservation_details['paid_amount']; ?></td>
			</tr>
			<tr bgcolor="#f5e8c8">
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b><?php echo lang("Due_Amount"); ?>:</b></td>
				<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;"><?php echo $reservation_details['due_amount']; ?></td>
			</tr>
			<tr>
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b><?php echo lang("Payment_Mode"); ?>:</b></td>
				<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;"><?php echo $reservation_details['payment_mode']; ?></td>
			</tr>
			<tr bgcolor="#f5e8c8">
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b><?php echo lang("Payment_Status"); ?>:</b></td>
				<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;"><?php echo $reservation_details['payment_status']; ?></td>
			</tr>
			<tr>
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b><?php echo lang("Reservation_Status"); ?>:</b></td>
				<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;"><?php echo $reservation_details['reservation_status']; ?></td>
			</tr>
		</table>
		<?php 
	*/}	
	
	//Function for getting print details of cleaning date
	function ajax_get_print_cleaning_details()
	{
		$cleaning_date=$_POST['cleaning_date'];
		$cleaning_details=$this->home_model->get_cleaning_print_details($cleaning_date);
		echo $cleaning_details;
	}
	
	//Function for getting print details of cleaning date
	function ajax_get_print_today_details()
	{

		$activites = $this->home_model->getActivites(date("Y-m-d"));
		
		
		
		$filename = "programme_du_".date("d_m_Y").".pdf";
		$msg_text2 = $this->load->view('today',array("activites"=>$activites), true);
		
		
		
		require_once(__DIR__.'/../../../html2pdf/html2pdf.class.php');
		$html2pdf = new HTML2PDF('P','A4','En');
	    $html2pdf->WriteHTML($msg_text2);
	    $html2pdf->Output($filename);
	}
}
?>
