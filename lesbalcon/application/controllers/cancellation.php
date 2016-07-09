<?php
ob_start();
class cancellation extends CI_Controller
{
    //var $data;
    function  __construct() 
	{
        parent::__construct();
		$this->load->library('public_init_elements');
		$this->public_init_elements->init_elements();
		$this->load->model('language_model');
		$this->load->model('reservation_model');
		$this->load->model('home_model');
		//$this->load->model('users_model');
		$this->load->model('currency_model');
		$this->load->library('paypal_lib');
    }

    function index($slug="")
	{

		$slug = $this->uri->segment(2);
		//$this->session->unset_userdata("reservation");
		//$this->session->unset_userdata("login_user_info");
		$this->data = array();
		$this->data['properties_arr'] = $this->reservation_model->get_properties();
		$this->data['bungalows_arr'] = $this->reservation_model->get_bungalows();
		//Get content for reservation page
		$this->data['reservation_content']=$this->reservation_model->get_reservation_content();
		
		
		$user_id = $this->session->userdata("login_user_info");
		
		//$this->data['result_arr']=$this->reservation_model->get_user_details_rows($user_id);
		
		//If reservation session exists then what options has been selected by users
		if($this->session->userdata("reservation"))
		{
			$reservation_session=$this->session->userdata('reservation');
			$bungalow_id=$reservation_session['bungalow_id'];
			
			$this->data['options_arr']=$this->reservation_model->get_options_for_reservation($bungalow_id);
			
			$selected_bungalow_person=$this->reservation_model->get_bungalow_max_person($slug);
			$this->data['selected_bungalow_person']=$selected_bungalow_person;

			$selected_bungalow_cat_type=$this->reservation_model->get_bungalow_catergory_type_by_slug($slug);
			$this->data['selected_bungalow_cat_type']=$selected_bungalow_cat_type;
		}
		
		//----------------//
		//if user is making reservation from details page
		if($slug!="")
		{
			$selected_bungalow_id=$this->reservation_model->get_bungalow_details_by_slug($slug);
			$this->data['selected_bungalow_id']=$selected_bungalow_id;
			$this->data['options_arr']=$this->reservation_model->get_options_for_reservation($selected_bungalow_id);
			
			$selected_bungalow_person=$this->reservation_model->get_bungalow_max_person($slug);
			$this->data['selected_bungalow_person']=$selected_bungalow_person;

			$selected_bungalow_cat_type=$this->reservation_model->get_bungalow_catergory_type_by_slug($slug);
			$this->data['selected_bungalow_cat_type']=$selected_bungalow_cat_type;
		}
		//----------------//
		
		$this->data['head'] = $this->load->view('elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('elements/header_top', $this->data, true);
		$this->data['header_menu'] = $this->load->view('elements/header_menu', $this->data, true);
		
		//$this->data['content'] = $this->load->view('maincontents/reservation', $this->data, true);
		$this->data['content'] = $this->load->view('maincontents/cancellation_short', $this->data, true);
		
		$this->data['footer'] = $this->load->view('elements/footer', $this->data, true);
		$this->load->view('layout', $this->data);
    }

	function ajax_get_options()
	{
		$bungalow_id=$_POST['bungalow_id'];
		$result=$this->reservation_model->ajax_get_options($bungalow_id);
		?>
		<div class="col-md-4">
			<label>Options  </label>
		  </div>
		  <?php
		  $out_put='<div class="col-md-6">';
		  foreach($result as $options)
		  {
				$out_put .='<div class="col-md-4"> <input class="options" id="option_'.$options['options_id']. '" name="options[]" type="checkbox" value="'.$options['options_id']. '">&nbsp;'
				. '<label id="l_option_'.$options['options_id']. '" for="option_'.$options['options_id']. '">' .  $options['options_name'] . '</label>'
				.'</div>';
		  }
		  $out_put .='</div>';
		  echo  $out_put;
	}
	
	function get_max_person(){
		$val = $this->reservation_model->get_bungalow_max_personbyID($_REQUEST['id']);
		echo $val;
	}
	//function to check availability
	function ajax_check_availability()
	{
		
		$bungalow_id=$_POST['bungalow_id'];
		
		$posted_arrival_date=$_POST['arrival_date'];
		$posted_leave_date=$_POST['leave_date'];
		
		$arrival_date_arr=explode("/", $posted_arrival_date);
		$arrival_date = mktime(0,0,0, $arrival_date_arr[1], $arrival_date_arr[0], $arrival_date_arr[2] );
		
		$leave_date_arr = explode("/", $posted_leave_date);
		$leave_date=mktime(0,0,0, $leave_date_arr[1], $leave_date_arr[0], $leave_date_arr[2] );

		$result=$this->reservation_model->ajax_check_availability($bungalow_id, $arrival_date, $leave_date);
		
		if($result=="available")
		{
			$price_data = $this->reservation_model->get_bungalows_price($bungalow_id, $posted_arrival_date, $posted_leave_date, explode(',', $_POST['options']));
			
			if( !empty($price_data) && !empty( $price_data['total_euro'] ) ){
				echo json_encode(array('success'=>true, 'available'=>'yes', 'price'=>$price_data));
			}else {
				echo json_encode(array('success'=>false, 'available'=>'no', 'price'=>null ));
				return;
			}
		}
		elseif($result=="notavailable")
		{
			echo json_encode(array('success'=>true, 'available'=>'no', 'price'=>false));
		}
		else
		{
			echo json_encode(array('success'=>true, 'available'=>'partial', 'price'=>false, 'available_dates'=>$result));
		}
	}
	
	
	//Function for reservation process after check availability
	function reservation_process()
	{
		$result=$this->reservation_model->reservation_process();
	}
	
	//function to set registration session while reservation
	function ajax_set_registration_session()
	{
		$this->session->set_userdata("registration", "1");
	}
	
	//function to unset registration session while reservation
	function ajax_unset_registration_session()
	{
		$this->session->unset_userdata("registration");
	}
	
	//function to check user logged in or not
	function ajax_check_user_logged_in()
	{
		if(!$this->session->userdata('login_user_info'))
		{	
			echo "0";
		}
		else 
		{
			echo "1";
		}
	}
	
	//function for loading payment page
	function payment()
	{
		$this->data = array();
		//If reservation session does not exist then it will be redirected to the reservation page
		if(!$this->session->userdata("reservation"))
		{
			redirect('reservation');
		}
		$this->session->set_userdata("payment");
		$reservation_session=$this->session->userdata("reservation");

		$this->data['dollar_currency']=$this->reservation_model->get_dollar_currency();
		
		$this->data['partial_payment_rate']=$this->reservation_model->get_partial_payment_rate();
		$this->data['season_name']=$this->reservation_model->get_season_name_for_payment_page();
		$this->data['bungalow_rate']=$this->reservation_model->get_bungalows_with_rate($reservation_session['bungalow_id']);
		$this->data['options_rate_arr']=$this->reservation_model->get_options_rate_for_payment_page();
		$this->data['tax_rate_arr']=$this->reservation_model->get_tax_rate_for_payment_page($reservation_session['bungalow_id']);
		$this->data['discount_rate']=$this->reservation_model->get_discount($reservation_session['bungalow_id']);
		$this->data['total']=$this->reservation_model->get_total();

		$this->data['head'] = $this->load->view('elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('elements/header_top', $this->data, true);
		$this->data['header_menu'] = $this->load->view('elements/header_menu', $this->data, true);
		$this->data['content'] = $this->load->view('maincontents/payment', $this->data, true);
		$this->data['footer'] = $this->load->view('elements/footer', $this->data, true);
		$this->load->view('layout', $this->data);
	}
	
	//Proceed to payment process
	function payment_process()
	{
		if(isset($_POST['payment_submit']))
		{
			//$payment_type = $this->input->post('payment_type'); 
			$payment_type = "on_arrival";
			if($payment_type=="full")
			{
				$this->paypal_payment("full");
			}
			if($payment_type=="partial")
			{
				$this->paypal_payment("partial");
			}
			if($payment_type=="on_arrival")
			{
				$this->on_arrival_payment("on_arrival");
			}
		}
	}
	
	
	//Function for paypal full payment or partial payment
	function paypal_payment($payment_type)
	{
		$default_currency=$this->currency_model->get_default_currency();
		$paypal_email_id=$this->reservation_model->get_paypal_details();
		$partial_payment_rate=$this->reservation_model->get_partial_payment_rate();
		$reservation_session=$this->session->userdata("reservation");
		$bungalow_details=$this->reservation_model->get_bunglow_details_for_paypal($reservation_session['bungalow_id']);
		//Total Bungalow rate
		$total_bungalow_rate=$this->reservation_model->get_bungalows_with_rate($reservation_session['bungalow_id']);
		//Total tax of bungalow 
		$total_taxes_rates=$this->reservation_model->get_total_taxes_rate($total_bungalow_rate);
		//Total options rate of bungalow if user selected any options
		$total_options_rate=$this->reservation_model->get_total_options_rate();
		//Getting discount

		$discount=$this->reservation_model->get_discount($reservation_session['bungalow_id']);
		$discounted_value=($total_bungalow_rate+$total_options_rate)*$discount/100;
		
		//Get final rate after adding bungalow rate and options rate and substracting discount
		$total_rate=(($total_bungalow_rate+$total_options_rate)-$discounted_value)+$total_taxes_rates;
		
		$reservation_session['amount_to_be_paid']=$total_rate;
		$reservation_session['payment_type']=$payment_type;
		$this->session->set_userdata('reservation', $reservation_session);
		if($payment_type=="partial")
		{
			$due_rate=$total_rate-($total_rate*$partial_payment_rate/100);
			$total_rate=$total_rate*$partial_payment_rate/100;
			$payment_session_data = $this->session->userdata('payment');
			$payment_session_data['partial_payment'] = $total_rate;
			$payment_session_data['due_payment'] = $due_rate;
			$this->session->set_userdata("payment", $payment_session_data);
		}

		//Adding paypal fields
		$this->paypal_lib->add_field('business', $paypal_email_id);
		$this->paypal_lib->add_field('return', base_url().'reservation/paypal_success');
		$this->paypal_lib->add_field('cancel_return',  base_url().'reservation/paypal_cancel');
		$this->paypal_lib->add_field('image_url', base_url().'assets/frontend/images/logo.png');
		$this->paypal_lib->add_field('currency_code', $default_currency['currency_code']);
		$this->paypal_lib->add_field('charset', 'utf8');
		$this->paypal_lib->add_field('item_name', $bungalow_details[0]['bunglow_name']);
		$this->paypal_lib->add_field('item_number', $reservation_session['bungalow_id']);
		$this->paypal_lib->add_field('amount', $reservation_session["final_amount"]);
		$this->paypal_lib->paypal_auto_form(); 
	}
	
	
	//Function for payment on arrival_date
	function on_arrival_payment($payment_type)
	{
		$user_session_info=$this->session->userdata("login_user_info");
		$default_currency=$this->currency_model->get_default_currency();
		$reservation_session=$this->session->userdata("reservation");

		//Total Bungalow rate multiplying by total days of staying
		echo $total_bungalow_rate=$this->reservation_model->get_bungalows_with_rate($reservation_session['bungalow_id']);
		//Total tax of bungalow 
		$total_taxes_rates=$this->reservation_model->get_total_taxes_rate($total_bungalow_rate);
		//Total options rate of bungalow if user selected any options
		$total_options_rate=$this->reservation_model->get_total_options_rate();

		//Getting discount
		$discount=$this->reservation_model->get_discount($reservation_session['bungalow_id']);

		$discounted_value=($reservation_session['stay_euro']+$reservation_session['total'])*$discount/100;
		//Get final rate after adding bungalow rate and options rate and substracting discount
		$total_rate=(($reservation_session['stay_euro']+$reservation_session['total'])-$discounted_value)+$total_taxes_rates;
		//$reservation_session['amount_to_be_paid']=$total_rate;
		$reservation_session['payment_type']=$payment_type;
		//$this->session->set_userdata('reservation', $reservation_session);
		
		$arrival_date_arr=explode("/", $reservation_session['arrival_date']);
		$arrival_date=$arrival_date_arr[2]."-".$arrival_date_arr[1]."-".$arrival_date_arr[0];
		$leave_date_arr=explode("/", $reservation_session['leave_date']);
		$leave_date=$leave_date_arr[2]."-".$leave_date_arr[1]."-".$leave_date_arr[0];
		
		
		$payment_session=$this->session->userdata("payment");
		
		//Options rate concatenated with comma based on total days of accommodation
		foreach($payment_session['options_rate_array'] as $row) 
		{
			$options_rate [] = $row['options_charges'];
		}
		
		foreach($payment_session['options_rate_array'] as $row) 
		{
			$options_rate_dollar [] = $row['options_charges_dollar'];
		}
		
		foreach($payment_session['taxes_rate_array'] as $row) 
		{
			$tax_rate [] = $row['tax_rate'];
		}
		
		
		if($this->session->userdata("reservation"))	
		{
			//Inserting data returned by paypal after payment 
			if(!empty($reservation_session['options_id']))//If options are not available
			{
				$options_ids=implode(",",$reservation_session['options_id']);
				$options_rates=implode(",", $options_rate);
				$options_rates_dollar=implode(",", $options_rate_dollar);
			}
			else 
			{
				$options_ids="";
				$options_rates="";
				$options_rates_dollar="";
			}
			
			/*if(!empty($reservation_session['taxes']))//If tax are not available
			{
				$tax_rates=implode(",", $tax_rate);
			}
			else 
			{*/
				$tax_rates="4";
			//}

			$invoice_number=$this->reservation_model->get_unique_invoice_number();
			$random_color=$this->home_model->randomColor();
			$ins_arr=array(
				"user_id"=>$this->session->userdata("login_user_info")['user_id'],
				"name"=>$this->session->userdata("login_user_info")['full_name'],
				"phone"=>$this->session->userdata("login_user_info")['contact_number'],
				"email"=>$this->session->userdata("login_user_info")['email'],
				"bunglow_id"=>$reservation_session['bungalow_id'],
				"options_id"=>$options_ids,
				"options_rate"=>$reservation_session['total'],
				"options_rate_dollar"=>$options_rates_dollar,
				"tax_id"=>$reservation_session['taxes'],
				"tax_rate"=>$tax_rates,
				"bunglow_per_day"=>$payment_session['bungalow_per_day'],
				"bunglow_per_day_dollar"=>$payment_session['bungalow_per_day_dollar'],
				"discount"=>$payment_session['discount'],
				"reservation_date"=>date("Y-m-d H:i:s"),
				"arrival_date"=>$arrival_date,
				"leave_date"=>$leave_date,
				"comment"=>$reservation_session['description'],
				"reservation_status"=>"PENDING",
				"payment_mode"=>"ONARRIVAL",
				"amount_to_be_paid"=>$reservation_session['final_amount'],
				"paid_amount"=>0,
				"due_amount"=>$reservation_session['final_amount'],
				"invoice_number"=>$invoice_number,
				"payment_status"=>"PENDING", //Payment Status is pending because this is payment on arrival
				"is_active"=>"ACTIVE",
				"color_code"=>$random_color,
				"source"=>'W'
			);

			$this->reservation_model->insert_payment_data_on_success($ins_arr);
				
		}
		redirect("reservation/success");
	}
	
	
	
	//Function to load page of success message
	function paypal_success()
	{
		$user_session_info=$this->session->userdata("login_user_info");
		$reservation_session=$this->session->userdata("reservation");
		$pp_info=$_REQUEST;
		$item_number=		$pp_info["item_number"];
		$payment_status=	$pp_info["st"];
		$transactionId=		$pp_info["tx"];
		$paid_amount=		$pp_info["amt"];
		if($reservation_session['payment_type']=="full")
		{
			$payment_type="FULL";
			$payment_status="COMPLETED";
		}
		elseif($reservation_session['payment_type']=="partial")
		{
			$payment_type="PARTIAL";
			$payment_status="PENDING";
		}
		
		if($this->session->userdata("reservation"))	
		{
			//Inserting data returned by paypal after payment 
			$invoice_number=$this->reservation_model->get_unique_invoice_number();
			
			$arrival_date_arr=explode("/", $reservation_session['arrival_date']);
			$arrival_date=$arrival_date_arr[2]."-".$arrival_date_arr[1]."-".$arrival_date_arr[0];
			$leave_date_arr=explode("/", $reservation_session['leave_date']);
			$leave_date=$leave_date_arr[2]."-".$leave_date_arr[1]."-".$leave_date_arr[0];

			$payment_session=$this->session->userdata("payment");

			//Options rate concatenated with comma based on total days of accommodation
			foreach($payment_session['options_rate_array'] as $row) 
			{
				$options_rate [] = $row['options_charges'];
			}
			
			foreach($payment_session['options_rate_array'] as $row) 
			{
				$options_rate_dollar [] = $row['options_charges_dollar'];
			}
			
			foreach($payment_session['taxes_rate_array'] as $row) 
			{
				$tax_rate [] = $row['tax_rate'];
			}

			if(!empty($reservation_session['options_id']))
			{
				$options_ids=implode(",",$reservation_session['options_id']);
				$options_rates=implode(",", $options_rate);
				$options_rates_dollar=implode(",", $options_rate_dollar);
			}
			else 
			{
				$options_ids="";
				$options_rates="";
				$options_rates_dollar="";
			}
			if(!empty($reservation_session['taxes']))
			{
				$tax_rates=implode(",", $tax_rate);
			}
			else 
			{
				$tax_rates="4";
			}
			$random_color=$this->home_model->randomColor();
			$ins_arr=array(
				"user_id"=>$this->session->userdata("login_user_info")['user_id'],
				"name"=>$this->session->userdata("login_user_info")['full_name'],
				"phone"=>$this->session->userdata("login_user_info")['contact_number'],
				"email"=>$this->session->userdata("login_user_info")['email'],
				"bunglow_id"=>$reservation_session['bungalow_id'],
				"options_id"=>$options_ids,
				"options_rate"=>$reservation_session['total'],
				"options_rate_dollar"=>$options_rates_dollar,
				"tax_id"=>$reservation_session['taxes'],
				"tax_rate"=>$tax_rates,
				"bunglow_per_day"=>$payment_session['bungalow_per_day'],
				"bunglow_per_day_dollar"=>$payment_session['bungalow_per_day_dollar'],
				"discount"=>$payment_session['discount'],
				"reservation_date"=>date("Y-m-d H:i:s"),
				"arrival_date"=>$arrival_date,
				"leave_date"=>$leave_date,
				"comment"=>$reservation_session['description'],
				"reservation_status"=>"PENDING",
				"payment_mode"=>$payment_type,
				"amount_to_be_paid"=>$reservation_session['final_amount'],
				"paid_amount"=>$paid_amount,
				"due_amount"=>$reservation_session['final_amount']-$paid_amount,
				"invoice_number"=>$invoice_number,
				"txn_id"=>$transactionId,
				"payment_status"=>$payment_status,
				"is_active"=>"ACTIVE",
				"color_code"=>$random_color,
				"source"=>'W'
			);
			$this->reservation_model->insert_payment_data_on_success($ins_arr);
		}
		$this->data = array();
		$this->data['head'] = $this->load->view('elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('elements/header_top', $this->data, true);
		$this->data['header_menu'] = $this->load->view('elements/header_menu', $this->data, true);
		$this->data['content'] = $this->load->view('maincontents/paypal_success', $this->data, true);
		$this->data['footer'] = $this->load->view('elements/footer', $this->data, true);
		$this->load->view('layout', $this->data);
	}
	
	//Function to load page of cancel message
	function paypal_cancel()
	{
		$user_session_info=$this->session->userdata("login_user_info");
		$reservation_session=$this->session->userdata("reservation");
		$pp_info=$_REQUEST;
		$item_number=		$pp_info["item_number"];
		$payment_status=	$pp_info["st"];
		$transactionId=		$pp_info["tx"];
		$paid_amount=		$pp_info["amt"];
		if($reservation_session['payment_type']=="full")
		{
			$payment_type="FULL";
			$payment_status="CANCELLED";
		}
		elseif($reservation_session['payment_type']=="partial")
		{
			$payment_type="PARTIAL";
			$payment_status="CANCELLED";
		}
		
		if($this->session->userdata("reservation"))	
		{
			//Inserting data returned by paypal after payment 
			$invoice_number=$this->reservation_model->get_unique_invoice_number();
			
			$arrival_date_arr=explode("/", $reservation_session['arrival_date']);
			$arrival_date=$arrival_date_arr[2]."-".$arrival_date_arr[1]."-".$arrival_date_arr[0];
			$leave_date_arr=explode("/", $reservation_session['leave_date']);
			$leave_date=$leave_date_arr[2]."-".$leave_date_arr[1]."-".$leave_date_arr[0];

			$payment_session=$this->session->userdata("payment");

			//Options rate concatenated with comma based on total days of accommodation
			foreach($payment_session['options_rate_array'] as $row) 
			{
				$options_rate [] = $row['options_charges'];
			}
			
			foreach($payment_session['options_rate_array'] as $row) 
			{
				$options_rate_dollar [] = $row['options_charges_dollar'];
			}
			
			foreach($payment_session['taxes_rate_array'] as $row) 
			{
				$tax_rate [] = $row['tax_rate'];
			}
			
			if(!empty($reservation_session['options_id']))
			{
				$options_ids=implode(",",$reservation_session['options_id']);
				$options_rates=implode(",", $options_rate);
				$options_rates_dollar=implode(",", $options_rate_dollar);
			}
			else 
			{
				$options_ids="";
				$options_rates="";
				$options_rates_dollar="";
			}
			/*if(!empty($reservation_session['taxes']))
			{
				$tax_rates=implode(",", $tax_rate);
			}
			else 
			{*/
				$tax_rates="4";
			//}
			
			$random_color=$this->home_model->randomColor();
			$ins_arr=array(
				"user_id"=>$this->session->userdata("login_user_info")['user_id'],
				"name"=>$this->session->userdata("login_user_info")['full_name'],
				"phone"=>$this->session->userdata("login_user_info")['contact_number'],
				"email"=>$this->session->userdata("login_user_info")['email'],
				"bunglow_id"=>$reservation_session['bungalow_id'],
				"options_id"=>$options_ids,
				"options_rate"=>$reservation_session['total'],
				"options_rate_dollar"=>$options_rates_dollar,
				"tax_id"=>$reservation_session['taxes'],
				"tax_rate"=>$tax_rates,
				"bunglow_per_day"=>$payment_session['bungalow_per_day'],
				"bunglow_per_day_dollar"=>$payment_session['bungalow_per_day_dollar'],
				"discount"=>$payment_session['discount'],
				"reservation_date"=>date("Y-m-d H:i:s"),
				"arrival_date"=>$arrival_date,
				"leave_date"=>$leave_date,
				"comment"=>$reservation_session['description'],
				"reservation_status"=>"PENDING",
				"payment_mode"=>$payment_type,
				"amount_to_be_paid"=>$reservation_session['final_amount'],
				"paid_amount"=>$paid_amount,
				"due_amount"=>$reservation_session['final_amount']-$paid_amount,
				"invoice_number"=>$invoice_number,
				"txn_id"=>$transactionId,
				"payment_status"=>$payment_status,
				"is_active"=>"DEACTIVE",
				"color_code"=>$random_color,
				"source"=>'W'
			);
			$this->reservation_model->insert_payment_data_on_success($ins_arr);
		}

		$this->data = array();
		$this->data['head'] = $this->load->view('elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('elements/header_top', $this->data, true);
		$this->data['header_menu'] = $this->load->view('elements/header_menu', $this->data, true);
		$this->data['content'] = $this->load->view('maincontents/paypal_cancel', $this->data, true);
		$this->data['footer'] = $this->load->view('elements/footer', $this->data, true);
		$this->load->view('layout', $this->data);
	}
	
	//function for loading reservation success page after payment on arrival
	function success()
	{
		$this->data = array();
		$this->data['head'] = $this->load->view('elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('elements/header_top', $this->data, true);
		$this->data['header_menu'] = $this->load->view('elements/header_menu', $this->data, true);
		$this->data['content'] = $this->load->view('maincontents/reservation_success', $this->data, true);
		$this->data['footer'] = $this->load->view('elements/footer', $this->data, true);
		$this->load->view('layout', $this->data);
	}
}

