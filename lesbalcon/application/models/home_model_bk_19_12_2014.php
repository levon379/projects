<?php
class home_model extends CI_Model
{
	function  __construct() 
	{
        parent::__construct();
    }

	//###############	FUNCTIONS FOR ADMIN PANEL DASHBOARD 	#############################
	
	//Getting unique years present in reservation table
	function get_unique_years_from_reservation()
	{
		$reservation=$this->db->get("lb_reservation")->result_array();
		$all_years_arr=array();
		if(count($reservation)==0)
		{
			$all_years_arr[0]=date("Y");
		}
		else 
		{
			$arrival_years_array=$this->db->query("SELECT distinct YEAR(`arrival_date`) as distinct_year from `lb_reservation`")->result_array();
			$leave_years_array=$this->db->query("SELECT distinct YEAR(`leave_date`) as distinct_year from `lb_reservation`")->result_array();
			$unique_years=array_intersect($arrival_years_array, $leave_years_array);
			for($i=0; $i<count($unique_years); $i++)
			{
				$all_years_arr[$i]=$unique_years[$i]['distinct_year'];
			}
		}
		return $all_years_arr;
	}
	//Getting array of months with total days in years
	function get_years_with_months($unique_years)
	{
		$all_months_arr=array();
		$particular_year=array();
		$i=0;
		foreach($unique_years as $years)
		{
			for ($m=0; $m<=11; $m++) 
			{
				$total_days=cal_days_in_month(CAL_GREGORIAN, ($m+1), $years);
				$month_name= date('F', mktime(0,0,0,($m+1), 1, $years));
				$all_months_arr[$m]['month']=($m+1);
				$all_months_arr[$m]['month_name']=$month_name;
				$all_months_arr[$m]['total_days']=$total_days;
				$all_months_arr[$m]['years']=$years;
			}
			array_push($particular_year, $all_months_arr);
			$i++;
		}
		//echo "<pre>";
		//print_r($particular_year);
		//die;
		return $particular_year;
	}
	
