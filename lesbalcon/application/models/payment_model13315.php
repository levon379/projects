<?php
class payment_model extends CI_Model
{
    
	//###############################################################//
	//############### INITIALIZE CONSTRUCTOR CLASS ##################//
	//###############################################################//
	
	function  __construct() 
	{
        parent::__construct();
    }
	
	//Function to listing whole payment from reservation table
	function get_payment($type="")
	{
		if($type=="")//Whole Payment
		{
			$this->db->order_by("id", "desc");
			$result=$this->db->get("lb_reservation")->result_array();
		}
		elseif($type=="partial")//Partial Payment
		{
			$this->db->order_by("id", "desc");
			$result=$this->db->get_where("lb_reservation", array("payment_mode"=>"PARTIAL"))->result_array();
		}
		elseif($type=="completed")//Completed Payment
		{
			$this->db->order_by("id", "desc");
			$result=$this->db->get_where("lb_reservation", array("payment_status"=>"COMPLETED"))->result_array();
		}
		elseif($type=="cancelled")//Cancelled Payment
		{
			$this->db->order_by("id", "desc");
			$result=$this->db->get_where("lb_reservation", array("payment_status"=>"CANCELLED"))->result_array();
		}
		$default_language=$this->db->get_where("mast_language", array("set_as_default"=>"Y"))->result_array();
		$default_language_id=$default_language[0]['id'];
		$payment_arr=array();
		$i=0;
		foreach($result as $row)
		{
			$bungalow_id=$row['bunglow_id'];
			$bungalow_details=$this->db->get_where("lb_bunglow_lang", array("bunglow_id"=>$bungalow_id, "language_id"=>$default_language_id))->result_array();
			$payment_arr[$i]['id']=$row['id'];
			$payment_arr[$i]['reservation_date']=$row['reservation_date'];
			$payment_arr[$i]['bunglow_name']=$bungalow_details[0]['bunglow_name'];
			$payment_arr[$i]['arrival_date']=$row['arrival_date'];
			$payment_arr[$i]['leave_date']=$row['leave_date'];
			$payment_arr[$i]['reservation_status']=$row['reservation_status'];
			$payment_arr[$i]['payment_status']=$row['payment_status'];
			$payment_arr[$i]['is_active']=$row['is_active'];
			$i++;
		}
		return $payment_arr;
	}
	
	
	//function to change status of reservation
	function ajax_change_reservation_status($id, $status)
	{
		$this->db->update("lb_reservation", array("reservation_status"=>$status), array("id"=>$id));
	}
	
	//function to change status of payment
	function ajax_change_payment_status($id, $status)
	{
		$this->db->update("lb_reservation", array("payment_status"=>$status), array("id"=>$id));
	}
	
	//function to change status of payment
	function ajax_change_active_inactive($id, $status)
	{
		$this->db->update("lb_reservation", array("is_active"=>$status), array("id"=>$id));
	}
	
