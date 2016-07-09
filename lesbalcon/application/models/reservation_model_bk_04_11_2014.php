<?php
class reservation_model extends CI_Model
{
	
	function  __construct() 
	{
        parent::__construct();
    }
	
	
	//*******************************************ADMIN PANEL CATEGORY**********************************************************************//
	
	
	//Getting All Reservation At Once
	function get_rows()//Get all rows for listing page
    {
		$this->db->order_by('id', "desc");
		$query = $this->db->get('lb_reservation');
		$result=array();
        foreach ($query->result() as $row) 
		{
			$result[] = array(
				'id' 					=> $row->id,
				'user_id' 				=> $row->user_id,
				'bunglow_id' 			=> $row->bunglow_id,
				'options_id' 			=> $row->options_id,
				'reservation_date' 		=> $row->reservation_date,
				'arrival_date' 			=> $row->arrival_date,
				'leave_date' 			=> $row->leave_date,
				'comment' 				=> $row->comment,
				'payment_mode' 			=> $row->payment_mode,
				'amount_to_be_paid' 	=> $row->amount_to_be_paid,
				'paid_amount' 			=> $row->paid_amount,
				'invoice_number' 		=> $row->invoice_number,
				'txn_id' 				=> $row->txn_id,
				'payment_status' 		=> $row->payment_status
			);
        }
        return $result;
    }
	
	//function to delete reservation
	function delete($reservation_id)
	{
		$this->db->delete("lb_reservation", array("id"=>$reservation_id));
	}
	
	
	
	
	//########################	Function for front end 	#############################
	
	
	//Function to get bungalow list in drop down
	function get_bungalows()
	{
		$current_lang_id=$this->session->userdata("current_lang_id");
		$all_bunglow_array=array();
		$this->db->order_by('id', 'desc');
		$array=$this->db->get_where("lb_bunglow", array("type"=>"B","is_active"=>"Y"), 10, 0)->result_array();
		$i=0;

		foreach($array as $val)
		{
			$peroperty_id=$val['id'];
			$get_details_arr=$this->db->get_where("lb_bunglow_lang", array("bunglow_id"=>$peroperty_id, "language_id"=>$current_lang_id))->result_array();
			$all_bunglow_array[$i]['id']=$val['id'];
			$all_bunglow_array[$i]['bunglow_name']=$get_details_arr[0]['bunglow_name'];
			$i++;
		}
		return $all_bunglow_array;
	}
	
