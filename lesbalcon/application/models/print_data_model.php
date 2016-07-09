<?php
class print_data_model extends CI_Model
{
    
	//###############################################################//
	//############### INITIALIZE CONSTRUCTOR CLASS ##################//
	//###############################################################//
	
	function  __construct() 
	{
        parent::__construct();
    }
	
	function print_process($report_type, $posted_from_date, $posted_to_date)
	{
		$report_type=$this->input->post("report_type");
		$from_date_arr=explode("/",$posted_from_date);
		$from_date=$from_date_arr[2]."-".$from_date_arr[1]."-".$from_date_arr[0];

		$to_date_arr=explode("/",$posted_to_date);
		$to_date=$to_date_arr[2]."-".$to_date_arr[1]."-".$to_date_arr[0];
		
		if($report_type=="booking")
		{
			$result=$this->db->query("SELECT * FROM `lb_reservation` WHERE (`arrival_date` between '$from_date' AND '$to_date') AND (`leave_date` between '$from_date' AND '$to_date')")->result_array();
			if(count($result)==0)
			{
				return "notavailable";
			}
			else 
			{
				$output="";
				$output .="<table border='1px solid' cellpadding='0' cellspacing='0'>
							<th>Date</th>
							<th>Bunglow under booking</th>
							<th>Name of the customer</th>
							<th>Payment Mode</th>
							<th>Outstanding Payment</th>
							<th>Total days of booking</th>
							<th>Arrival Date</th>
							<th>Leave Date</th>
							<th>Booked On</th>";
							
				foreach($result as $value)
				{
					$user_id=$value['user_id'];
					$user_details=$this->db->get_where("lb_users", array("id"=>$user_id))->result_array();
					$arrival_date=$value['arrival_date'];
					$leave_date=$value['leave_date'];
					
					$date=date("d/m/Y");
					$bungalow_under_booking=$value['name'];
					$name_of_the_customer=$user_details[0]['name'];
					$payment_mode=$value['payment_mode'];
					$outstanding_payment=$value['due_amount'];
					$total_days_of_booking= ceil(abs(strtotime($leave_date) - strtotime($arrival_date)) / 86400);
					$booked_on=date("d/m/Y H:i:s", strtotime($value['reservation_date']));
					$arrival_date=date("d/m/Y", strtotime($value['arrival_date']));
					$leave_date=date("d/m/Y", strtotime($value['leave_date']));
					$output .="<tr>
									<td>".$date."</td>
									<td>".$bungalow_under_booking."</td>
									<td>".$name_of_the_customer."</td>
									<td>".$payment_mode."</td>
									<td>".$outstanding_payment."</td>
									<td>".$total_days_of_booking."</td>
									<td>".$arrival_date."</td>
									<td>".$leave_date."</td>
									<td style='padding-left:10px;'>".$booked_on."</td>
								</tr>";
				}
							
				$output .="</table>";
				return $output;			
			}
		}
		elseif($report_type=="cleaning")
		{
			$default_lang_arr=$this->db->get_where("mast_language", array("set_as_default"=>"Y"))->result_array();
			$default_langugage_id=$default_lang_arr[0]['id'];
		
			$this->db->select('*');
			$this->db->from('lb_bunglow');
			$this->db->order_by('cleaning_date', 'asc');
			$this->db->where('cleaning_date >=', $from_date);
			$this->db->where('cleaning_date <=', $to_date);
			$result=$this->db->get()->result_array();
			
			if(count($result)==0)
			{
				return "notavailable";
			}
			else 
			{
				$distinct_bungalow_arr=$this->db->query("SELECT DISTINCT `bunglow_id` FROM  `lb_bunglow_cleaning` WHERE `cleaning_date`>='$from_date' AND `cleaning_date`<='$to_date'")->result_array();
				$output="";
				$output .="<table border='1px solid' cellpadding='0' cellspacing='0'>
							<th>Bungalow Name</th>
							<th>Date</th>";
			
				foreach($distinct_bungalow_arr as $value)
				{
					$bungalow_id=$value['bunglow_id'];
					$bungalow_details=$this->db->get_where("lb_bunglow_lang", array("bunglow_id"=>$bungalow_id, "language_id"=>$default_langugage_id))->result_array();
					$cleaning_date_array=array();
					$cleaning_arr=$this->db->query("SELECT * from  `lb_bunglow_cleaning` WHERE `bunglow_id`='$bungalow_id' AND `cleaning_date`>='$from_date' AND `cleaning_date`<='$to_date'")->result_array();
					foreach($cleaning_arr as $cleaning_date)
					{
						$cleaning_date_arr=explode("-", $cleaning_date['cleaning_date']);
						$new_cleaning_date=$cleaning_date_arr[2]."/".$cleaning_date_arr[1]."/".$cleaning_date_arr[0];
						array_push($cleaning_date_array, $new_cleaning_date);
					}
					$bungalow_name=$bungalow_details[0]['bunglow_name'];
					$output .="<tr>
									<td>".$bungalow_name."</td>
									<td>".implode(",", $cleaning_date_array)."</td>
								</tr>";
				}
				$output .="</table>";
				return $output;	
			}
		}
	}
}
	

?>