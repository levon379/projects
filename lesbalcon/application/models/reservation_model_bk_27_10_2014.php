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
	
	
	//Function to get bungalow property list in drop down
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
}
	

?>