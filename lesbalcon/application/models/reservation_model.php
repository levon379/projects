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
		$this->db->order_by('sort_order', 'asc');
		$array=$this->db->get_where("lb_bunglow", array("type"=>"B","is_active"=>"Y"))->result_array();
		$i=0;

		foreach($array as $val)
		{
			$peroperty_id=$val['id'];
			$get_details_arr=$this->db->get_where("lb_bunglow_lang", array("bunglow_id"=>$peroperty_id, "language_id"=>$current_lang_id))->result_array();
			$all_bunglow_array[$i]['id']=$val['id'];
			$val = explode("<span>",$get_details_arr[0]['bunglow_name']);
			$all_bunglow_array[$i]['bunglow_name']=$val[0];
			$i++;
		}
		return $all_bunglow_array;
	}

	//Function to get bungalow list in drop down
	function get_bungalows_by_id($bunglow_id)
	{
		$current_lang_id=$this->session->userdata("current_lang_id");
		$get_details_arr=$this->db->get_where("lb_bunglow_lang", array("bunglow_id"=>$bunglow_id, "language_id"=>$current_lang_id))->result_array();
		$val = explode("<span>",$get_details_arr[0]['bunglow_name']);
		return $val[0];
	}
	
	//Function to get properties list in drop down
	function get_properties()
	{
		$current_lang_id=$this->session->userdata("current_lang_id");
		$all_bunglow_array=array();
		$this->db->order_by('id', 'desc');
		$array=$this->db->get_where("lb_bunglow", array("type"=>"P","is_active"=>"Y"))->result_array();
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
		
		if( !empty($options_ids) ) {
			$this->db->select('*');
			$this->db->from('lb_bunglow_options');
			$this->db->join('lb_bunglow_options_lang', 'lb_bunglow_options.id = lb_bunglow_options_lang.options_id AND lb_bunglow_options.is_active="Y" AND lb_bunglow_options.id IN ('.$options_ids.') AND lb_bunglow_options_lang.language_id='.$current_lang_id);
			$options_details_arr=$this->db->get()->result_array();
		}else {
			$options_details_arr = array();
		}
		return $options_details_arr;
		
	}
	
	
	//function to check availability via ajax
	function ajax_check_availability_old($bungalow_id, $arrival_date, $leave_date)
	{
		//$query=$this->db->get_where("lb_reservation", array("bunglow_id"=>$bungalow_id))->result_array();
		//if(count($query)>0)
		//{
			$date_arr=$this->dateRange($arrival_date, $leave_date);
			$total_days=count($date_arr);

			$available_date=array();
			
			foreach($date_arr as $date)
			{
				//echo "SELECT * FROM `lb_reservation` WHERE `bunglow_id` = '$bungalow_id' AND (`arrival_date` <= '$date' AND `leave_date` >= '$date') AND `is_active`!='Desactiver' AND `reservation_status` != 'Annulé'"; 
				$check_query=$this->db->query("SELECT * FROM `lb_reservation` WHERE `bunglow_id` = '$bungalow_id' AND (`arrival_date` <= '$date' AND `leave_date` >= '$date') AND `is_active`!='Desactiver' AND `reservation_status` != 'Annulé'")->result_array();
				if(count($check_query)==0)//If date is not reserved
				{
					$check_cleaning=$this->db->query("SELECT * FROM `lb_bunglow_cleaning` WHERE `bunglow_id`='$bungalow_id' AND `cleaning_date`='$date'")->result_array();
					if(count($check_cleaning)==0)//Check if date is reserved for cleaning
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
		//}
		//else 
		//{
			//return "available";
		//}
	} 
	
	
	//function to check availability via ajax
	function ajax_check_availability($bungalow_id, $arrival_date, $leave_date,$reservation_id='')
	{
		//$query=$this->db->get_where("lb_reservation", array("bunglow_id"=>$bungalow_id))->result_array();
		//if(count($query)>0)
		//{
			$date_arr=$this->dateRange($arrival_date, $leave_date);
			$total_days=count($date_arr);

			$available_date=array();
			
			foreach($date_arr as $date)
			{
				//echo "SELECT * FROM `lb_reservation` WHERE `bunglow_id` = '$bungalow_id' AND (`arrival_date` <= '$date' AND `leave_date` >= '$date') AND `is_active`!='Desactiver' AND `reservation_status` != 'Annulée'"; 
				if($reservation_id != '') $check_query=$this->db->query("SELECT * FROM `lb_reservation` WHERE `id` != '$reservation_id' and `bunglow_id` = '$bungalow_id' AND (`arrival_date` <= '$date' AND `leave_date` > '$date') AND `is_active`!='Desactiver' AND `reservation_status` != 'Annulée'")->result_array();
				else $check_query=$this->db->query("SELECT * FROM `lb_reservation` WHERE `bunglow_id` = '$bungalow_id' AND (`arrival_date` <= '$date' AND `leave_date` > '$date') AND `is_active`!='Desactiver' AND `reservation_status` != 'Annulée'")->result_array();
				
				if(count($check_query)==0)//If date is not reserved
				{
					$check_cleaning=$this->db->query("SELECT * FROM `lb_bunglow_cleaning` WHERE `bunglow_id`='$bungalow_id' AND `cleaning_date`='$date'")->result_array();
					if(count($check_cleaning)==0 || 1==1)//Check if date is reserved for cleaning
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
		//}
		//else 
		//{
			//return "available";
		//}
	} 
	
	
	//Function for getting all dates between two dates
	function dateRange($first_date, $last_date, $step = '+1 day', $format = 'Y-m-d' ) 
	{ 
		$dates = array();
		
		$current = intval($first_date) == $first_date ? $first_date : strtotime($first_date);
		$last = intval($last_date) == $last_date ? $last_date : strtotime($last_date);

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
		$stay_euro = 0;

		$q_val = explode("/",$this->input->post('arrival_date'));		 
		$season_id = $this->getSeasons($q_val[0],$q_val[1],$q_val[2]);

		$q_val1 = explode("/",$this->input->post('leave_date'));		 
		$another_season_id = $this->getSeasons($q_val1[0],$q_val1[1],$q_val1[2]);
		
		$arrival_date_arr=explode("/",$this->input->post('arrival_date'));
		$arrival_date = mktime(0,0,0, $arrival_date_arr[1], $arrival_date_arr[0], $arrival_date_arr[2] );
		$leave_date_arr=explode("/", $this->input->post('leave_date'));
		$leave_date=mktime(0,0,0, $leave_date_arr[1], $leave_date_arr[0], $leave_date_arr[2] );

		$date_arr=$this->dateRange($arrival_date, $leave_date);
		$days_count=count($date_arr) - 1;
		//$days_count=count($date_arr);

		if($season_id != $another_season_id){
			$arrival_date1 = $this->input->post('arrival_date');
			$leave_date1 = $this->input->post('leave_date');

			$a_date_part = explode("/",$arrival_date1);
			$l_date_part = explode("/",$leave_date1);

			$arrival_time = mktime(0,0,0,$a_date_part[1],$a_date_part[0],$a_date_part[2]);
			$leave_time = mktime(0,0,0,$l_date_part[1],$l_date_part[0],$l_date_part[2]);//strtotime($leave_date);

			$high_days = $low_days = 0;
			if($season_id == '1' && $another_season_id == '2'){
				$high_end_date = mktime(0,0,0,4,14,$a_date_part[2]);
				$low_start_date = mktime(0,0,0,4,15,$l_date_part[2]);

				for($i=1;$i<=$days_count;$i++){ 
					if($high_end_date >= $arrival_time) {
						$high_days++;
						$arrival_time = strtotime("+1 day",$arrival_time);
					}
					else{
						$low_days++;
					}
				}
			}
			else if($season_id == '2' && $another_season_id == '1'){
				$low_end_date = mktime(0,0,0,12,14,$l_date_part[2]);
				$high_start_date = mktime(0,0,0,12,15,$a_date_part[2]);

				for($i=1;$i<=$days_count;$i++){ 
					if($low_end_date >= $arrival_time) {
						$low_days++;
						$arrival_time = strtotime("+1 day",$arrival_time);
					}
					else{
						$high_days++;
					}
				}
			}

			$rate_details_arr=$this->db->get_where("lb_bunglow_rates", array("bunglow_id"=>$this->input->post('bungalow'), "season_id"=>"1"))->result_array();
			$rate_details_arr1=$this->db->get_where("lb_bunglow_rates", array("bunglow_id"=>$this->input->post('bungalow'), "season_id"=>"2"))->result_array();
			/*echo "Extra per night (HIGH): ".$rate_details_arr[0]['extranight_perday_europrice'].",Extra per night (LOW): ".$rate_details_arr1[0]['extranight_perday_europrice']."<br/>";
			echo "Rate per night (HIGH): ".$rate_details_arr[0]['rate_per_day_euro'].",Rate per night (LOW): ".$rate_details_arr1[0]['rate_per_day_euro']."<br/>";
			*/if( $days_count > 6 ){
				$stay_euro = $low_days * $rate_details_arr1[0]['extranight_perday_europrice'];
				$stay_euro += $high_days * $rate_details_arr[0]['extranight_perday_europrice'];
			}else {
				$stay_euro = $rate_details_arr1[0]['rate_per_day_euro'] * $low_days;
				$stay_euro += $rate_details_arr[0]['rate_per_day_euro'] * $high_days;
			}

			/*echo "Arrival Date: ".$arrival_date1.", Leave Date: ".$leave_date1.". No. of high days: ".$high_days.". No. of low days: ".$low_days.", Price: ".$stay_euro."<br/>";
			die;*/
		}else{

			//Get rate details with season id and bungalow_id
			$rate_details_arr=$this->db->get_where("lb_bunglow_rates", array("bunglow_id"=>$this->input->post('bungalow'), "season_id"=>$season_id))->result_array();

			if( $days_count > 6 ){
				$stay_euro = $days_count * $rate_details_arr[0]['extranight_perday_europrice'];
			}else {
				$stay_euro = $rate_details_arr[0]['rate_per_day_euro'] * $days_count;
			}
		}	

		$val1 = $val2 = $val3 = $val4 = $val5 = $val6 = $val7 = 0;
		
		$val1 = ($this->input->post('no_of_adult') != "--Sélectionner--") ? $this->input->post('no_of_adult') :"0";
		$val2 = ($this->input->post('no_of_extra_real_adult') != "--Sélectionner--") ?$this->input->post('no_of_extra_real_adult') :"0";
		$val3 = ($this->input->post('no_of_extra_adult') != "--Sélectionner--") ?$this->input->post('no_of_extra_adult') :"0";
		$val4 = ($this->input->post('no_of_extra_kid') != "--Sélectionner--") ?$this->input->post('no_of_extra_kid') :"0";
		$val5 = ($this->input->post('no_of_folding_bed_kid') != "--Sélectionner--") ?$this->input->post('no_of_folding_bed_kid') :"0";
		$val6 = ($this->input->post('no_of_folding_bed_adult') != "--Sélectionner--") ?$this->input->post('no_of_extra_real_adult') :"0";
		$val7 = ($this->input->post('no_of_baby_bed') != "--Sélectionner--") ?$this->input->post('no_of_baby_bed') :"0";

	 	$total = ($val2 * 15 * $days_count) + ($val3 * 15 * $days_count) + ($val6 * 15 * $days_count);
		$final_amount = $total + $stay_euro + (($total + $stay_euro) * 4/100); 


		$bunglow_name = $this->get_bungalows_by_id($this->input->post('bungalow'));

		$taxes=$get_tax_id[0]['tax_id'];
		$reservation_session=array(
			"name"=>$this->input->post('name'),
			"phone"=>$this->input->post('phone'),
			"email"=>$this->input->post('email'),
			"arrival_date"=>$this->input->post('arrival_date'),
			"leave_date"=>$this->input->post('leave_date'),
			"bungalow_id"=>$this->input->post('bungalow'),
			"bungalow_name" => $bunglow_name,
			"options_id"=>$this->input->post('options'),
			"days_count" => $days_count,
			"taxes"=>$taxes,
			"description"=>$this->input->post('description'),
			"no_of_adult" => $val1,
			"no_of_extra_real_adult" => $val2,
			"no_of_extra_adult" => $val3,
			"no_of_extra_kid" => $val4,
			"no_of_folding_bed_kid" => $val5,
			"no_of_folding_bed_adult" => $val6,
			"no_of_baby_bed" => $val7,
			"stay_euro" => $stay_euro,
			"total" => $total,
			"final_amount" => $final_amount,
			"season_name" => $this->get_season_name_for_payment_page()
		);
				
		$this->session->set_userdata("reservation", $reservation_session);
		if($this->session->userdata('registration'))
		{
			redirect('user/registration');
		}
		elseif(!$this->session->userdata('login_user_info'))
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
		$query=$this->db->get_where("lb_bunglow", array("id"=>$bungalow_id));
		if($query->num_rows()){
		   $result = $query->result_array();
		   $options_ids=$result[0]['option_id'];
	    }
		$options_arr=array();
		/*if(isset($options_ids))
		{
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
		}*/
	}
	
	function get_bungalows_with_rate($bungalow_id){
		$user_data = $this->session->userdata("reservation");
		//getting all seasons so that we cou\ld match current season and get id
		$q_val = explode("/",$user_data["arrival_date"]);		 
		$season_id = $this->getSeasons($q_val[0],$q_val[1],$q_val[2]);

		//Get rate details with season id and bungalow_id
		$rate_details_arr=$this->db->get_where("lb_bunglow_rates", array("bunglow_id"=>$bungalow_id, "season_id"=>$season_id))->result_array();

		//Calculate according to how many days user will stay
		$days_count = ceil(abs($user_data["leave_date"] - $user_data["arrival_date"]) / 86400) - 1;
		
		$result = array();
		$result['per_day_euro'] = $rate_details_arr[0]['rate_per_day_euro'];
		$result['extranight_perday_europrice'] = $rate_details_arr[0]['extranight_perday_europrice'];
		
		$per_day = $rate_details_arr[0]['rate_per_day_euro'];
		
		if( $days_count > 6 ){
			$stay_euro = $days_count * $result['extranight_perday_europrice'];
		}else {
			$stay_euro = $per_day * $days_count;
		}
		
		$result['extra_euro'] = 0;
		$result['total_euro'] = 0;
		$result['day_diff'] = $days_count;
		
		
		$payment_session_data = $this->session->userdata('payment');
		$payment_session_data['bungalow_per_day'] = $rate_details_arr[0]['rate_per_day_euro'];
		$payment_session_data['bungalow_per_day_dollar'] = $rate_details_arr[0]['rate_per_day_dollar'];		
		$payment_session_data['total_bungalow_rate'] = $stay_euro;
		$payment_session_data['total_bungalow_rate_dollar'] = $total_bungalow_rate_dollar;
		$this->session->set_userdata("payment", $payment_session_data);
		return $total_bungalow_rate; //returning euro rate because payment will be in euro
	}
	
	//Function for getting bungalow rates while payment (According to season and total days to stay)
	function get_bungalows_with_rate_old($bungalow_id)
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
		$res_val = $this->session->userdata("reservation");
		$q_val = explode("/",$res_val['arrival_date']);		 
		$season_id = $this->getSeasons($q_val[0],$q_val[1],$q_val[2]);
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
		$payment_session_data['bungalow_per_day'] = $rate_details_arr[0]['rate_per_day_euro'];
		$payment_session_data['bungalow_per_day_dollar'] = $rate_details_arr[0]['rate_per_day_dollar'];
		
		$payment_session_data['total_bungalow_rate'] = $total_bungalow_rate;
		$payment_session_data['total_bungalow_rate_dollar'] = $total_bungalow_rate_dollar;
		$this->session->set_userdata("payment", $payment_session_data);
		return $total_bungalow_rate; //returning euro rate because payment will be in euro
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
		return $total_tax_rate; //Returning total tax rate based on euro total rate
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
		return $total_options_rate; //Returning total options rate based on euro 
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
		$res_val = $this->session->userdata("reservation");
		$q_val = explode("/",$res_val["arrival_date"]);		 
		$season_id = $this->getSeasons($q_val[0],$q_val[1],$q_val[2]);

		//Get rate details with season id and bungalow_id
		$rate_details_arr=$this->db->get_where("lb_bunglow_rates", array("bunglow_id"=>$bungalow_id, "season_id"=>$season_id))->result_array();
		$payment_session_data = $this->session->userdata('payment');
		$payment_session_data['discount'] = $rate_details_arr[0]['discount_per_night'];
		
		$this->session->set_userdata("payment", $payment_session_data);
		return $rate_details_arr[0]['discount_per_night'];
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
		$res_val = $this->session->userdata("reservation");
		$q_val = explode("/",$res_val["arrival_date"]);		 
		$season_id = $this->getSeasons($q_val[0],$q_val[1],$q_val[2]);

		$current_lang_id=$this->session->userdata("current_lang_id");
		$season_arr=$this->db->get_where("lb_season_lang", array("language_id"=>$current_lang_id, "season_id"=>$season_id))->result_array();
		return $season_arr;
	}

	//function to get season array
	function getSeasons($day,$month,$year,$output=""){
		$cur_date = date('Y-m-d', mktime(0,0,0,$month,$day,$year));
		$high_start_date = date('Y-m-d', mktime(0,0,0,12,15,$year));
		$high_end_date = date('Y-m-d', mktime(0,0,0,4,14,($year+1)));

		$low_start_date = date('Y-m-d', mktime(0,0,0,4,15,$year));
		$low_end_date = date('Y-m-d', mktime(0,0,0,12,14,$year));
		$season_id = 0;
		$season_name = "";
		if($cur_date >= $low_start_date && $cur_date <= $low_end_date) { $season_id = "2"; $season_name = lang("low_season"); }
		else {$season_id = "1";  $season_name = lang("high_season"); }

//echo $cur_date."*".$high_start_date."*".$high_end_date."*".$low_start_date."*".$low_end_date."---".$season_id;
		if($output == "") return $season_id;
		else return $season_name;
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
		//echo "<pre>";
		//print_r($payment_session_data);
		//die;
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
		$query=$this->db->get_where("lb_bunglow", array("slug"=>$slug));
		if($query->num_rows()){
		   $bungalow_arr = $query->result_array();
		   return $bungalow_arr[0]['id'];
	    }
	}
	
	//Function to get bungalow_details by slug
	function get_bungalow_max_person($slug)
	{
		$query=$this->db->get_where("lb_bunglow", array("slug"=>$slug));
		if($query->num_rows()){
		   $bungalow_person = $query->result_array();
		   return $bungalow_person[0]['max_person'];
	    }
	}	
		
	//Function to get bungalow_details by slug
	function get_bungalow_max_personbyID($id)
	{
		$query=$this->db->get_where("lb_bunglow", array("id"=>$id));
		if($query->num_rows()){
		   $bungalow_person = $query->result_array();
		   return $bungalow_person[0]['max_person']."-".$bungalow_person[0]['cat_type'];
	    }
	}	

	//Function to get bungalow_details by id
	function get_bungalow_catergory_type($id)
	{
		$query=$this->db->get_where("lb_bunglow", array("id"=>$id));
        if($query->num_rows()){
		   $bungalow_person = $query->result_array();
		   return $bungalow_person[0]['cat_type'];
	    }
	}	
	
	//Function to get bungalow_details by id
	function get_bungalow_catergory_type_by_slug($slug)
	{
		$query=$this->db->get_where("lb_bunglow", array("slug"=>$slug));
        if($query->num_rows()){
		   $bungalow_person = $query->result_array();
		   return $bungalow_person[0]['cat_type'];
	    }
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

		$q_val = explode("/",$reservation_session['arrival_date']);		 
		$season_name = $this->getSeasons($q_val[0],$q_val[1],$q_val[2],"name"); 
		
		$options_text="";
		/*if(!empty($payment_session['options_rate_array']))
		{
			foreach($payment_session['options_rate_array'] as $options_rate)
			{
				$options_text .="<p>".$options_rate['options_name']." : ".$currency_arr[0]['currency_symbol'].$options_rate['options_charges']."</p>";
			}
		}
		else`
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
			$payment_type=lang("PARTIAL");
			$additional_payment_text='<tr>
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>'.lang('Paid_Amount').'</b></td>
				<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$currency_arr[0]['currency_symbol'].$payment_session['partial_payment'].'</td>
			</tr>
			<tr bgcolor="#f5e8c8">
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>'.lang('Due_Amount').'</b></td>
				<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$currency_arr[0]['currency_symbol'].$payment_session['due_payment'].'</td>
			</tr>
			';
		}
		if($reservation_session['payment_type']=="on_arrival")
		{
			$payment_type=lang("ON_ARRIVAL");
			$additional_payment_text='
			<tr>
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>'.lang('Amount_to_be_paid').':</b></td>
				<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$currency_arr[0]['currency_symbol'].$reservation_session['amount_to_be_paid'].'</td>
			</tr>
			';
		}
		if($reservation_session['payment_type']=="full")
		{
			$payment_type=lang("FULL");
			$additional_payment_text='
			<tr>
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>'.lang('Paid_Amount').':</b></td>
				<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$currency_arr[0]['currency_symbol'].$reservation_session['amount_to_be_paid'].'</td>
			</tr>
			';
		}*/
		
		//Send email to user
		
		$msg_text1='<table width="650" align="center" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" style="border:1px solid #C9AD64; font-family:arial; font-size:12px;">
			<tr bgcolor="#222222">
			<td colspan="2" align="center" style="padding:8px 0;"><b><font color="#FFFFFF">'.lang('New_Reservation_Les_Balcons_Company').'</font></b></td>
			</tr>';
		$msg_text1.='
			<tr>
				<td colspan="2" align="center" valign="top" style="padding:10px 10px;"><a href="#" target="_blank"><img src="'.base_url().'assets/images/logo.png" alt="" border="0" /></a></td>
			</tr>
			<tr>
				<td colspan="2" style="border-top:1px solid #C9AD64; padding:5px;">
					<b>'.lang('Dear').' '.$user_details[0]['name'].',</b><br>
					<b>'.lang('Thank_you_for_your_reservation').'</b><br>
					<b>'.lang('Find_the_details_below').'</b>
				</td>
			</tr>
			<tr bgcolor="#f5e8c8">
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>'.lang('Name').': </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$user_session['full_name'].'</td>
			</tr>
			<tr>
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>'.lang('Email').': </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$user_session['email'].'</td>
			</tr>
			<tr bgcolor="#f5e8c8">
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>'.lang('Address').': </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$user_session['address'].'</td>
			</tr>
			<tr>
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>'.lang('Contact_no').': </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$user_session['contact_number'].'</td>
			</tr>
			<tr bgcolor="#f5e8c8">
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>'.lang('Arrival_Date').': </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$reservation_session['arrival_date'].'</td>
			</tr>
			<tr>
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>'.lang('Leave_Date').':</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$reservation_session['leave_date'].'</td>
			</tr>
                        <!--
			<tr bgcolor="#f5e8c8" style="display:none;">
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>'.lang('Season').':</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$season_name.'</td>
			</tr>-->
			<tr>
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>'.lang('Bungalow_Name').':</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$bungalow_details[0]['bunglow_name'].'</td>
			</tr>';
		if($reservation_session['no_of_adult'] != ""){
			$msg_text1.= '<tr>
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>'.lang('no_of_adult').':</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$reservation_session['no_of_adult'].'</td>
			</tr>';
		}if($reservation_session['no_of_extra_real_adult'] != ""){
			$msg_text1.= '
			<tr bgcolor="#f5e8c8">
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>'.lang('no_of_extra_real_adult').':</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$reservation_session['no_of_extra_real_adult'].'</td>
			</tr>';
		}if($reservation_session['no_of_extra_adult'] != ""){
			$msg_text1.= '
			<tr>
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>'.lang('no_of_extra_adult').':</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$reservation_session['no_of_extra_adult'].'</td>
			</tr>';
		}if($reservation_session['no_of_extra_kid'] != ""){
			$msg_text1.= '
			<tr bgcolor="#f5e8c8">
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>'.lang('no_of_extra_kid').':</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$reservation_session['no_of_extra_kid'].'</td>
			</tr>';
		}if($reservation_session['no_of_folding_bed_kid'] != ""){
			$msg_text1.= '
			<tr>
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>'.lang('no_of_folding_bed_kid').':</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$reservation_session['no_of_folding_bed_kid'].'</td>
			</tr>';
		}if($reservation_session['no_of_folding_bed_adult'] != ""){
			$msg_text1.= '
			<tr bgcolor="#f5e8c8">
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>'.lang('no_of_folding_bed_adult').':</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$reservation_session['no_of_folding_bed_adult'].'</td>
			</tr>';
		}if($reservation_session['no_of_baby_bed'] != ""){
			$msg_text1.= '
			<tr>
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>'.lang('no_of_baby_bed').':</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$reservation_session['no_of_baby_bed'].'</td>
			</tr>';
		}
		$msg_text1.= '
			<tr bgcolor="#f5e8c8">
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>'.lang('STAY_TAX_TEXT').':</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">4%</td>
			</tr>
			<tr>
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>'.lang('basic_stay').':</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$currency_arr[0]['currency_symbol'].$reservation_session['stay_euro'].'</td>
			</tr>
			<tr bgcolor="#f5e8c8">
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>'.lang('extra_price').':</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$currency_arr[0]['currency_symbol'].$reservation_session['total'].'</td>
			</tr>
			<tr>
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>'.lang('total_price').':</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$currency_arr[0]['currency_symbol'].$reservation_session['final_amount'].'</td>
			</tr>
			<tr bgcolor="#f5e8c8">
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>'.ucfirst(lang('Comments')).':</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.str_replace('\n', '<br/>',$reservation_session['comments']).'</td>
			</tr>';
			if($additional_payment_text!="")
			{
				$msg_text1.=$additional_payment_text;
			}
			$msg_text1.='<tr>
				<td colspan="2" style="border-top:1px solid #C9AD64; padding:5px; ">
					<p><b>'.lang('Regards').'</b></p>
					<p><b>La Balcons Company</b></p>
				</td>
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

		$msg_text2='<table width="650" align="center" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" style="border:1px solid #C9AD64; font-family:arial; font-size:12px;">
			<tr bgcolor="#222222">
			<td colspan="2" align="center" style="padding:8px 0;"><b><font color="#FFFFFF">'.lang('New_Reservation_Les_Balcons_Company').'</font></b></td>
			</tr>';
		$msg_text2.='
			<tr>
				<td colspan="2" align="center" valign="top" style="padding:10px 10px;"><a href="#" target="_blank"><img src="'.base_url().'assets/images/logo.png" alt="" border="0" /></a></td>
			</tr>
			<tr>
				<td colspan="2" style="border-top:1px solid #C9AD64; padding:5px;">
					<b>'.lang('Dear').' Admin,</b><br>
					<b>'.lang('New_Reservation_has_been_done').'</b><br>
					<b>'.lang('Find_the_details_below').'</b>
				</td>
			</tr>
			<tr bgcolor="#f5e8c8">
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>'.lang('Name').': </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$user_session['full_name'].'</td>
			</tr>
			<tr>
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>'.lang('Email').': </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$user_session['email'].'</td>
			</tr>
			<tr bgcolor="#f5e8c8">
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>'.lang('Address').': </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$user_session['address'].'</td>
			</tr>
			<tr>
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>'.lang('Contact_no').': </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$user_session['contact_number'].'</td>
			</tr>
			<tr bgcolor="#f5e8c8">
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>'.lang('Arrival_Date').': </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$reservation_session['arrival_date'].'</td>
			</tr>
			<tr>
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>'.lang('Leave_Date').':</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$reservation_session['leave_date'].'</td>
			</tr>
                        <!--
			<tr bgcolor="#f5e8c8" style="display:none;">
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>'.lang('Season').':</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$season_name.'</td>
			</tr>-->
			<tr>
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>'.lang('Bungalow_Name').':</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$bungalow_details[0]['bunglow_name'].'</td>
			</tr>';
		if($reservation_session['no_of_adult'] != ""){
			$msg_text2.= '<tr>
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>'.lang('no_of_adult').':</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$reservation_session['no_of_adult'].'</td>
			</tr>';
		}if($reservation_session['no_of_extra_real_adult'] != ""){
			$msg_text2.= '
			<tr bgcolor="#f5e8c8">
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>'.lang('no_of_extra_real_adult').':</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$reservation_session['no_of_extra_real_adult'].'</td>
			</tr>';
		}if($reservation_session['no_of_extra_adult'] != ""){
			$msg_text2.= '
			<tr>
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>'.lang('no_of_extra_adult').':</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$reservation_session['no_of_extra_adult'].'</td>
			</tr>';
		}if($reservation_session['no_of_extra_kid'] != ""){
			$msg_text2.= '
			<tr bgcolor="#f5e8c8">
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>'.lang('no_of_extra_kid').':</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$reservation_session['no_of_extra_kid'].'</td>
			</tr>';
		}if($reservation_session['no_of_folding_bed_kid'] != ""){
			$msg_text2.= '
			<tr>
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>'.lang('no_of_folding_bed_kid').':</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$reservation_session['no_of_folding_bed_kid'].'</td>
			</tr>';
		}if($reservation_session['no_of_folding_bed_adult'] != ""){
			$msg_text2.= '
			<tr bgcolor="#f5e8c8">
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>'.lang('no_of_folding_bed_adult').':</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$reservation_session['no_of_folding_bed_adult'].'</td>
			</tr>';
		}if($reservation_session['no_of_baby_bed'] != ""){
			$msg_text2.= '
			<tr>
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>'.lang('no_of_baby_bed').':</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$reservation_session['no_of_baby_bed'].'</td>
			</tr>';
		}
		$msg_text2.= '
			<tr bgcolor="#f5e8c8">
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>'.lang('STAY_TAX_TEXT').':</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">4%</td>
			</tr>
			<tr>
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>'.lang('basic_stay').':</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$currency_arr[0]['currency_symbol'].$reservation_session['stay_euro'].'</td>
			</tr>
			<tr bgcolor="#f5e8c8">
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>'.lang('extra_price').':</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$currency_arr[0]['currency_symbol'].$reservation_session['total'].'</td>
			</tr>
			<tr>
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>'.lang('total_price').':</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$currency_arr[0]['currency_symbol'].$reservation_session['final_amount'].'</td>
			</tr>
			<tr bgcolor="#f5e8c8">
				<td style="border-top:1px solid #C9AD64; padding:5px;"><b>'.ucfirst(lang('Comments')).':</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;"><span style="white-space:pre-wrap;">'.str_replace('\n', '<br/>',$reservation_session['comments']).'</span></td>
			</tr>';
			if($additional_payment_text!="")
			{
				$msg_text2.=$additional_payment_text;
			}
			$msg_text2.='<tr>
				<td colspan="2" style="border-top:1px solid #C9AD64; padding:5px; ">
					<p><b>'.lang('Regards').'</b></p>
					<p><b>La Balcons Company</b></p>
				</td>
				</tr>';
			$msg_text2.='</table>';
		
		$subject2 = lang('New_Reservation_Les_Balcons_Company');
		$to2 = $admin_email.",j.willemin@caribwebservices.com"; 
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
	
	//function to get content for reservation page
	function get_reservation_content()
	{
		$current_lang_id=$this->session->userdata("current_lang_id");
		$this->db->select('*');
		$this->db->from('lb_pages');
		$this->db->where('lb_pages.id',"5");
		$this->db->join('lb_pages_lang', 'lb_pages.id = lb_pages_lang.pages_id AND lb_pages_lang.language_id='.$current_lang_id);
		$pages_arr = $this->db->get()->result_array();
		return $pages_arr;
	}
	
	//function for get particular user
	function get_user_details_rows($user_id)
	{
		$result=$this->db->get_where("lb_users", array("id"=>$user_id))->result_array();
		return $result;
	}
	
	
	//Function for getting bungalow rates while payment (According to season and total days to stay)
	function get_bungalows_price($bungalow_id, $arrival_date, $leave_date, $options = array())
	{
		//Get default currency
		$currency_arr=$this->db->get_where("lb_currency_master", array("set_as_default"=>"Y"))->result_array();
		

		$stay_euro = 0;

		$arrival_date1 = $arrival_date;
		$leave_date1 = $leave_date;

		$q_val = explode("/",$arrival_date);		 
		$season_id = $this->getSeasons($q_val[0],$q_val[1],$q_val[2]);

		$q_val1 = explode("/",$leave_date);		 
		$another_season_id = $this->getSeasons($q_val1[0],$q_val1[1],$q_val1[2]);
		
		$arrival_date_arr=explode("/",$arrival_date);
		$arrival_date = mktime(0,0,0, $arrival_date_arr[1], $arrival_date_arr[0], $arrival_date_arr[2] );
		$leave_date_arr=explode("/", $leave_date);
		$leave_date=mktime(0,0,0, $leave_date_arr[1], $leave_date_arr[0], $leave_date_arr[2] );

		$date_arr=$this->dateRange($arrival_date, $leave_date);
		$days_count=count($date_arr) - 1;
		//$days_count=count($date_arr);

		if($season_id != $another_season_id){
			$a_date_part = explode("/",$arrival_date1);
			$l_date_part = explode("/",$leave_date1);

			$arrival_time = mktime(0,0,0,$a_date_part[1],$a_date_part[0],$a_date_part[2]);
			$leave_time = mktime(0,0,0,$l_date_part[1],$l_date_part[0],$l_date_part[2]);//strtotime($leave_date);

			$high_days = $low_days = 0;
			if($season_id == '1' && $another_season_id == '2'){
				$high_end_date = mktime(0,0,0,4,14,$a_date_part[2]);
				$low_start_date = mktime(0,0,0,4,15,$l_date_part[2]);

				for($i=1;$i<=$days_count;$i++){ 
					if($high_end_date >= $arrival_time) {
						$high_days++;
						$arrival_time = strtotime("+1 day",$arrival_time);
					}
					else{
						$low_days++;
					}
				}
			}
			else if($season_id == '2' && $another_season_id == '1'){
				$low_end_date = mktime(0,0,0,12,14,$l_date_part[2]);
				$high_start_date = mktime(0,0,0,12,15,$a_date_part[2]);

				for($i=1;$i<=$days_count;$i++){ 
					if($low_end_date >= $arrival_time) {
						$low_days++;
						$arrival_time = strtotime("+1 day",$arrival_time);
					}
					else{
						$high_days++;
					}
				}
			}

			$rate_details_arr=$this->db->get_where("lb_bunglow_rates", array("bunglow_id"=>$bungalow_id, "season_id"=>"1"))->result_array();
			$rate_details_arr1=$this->db->get_where("lb_bunglow_rates", array("bunglow_id"=>$bungalow_id, "season_id"=>"2"))->result_array();
			//echo "Extra per night (HIGH): ".$rate_details_arr[0]['extranight_perday_europrice'].",Extra per night (LOW): ".$rate_details_arr1[0]['extranight_perday_europrice']."<br/>";
			//echo "Rate per night (HIGH): ".$rate_details_arr[0]['rate_per_day_euro'].",Rate per night (LOW): ".$rate_details_arr1[0]['rate_per_day_euro']."<br/>";
			if( $days_count > 6 ){
				$stay_euro = $low_days * $rate_details_arr1[0]['extranight_perday_europrice'];
				$stay_euro += $high_days * $rate_details_arr[0]['extranight_perday_europrice'];
			}else {
				$stay_euro = $rate_details_arr1[0]['rate_per_day_euro'] * $low_days;
				$stay_euro += $rate_details_arr[0]['rate_per_day_euro'] * $high_days; 
			}

			//return "Arrival Date: ".$arrival_date1.", Leave Date: ".$leave_date1.". No. of high days: ".$high_days.". No. of low days: ".$low_days.", Price: ".$stay_euro."<br/>";
			
		}else{

			//Get rate details with season id and bungalow_id
			$rate_details_arr=$this->db->get_where("lb_bunglow_rates", array("bunglow_id"=>$bungalow_id, "season_id"=>$season_id))->result_array();

			if( $days_count > 6 ){
				$stay_euro = $days_count * $rate_details_arr[0]['extranight_perday_europrice'];
			}else {
				$stay_euro = $rate_details_arr[0]['rate_per_day_euro'] * $days_count;
			}
		}	

		$result = array();
		$result['stay_euro'] = $stay_euro;
		$result['extra_euro'] = 0;
		$result['total_euro'] = 0;
		$result['day_diff'] = $days_count;
		
		$result['total_euro'] = ($result['stay_euro'] + $result['option_euro'] +(($result['stay_euro'] + $result['option_euro']) *4/100));
		return $result; 

	}
	
	public function getAccomodation($reservation_details)
	{		
		$arrival_date_arr=explode("-",$reservation_details[0]['arrival_date']);
		$arrival_date = mktime(0,0,0, $arrival_date_arr[1], $arrival_date_arr[2], $arrival_date_arr[0]);
		$leave_date_arr=explode("-", $reservation_details[0]['leave_date']);
		$leave_date=mktime(0,0,0, $leave_date_arr[1], $leave_date_arr[2], $leave_date_arr[0]);
		$date_arr=$this->home_model->dateRanges($arrival_date, $leave_date);
		$days_count=count($date_arr) - 1;
		$accommodation = $days_count;
		return $accommodation;
	}
	
	
	public function getAmountTotal($reservation_details)
	{
		
		$arrival_date_array	=explode("-", $reservation_details[0]['arrival_date']);
		$arrival_date		=$arrival_date_array[2]."/".$arrival_date_array[1]."/".$arrival_date_array[0];
		$leave_date_array	=explode("-", $reservation_details[0]['leave_date']);
		$leave_date			=$leave_date_array[2]."/".$leave_date_array[1]."/".$leave_date_array[0];
		
		
		$result_resa=$this->get_bungalows_price($reservation_details[0]['bunglow_id'],$arrival_date,$leave_date);
		$stay_euro = $result_resa['stay_euro'];

		$bungalow_rate = $stay_euro;
		//calcul total duplication
		//get accomodation
		$accomodation = $this->getAccomodation($reservation_details);
		//
		$val2 = $reservation_details[0]['no_of_extra_real_adult'];
		$val3 = $reservation_details[0]['no_of_extra_adult'];
		$val6 = $reservation_details[0]['no_of_folding_bed_adult'];
		if($val2 > 0) $tot = ($val2 * 15 * $accommodation);
		if($val3 > 0) $tot += ($val3 * 15 * $accommodation);
		if($val6 > 0) $tot += ($val6 * 15 * $accommodation);
		$extra_person = $tot;
		$tot = ($bungalow_rate + $tot);
		
		$discount = ($reservation_details[0]['discount'] != "")?$reservation_details[0]['discount']:"0";
		
		if($discount!=0 && $discount!='')
		$discount1 = ($tot * $discount/100);
		else
		$discount1=0;
		
		$tot = $tot-$discount1;
		
		$tax = ($tot * 4/100);

		$amount_without_tax = ($bungalow_rate + $extra_person);
		
		$totalAmt = $tot+$tax;
		
		return $totalAmt;
	}
	
	public function getDueAmount($totalAmt,$paidAmt){

		$paidAmt_exploded = explode('.',$paidAmt);
		$paidAmt_fomate = number_format($paidAmt, 2, '.', ',');
		$paidAmt_len = strlen($paidAmt_fomate);
		if(count($paidAmt_exploded) == 2 && $paidAmt_len == 4){
			$paidAmt = $paidAmt_exploded[0].$paidAmt_exploded[1].'.00';
		}
		
		
		$paidAmt_lenght = strlen($paidAmt); 
		if($paidAmt[$paidAmt_lenght-1] == '0' && $paidAmt[$paidAmt_lenght-2] == '0' && count($paidAmt_exploded) > 1){
			$paidAmt = substr($paidAmt, 0, -2);
			$paidAmt_formated = floatval($paidAmt);
		}else{
			$paidAmt_formated = floatval($paidAmt);
		}
		
		
		$dueAmt = $totalAmt - $paidAmt_formated;

		return $dueAmt; 
		
	}
	
	/*//function for getting reservation list for particular user 25-11-2014
	function get_user_details_rows($user_id)
	{
		$this->db->order_by('id', 'desc');
		$result=$this->db->get_where("lb_users", array("id"=>$user_id))->result_array();
		//$default_language=$this->db->get_where("mast_language", array("set_as_default"=>"Y"))->result_array();
		//$default_language_id=$default_language[0]['id'];
		$result_arr=array();
		
		foreach($result as $row)
		{
			'name'=$row['name'];
		    'email'=$row['email'];
			'contact_number'=$row['contact_number'];
			
			
		}
		return $result_arr;
	}*/
	
	
	
}
	

?>