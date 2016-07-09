<?php
ob_start();
class reservation extends CI_Controller
{
    //var $data;
    function  __construct() 
	{
        parent::__construct();
		$this->load->library('public_init_elements');
		$this->public_init_elements->init_elements();
		$this->load->model('language_model');
		$this->load->model('reservation_model');
		$this->load->model('currency_model');
		$this->load->library('paypal_lib');
    }

    function index($slug="")
	{ 
		//$this->session->unset_userdata("reservation");
		//$this->session->unset_userdata("login_user_info");
		$this->data = array();
		$this->data['properties_arr'] = $this->reservation_model->get_properties();
		$this->data['bungalows_arr'] = $this->reservation_model->get_bungalows();
		//If reservation session exists then what options has been selected by users
		if($this->session->userdata("reservation"))
		{
			$reservation_session=$this->session->userdata('reservation');
			$bungalow_id=$reservation_session['bungalow_id'];
			$this->data['options_arr']=$this->reservation_model->get_options_for_reservation($bungalow_id);
		}
		//----------------//
		//if user is making reservation from details page
		if($slug!="")
		{
			$selected_bungalow_id=$this->reservation_model->get_bungalow_details_by_slug($slug);
			$this->data['selected_bungalow_id']=$selected_bungalow_id;
			$this->data['options_arr']=$this->reservation_model->get_options_for_reservation($selected_bungalow_id);
		}
		//----------------//
		
		$this->data['head'] = $this->load->view('elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('elements/header_top', $this->data, true);
		$this->data['header_menu'] = $this->load->view('elements/header_menu', $this->data, true);
		$this->data['content'] = $this->load->view('maincontents/reservation', $this->data, true);
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
				$out_put .='<div class="col-md-4"> <input id="options" name="options[]" type="checkbox" value="'.$options['options_id']. '">&nbsp;'.$options['options_name'].'</div>';
		  }
		  $out_put .='</div>';
		  echo  $out_put;
	}
	
	
	//function to check availability
	function ajax_check_availability()
	{
		$bungalow_id=$_POST['bungalow_id'];
		
		$posted_arrival_date=$_POST['arrival_date'];
		$arrival_date_arr=explode("/", $posted_arrival_date);
		$arrival_date=$arrival_date_arr[2]."-".$arrival_date_arr[1]."-".$arrival_date_arr[0];

		$posted_leave_date=$_POST['leave_date'];
		$leave_date_arr=explode("/", $posted_leave_date);
		$leave_date=$leave_date_arr[2]."-".$leave_date_arr[1]."-".$leave_date_arr[0];

		$result=$this->reservation_model->ajax_check_availability($bungalow_id, $arrival_date, $leave_date);
		if($result=="available")
		{
			echo "available";
		}
		elseif($result=="notavailable")
		{
			echo "notavailable";
		}
		else
		{
			$imploded_result=implode("^", $result);
			echo $imploded_result;
		}
	}
	
	
	//Function for reservation process after check availability
	function reservation_process()
	{
		$result=$this->reservation_model->reservation_process();
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
			$payment_type = $this->input->post('payment_type');
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
		$this->paypal_lib->add_field('amount', $total_rate);
		$this->paypal_lib->paypal_auto_form(); 
	}
	
	
	//Function for payment on arrival_date
	function on_arrival_payment($payment_type)
	{
		$user_session_info=$this->session->userdata("login_user_info");
		$default_currency=$this->currency_model->get_default_currency();
		$reservation_session=$this->session->userdata("reservation");
		$bungalow_details=$this->reservation_model->get_bunglow_details_for_paypal($reservation_session['bungalow_id']);
		//Total Bungalow rate multiplying by total days of staying
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
		
		$arrival_date_arr=explode("/", $reservation_session['arrival_date']);
		$arrival_date=$arrival_date_arr[2]."-".$arrival_date_arr[1]."-".$arrival_date_arr[0];
		$leave_date_arr=explode("/", $reservation_session['leave_date']);
		$leave_date=$leave_date_arr[2]."-".$leave_date_arr[1]."-".$leave_date_arr[0];
		
		
		if($this->session->userdata("reservation"))	
		{
			//Inserting data returned by paypal after payment 
			$invoice_number=$this->reservation_model->get_unique_invoice_number();
			$ins_arr=array(
				"user_id"=>$user_session_info['user_id'],
				"name"=>$reservation_session['name'],
				"phone"=>implode(",",$reservation_session['phone']),
				"email"=>implode(",",$reservation_session['email']),
				"bunglow_id"=>$reservation_session['bungalow_id'],
				"options_id"=>implode(",",$reservation_session['options_id']),
				"tax_id"=>$reservation_session['taxes'],
				"reservation_date"=>date("Y-m-d h:i:s"),
				"arrival_date"=>$arrival_date,
				"leave_date"=>$leave_date,
				"comment"=>$reservation_session['description'],
				"payment_mode"=>"ONARRIVAL",
				"amount_to_be_paid"=>$reservation_session['amount_to_be_paid'],
				"paid_amount"=>0,
				"due_amount"=>$reservation_session['amount_to_be_paid'],
				"invoice_number"=>$invoice_number,
				"payment_status"=>"PENDING" //Payment Status is pending because this is payment on arrival
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
			$payment_status="CONFIRMED";
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
			
			$ins_arr=array(
				"user_id"=>$user_session_info['user_id'],
				"name"=>$reservation_session['name'],
				"phone"=>implode(",",$reservation_session['phone']),
				"email"=>implode(",",$reservation_session['email']),
				"bunglow_id"=>$reservation_session['bungalow_id'],
				"options_id"=>implode(",",$reservation_session['options_id']),
				"tax_id"=>$reservation_session['taxes'],
				"reservation_date"=>date("Y-m-d h:i:s"),
				"arrival_date"=>$arrival_date,
				"leave_date"=>$leave_date,
				"comment"=>$reservation_session['description'],
				"payment_mode"=>$payment_type,
				"amount_to_be_paid"=>$reservation_session['amount_to_be_paid'],
				"paid_amount"=>$paid_amount,
				"due_amount"=>$reservation_session['amount_to_be_paid']-$paid_amount,
				"invoice_number"=>$invoice_number,
				"txn_id"=>$transactionId,
				"payment_status"=>$payment_status
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