	//function to delete payment
	function ajax_delete_payment($id)
	{
		$this->db->delete("lb_reservation", array("id"=>$id));
	}
	
	
	//Function to get payment details
	function get_payment_details($payment_id)
	{
		$default_language=$this->db->get_where("mast_language", array("set_as_default"=>"Y"))->result_array();
		$default_language_id=$default_language[0]['id'];
		
		$default_currency_arr=$this->db->get_where("lb_currency_master", array("set_as_default"=>"Y"))->result_array();
		$default_currency=$default_currency_arr[0]['currency_symbol'];
		
		$payment_details_arr=array();
		$payment_details=$this->db->get_where("lb_reservation", array("id"=>$payment_id))->result_array();
		
		$user_id=$payment_details[0]['user_id'];
		$user_details=$this->db->get_where("lb_users", array("id"=>$user_id))->result_array();
		
		$bungalow_id=$payment_details[0]['bunglow_id'];
		$bungalow_details=$this->db->get_where("lb_bunglow_lang", array("bunglow_id"=>$bungalow_id, "language_id"=>$default_language_id))->result_array();
		
		
		//Getting bungalow rates
		$accommodation=ceil(abs(strtotime($payment_details[0]['leave_date']) - strtotime($payment_details[0]['arrival_date'])) / 86400);
		$bungalow_rate=$payment_details[0]['bunglow_per_day']*$accommodation;
		
		
		//Getting options rates
		$total_options_rate_arr=array();
		$options_ids=$payment_details[0]['options_id'];
		if($options_ids!="")
		{
			$options_id_arr=explode(",", $options_ids);
			$x=0;
			$options_rate_arr=explode(",", $payment_details[0]['options_rate']);
			foreach($options_id_arr as $options)
			{
				$options_details=$this->db->get_where("lb_bunglow_options_lang", array("options_id"=>$options, "language_id"=>$default_language_id))->result_array();
				if(count($options_details)>0)
				{
					$total_options_rate_arr[$x]['option_name']=$options_details[0]['options_name'];
					$total_options_rate_arr[$x]['option_rate']=$default_currency.$options_rate_arr[$x];
					$x++;
				}
			}
		}
	
		
		//Getting tax rates
		$total_tax_rate_arr=array();
		$tax_ids=$payment_details[0]['tax_id'];
		if($tax_ids!="")
		{
			$tax_id_arr=explode(",", $tax_ids);
			$x=0;
			$tax_rate_arr=explode(",", $payment_details[0]['tax_rate']);
			foreach($tax_id_arr as $tax_id)
			{
				$tax_value=$bungalow_rate*$tax_rate_arr[$x]/100;
				$tax_details=$this->db->get_where("lb_tax_lang", array("tax_id"=>$tax_id, "language_id"=>$default_language_id))->result_array();
				$total_tax_rate_arr[$x]['tax_name']=$tax_details[0]['tax_name']." (".$tax_rate_arr[$x]."%)";
				$total_tax_rate_arr[$x]['tax_rate']=$default_currency.$tax_value;
				$x++;
			}
		}
		$payment_details_arr['reservation_id']=$payment_details[0]['id'];
		$payment_details_arr['reservation_date']=$payment_details[0]['reservation_date'];
		$payment_details_arr['user_id']=$user_id;
		$payment_details_arr['user_name']=$user_details[0]['name'];
		$payment_details_arr['user_email']=$user_details[0]['email'];
		$payment_details_arr['bunglow_under_booking']=$payment_details[0]['name'];
		$payment_details_arr['more_phone']=$payment_details[0]['phone'];
		$payment_details_arr['more_email']=$payment_details[0]['email'];
		$payment_details_arr['arrival_date']=$payment_details[0]['arrival_date'];
		$payment_details_arr['leave_date']=$payment_details[0]['leave_date'];
		$payment_details_arr['accommodation']=ceil(abs(strtotime($payment_details[0]['leave_date']) - strtotime($payment_details[0]['arrival_date'])) / 86400);
		$payment_details_arr['bungalow_name']=$bungalow_details[0]['bunglow_name'];
		$payment_details_arr['bungalow_rate']=$default_currency.$bungalow_rate;
		$payment_details_arr['options_rate']=$total_options_rate_arr;
		$payment_details_arr['discount']=$payment_details[0]['discount'];
		$payment_details_arr['tax_rate']=$total_tax_rate_arr;
		$payment_details_arr['total']=$default_currency.$payment_details[0]['amount_to_be_paid'];
		$payment_details_arr['paid_amount']=$default_currency.$payment_details[0]['paid_amount'];
		$payment_details_arr['due_amount']=$default_currency.$payment_details[0]['due_amount'];
		$payment_details_arr['payment_mode']=$payment_details[0]['payment_mode'];
		$payment_details_arr['invoice_number']=$payment_details[0]['invoice_number'];
		$payment_details_arr['payment_status']=$payment_details[0]['payment_status'];
		$payment_details_arr['reservation_status']=$payment_details[0]['reservation_status'];
		$payment_details_arr['is_active']=$payment_details[0]['is_active'];

		//echo "<pre>";
		//print_r($payment_details_arr);
		//die;
		return $payment_details_arr;
	}
	
	
	//Function to increase leave date
	function ajax_increase_leave_date($reservation_id, $start_date, $leave_date)
	{
		$reservation_details=$this->db->get_where("lb_reservation", array("id"=>$reservation_id))->result_array();
		$bungalow_id=$reservation_details[0]['bunglow_id'];
		$query=$this->db->get_where("lb_reservation", array("bunglow_id"=>$bungalow_id))->result_array();
		$date_arr=$this->dateRange($start_date, $leave_date);
		$total_days=count($date_arr);
		$available_date=array();
		foreach($date_arr as $date)
		{
			$check_query=$this->db->query("SELECT * FROM `lb_reservation` WHERE `bunglow_id`='$bungalow_id' AND (`arrival_date` <= '$date' AND `leave_date` >= '$date')")->result_array();
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
			$this->db->update("lb_reservation", array("leave_date"=>$leave_date, "is_active"=>"ACTIVE"), array("id"=>$reservation_id));
			return "available";
		}
		elseif(count($available_date)==0)
		{
			return "notavailable";
		}
		else
		{
			return implode(", ",$available_date);
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
	
}
	

?>