	//Function to get properties list in drop down
	function get_properties()
	{
		$current_lang_id=$this->session->userdata("current_lang_id");
		$all_bunglow_array=array();
		$this->db->order_by('id', 'desc');
		$array=$this->db->get_where("lb_bunglow", array("type"=>"P","is_active"=>"Y"), 10, 0)->result_array();
		$i=0;

		foreach($array as $val)
		{
			$peroperty_id=$val['id'];
			$get_details_arr=$this->db->get_where("lb_bunglow_lang", array("bunglow_id"=>$peroperty_id, "language_id"=>$current_lang_id))->result_array();
			$all_bunglow_array[$i]['id']=$val['id'];
			$all_bunglow_array[$i]['bunglow_name']=$get_details_arr[0]['bunglow_name'];
			$i++;
		}
		return $all_bunglow_array;
	}
	
	
	//Ajax function to get options
	function ajax_get_options($bunglow_id)
	{
		$current_lang_id=$this->session->userdata("current_lang_id");
		$options_arr=$this->db->get_where("lb_bunglow", array("id"=>$bunglow_id))->result_array();
		$options_ids=$options_arr[0]['option_id'];
		$this->db->select('*');
		$this->db->from('lb_bunglow_options');
		$this->db->join('lb_bunglow_options_lang', 'lb_bunglow_options.id = lb_bunglow_options_lang.options_id AND lb_bunglow_options.is_active="Y" AND lb_bunglow_options.id IN ('.$options_ids.') AND lb_bunglow_options_lang.language_id='.$current_lang_id);
		$options_details_arr=$this->db->get()->result_array();
		return $options_details_arr;
		
	}
	
	
	//function to check availability via ajax
	function ajax_check_availability($bungalow_id, $arrival_date, $leave_date)
	{
		$query=$this->db->get_where("lb_reservation", array("bunglow_id"=>$bungalow_id))->result_array();
		if(count($query)>0)
		{
			$date_arr=$this->dateRange($arrival_date, $leave_date);
			$total_days=count($date_arr);
			$available_date=array();
			$check_cleaning=$this->db->query("SELECT * FROM `lb_bunglow` WHERE `id`='$bungalow_id'")->result_array();
			foreach($date_arr as $date)
			{
				$check_query=$this->db->query("SELECT * FROM `lb_reservation` WHERE `bunglow_id`='$bungalow_id' AND (`arrival_date` <= '$date' AND `leave_date` >= '$date')")->result_array();
				if(count($check_query)==0)//If date is not reserved
				{
					if($check_cleaning[0]['cleaning_date']!=$date)//Check if date is reserved for cleaning
					{
						$date_format_arr=explode("-", $date); //date format is yyyy-mm-dd. so change it to dd/mm/yyyy
						$new_date_format=$date_format_arr[2]."/".$date_format_arr[1]."/".$date_format_arr[0];
						array_push($available_date, $new_date_format);
					}
				}
			}
			if(count($available_date)==$total_days)//If User selected dates are not reserved
			{
				return "available";
			}
			elseif(count($available_date)==0)
			{
				return "notavailable";
			}
			else
			{
				return $available_date;
			}
		}
		else 
		{
			return "available";
		}
	} 
	
	
	//Function for getting all dates between two dates
	function dateRange($first_date, $last_date, $step = '+1 day', $format = 'Y-m-d' ) 
	{ 
		$dates = array();
		$current = strtotime($first_date);
		$last = strtotime($last_date);

		while( $current <= $last ) 
		{ 
			$dates[] = date($format, $current);
			$current = strtotime($step, $current);
		}
		return $dates;
	}
	
	//function for reservation process
	function reservation_process()
	{
		$get_tax_id=$this->db->get_where("lb_bunglow", array("id"=>$this->input->post('bungalow')))->result_array();
		$taxes=$get_tax_id[0]['tax_id'];
		$reservation_session=array(
			"name"=>$this->input->post('name'),
			"phone"=>$this->input->post('phone'),
			"email"=>$this->input->post('email'),
			"arrival_date"=>$this->input->post('arrival_date'),
			"leave_date"=>$this->input->post('leave_date'),
			"bungalow_id"=>$this->input->post('bungalow'),
			"options_id"=>$this->input->post('options'),
			"taxes"=>$taxes,
			"description"=>$this->input->post('description')
		);
				
		$this->session->set_userdata("reservation", $reservation_session);

		if(!$this->session->userdata('login_user_info'))
		{	
			redirect('user/login');
		}
		else 
		{
			redirect('reservation/payment');
		}
	}
	