	//Functions to get bungalows with reserved date
	function get_bungalows()
	{
		//Getting all bungalows according to default language_id
		$default_language=$this->db->get_where("mast_language", array("set_as_default"=>"Y"))->result_array();
		$default_language_id=$default_language[0]['id'];
		$this->db->order_by("sort_order");
		$this->db->from('lb_bunglow');
		$this->db->join('lb_bunglow_lang', 'lb_bunglow.id = lb_bunglow_lang.bunglow_id AND lb_bunglow.is_active="Y" AND lb_bunglow_lang.language_id='.$default_language_id);
		$bungalow_arr = $this->db->get()->result_array();
		$all_bungalows_arr=array();
		$i=0;
		if(count($bungalow_arr)>0)
		{
			foreach($bungalow_arr as $bungalows)
			{
				$bungalow_id=$bungalows['bunglow_id'];
				//Getting all reservation for a particular bungalow
				$reservation_array=$this->db->get_where("lb_reservation", array("bunglow_id"=>$bungalow_id))->result_array();
				$reservation_date_array=array();
				if(count($reservation_array)>0)
				{
					$x=0;
					foreach($reservation_array as $reservation)
					{
						//Getting all dates between every arrival date and leave date
						$all_days=$this->dateRange($reservation['arrival_date'], $reservation['leave_date']);
						foreach($all_days as $days)
						{
							$reservation_date_array[$days]=array();
							$reservation_date_array[$days]['reservation_id']=$reservation['id'];
							$x++;
						}
					}
				}
				
				//Getting Cleaning dates for bungalows
				$cleaning_array=$this->db->get_where("lb_bunglow_cleaning", array("bunglow_id"=>$bungalow_id))->result_array();
				$cleaning_date_array=array();
				if(count($cleaning_array)>0)
				{
					$x=0;
					foreach($cleaning_array as $cleaning)
					{
						$cleaning_date_array[$x]=$cleaning['cleaning_date'];
						$x++;
					}
				}
				$all_bungalows_arr[$i]['bunglow_id']=$bungalow_id;
				$all_bungalows_arr[$i]['bunglow_name']=$bungalows['bunglow_name'];
				$all_bungalows_arr[$i]['reservation']=$reservation_date_array;
				$all_bungalows_arr[$i]['cleaning']=$cleaning_date_array;
				$i++;
			}
		}
		
		//echo "<pre>";
		//print_r($bungalow_arr);
		//print_r($all_bungalows_arr);
		//die;
		return $all_bungalows_arr;
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
	
	//Function for mark as cleaning
	function ajax_mark_for_cleaning($bungalow_id, $date_for_cleaning)
	{
		$this->db->insert("lb_bunglow_cleaning", array("bunglow_id"=>$bungalow_id, "cleaning_date"=>$date_for_cleaning));
	}
	
	//function for removing cleaning class
	function ajax_removing_cleaning($bungalow_id, $cleaning_date)
	{
		$this->db->delete("lb_bunglow_cleaning", array("bunglow_id"=>$bungalow_id, "cleaning_date"=>$cleaning_date));
	}
	
	//Generating add reservation form for calendar
	function get_all_users()
	{
		$this->db->order_by("id", "desc");
		$result=$this->db->get_where("lb_users", array("status"=>"A"))->result_array();
		return $result;
	}
	
	//function for getting bungalow details
	function get_bungalow_details($bungalow_id)
	{
		$default_language=$this->db->get_where("mast_language", array("set_as_default"=>"Y"))->result_array();
		$default_language_id=$default_language[0]['id'];
		$this->db->select('*');
		$this->db->from('lb_bunglow');
		$this->db->join('lb_bunglow_lang', 'lb_bunglow.id = lb_bunglow_lang.bunglow_id AND lb_bunglow.id='.$bungalow_id.' AND lb_bunglow_lang.language_id='.$default_language_id);
		$get_details_arr = $this->db->get()->result_array();
		return $get_details_arr;
	}
	
	//function to get options details
	function get_options_details($bungalow_id)
	{
		$default_language=$this->db->get_where("mast_language", array("set_as_default"=>"Y"))->result_array();
		$default_language_id=$default_language[0]['id'];
		$options_arr=$this->db->get_where("lb_bunglow", array("id"=>$bungalow_id))->result_array();
		$options_ids=$options_arr[0]['option_id'];
		$this->db->select('*');
		$this->db->from('lb_bunglow_options');
		$this->db->join('lb_bunglow_options_lang', 'lb_bunglow_options.id = lb_bunglow_options_lang.options_id AND lb_bunglow_options.is_active="Y" AND lb_bunglow_options.id IN ('.$options_ids.') AND lb_bunglow_options_lang.language_id='.$default_language_id);
		$options_details_arr=$this->db->get()->result_array();
		return $options_details_arr;
	}
	
	//function for add reservation from calendar
	function add_reservation()
	{
		$default_language=$this->db->get_where("mast_language", array("set_as_default"=>"Y"))->result_array();
		$default_language_id=$default_language[0]['id'];
		$currency_arr=$this->db->get_where("lb_currency_master", array("set_as_default"=>"Y"))->result_array();
		$admin_arr=$this->db->get_where("mast_admin_info", array('id'=>1))->result_array();
		$admin_email=$admin_arr[0]['email'];

		$user_id=$this->input->post("user_id");
		$user_details=$this->db->get_where("lb_users", array("id"=>$user_id))->result_array();
		$bungalow_id=$this->input->post("bungalow_id");
		$bungalow_details=$this->get_bungalow_details($bungalow_id);

		
		$name=$this->input->post("reservation_name");
		$contact=$this->input->post("reservation_contact");

		$arrival_date_arr=explode("/", $this->input->post("arrival_date"));
		$arrival_date=strtotime($arrival_date_arr[2]."-".$arrival_date_arr[1]."-".$arrival_date_arr[0]);
		$arrival_date_new_format=$arrival_date_arr[2]."-".$arrival_date_arr[1]."-".$arrival_date_arr[0];
		$leave_date_arr=explode("/", $this->input->post("leave_date"));
		$leave_date=strtotime($leave_date_arr[2]."-".$leave_date_arr[1]."-".$leave_date_arr[0]);
		$leave_date_new_format=$leave_date_arr[2]."-".$leave_date_arr[1]."-".$leave_date_arr[0];
		$diff = ceil(abs($leave_date - $arrival_date) / 86400);
		$text=$this->input->post("reservation_text");
		$invoice_number=$this->get_unique_invoice_number();
		
		//Getting Bungalow Rate
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
		$rate_details_arr=$this->db->get_where("lb_bunglow_rates", array("bunglow_id"=>$bungalow_id, "season_id"=>$season_id))->result_array();
		$total_bungalow_rate=$rate_details_arr[0]['rate_per_day_euro']*$diff; //Multiplying with total days of staying
		$total_bungalow_rate_dollar=$rate_details_arr[0]['rate_per_day_dollar']*$diff;
		$discount=$rate_details_arr[0]['discount']; //discount in %
		
		//Calculating options rate
		$options_rate_euro=array();
		$options_rate_dollar=array();
		$options_text_for_mail="";
		$total_options_rate=0; //By default currency is euro so that calculation will be in euro
		$x=0;
		if($this->input->post("options_id"))
		{
			$options_ids=implode(",", $this->input->post("options_id"));
			foreach($this->input->post("options_id") as $options_id)
			{
				$this->db->select('*');
				$this->db->from('lb_bunglow_options');
				$this->db->join('lb_bunglow_options_lang', 'lb_bunglow_options.id = lb_bunglow_options_lang.options_id AND lb_bunglow_options.id='.$options_id.' AND lb_bunglow_options_lang.language_id='.$default_language_id);
				$options_details=$this->db->get()->result_array();
				array_push($options_rate_euro, $options_details[0]["charge_in_euro"]*$diff);
				array_push($options_rate_dollar, $options_details[0]["charge_in_dollars"]*$diff);
				$total_options_rate=$total_options_rate+$options_details[0]["charge_in_euro"]*$diff;
				$options_text_for_mail .="<p>".$options_details[0]['options_name']." : ".$currency_arr[0]['currency_symbol'].$options_details[0]["charge_in_euro"]*$diff."</p>";
			}
			$options_rates=implode(",", $options_rate_euro);
			$options_rates_dollar=implode(",", $options_rate_dollar);
		}
		else
		{
			$options_ids="";
			$options_rates="";
			$options_rates_dollar="";
			$options_text_for_mail="N/A";
		}
		$discounted_value=($total_bungalow_rate+$total_options_rate)*$discount/100;

		//Getting taxes 
		$total_taxes=0;
		$taxes_rate_array=array();
		$tax_text_for_mail="";
		if(!empty($bungalow_details[0]['tax_id']))
		{
			$taxes_ids=$bungalow_details[0]['tax_id'];
			$taxes_arr=explode(",", $bungalow_details[0]['tax_id']);
			foreach($taxes_arr as $tax_id)
			{
				$this->db->select('*');
				$this->db->from('lb_tax');
				$this->db->join('lb_tax_lang', 'lb_tax.id = lb_tax_lang.tax_id AND lb_tax.id='.$tax_id.' AND lb_tax_lang.language_id='.$default_language_id);
				$tax_details=$this->db->get()->result_array();
				$rates_percentage=$tax_details[0]['rate'];
				$total_tax_rate=$total_bungalow_rate*$rates_percentage/100;
				$total_taxes=$total_taxes+$total_tax_rate;
				$tax_text_for_mail .="<p>".$tax_details[0]['tax_name']." (".$tax_details[0]['rate']."%) : ".$currency_arr[0]['currency_symbol'].$total_tax_rate."</p>";
				array_push($taxes_rate_array, $rates_percentage);
			}
			$taxes_rate= implode(",", $taxes_rate_array);
		}
		else 
		{
			$taxes_ids="";
			$taxes_rate="";
			$tax_text_for_mail="N/A";
		}
		
		//Now finally calculating all final amount to be paid
		$total_rate=(($total_bungalow_rate+$total_options_rate)-$discounted_value)+$total_taxes;

		$ins_arr=array(
			"user_id"=>$user_id,
			"name"=>$name,
			"phone"=>$contact,
			"email"=>"",
			"bunglow_id"=>$bungalow_id,
			"options_id"=>$options_ids,
			"options_rate"=>$options_rates,
			"options_rate_dollar"=>$options_rates_dollar,
			"tax_id"=>$taxes_ids,
			"tax_id"=>$taxes_ids,
			"tax_rate"=>$taxes_rate,
			"bunglow_per_day"=>$rate_details_arr[0]['rate_per_day_euro'],
			"bunglow_per_day_dollar"=>$rate_details_arr[0]['rate_per_day_dollar'],
			"discount"=>$discount,
			"reservation_date"=>date("Y-m-d H:i:s"),
			"arrival_date"=>$arrival_date_new_format,
			"leave_date"=>$leave_date_new_format,
			"comment"=>$text,
			"reservation_status"=>"PENDING",
			"payment_mode"=>"ONARRIVAL",
			"amount_to_be_paid"=>$total_rate,
			"paid_amount"=>0,
			"due_amount"=>$total_rate,
			"invoice_number"=>$invoice_number,
			"payment_status"=>"PENDING",
			"is_active"=>"ACTIVE"
		);
		$this->db->insert("lb_reservation", $ins_arr);
		
		//if user belongs to french then email text will be in french otherwise in english
		if($user_details[0]['user_language']==1)
		{
			$msg_text1='<table width="650" align="center" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" style="border:1px solid #C9AD64; font-family:arial; font-size:12px;">
				
				<tr bgcolor="#222222">
				<td colspan="2" align="center" style="padding:8px 0;"><b><font color="#FFFFFF">New Reservation @ Les Balcons Company</font></b></td>
				</tr>';
			$msg_text1.='
				<tr>
					<td colspan="2" align="center" valign="top" style="padding:10px 10px;"><a href="#" target="_blank"><img src="'.base_url().'assets/images/logo.png" alt="" border="0" /></a></td>
				</tr>
				<tr>
					<td colspan="2" style="border-top:1px solid #C9AD64; padding:5px;">
						<b>Dear '.$user_details[0]['name'].',</b><br>
						<b>Your reservation has been done successfully.</b><br>
						<b>Find the details below.</b>
					</td>
				</tr>
				<tr bgcolor="#f5e8c8">
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Name: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$name.'</td>
				</tr>
				<tr>
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Arrival Date: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$this->input->post("arrival_date").'</td>
				</tr>
				<tr bgcolor="#f5e8c8">
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Leave Date:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$this->input->post("leave_date").'</td>
				</tr>
				<tr>
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Bungalow:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$bungalow_details[0]['bunglow_name'].'</td>
				</tr>
				<tr bgcolor="#f5e8c8">
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Total Bungalow Rate:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$currency_arr[0]['currency_symbol'].$total_bungalow_rate.'</td>
				</tr>
				<tr>
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Options:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$options_text_for_mail.'</td>
				</tr>
				<tr bgcolor="#f5e8c8">
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Discount:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$discount.'%</td>
				</tr>
				<tr>
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Tax:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$tax_text_for_mail.'</td>
				</tr>
				<tr bgcolor="#f5e8c8">
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Total:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$currency_arr[0]['currency_symbol'].$total_rate.'</td>
				</tr>
				<tr>
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Amount to be paid:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$currency_arr[0]['currency_symbol'].$total_rate.'</td>
				</tr>
				<tr>
					<td colspan="2" style="border-top:1px solid #C9AD64; padding:5px; ">
					<p><b>Regards,</b></p>
					<p><b>La Balcons Company</b></p>
					</td>
				</tr>
			</table>';

			$subject1 = "New Reservation @ Les Balcons Company";
			$to1 = $user_details[0]['email'];
			$this->load->library('email');
			$config['mailtype'] = "html";
			$this->email->initialize($config);	
			$this->email->clear();
			$this->email->from($admin_email, 'LES BALCONS');
			$this->email->to($to1);
			$this->email->subject($subject1);
			$this->email->message($msg_text1); 
			$this->email->send();
		}
		elseif($user_details[0]['user_language']==2)//If user belongs to french
		{

			$msg_text1='<table width="650" align="center" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" style="border:1px solid #C9AD64; font-family:arial; font-size:12px;">
				
				<tr bgcolor="#222222">
				<td colspan="2" align="center" style="padding:8px 0;"><b><font color="#FFFFFF">Nouvelle réservation @ Les Balcons Company</font></b></td>
				</tr>';
			$msg_text1.='
				<tr>
					<td colspan="2" align="center" valign="top" style="padding:10px 10px;"><a href="#" target="_blank"><img src="'.base_url().'assets/images/logo.png" alt="" border="0" /></a></td>
				</tr>
				<tr>
					<td colspan="2" style="border-top:1px solid #C9AD64; padding:5px;">
						<b>Cher '.$user_details[0]['name'].',</b><br>
						<b>Votre réservation a été effectuée avec succès.</b><br>
						<b>Trouver les détails ci-dessous.</b>
					</td>
				</tr>
				<tr bgcolor="#f5e8c8">
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Nom: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$name.'</td>
				</tr>
				<tr>
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Date d\'arrivée: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$this->input->post("arrival_date").'</td>
				</tr>
				<tr bgcolor="#f5e8c8">
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Date de départ:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$this->input->post("leave_date").'</td>
				</tr>
				<tr>
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Bungalow:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$bungalow_details[0]['bunglow_name'].'</td>
				</tr>
				<tr bgcolor="#f5e8c8">
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Taux total Bungalow:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$currency_arr[0]['currency_symbol'].$total_bungalow_rate.'</td>
				</tr>
				<tr>
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Options:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$options_text_for_mail.'</td>
				</tr>
				<tr bgcolor="#f5e8c8">
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Réduction:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$discount.'%</td>
				</tr>
				<tr>
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Impôt:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$tax_text_for_mail.'</td>
				</tr>
				<tr bgcolor="#f5e8c8">
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Total:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$currency_arr[0]['currency_symbol'].$total_rate.'</td>
				</tr>
				<tr>
					<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Montant à payer:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$currency_arr[0]['currency_symbol'].$total_rate.'</td>
				</tr>
				<tr>
					<td colspan="2" style="border-top:1px solid #C9AD64; padding:5px; ">
					<p><b>Cordialement,</b></p>
					<p><b>La Balcons Company</b></p>
					</td>
				</tr>
			</table>';
				
				
			$subject1 = "Nouvelle réservation @ Les Balcons Société";
			$to1 = $user_details[0]['email'];
			$this->load->library('email');
			$config['mailtype'] = "html";
			$this->email->initialize($config);	
			$this->email->clear();
			$this->email->from($admin_email, 'LES BALCONS');
			$this->email->to($to1);
			$this->email->subject($subject1);
			$this->email->message($msg_text1); 
			$this->email->send();
		}
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
	
	//Function for getting reservation details
	function get_reservation_details($reservation_id)
	{
		$result=$this->db->get_where("lb_reservation", array("id"=>$reservation_id))->result_array();
		return $result;
	}
	
	//function for editing reservation
	function edit_reservation()
	{
		$default_language=$this->db->get_where("mast_language", array("set_as_default"=>"Y"))->result_array();
		$default_language_id=$default_language[0]['id'];
		$currency_arr=$this->db->get_where("lb_currency_master", array("set_as_default"=>"Y"))->result_array();
		$admin_arr=$this->db->get_where("mast_admin_info", array('id'=>1))->result_array();
		$admin_email=$admin_arr[0]['email'];

		$user_id=$this->input->post("user_id");
		$user_details=$this->db->get_where("lb_users", array("id"=>$user_id))->result_array();
		$bungalow_id=$this->input->post("bungalow_id");
		$bungalow_details=$this->get_bungalow_details($bungalow_id);
		$reservation_id=$this->input->post("reservation_id");
		
		$name=$this->input->post("reservation_name");
		$contact=$this->input->post("reservation_contact");

		$arrival_date_arr=explode("/", $this->input->post("arrival_date"));
		$arrival_date=strtotime($arrival_date_arr[2]."-".$arrival_date_arr[1]."-".$arrival_date_arr[0]);
		$arrival_date_new_format=$arrival_date_arr[2]."-".$arrival_date_arr[1]."-".$arrival_date_arr[0];
		$leave_date_arr=explode("/", $this->input->post("leave_date"));
		$leave_date=strtotime($leave_date_arr[2]."-".$leave_date_arr[1]."-".$leave_date_arr[0]);
		$leave_date_new_format=$leave_date_arr[2]."-".$leave_date_arr[1]."-".$leave_date_arr[0];
		$diff = ceil(abs($leave_date - $arrival_date) / 86400);
		$text=$this->input->post("reservation_text");
		$invoice_number=$this->get_unique_invoice_number();
		
		//Getting Bungalow Rate
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
		$rate_details_arr=$this->db->get_where("lb_bunglow_rates", array("bunglow_id"=>$bungalow_id, "season_id"=>$season_id))->result_array();
		$total_bungalow_rate=$rate_details_arr[0]['rate_per_day_euro']*$diff; //Multiplying with total days of staying
		$total_bungalow_rate_dollar=$rate_details_arr[0]['rate_per_day_dollar']*$diff;
		$discount=$rate_details_arr[0]['discount']; //discount in %
		
		//Calculating options rate
		$options_rate_euro=array();
		$options_rate_dollar=array();
		$options_text_for_mail="";
		$total_options_rate=0; //By default currency is euro so that calculation will be in euro
		$x=0;
		if($this->input->post("options_id"))
		{
			$options_ids=implode(",", $this->input->post("options_id"));
			foreach($this->input->post("options_id") as $options_id)
			{
				$this->db->select('*');
				$this->db->from('lb_bunglow_options');
				$this->db->join('lb_bunglow_options_lang', 'lb_bunglow_options.id = lb_bunglow_options_lang.options_id AND lb_bunglow_options.id='.$options_id.' AND lb_bunglow_options_lang.language_id='.$default_language_id);
				$options_details=$this->db->get()->result_array();
				array_push($options_rate_euro, $options_details[0]["charge_in_euro"]*$diff);
				array_push($options_rate_dollar, $options_details[0]["charge_in_dollars"]*$diff);
				$total_options_rate=$total_options_rate+$options_details[0]["charge_in_euro"]*$diff;
				$options_text_for_mail .="<p>".$options_details[0]['options_name']." : ".$currency_arr[0]['currency_symbol'].$options_details[0]["charge_in_euro"]*$diff."</p>";
			}
			$options_rates=implode(",", $options_rate_euro);
			$options_rates_dollar=implode(",", $options_rate_dollar);
		}
		else
		{
			$options_ids="";
			$options_rates="";
			$options_rates_dollar="";
			$options_text_for_mail="N/A";
		}
		$discounted_value=($total_bungalow_rate+$total_options_rate)*$discount/100;

		//Getting taxes 
		$total_taxes=0;
		$taxes_rate_array=array();
		$tax_text_for_mail="";
		if(!empty($bungalow_details[0]['tax_id']))
		{
			$taxes_ids=$bungalow_details[0]['tax_id'];
			$taxes_arr=explode(",", $bungalow_details[0]['tax_id']);
			foreach($taxes_arr as $tax_id)
			{
				$this->db->select('*');
				$this->db->from('lb_tax');
				$this->db->join('lb_tax_lang', 'lb_tax.id = lb_tax_lang.tax_id AND lb_tax.id='.$tax_id.' AND lb_tax_lang.language_id='.$default_language_id);
				$tax_details=$this->db->get()->result_array();
				$rates_percentage=$tax_details[0]['rate'];
				$total_tax_rate=$total_bungalow_rate*$rates_percentage/100;
				$total_taxes=$total_taxes+$total_tax_rate;
				$tax_text_for_mail .="<p>".$tax_details[0]['tax_name']." (".$tax_details[0]['rate']."%) : ".$currency_arr[0]['currency_symbol'].$total_tax_rate."</p>";
				array_push($taxes_rate_array, $rates_percentage);
			}
			$taxes_rate= implode(",", $taxes_rate_array);
		}
		else 
		{
			$taxes_ids="";
			$taxes_rate="";
			$tax_text_for_mail="N/A";
		}
		
		//Now finally calculating all final amount to be paid
		$total_rate=(($total_bungalow_rate+$total_options_rate)-$discounted_value)+$total_taxes;

		$upd_arr=array(
			"user_id"=>$user_id,
			"name"=>$name,
			"phone"=>$contact,
			"email"=>"",
			"bunglow_id"=>$bungalow_id,
			"options_id"=>$options_ids,
			"options_rate"=>$options_rates,
			"options_rate_dollar"=>$options_rates_dollar,
			"tax_id"=>$taxes_ids,
			"tax_id"=>$taxes_ids,
			"tax_rate"=>$taxes_rate,
			"bunglow_per_day"=>$rate_details_arr[0]['rate_per_day_euro'],
			"bunglow_per_day_dollar"=>$rate_details_arr[0]['rate_per_day_dollar'],
			"discount"=>$discount,
			"arrival_date"=>$arrival_date_new_format,
			"leave_date"=>$leave_date_new_format,
			"comment"=>$text,
			"amount_to_be_paid"=>$total_rate,
			"paid_amount"=>0,
			"due_amount"=>$total_rate,
		);
		$this->db->update("lb_reservation", $upd_arr, array("id"=>$reservation_id));
	}
	
	//function for getting user details
	function get_user_details($user_id)
	{
		$result=$this->db->get_where("lb_users", array("id"=>$user_id))->result_array();
		return $result;
	}
	
	//function to send invoice from calendar
	function send_invoice()
	{
		$admin_arr=$this->db->get_where("mast_admin_info", array('id'=>1))->result_array();
		$admin_email=$admin_arr[0]['email'];
		$reservation_id=$this->input->post("reservation_id");
		$payment_details=$this->db->get_where("lb_reservation", array("id"=>$reservation_id))->result_array();
		$user_id=$payment_details[0]['user_id'];
		$user_details=$this->get_user_details($user_id);
		$default_language_id=$user_details[0]['user_language'];//user belongs to which language
		$bungalow_id=$payment_details[0]['bunglow_id'];
		$bungalow_details=$this->db->get_where("lb_bunglow_lang", array("bunglow_id"=>$bungalow_id, "language_id"=>$default_language_id))->result_array();
		if($this->input->post("currency_type")=="EUR")//If invoice sending in euro currency
		{
			$default_currency_arr=$this->db->get_where("lb_currency_master", array("currency_id"=>"2"))->result_array();
			$default_currency=$default_currency_arr[0]['currency_symbol'];
			
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
					$total_options_rate_arr[$x]['option_name']=$options_details[0]['options_name'];
					$total_options_rate_arr[$x]['options_rate']=$default_currency.$options_rate_arr[$x];
					$x++;
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
			$reservation_date	=date("d/m/Y H:i:s", strtotime($payment_details[0]['reservation_date']));
			$user_name			=$user_details[0]['name'];
			$user_email			=$user_details[0]['email'];
			$bunglow_under_booking=$payment_details[0]['name'];
			$more_phone			=$payment_details[0]['phone'];
			$more_email			=$payment_details[0]['email'];
			$arrival_date_arr	=explode("-",$payment_details[0]['arrival_date']);
			$arrival_date		=$arrival_date_arr[2]."/".$arrival_date_arr[1]."/".$arrival_date_arr[0];
			$leave_date_arr		=explode("-",$payment_details[0]['leave_date']);
			$leave_date			=$leave_date_arr[2]."/".$leave_date_arr[1]."/".$leave_date_arr[0];
			$accommodation		=ceil(abs(strtotime($payment_details[0]['leave_date']) - strtotime($payment_details[0]['arrival_date'])) / 86400);
			$bungalow_name		=$bungalow_details[0]['bunglow_name'];
			$bungalow_rate		=$default_currency.$bungalow_rate;
			$options_rate		=$total_options_rate_arr;
			$discount			=$payment_details[0]['discount'];
			$tax_rate			=$total_tax_rate_arr;
			$total				=$default_currency.$payment_details[0]['amount_to_be_paid'];
			$paid_amount		=$default_currency.$payment_details[0]['paid_amount'];
			$due_amount			=$default_currency.$payment_details[0]['due_amount'];
			$payment_mode		=$payment_details[0]['payment_mode'];
			$invoice_number		=$payment_details[0]['invoice_number'];
			$payment_status		=$payment_details[0]['payment_status'];
			$reservation_status	=$payment_details[0]['reservation_status'];
			
			$options_text_for_mail="";
			if(count($options_rate)>0)
			{
				foreach($options_rate as $options) 
				{
					$options_text_for_mail .=$options['option_name'].": ".$options['options_rate']." ";
				}
			}
			else 
			{
				$options_text_for_mail="N/A";
			}
			
			$tax_text_for_mail="";
			if(count($tax_rate)>0)
			{
				foreach($tax_rate as $tax) 
				{
					$tax_text_for_mail .=$tax['tax_name'].": ".$tax['tax_rate']." ";
				}
			}
			else 
			{
				$tax_text_for_mail="N/A";
			}
			

			if($default_language_id==1)//If user language is english
			{
				$additional_payment_text ="";
				if($payment_mode=="FULL")
				{
					$additional_payment_text .='
					<tr>
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Paid Amount: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$paid_amount.'</td>
					</tr>
					<tr  bgcolor="#f5e8c8">
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Payment Status:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$payment_status.'</td>
					</tr>
					<tr>
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Reservation Status: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$reservation_status.'</td>
					</tr>';
				}
				elseif($payment_mode=="PARTIAL")
				{
					$additional_payment_text .='
					<tr>
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Paid Amount: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$paid_amount.'</td>
					</tr>
					<tr  bgcolor="#f5e8c8">
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Due Amount:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$due_amount.'</td>
					</tr>
					<tr>
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Payment Status:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$payment_status.'</td>
					</tr>
					<tr bgcolor="#f5e8c8">
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Reservation Status: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$reservation_status.'</td>
					</tr>';
				}
				elseif($payment_mode=="ONARRIVAL")
				{
					$additional_payment_text .='
					<tr>
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Due Amount:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$due_amount.'</td>
					</tr>
					<tr bgcolor="#f5e8c8">
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Payment Status:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$payment_status.'</td>
					</tr>
					<tr>
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Reservation Status: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$reservation_status.'</td>
					</tr>';
				}
				//Sending email to users
				$msg_text2='<table width="650" align="center" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" style="border:1px solid #C9AD64; font-family:arial; font-size:12px;">
					<tr bgcolor="#222222">
					<td colspan="2" align="center" style="padding:8px 0;"><b><font color="#FFFFFF">INVOICE</font></b></td>
					</tr>';
				$msg_text2.='
					<tr>
						<td colspan="2" align="center" valign="top" style="padding:10px 10px;"><a href="#" target="_blank"><img src="'.base_url().'assets/images/logo.png" alt="" border="0" /></a></td>
					</tr>
					<tr>

					<td colspan="2" style="border-top:1px solid #C9AD64; padding:5px;">
						<b>Dear '.$user_name.',</b><br>
						<b>Your invoice number is: '.$invoice_number.'</b><br>
						<b>Payment Mode: '.$payment_mode.'</b><br>
					</td>
					</tr>
					<tr  bgcolor="#f5e8c8">
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Customer Name: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$bunglow_under_booking.'</td>
					</tr>
					<tr>
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Reservation Date: </b></td style="border-top:1px solid #C9AD64; padding:5px;"><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$reservation_date.'</td>
					</tr>
					<tr  bgcolor="#f5e8c8">
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Arrival Date: </b></td style="border-top:1px solid #C9AD64; padding:5px;"><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$arrival_date.'</td>
					</tr>
					<tr>
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Leave Date: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$leave_date.'</td>
					</tr>
					<tr  bgcolor="#f5e8c8">
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Accommodation(days):</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$accommodation.'</td>
					</tr>
					<tr>
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Bungalow: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$bungalow_name.'</td>
					</tr>
					<tr  bgcolor="#f5e8c8">
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Total Bungalow Rate:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$bungalow_rate.'</td>
					</tr>
					<tr>
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Options: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$options_text_for_mail.'</td>
					</tr>
					<tr  bgcolor="#f5e8c8">
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Discount:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$discount.'%</td>
					</tr>
					<tr>
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Tax: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$tax_text_for_mail.'</td>
					</tr>
					<tr  bgcolor="#f5e8c8">
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Total Amount:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$total.'</td>
					</tr>';
					
				$msg_text2.=$additional_payment_text;
					
				$msg_text2.='<tr>
						<td colspan="2" style="border-top:1px solid #C9AD64; padding:5px; ">
						<p><b>Regards,</b></p>
						<p><b>La Balcons Company</b></p>
						</td>
					</tr>
					';
				$msg_text2.='</table>';
				$subject2 ="INVOICE @ LES BALCONS";
				$to2 = $user_email;
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
			elseif($default_language_id==2)//If user language is french
			{
				//Sending email to users
				$additional_payment_text ="";
				if($payment_mode=="FULL")
				{
					$additional_payment_text .='
					<tr>
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Montant payé: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$paid_amount.'</td>
					</tr>
					<tr  bgcolor="#f5e8c8">
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Statut de paiement:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$payment_status.'</td>
					</tr>
					<tr>
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Statut de la réservation: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$reservation_status.'</td>
					</tr>';
				}
				elseif($payment_mode=="PARTIAL")
				{
					$additional_payment_text .='
					<tr>
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Montant payé: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$paid_amount.'</td>
					</tr>
					<tr  bgcolor="#f5e8c8">
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Montant dû:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$due_amount.'</td>
					</tr>
					<tr>
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Statut de paiement:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$payment_status.'</td>
					</tr>
					<tr bgcolor="#f5e8c8">
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Statut de la réservation: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$reservation_status.'</td>
					</tr>';
				}
				elseif($payment_mode=="ONARRIVAL")
				{
					$additional_payment_text .='
					<tr>
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Montant dû:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$due_amount.'</td>
					</tr>
					<tr bgcolor="#f5e8c8">
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Statut de paiement:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$payment_status.'</td>
					</tr>
					<tr>
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Statut de la réservation: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$reservation_status.'</td>
					</tr>';
				}
				
				$msg_text2='<table width="650" align="center" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" style="border:1px solid #C9AD64; font-family:arial; font-size:12px;">
					<tr bgcolor="#222222">
					<td colspan="2" align="center" style="padding:8px 0;"><b><font color="#FFFFFF">FACTURE</font></b></td>
					</tr>';
				$msg_text2.='
					<tr>
						<td colspan="2" align="center" valign="top" style="padding:10px 10px;"><a href="#" target="_blank"><img src="'.base_url().'assets/images/logo.png" alt="" border="0" /></a></td>
					</tr>
					<tr>

					<td colspan="2" style="border-top:1px solid #C9AD64; padding:5px;">
						<b>Cher '.$user_name.',</b><br>
						<b>Votre numéro de facture est: '.$invoice_number.'</b><br>
						<b>Mode de paiement: '.$payment_mode.'</b><br>
					</td>
					</tr>
					<tr  bgcolor="#f5e8c8">
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Nom du client: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$bunglow_under_booking.'</td>
					</tr>
					<tr>
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Date de réservation: </b></td style="border-top:1px solid #C9AD64; padding:5px;"><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$reservation_date.'</td>
					</tr>
					<tr  bgcolor="#f5e8c8">
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Date d\'arrivée: </b></td style="border-top:1px solid #C9AD64; padding:5px;"><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$arrival_date.'</td>
					</tr>
					<tr>
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Date de départ: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$leave_date.'</td>
					</tr>
					<tr  bgcolor="#f5e8c8">
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Logement(journées):</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$accommodation.'</td>
					</tr>
					<tr>
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Bungalow: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$bungalow_name.'</td>
					</tr>
					<tr  bgcolor="#f5e8c8">
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Taux Total Bungalow:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$bungalow_rate.'</td>
					</tr>
					<tr>
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Options: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$options_text_for_mail.'</td>
					</tr>
					<tr  bgcolor="#f5e8c8">
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Réduction:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$discount.'%</td>
					</tr>
					<tr>
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Impôt: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$tax_text_for_mail.'</td>
					</tr>
					<tr  bgcolor="#f5e8c8">
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Montant Total:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$total.'</td>
					</tr>';
					$msg_text2.=$additional_payment_text;
					$msg_text2.='<tr>
						<td colspan="2" style="border-top:1px solid #C9AD64; padding:5px; ">
						<p><b>Cordialement,</b></p>
						<p><b>La Balcons Company</b></p>
						</td>
					</tr>
					';
				$msg_text2.='</table>';
				$subject2 ="FACTURE @ LES BALCONS";
				$to2 = $user_email;
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
		}
		elseif($this->input->post("currency_type")=="USD")//If invoice sending in dollar currency
		{
			$default_currency_arr=$this->db->get_where("lb_currency_master", array("currency_id"=>"1"))->result_array();
			$default_currency=$default_currency_arr[0]['currency_symbol'];
			
			//Getting bungalow rates
			$accommodation=ceil(abs(strtotime($payment_details[0]['leave_date']) - strtotime($payment_details[0]['arrival_date'])) / 86400);
			$bungalow_rate=$payment_details[0]['bunglow_per_day_dollar']*$accommodation;

			//Getting options rates
			$total_options_rate=0;
			$total_options_rate_arr=array();
			$options_ids=$payment_details[0]['options_id'];
			if($options_ids!="")
			{
				$options_id_arr=explode(",", $options_ids);
				$x=0;
				$options_rate_arr=explode(",", $payment_details[0]['options_rate_dollar']);
				foreach($options_id_arr as $options)
				{
					$options_details=$this->db->get_where("lb_bunglow_options_lang", array("options_id"=>$options, "language_id"=>$default_language_id))->result_array();
					$total_options_rate_arr[$x]['option_name']=$options_details[0]['options_name'];
					$total_options_rate_arr[$x]['options_rate_dollar']=$default_currency.$options_rate_arr[$x];
					$total_options_rate=$total_options_rate+$options_rate_arr[$x];
					$x++;
				}
			}
			

			//Getting tax rates
			$total_tax_rate=0;
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
					$total_tax_rate=$total_tax_rate+$tax_value;
					$x++;
				}
			}
			
			$total_with_options=$bungalow_rate+$total_options_rate;
			$total_with_discount=$total_with_options-($total_with_options*$payment_details[0]['discount']/100);
			$final_amount_with_tax=$total_with_discount+$total_tax_rate;
			
			$reservation_date	=date("d/m/Y H:i:s", strtotime($payment_details[0]['reservation_date']));
			$user_name			=$user_details[0]['name'];
			$user_email			=$user_details[0]['email'];
			$bunglow_under_booking=$payment_details[0]['name'];
			$more_phone			=$payment_details[0]['phone'];
			$more_email			=$payment_details[0]['email'];
			$arrival_date_arr	=explode("-",$payment_details[0]['arrival_date']);
			$arrival_date		=$arrival_date_arr[2]."/".$arrival_date_arr[1]."/".$arrival_date_arr[0];
			$leave_date_arr		=explode("-",$payment_details[0]['leave_date']);
			$leave_date			=$leave_date_arr[2]."/".$leave_date_arr[1]."/".$leave_date_arr[0];
			$accommodation		=ceil(abs(strtotime($payment_details[0]['leave_date']) - strtotime($payment_details[0]['arrival_date'])) / 86400);
			$bungalow_name		=$bungalow_details[0]['bunglow_name'];
			$bungalow_rate		=$default_currency.$bungalow_rate;
			$options_rate		=$total_options_rate_arr;
			$discount			=$payment_details[0]['discount'];
			$tax_rate			=$total_tax_rate_arr;
			$total				=$default_currency.$final_amount_with_tax;
			$due_amount			=$default_currency.$final_amount_with_tax;
			$payment_mode		=$payment_details[0]['payment_mode'];
			$invoice_number		=$payment_details[0]['invoice_number'];
			$payment_status		=$payment_details[0]['payment_status'];
			$reservation_status	=$payment_details[0]['reservation_status'];
			
			$options_text_for_mail="";
			if(count($options_rate)>0)
			{
				foreach($options_rate as $options) 
				{
					$options_text_for_mail .=$options['option_name'].": ".$options['options_rate_dollar']." ";
				}
			}
			else 
			{
				$options_text_for_mail="N/A";
			}
			
			$tax_text_for_mail="";
			if(count($tax_rate)>0)
			{
				foreach($tax_rate as $tax) 
				{
					$tax_text_for_mail .=$tax['tax_name'].": ".$tax['tax_rate']." ";
				}
			}
			else 
			{
				$tax_text_for_mail="N/A";
			}
			
			if($default_language_id==1)//If user language is english
			{

				//Sending email to users
				$msg_text2='<table width="650" align="center" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" style="border:1px solid #C9AD64; font-family:arial; font-size:12px;">
					<tr bgcolor="#222222">
					<td colspan="2" align="center" style="padding:8px 0;"><b><font color="#FFFFFF">INVOICE</font></b></td>
					</tr>';
				$msg_text2.='
					<tr>
						<td colspan="2" align="center" valign="top" style="padding:10px 10px;"><a href="#" target="_blank"><img src="'.base_url().'assets/images/logo.png" alt="" border="0" /></a></td>
					</tr>
					<tr>

					<td colspan="2" style="border-top:1px solid #C9AD64; padding:5px;">
						<b>Dear '.$user_name.',</b><br>
						<b>Your invoice number is: '.$invoice_number.'</b><br>
						<b>Payment Mode: '.$payment_mode.'</b><br>
					</td>
					</tr>
					<tr  bgcolor="#f5e8c8">
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Customer Name: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$bunglow_under_booking.'</td>
					</tr>
					<tr>
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Reservation Date: </b></td style="border-top:1px solid #C9AD64; padding:5px;"><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$reservation_date.'</td>
					</tr>
					<tr  bgcolor="#f5e8c8">
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Arrival Date: </b></td style="border-top:1px solid #C9AD64; padding:5px;"><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$arrival_date.'</td>
					</tr>
					<tr>
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Leave Date: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$leave_date.'</td>
					</tr>
					<tr  bgcolor="#f5e8c8">
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Accommodation(days):</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$accommodation.'</td>
					</tr>
					<tr>
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Bungalow: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$bungalow_name.'</td>
					</tr>
					<tr  bgcolor="#f5e8c8">
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Total Bungalow Rate:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$bungalow_rate.'</td>
					</tr>
					<tr>
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Options: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$options_text_for_mail.'</td>
					</tr>
					<tr  bgcolor="#f5e8c8">
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Discount:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$discount.'%</td>
					</tr>
					<tr>
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Tax: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$tax_text_for_mail.'</td>
					</tr>
					<tr  bgcolor="#f5e8c8">
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Total Amount:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$total.'</td>
					</tr>
					<tr>
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Due Amount: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$due_amount.'</td>
					</tr>
					<tr  bgcolor="#f5e8c8">
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Payment Status:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$payment_status.'</td>
					</tr>
					<tr>
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Reservation Status: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$reservation_status.'</td>
					</tr>
					<tr>
						<td colspan="2" style="border-top:1px solid #C9AD64; padding:5px; ">
						<p><b>Regards,</b></p>
						<p><b>La Balcons Company</b></p>
						</td>
					</tr>
					';
				$msg_text2.='</table>';
				$subject2 ="INVOICE @ LES BALCONS";
				$to2 = $user_email;
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
			elseif($default_language_id==2)//If user language is french
			{
				//Sending email to users
				$msg_text2='<table width="650" align="center" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" style="border:1px solid #C9AD64; font-family:arial; font-size:12px;">
					<tr bgcolor="#222222">
					<td colspan="2" align="center" style="padding:8px 0;"><b><font color="#FFFFFF">FACTURE</font></b></td>
					</tr>';
				$msg_text2.='
					<tr>
						<td colspan="2" align="center" valign="top" style="padding:10px 10px;"><a href="#" target="_blank"><img src="'.base_url().'assets/images/logo.png" alt="" border="0" /></a></td>
					</tr>
					<tr>

					<td colspan="2" style="border-top:1px solid #C9AD64; padding:5px;">
						<b>Cher '.$user_name.',</b><br>
						<b>Votre numéro de facture est: '.$invoice_number.'</b><br>
						<b>Mode de paiement: '.$payment_mode.'</b><br>
					</td>
					</tr>
					<tr  bgcolor="#f5e8c8">
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Nom du client: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$bunglow_under_booking.'</td>
					</tr>
					<tr>
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Date de réservation: </b></td style="border-top:1px solid #C9AD64; padding:5px;"><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$reservation_date.'</td>
					</tr>
					<tr  bgcolor="#f5e8c8">
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Date d\'arrivée: </b></td style="border-top:1px solid #C9AD64; padding:5px;"><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$arrival_date.'</td>
					</tr>
					<tr>
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Date de départ: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$leave_date.'</td>
					</tr>
					<tr  bgcolor="#f5e8c8">
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Logement(journées):</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$accommodation.'</td>
					</tr>
					<tr>
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Bungalow: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$bungalow_name.'</td>
					</tr>
					<tr  bgcolor="#f5e8c8">
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Taux Total Bungalow:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$bungalow_rate.'</td>
					</tr>
					<tr>
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Options: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$options_text_for_mail.'</td>
					</tr>
					<tr  bgcolor="#f5e8c8">
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Réduction:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$discount.'%</td>
					</tr>
					<tr>
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Impôt: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$tax_text_for_mail.'</td>
					</tr>
					<tr  bgcolor="#f5e8c8">
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Montant Total:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$total.'</td>
					</tr>
					<tr>
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Montant dû: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$due_amount.'</td>
					</tr>
					<tr  bgcolor="#f5e8c8">
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Statut de paiement:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$payment_status.'</td>
					</tr>
					<tr>
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Statut de la réservation: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$reservation_status.'</td>
					</tr>
					<tr>
						<td colspan="2" style="border-top:1px solid #C9AD64; padding:5px; ">
						<p><b>Cordialement,</b></p>
						<p><b>La Balcons Company</b></p>
						</td>
					</tr>
					';
				$msg_text2.='</table>';
				$subject2 ="FACTURE @ LES BALCONS";
				$to2 = $user_email;
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
		}
	}
	
	
	//function for getting cleaning print details
	function get_cleaning_print_details($cleaning_date)
	{
		$default_lang_arr=$this->db->get_where("mast_language", array("set_as_default"=>"Y"))->result_array();
		$default_langugage_id=$default_lang_arr[0]['id'];
		$cleaning_details=$this->db->get_where("lb_bunglow_cleaning", array("cleaning_date"=>$cleaning_date))->result_array();
		$output="";
		$output .='<table width="650" align="center" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" style="border:1px solid #C9AD64; font-family:arial; font-size:12px;">
			<tr>
				<td colspan="2" align="center"><h2>Cleaning Details</h2></td>
			</tr>
			<tr bgcolor="#ccc">
				<th style="border-top:1px solid #C9AD64; padding:5px;">Date</th>
				<th style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">Bungalow</th>
			</tr>
		';
		foreach($cleaning_details as $cleaning)
		{
			$bungalow_id=$cleaning['bunglow_id'];
			$bungalow_details=$this->db->get_where("lb_bunglow_lang", array("bunglow_id"=>$bungalow_id, "language_id"=>$default_langugage_id))->result_array();
			$output .=
				'<tr>
					<td style="border-top:1px solid #C9AD64; padding:5px;">
					'.date("d/m/Y", strtotime($cleaning['cleaning_date'])).'
					</td>
					<td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">
					'.$bungalow_details[0]['bunglow_name'].'
					</td>
				</tr>
				';
		}
		$output .="</table>";
		return $output;	
	}
	
	
	//Function for getting latest booking
	function get_latest_booking()
	{
		//Getting reservation which has been done within 24 hour
		$default_lang_arr=$this->db->get_where("mast_language", array("set_as_default"=>"Y"))->result_array();
		$default_langugage_id=$default_lang_arr[0]['id'];
		$current_date_time=date("d-m-Y H:i:s");
		$current_time_stamp=strtotime($current_date_time);
		$this->db->order_by("id");
		$reservation_list=$this->db->get("lb_reservation")->result_array();
		$latest_reservation_arr=array();
		foreach($reservation_list as $value)
		{
			$reservation_date=$value['reservation_date'];
			$reservation_time_stamp=strtotime($reservation_date);
			$seconds=$current_time_stamp-$reservation_time_stamp;
			$hour=round($seconds/60/60);
			if($hour<24)
			{
				$latest_id=$value['id'];
				$reservation_details=$this->get_reservation_details($latest_id);
				$bungalow_details=$bungalow_details=$this->db->get_where("lb_bunglow_lang", array("bunglow_id"=>$reservation_details[0]['bunglow_id'], "language_id"=>$default_langugage_id))->result_array();
				$options_details=$this->db->query("SELECT * FROM `lb_bunglow_options_lang` WHERE `options_id` IN (".$reservation_details[0]['options_id'].") AND `language_id`='$default_langugage_id'")->result_array();
				$options_arr=array();
				if($reservation_details[0]['options_id']!="")
				{
					foreach($options_details as $options)
					{
						array_push($options_arr, $options['options_name']);
					}
				}
				if(count($options_arr)>0)
				{
					$options_text=implode(", ",$options_arr);
				}
				else 
				{
					$options_text="N/A";
				}
				$latest_reservation_arr['reservation_date']=date("d/m/Y h:i:s", strtotime($reservation_details[0]['reservation_date']));
				$latest_reservation_arr['arrival_date']=date("d/m/Y", strtotime($reservation_details[0]['arrival_date']));
				$latest_reservation_arr['leave_date']=date("d/m/Y", strtotime($reservation_details[0]['leave_date']));	
				$latest_reservation_arr['bungalow_name']=$bungalow_details[0]['bunglow_name'];	
				$latest_reservation_arr['options']=$options_text;
				$latest_reservation_arr['payment_status']=$reservation_details[0]['is_active'];
			}
			
		}
		return $latest_reservation_arr;
	}
	
	
	
	
	//###############	FUNCTIONS FOR FRONT END		#############################
	
	
	//###############function to get banners on home page###############
	function get_banners()
	{
		$current_lang_id=$this->session->userdata("current_lang_id");
		$this->db->select('*');
		$this->db->from('lb_banner');
		$this->db->order_by('lb_banner.sort_order', 'asc');
		$this->db->join('lb_banner_lang', 'lb_banner.id = lb_banner_lang.banner_id AND lb_banner.is_active = "Y" AND lb_banner_lang.language_id='.$current_lang_id);
		$banner_arr = $this->db->get()->result_array();
		return $banner_arr;
	}
	
	//###############function to get welcome text###############
	function get_welcome_text()
	{
		$current_lang_id=$this->session->userdata("current_lang_id");
		$result=$this->db->get_where("lb_welcome_text", array("language_id"=>$current_lang_id))->result_array();
		return $result[0]['text'];
	}
	
	//###############Function to get property listing in home page###############
	function get_property()
	{
		$current_lang_id=$this->session->userdata("current_lang_id");
		$all_property_array=array();
		$this->db->order_by('id', 'desc');
		//Firstly Getting Featured Property
		$array=$this->db->get_where("lb_bunglow", array("type"=>"P","is_active"=>"Y", "is_featured"=>"Y"), 4, 0)->result_array();
		$i=0;
		if(count($array)>0)
		{
			foreach($array as $val)
			{
				$peroperty_id=$val['id'];
				$get_details_arr=$this->db->get_where("lb_bunglow_lang", array("bunglow_id"=>$peroperty_id, "language_id"=>$current_lang_id))->result_array();
				//Get Property Images
				$this->db->select('*');
				$this->db->from('lb_bunglow_image');
				$this->db->order_by('lb_bunglow_image.id', 'desc');
				$this->db->join('lb_bunglow_image_lang', 'lb_bunglow_image.id = lb_bunglow_image_lang.image_id AND lb_bunglow_image.bunglow_id='.$peroperty_id.' AND lb_bunglow_image.is_active = "Y" AND lb_bunglow_image_lang.language_id='.$current_lang_id);
				$this->db->limit(1);
				$image_arr = $this->db->get()->result_array();
				$all_property_array[$i]['id']=$val['id'];
				$all_property_array[$i]['bunglow_name']=$get_details_arr[0]['bunglow_name'];
				$all_property_array[$i]['bunglow_overview']=$get_details_arr[0]['bunglow_overview'];
				$all_property_array[$i]['slug']=$val['slug'];
				$all_property_array[$i]['image']=$image_arr[0]['image'];
				$i++;
			}
		}
		
		//If featured property will be less than 4 then last added property will be in array
		if(count($all_property_array)<4)//Here 4 has been given because at home page there is 4 property listing
		{
			$limit=4-count($all_property_array);
			$this->db->order_by('id', 'desc');
			$array=$this->db->get_where("lb_bunglow", array("type"=>"P","is_active"=>"Y", "is_featured"=>"N"), $limit, 0)->result_array();
			if(count($array)>0)
			{
				foreach($array as $val)
				{
					$peroperty_id=$val['id'];
					$get_details_arr=$this->db->get_where("lb_bunglow_lang", array("bunglow_id"=>$peroperty_id, "language_id"=>$current_lang_id))->result_array();
					//Get Property Images
					$this->db->select('*');
					$this->db->from('lb_bunglow_image');
					$this->db->order_by('lb_bunglow_image.id', 'desc');
					$this->db->join('lb_bunglow_image_lang', 'lb_bunglow_image.id = lb_bunglow_image_lang.image_id AND lb_bunglow_image.bunglow_id='.$peroperty_id.' AND lb_bunglow_image.is_active = "Y" AND lb_bunglow_image_lang.language_id='.$current_lang_id);
					$this->db->limit(1);
					$image_arr = $this->db->get()->result_array();
					$all_property_array[$i]['id']=$val['id'];
					$all_property_array[$i]['bunglow_name']=$get_details_arr[0]['bunglow_name'];
					$all_property_array[$i]['bunglow_overview']=$get_details_arr[0]['bunglow_overview'];
					$all_property_array[$i]['slug']=$val['slug'];
					$all_property_array[$i]['image']=$image_arr[0]['image'];
					$i++;
				}
			}
		}
		return $all_property_array;
	}
	
	//###############Function to get bungalow listing in home page###############
	function get_bungalow()
	{
		$current_lang_id=$this->session->userdata("current_lang_id");
		$all_bunglow_array=array();
		$this->db->order_by('id', 'desc');
		//Firstly Getting Featured bungalow
		$array=$this->db->get_where("lb_bunglow", array("type"=>"B","is_active"=>"Y", "is_featured"=>"Y"), 10, 0)->result_array();
		$i=0;
		if(count($array)>0)
		{
			foreach($array as $val)
			{
				$peroperty_id=$val['id'];
				$get_details_arr=$this->db->get_where("lb_bunglow_lang", array("bunglow_id"=>$peroperty_id, "language_id"=>$current_lang_id))->result_array();
				//Get bungalow Images
				$this->db->select('*');
				$this->db->from('lb_bunglow_image');
				$this->db->order_by('lb_bunglow_image.id', 'desc');
				$this->db->join('lb_bunglow_image_lang', 'lb_bunglow_image.id = lb_bunglow_image_lang.image_id AND lb_bunglow_image.bunglow_id='.$peroperty_id.' AND lb_bunglow_image.is_active = "Y" AND lb_bunglow_image_lang.language_id='.$current_lang_id);
				$this->db->limit(1);
				$image_arr = $this->db->get()->result_array();
				$all_bunglow_array[$i]['id']=$val['id'];
				$all_bunglow_array[$i]['bunglow_name']=$get_details_arr[0]['bunglow_name'];
				$all_bunglow_array[$i]['bunglow_overview']=$get_details_arr[0]['bunglow_overview'];
				$all_bunglow_array[$i]['slug']=$val['slug'];
				$all_bunglow_array[$i]['image']=$image_arr[0]['image'];
				$all_bunglow_array[$i]['caption']=$image_arr[0]['caption'];
				$i++;
			}
		}
		
		//If featured bungalow will be less than 10 then last added bungalow will be in array
		if(count($all_bunglow_array)<10)//Here 10 has been given because at home page there is 10 bungalow listing
		{
			$limit=10-count($all_bunglow_array);
			$this->db->order_by('id', 'desc');
			$array=$this->db->get_where("lb_bunglow", array("type"=>"B","is_active"=>"Y", "is_featured"=>"N"), $limit, 0)->result_array();
			if(count($array)>0)
			{
				foreach($array as $val)
				{
					$peroperty_id=$val['id'];
					$get_details_arr=$this->db->get_where("lb_bunglow_lang", array("bunglow_id"=>$peroperty_id, "language_id"=>$current_lang_id))->result_array();
					//Get bungalow Images
					$this->db->select('*');
					$this->db->from('lb_bunglow_image');
					$this->db->order_by('lb_bunglow_image.id', 'desc');
					$this->db->join('lb_bunglow_image_lang', 'lb_bunglow_image.id = lb_bunglow_image_lang.image_id AND lb_bunglow_image.bunglow_id='.$peroperty_id.' AND lb_bunglow_image.is_active = "Y" AND lb_bunglow_image_lang.language_id='.$current_lang_id);
					$this->db->limit(1);
					$image_arr = $this->db->get()->result_array();
					$all_bunglow_array[$i]['id']=$val['id'];
					$all_bunglow_array[$i]['bunglow_name']=$get_details_arr[0]['bunglow_name'];
					$all_bunglow_array[$i]['bunglow_overview']=$get_details_arr[0]['bunglow_overview'];
					$all_bunglow_array[$i]['slug']=$val['slug'];
					$all_bunglow_array[$i]['image']=$image_arr[0]['image'];
					$all_bunglow_array[$i]['caption']=$image_arr[0]['caption'];
					$i++;
				}
			}
		}
		return $all_bunglow_array;
	}
	
	//###############Function to get latest testimonial in home page###############
	function get_latest_testimonial()
	{
		$this->db->order_by('id', 'desc');
		$result=$this->db->get_where("lb_testimonials", array("status"=>"APPROVED"), 1, 0)->result_array();
		return $result;
	}
	
	//###############Function to get gallery in home page######################
	function get_gallery()
	{
		$current_lang_id=$this->session->userdata("current_lang_id");
		$all_gallery_array=array();
		$this->db->order_by('sort_order', 'asc');
		//Firstly Getting Featured gallery
		$array=$this->db->get_where("lb_gallery", array("is_active"=>"Y", "is_featured"=>"Y"), 3, 0)->result_array();
		$i=0;
		if(count($array)>0)
		{
			foreach($array as $val)
			{
				$gallery_id=$val['id'];
				$get_details_arr=$this->db->get_where("lb_gallery_lang", array("gallery_id"=>$gallery_id, "language_id"=>$current_lang_id))->result_array();
				$all_gallery_array[$i]['id']=$val['id'];
				$all_gallery_array[$i]['title']=$get_details_arr[0]['title'];
				$all_gallery_array[$i]['description']=$get_details_arr[0]['description'];
				$all_gallery_array[$i]['image_file_name']=$val['image_file_name'];
				$all_gallery_array[$i]['is_featured']=$val['is_featured'];
				$all_gallery_array[$i]['is_active']=$val['is_active'];
				$i++;
			}
		}
		
		//If featured bungalow will be less than 10 then last added property will be in array
		if(count($all_gallery_array)<3)//Here 10 has been given because at home page there is 10 bungalow listing
		{
			$limit=3-count($all_gallery_array);
			$this->db->order_by('sort_order', 'asc');
			$array=$this->db->get_where("lb_gallery", array("is_active"=>"Y", "is_featured"=>"N"), $limit, 0)->result_array();
			if(count($array)>0)
			{
				foreach($array as $val)
				{
					$gallery_id=$val['id'];
					$get_details_arr=$this->db->get_where("lb_gallery_lang", array("gallery_id"=>$gallery_id, "language_id"=>$current_lang_id))->result_array();
					$all_gallery_array[$i]['id']=$val['id'];
					$all_gallery_array[$i]['title']=$get_details_arr[0]['title'];
					$all_gallery_array[$i]['description']=$get_details_arr[0]['description'];
					$all_gallery_array[$i]['image_file_name']=$val['image_file_name'];
					$all_gallery_array[$i]['is_featured']=$val['is_featured'];
					$all_gallery_array[$i]['is_active']=$val['is_active'];
					$i++;
				}
			}
		}
		return $all_gallery_array;
	}

	//Function to save newsletter email
	function save_email($email)
	{
		$details=$this->db->get_where("lb_newsletter_email", array("email"=>$email))->result_array();
		if(count($details)>0)
		{
			return "exist";
		}
		else
		{
			$result=$this->db->insert("lb_newsletter_email", array("email"=>$email, "creation_date"=>date("Y-m-d h:i:s")));
		}
	}
	
	
	//Function to get default seo
	function get_default_seo()
	{
		$seo_arr=$this->db->get_where("mast_setting", array("site_setting_id"=>1))->result_array();
		$seo_details=array();
		$seo_details['meta_title']=$seo_arr[0]['meta_title'];
		$seo_details['meta_keyword']=$seo_arr[0]['meta_keyword'];
		$seo_details['meta_description']=$seo_arr[0]['meta_description'];
		return $seo_details;
	}
	
	//function to get bungalow seo details
	function get_bungalow_seo($slug)
	{
		$current_lang_id=$this->session->userdata("current_lang_id");
		$this->db->select('*');
		$this->db->from('lb_bunglow');
		$this->db->where('slug', $slug);
		$details_arr = $this->db->get()->result_array();
		$bungalow_id = $details_arr[0]['id'];
		$seo_arr=$this->db->get_where("lb_bunglow_lang", array("bunglow_id"=>$bungalow_id, "language_id"=>$current_lang_id))->result_array();
		$seo_details=array();
		$seo_details['meta_title']=$seo_arr[0]['meta_title'];
		$seo_details['meta_keyword']=$seo_arr[0]['meta_keyword'];
		$seo_details['meta_description']=$seo_arr[0]['meta_description'];
		return $seo_details;
	}
	
	//function to get static page seo details
	function get_static_page_seo($slug)
	{
		$current_lang_id=$this->session->userdata("current_lang_id");
		$this->db->select('*');
		$this->db->from('lb_pages');
		$this->db->where('pages_slug', $slug);
		$details_arr = $this->db->get()->result_array();
		$pages_id = $details_arr[0]['id'];
		$seo_arr=$this->db->get_where("lb_pages_lang", array("pages_id"=>$pages_id, "language_id"=>$current_lang_id))->result_array();
		$seo_details=array();
		$seo_details['meta_title']=$seo_arr[0]['pages_meta_title'];
		$seo_details['meta_keyword']=$seo_arr[0]['pages_meta_keyword'];
		$seo_details['meta_description']=$seo_arr[0]['pages_meta_description'];
		return $seo_details;
	}
	
	//function to get all featured news and non featured news
	function get_news()
	{
		$current_lang_id=$this->session->userdata("current_lang_id");
		$all_news_array=array();
		//Firstly Getting Featured news
		$this->db->order_by('id', 'desc');
		$array=$this->db->get_where("lb_news", array("is_active"=>"Y", "is_featured"=>"Y"))->result_array();
		if(count($array)>0)
		{
			$i=0;
			foreach($array as $val)
			{
				$news_id=$val['id'];
				$news_details_arr=$this->db->get_where("lb_news_lang", array("news_id"=>$news_id, "language_id"=>$current_lang_id))->result_array();
				$all_news_array[$i]['id']=$val['id'];
				$all_news_array[$i]['slug']=$val['slug'];
				$all_news_array[$i]['title']=$news_details_arr[0]['title'];
				$all_news_array[$i]['content']=$news_details_arr[0]['content'];
				$i++;
			}
		}
		$this->db->order_by('id', 'asc');
		$array=$this->db->get_where("lb_news", array("is_active"=>"Y", "is_featured"=>"N"))->result_array();
		if(count($array)>0)
		{
			foreach($array as $val)
			{
				$news_id=$val['id'];
				$news_details_arr=$this->db->get_where("lb_news_lang", array("news_id"=>$news_id, "language_id"=>$current_lang_id))->result_array();
				$all_news_array[$i]['id']=$val['id'];
				$all_news_array[$i]['slug']=$val['slug'];
				$all_news_array[$i]['title']=$news_details_arr[0]['title'];
				$all_news_array[$i]['content']=$news_details_arr[0]['content'];
				$i++;
			}
		}
		return $all_news_array;
	}
	
	//Function to get news for details page
	function get_news_details($slug)
	{
		$current_lang_id=$this->session->userdata("current_lang_id");
		$all_news_array=array();
		$array=$this->db->get_where("lb_news", array("slug"=>$slug))->result_array();
		$news_id=$array[0]['id'];
		$news_details_arr=$this->db->get_where("lb_news_lang", array("news_id"=>$news_id, "language_id"=>$current_lang_id))->result_array();
		$all_news_array[0]['id']=$array[0]['id'];
		$all_news_array[0]['slug']=$array[0]['slug'];
		$all_news_array[0]['title']=$news_details_arr[0]['title'];
		$all_news_array[0]['content']=$news_details_arr[0]['content'];
		return $all_news_array;
	}
}

?>