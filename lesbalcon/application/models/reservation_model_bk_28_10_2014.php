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
			foreach($date_arr as $date)
			{
				$check_query=$this->db->query("SELECT * FROM `lb_reservation` WHERE `bunglow_id`='$bungalow_id' AND (`arrival_date` <= '$date' AND `leave_date` >= '$date')")->result_array();
				if(count($check_query)==0)//If date is not reserved
				{
					array_push($available_date, $date);
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
	
	
	//Function for getting bungalow rates while payment (According to season)
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
		if($currency_arr[0]['currency_id']==1)
		{
			$total_bungalow_rate=$rate_details_arr[0]['rate_per_day_dollar'];
		}
		//if default currency is euro
		elseif($currency_arr[0]['currency_id']==2)
		{
			$total_bungalow_rate=$rate_details_arr[0]['rate_per_day_euro'];
		}
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
		$this->session->unset_userdata("reservation");
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
		return $rate_details_arr[0]['discount'];
	}
	
}
	

?>