	//function for get options for users when he has filled reservation form and he is not logged in
	function get_options_for_reservation($bungalow_id)
	{
		$current_lang_id=$this->session->userdata("current_lang_id");
		$result=$this->db->get_where("lb_bunglow", array("id"=>$bungalow_id))->result_array();
		$options_ids=$result[0]['option_id'];
		$options_arr=array();
		$result_arr=$this->db->query("SELECT * FROM `lb_bunglow_options` WHERE `id` IN (".$options_ids.")")->result_array();
		$i=0;
		foreach($result_arr as $options)
		{
			$details_arr=$this->db->get_where("lb_bunglow_options_lang", array("options_id"=>$options['id'], "language_id"=>$current_lang_id))->result_array();
			$options_arr[$i]['id']=$options['id'];
			$options_arr[$i]['options_id']=$details_arr[0]['options_id'];
			$options_arr[$i]['language_id']=$details_arr[0]['language_id'];
			$options_arr[$i]['options_name']=$details_arr[0]['options_name'];
			$options_arr[$i]['charge_in_dollars']=$options['charge_in_dollars'];
			$options_arr[$i]['charge_in_euro']=$options['charge_in_euro'];
			$i++;
		}
		return $options_arr;
	}
	
	
	//Function for getting bungalow rates while payment (According to season and total days to stay)
	function get_bungalows_with_rate($bungalow_id)
	{
		//Get default currency
		$currency_arr=$this->db->get_where("lb_currency_master", array("set_as_default"=>"Y"))->result_array();
		//firstly get current season running
		$reservation_session=$this->session->userdata("reservation");
		$current_month=date("m");
		//getting all seasons so that we could match current season and get id
		$seasons_arr=$this->db->get("lb_season")->result_array();
		foreach($seasons_arr as $seasons)
		{
			//If current months exist in seasons array
			$season_months_arr=explode("^", $seasons['months']);
			if(in_array($current_month, $season_months_arr))
			{
				$season_id=$seasons['id'];
			}
		}
		//Get rate details with season id and bungalow_id
		$rate_details_arr=$this->db->get_where("lb_bunglow_rates", array("bunglow_id"=>$bungalow_id, "season_id"=>$season_id))->result_array();
		//if default currency is dollar
		////if($currency_arr[0]['currency_id']==1)
		////{
			$total_bungalow_rate_dollar=$rate_details_arr[0]['rate_per_day_dollar'];
		////}
		//if default currency is euro
		////elseif($currency_arr[0]['currency_id']==2)
		////{
			$total_bungalow_rate=$rate_details_arr[0]['rate_per_day_euro'];
		////}
		//Calculate according to how many days user will stay
		$arrival_date_arr=explode("/", $reservation_session['arrival_date']);
		$arrival_date=strtotime($arrival_date_arr[2]."-".$arrival_date_arr[1]."-".$arrival_date_arr[0]);
		$leave_date_arr=explode("/", $reservation_session['leave_date']);
		$leave_date=strtotime($leave_date_arr[2]."-".$leave_date_arr[1]."-".$leave_date_arr[0]);
		$diff = ceil(abs($leave_date - $arrival_date) / 86400);
		$total_bungalow_rate=$total_bungalow_rate*$diff; //Multiplying with total days of staying
		$total_bungalow_rate_dollar=$total_bungalow_rate_dollar*$diff;
		
		
		$payment_session_data = $this->session->userdata('payment');
		$payment_session_data['total_bungalow_rate'] = $total_bungalow_rate;
		$payment_session_data['total_bungalow_rate_dollar'] = $total_bungalow_rate_dollar;
		$this->session->set_userdata("payment", $payment_session_data);
		return $total_bungalow_rate;
	}

	//Function to get options rate while payment
	function get_total_taxes_rate($total_bungalow_rate)
	{
		$reservation_session=$this->session->userdata("reservation");
		$total_tax_rate=0;
		//adding tax rate
		if(!empty($reservation_session['taxes']))
		{
			$taxes_arr=explode(",", $reservation_session['taxes']);
			foreach($taxes_arr as $tax_id)
			{
				$tax_details=$this->db->get_where("lb_tax", array("id"=>$tax_id))->result_array();
				//add tax rates percentage to total bungalow rates
				$rates_percentage=$tax_details[0]['rate'];
				$total_tax_rate=$total_tax_rate+($total_bungalow_rate*$rates_percentage/100);
			}
		}
		return $total_tax_rate;
	}
	
	
	//Function to get total bungalow rate with options
	function get_total_options_rate()
	{
		//Get default currency
		$total_options_rate=0;
		$currency_arr=$this->db->get_where("lb_currency_master", array("set_as_default"=>"Y"))->result_array();
		$reservation_session=$this->session->userdata("reservation");
		//adding option rate
		if(!empty($reservation_session['options_id']))
		{
			$options_arr=$reservation_session['options_id'];
			foreach($options_arr as $options_id)
			{
				$options_details_arr=$this->db->get_where("lb_bunglow_options", array("id"=>$options_id))->result_array();
				//if default currency is dollar
				if($currency_arr[0]['currency_id']==1)
				{
					$total_options_rate=$total_options_rate+$options_details_arr[0]['charge_in_dollars'];
				}
				//if default currency is euro
				elseif($currency_arr[0]['currency_id']==2)
				{
					$total_options_rate=$total_options_rate+$options_details_arr[0]['charge_in_euro'];
				}
			}
		}
		//Calculate according to how many days user will stay
		$arrival_date_arr=explode("/", $reservation_session['arrival_date']);
		$arrival_date=strtotime($arrival_date_arr[2]."-".$arrival_date_arr[1]."-".$arrival_date_arr[0]);
		$leave_date_arr=explode("/", $reservation_session['leave_date']);
		$leave_date=strtotime($leave_date_arr[2]."-".$leave_date_arr[1]."-".$leave_date_arr[0]);
		$diff = ceil(abs($leave_date - $arrival_date) / 86400);
		$total_options_rate=$total_options_rate*$diff; //Multiplying with total days of staying
		return $total_options_rate;
	}
	
	
	//Function to get partial payment rate while payment
	function get_partial_payment_rate()
	{
		$details=$this->db->get_where("mast_setting", array("site_setting_id"=>1))->result_array();
		return $details[0]['partial_amount_percentage'];
	}
	
	
	//Function to get paypal details while payment
	function get_paypal_details()
	{
		$details=$this->db->get_where("mast_setting", array("site_setting_id"=>1))->result_array();
		return $details[0]['paypal_id'];
	}
	
	//Function to get bungalow details for paypal
	function get_bunglow_details_for_paypal($bungalow_id)
	{
		$current_lang_id=$this->session->userdata("current_lang_id");
		$get_main_data=$this->db->get_where("lb_bunglow", array("id"=>$bungalow_id))->result_array();
		$auto_id=$get_main_data[0]['id'];
		$this->db->select('*');
		$this->db->from('lb_bunglow');
		$this->db->join('lb_bunglow_lang', 'lb_bunglow.id = lb_bunglow_lang.bunglow_id AND lb_bunglow.id='.$auto_id.' AND lb_bunglow_lang.language_id='.$current_lang_id);
		$get_details_arr = $this->db->get()->result_array();
		return $get_details_arr;
	}
	
	
	//Function for inserting payment data
	function insert_payment_data_on_success($ins_arr)
	{
		$this->db->insert("lb_reservation", $ins_arr);
		$last_id=$this->db->insert_id();
		$this->send_email_process();
		$this->session->unset_userdata("reservation");
		$this->session->unset_userdata("payment");
	}
	
	//Function for getting discount on bungalow
	function get_discount($bungalow_id)
	{
		//Get default currency
		$currency_arr=$this->db->get_where("lb_currency_master", array("set_as_default"=>"Y"))->result_array();
		//firstly get current season running
		$reservation_session=$this->session->userdata("reservation");
		$current_month=date("m");
		//getting all seasons so that we could match current season and get id
		$seasons_arr=$this->db->get("lb_season")->result_array();
		foreach($seasons_arr as $seasons)
		{
			//If current months exist in seasons array
			$season_months_arr=explode("^", $seasons['months']);
			if(in_array($current_month, $season_months_arr))
			{
				$season_id=$seasons['id'];
			}
		}
		//Get rate details with season id and bungalow_id
		$rate_details_arr=$this->db->get_where("lb_bunglow_rates", array("bunglow_id"=>$bungalow_id, "season_id"=>$season_id))->result_array();
		$payment_session_data = $this->session->userdata('payment');
		$payment_session_data['discount'] = $rate_details_arr[0]['discount'];
		$this->session->set_userdata("payment", $payment_session_data);
		return $rate_details_arr[0]['discount'];
	}
	
	
	
	//Function for getting current season name for payment page
	function get_season_name_for_payment_page()
	{
		$current_month=date("m");
		$seasons_arr=$this->db->get("lb_season")->result_array();
		foreach($seasons_arr as $seasons)
		{
			//If current months exist in seasons array
			$season_months_arr=explode("^", $seasons['months']);
			if(in_array($current_month, $season_months_arr))
			{
				$season_id=$seasons['id'];
			}
		}
		$current_lang_id=$this->session->userdata("current_lang_id");
		$season_arr=$this->db->get_where("lb_season_lang", array("language_id"=>$current_lang_id, "season_id"=>$season_id))->result_array();
		return $season_arr;
	}
	
	//function to get tax rate for payment page
	function get_tax_rate_for_payment_page($bungalow_id)
	{
		$current_lang_id=$this->session->userdata("current_lang_id");
		$payment_session=$this->session->userdata('payment');
		$total_bungalow_rate=$this->get_bungalows_with_rate($bungalow_id);
		$total_bungalow_rate_dollar=$payment_session['total_bungalow_rate_dollar'];
		$reservation_session=$this->session->userdata("reservation");
		$total_tax_rate_arr=array();
		$all_total_tax_rate=0;
		$all_total_tax_rate_dollar=0;
		//adding tax rate
		if(!empty($reservation_session['taxes']))
		{
			$taxes_arr=explode(",", $reservation_session['taxes']);
			$x=0;
			foreach($taxes_arr as $tax_id)
			{
				$this->db->select('*');
				$this->db->from('lb_tax');
				$this->db->join('lb_tax_lang', 'lb_tax.id = lb_tax_lang.tax_id AND lb_tax.id='.$tax_id.' AND lb_tax_lang.language_id='.$current_lang_id);
				$tax_details=$this->db->get()->result_array();
				//add tax rates percentage to total bungalow rates
				$rates_percentage=$tax_details[0]['rate'];
				$total_tax_rate=$total_bungalow_rate*$rates_percentage/100;
				$total_tax_rate_dollar=$total_bungalow_rate_dollar*$rates_percentage/100;
				$total_tax_rate_arr[$x]['tax_name']=$tax_details[0]['tax_name'];
				$total_tax_rate_arr[$x]['tax_rate']=$rates_percentage;
				$total_tax_rate_arr[$x]['tax_value']=$total_tax_rate;
				$total_tax_rate_arr[$x]['tax_value_dollar']=$total_tax_rate_dollar;
				$all_total_tax_rate=$all_total_tax_rate+$total_tax_rate;
				$all_total_tax_rate_dollar=$all_total_tax_rate_dollar+$total_tax_rate_dollar;
				$x++;
				
			}
		}
		
		$payment_session_data = $this->session->userdata('payment');
		$payment_session_data['total_taxes_rate'] = $all_total_tax_rate;
		$payment_session_data['total_taxes_rate_dollar'] = $all_total_tax_rate_dollar;
		$payment_session_data['taxes_rate_array'] = $total_tax_rate_arr;
		$this->session->set_userdata("payment", $payment_session_data);

		return $total_tax_rate_arr;
	}
	
	
	//Function for getting options rate for that particular bungalow
	function get_options_rate_for_payment_page()
	{
		//Get default currency
		$current_lang_id=$this->session->userdata("current_lang_id");
		$total_options_rate=0;
		$currency_arr=$this->db->get_where("lb_currency_master", array("set_as_default"=>"Y"))->result_array();
		$reservation_session=$this->session->userdata("reservation");
		$total_options_rate_arr=array();
		$total_options_rate=0;
		$total_options_rate_dollar=0;
		//adding option rate
		if(!empty($reservation_session['options_id']))
		{
			//Calculate according to how many days user will stay
			$arrival_date_arr=explode("/", $reservation_session['arrival_date']);
			$arrival_date=strtotime($arrival_date_arr[2]."-".$arrival_date_arr[1]."-".$arrival_date_arr[0]);
			$leave_date_arr=explode("/", $reservation_session['leave_date']);
			$leave_date=strtotime($leave_date_arr[2]."-".$leave_date_arr[1]."-".$leave_date_arr[0]);
			$diff = ceil(abs($leave_date - $arrival_date) / 86400);
			
			$options_arr=$reservation_session['options_id'];
			$x=0;
			foreach($options_arr as $options_id)
			{
				$options_details_arr=$this->db->get_where("lb_bunglow_options", array("id"=>$options_id))->result_array();
				$this->db->select('*');
				$this->db->from('lb_bunglow_options');
				$this->db->join('lb_bunglow_options_lang', 'lb_bunglow_options.id = lb_bunglow_options_lang.options_id AND lb_bunglow_options.id='.$options_id.' AND lb_bunglow_options_lang.language_id='.$current_lang_id);
				$options_details=$this->db->get()->result_array();

				////if($currency_arr[0]['currency_id']==1)
				////{
					$total_options_rate_arr[$x]['options_name']=$options_details[0]['options_name'];
					$total_options_rate_arr[$x]['options_charges_dollar']=$options_details[0]['charge_in_dollars']*$diff;
					$total_options_rate_dollar=$total_options_rate_dollar+($options_details[0]['charge_in_dollars']*$diff);
				////}
				////elseif($currency_arr[0]['currency_id']==2)
				////{
					//$total_options_rate_arr[$x]['options_name']=$options_details[0]['options_name'];
					$total_options_rate_arr[$x]['options_charges']=$options_details[0]['charge_in_euro']*$diff;
					$total_options_rate=$total_options_rate+($options_details[0]['charge_in_euro']*$diff);
				////}
				$x++;
			}
		}
		$payment_session_data = $this->session->userdata('payment');
		$payment_session_data['total_options_rate'] = $total_options_rate;
		$payment_session_data['total_options_rate_dollar'] = $total_options_rate_dollar;
		$payment_session_data['options_rate_array'] = $total_options_rate_arr;
		$this->session->set_userdata("payment", $payment_session_data);
		return $total_options_rate_arr;
	}
	
	//Function for getting total charges 
	function get_total()
	{
		$payment_session=$this->session->userdata("payment");
		$total_bungalow_rate=$payment_session['total_bungalow_rate'];
		$total_options_rate=$payment_session['total_options_rate'];
		$total_taxes_rate=$payment_session['total_taxes_rate'];
		
		$total_bungalow_rate_dollar=$payment_session['total_bungalow_rate_dollar'];
		$total_options_rate_dollar=$payment_session['total_options_rate_dollar'];
		$total_taxes_rate_dollar=$payment_session['total_taxes_rate_dollar'];
		
		$discount=$payment_session['discount'];
		
		$total_with_bungalow_and_options=$total_bungalow_rate+$total_options_rate;
		$total_by_substrating_discount=$total_with_bungalow_and_options-($total_with_bungalow_and_options*$discount/100);
		$final_amount_with_taxes=$total_by_substrating_discount+$total_taxes_rate;
		
		$total_with_bungalow_and_options_dollar=$total_bungalow_rate_dollar+$total_options_rate_dollar;
		$total_by_substrating_discount_dollar=$total_with_bungalow_and_options_dollar-($total_with_bungalow_and_options_dollar*$discount/100);
		$final_amount_with_taxes_dollar=$total_by_substrating_discount_dollar+$total_taxes_rate_dollar;
		
		$payment_session_data = $this->session->userdata('payment');
		$payment_session_data['total_charge'] = $final_amount_with_taxes;
		$payment_session_data['total_charge_dollar'] = $final_amount_with_taxes_dollar;
		$this->session->set_userdata("payment", $payment_session_data);
		return $final_amount_with_taxes;
	}
	
	
	//Function to get unique invoice number_format
	function get_unique_invoice_number()
	{
		$invoice_num="LB".rand(11111111, 99999999);
		$check_inv=$this->db->get_where("lb_reservation", array("invoice_number"=>$invoice_num))->result_array();
		$z=0;
		while($z=0)
		{
			if(count($check_inv)>0)
			{
				$invoice_num="LB_".rand(111111, 999999);
			}
		}
		return $invoice_num;
	}
	
	//Function to get bungalow_details by slug
	function get_bungalow_details_by_slug($slug)
	{
		$bungalow_arr=$this->db->get_where("lb_bunglow", array("slug"=>$slug))->result_array();
		return $bungalow_arr[0]['id'];
	}
	
	
	
	//Function for sending email to user after reservation or payment
	function send_email_process()
	{
		$admin_arr=$this->db->get_where("mast_admin_info", array('id'=>1))->result_array();
		$admin_email=$admin_arr[0]['email'];
		$partial_payment_rate=$this->reservation_model->get_partial_payment_rate();

		//Get default currency
		$currency_arr=$this->db->get_where("lb_currency_master", array("set_as_default"=>"Y"))->result_array();
		$current_lang_id=$this->session->userdata("current_lang_id");
		$user_session=$this->session->userdata('login_user_info');
		$user_id=$user_session['user_id'];
		$user_details=$this->db->get_where("lb_users", array("id"=>$user_id))->result_array();
		$user_email=$user_details[0]['email'];
		$reservation_session=$this->session->userdata("reservation");
		$bungalow_id=$reservation_session['bungalow_id'];
		$this->db->select('*');
		$this->db->from('lb_bunglow');
		$this->db->join('lb_bunglow_lang', 'lb_bunglow.id = lb_bunglow_lang.bunglow_id AND lb_bunglow.id='.$bungalow_id.' AND lb_bunglow_lang.language_id='.$current_lang_id);
		$bungalow_details=$this->db->get()->result_array();
		$payment_session=$this->session->userdata("payment");
		
		$options_text="";
		if(!empty($payment_session['options_rate_array']))
		{
			foreach($payment_session['options_rate_array'] as $options_rate)
			{
				$options_text .="<p>".$options_rate['options_name']." : ".$currency_arr[0]['currency_symbol'].$options_rate['options_charges']."</p>";
			}
		}
		else
		{
			$options_text .="N/A";
		}
		
		$taxes_text="";
		if(!empty($payment_session['taxes_rate_array']))
		{
			foreach($payment_session['taxes_rate_array'] as $taxes_rate)
			{
				$taxes_text .="<p>".$taxes_rate['tax_name']." (".$taxes_rate['tax_rate']."%) : ".$currency_arr[0]['currency_symbol'].$taxes_rate['tax_value']."</p>";
			}
		}
		else
		{
			$taxes_text .="N/A";
		}
		
		$additional_payment_text="";
		if(isset($payment_session['partial_payment']))
		{
			$additional_payment_text='<tr>
				<td><b>'.lang('Paid_Amount').'</b></td>
				<td>'.$currency_arr[0]['currency_symbol'].$payment_session['partial_payment'].'</td>
			</tr>
			<tr>
				<td><b>'.lang('Due_Amount').'</b></td>
				<td>'.$currency_arr[0]['currency_symbol'].$payment_session['due_payment'].'</td>
			</tr>
			';
		}
		if($reservation_session['payment_type']=="on_arrival")
		{
			$additional_payment_text='
			<tr>
				<td><b>'.lang('Amount_to_be_paid').':</b></td>
				<td>'.$currency_arr[0]['currency_symbol'].$reservation_session['amount_to_be_paid'].'</td>
			</tr>
			';
		}
		
		
		//Send email to user
		$msg_text1='<table width="90%" border="0" cellspacing="3" cellpadding="3" bgcolor="#FFFFFF">
			<tr bgcolor="#999999">
			<td colspan="2" align="center" ><b><font color="#FFFFFF">'.lang('New_Reservation_Les_Balcons_Company').'</font></b></td>
			</tr>';
		$msg_text1.='
			<tr bgcolor="#CCCCCC">
			<td colspan="2">
				<b>'.lang('Dear').' '.$user_details[0]['name'].',</b><br>
				<b>'.lang('Your_reservation_has_been_done_successfully').'</b><br>
				<b>'.lang('Find_the_details_below').'</b>
			</td>
			</tr>
			<tr>
				<td><b>'.lang('Name').': </b></td><td>'.$reservation_session['name'].'</td>
			</tr>
			<tr>
				<td><b>'.lang('Arrival_Date').': </b></td><td>'.$reservation_session['arrival_date'].'</td>
			</tr>
			<tr>
				<td><b>'.lang('Leave_Date').':</b></td><td>'.$reservation_session['leave_date'].'</td>
			</tr>
			<tr>
				<td><b>'.lang('Bungalow').':</b></td><td>'.$bungalow_details[0]['bunglow_name'].'</td>
			</tr>
			<tr>
				<td><b>'.lang('Bungalow').' '.lang('Rate').':</b></td><td>'.$currency_arr[0]['currency_symbol'].$payment_session['total_bungalow_rate'].'</td>
			</tr>
			<tr>
				<td><b>Options '.lang('Rate').':</b></td><td>'.$options_text.'</td>
			</tr>
			<tr>
				<td><b>'.lang('Discount').':</b></td><td>'.$payment_session['discount'].'%</td>
			</tr>
			<tr>
				<td><b>'.lang('Tax').' '.lang('Rate').':</b></td><td>'.$taxes_text.'</td>
			</tr>
			<tr>
				<td><b>Total:</b></td><td>'.$currency_arr[0]['currency_symbol'].$payment_session['total_charge'].'</td>
			</tr>';
		if($additional_payment_text!="")
		{
			$msg_text1.=$additional_payment_text;
		}
		$msg_text1.='<tr>
				<td colspan="2">
				<p><b>'.lang('Regards').'</b></p>
				<p><b>La Balcons Company</b></p>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="left" valign="top"><a href="#" target="_blank"><img src="'.base_url().'assets/images/logo.png" alt="" border="0" /></a></td>
			</tr>';
		$msg_text1.='</table>';
		$subject1 = lang('New_Reservation_Les_Balcons_Company');
		$to1 = $user_email;
		$this->load->library('email');
		$config['mailtype'] = "html";
		$this->email->initialize($config);	
		$this->email->clear();
		$this->email->from($admin_email, 'LES BALCONS');
		$this->email->to($to1);
		$this->email->subject($subject1);
		$this->email->message($msg_text1); 
		$this->email->send();
		
		//Send email to admin
		$msg_text2='<table width="90%" border="0" cellspacing="3" cellpadding="3" bgcolor="#FFFFFF">
			<tr bgcolor="#999999">
			<td colspan="2" align="center" ><b><font color="#FFFFFF">'.lang('New_Reservation_Les_Balcons_Company').'</font></b></td>
			</tr>';
		$msg_text2.='
			<tr bgcolor="#CCCCCC">
			<td colspan="2">
				<b>'.lang('Dear').' Admin,</b><br>
				<b>'.lang('Your_reservation_has_been_done_successfully').'</b><br>
				<b>'.lang('Find_the_details_below').'</b>
			</td>
			</tr>
			<tr>
				<td><b>'.lang('Name').': </b></td><td>'.$reservation_session['name'].'</td>
			</tr>
			<tr>
				<td><b>'.lang('Arrival_Date').': </b></td><td>'.$reservation_session['arrival_date'].'</td>
			</tr>
			<tr>
				<td><b>'.lang('Leave_Date').':</b></td><td>'.$reservation_session['leave_date'].'</td>
			</tr>
			<tr>
				<td><b>'.lang('Bungalow').':</b></td><td>'.$bungalow_details[0]['bunglow_name'].'</td>
			</tr>
			<tr>
				<td><b>'.lang('Bungalow').' '.lang('Rate').':</b></td><td>'.$currency_arr[0]['currency_symbol'].$payment_session['total_bungalow_rate'].'</td>
			</tr>
			<tr>
				<td><b>Options '.lang('Rate').':</b></td><td>'.$options_text.'</td>
			</tr>
			<tr>
				<td><b>'.lang('Discount').':</b></td><td>'.$payment_session['discount'].'%</td>
			</tr>
			<tr>
				<td><b>'.lang('Tax').' '.lang('Rate').':</b></td><td>'.$taxes_text.'</td>
			</tr>
			<tr>
				<td><b>Total:</b></td><td>'.$currency_arr[0]['currency_symbol'].$payment_session['total_charge'].'</td>
			</tr>';
			if($additional_payment_text!="")
			{
				$msg_text2.=$additional_payment_text;
			}
			$msg_text2.='<tr>
				<td colspan="2">
				<p><b>'.lang('Regards').'</b></p>
				<p><b>La Balcons Company</b></p>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="left" valign="top"><a href="#" target="_blank"><img src="'.base_url().'assets/images/logo.png" alt="" border="0" /></a></td>
			</tr>';
		$msg_text2.='</table>';
		$subject2 = lang('New_Reservation_Les_Balcons_Company');
		$to2 = $admin_email;
		$this->load->library('email');
		$config['mailtype'] = "html";
		$this->email->initialize($config);	
		$this->email->clear();
		$this->email->from($admin_email, 'LES BALCONS');
		$this->email->to($to2);
		$this->email->subject($subject2);
		$this->email->message($msg_text2); 
		$this->email->send();
		
	}
	
	
	//Function to get dollar currency
	function get_dollar_currency()
	{
		$result=$this->db->get_where("lb_currency_master", array("currency_id"=>1))->result_array();
		return $result[0]['currency_symbol'];
	}
}
	

?>