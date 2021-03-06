<?php
class home_model extends CI_Model
{
	function  __construct() 
	{
        parent::__construct();
    }
	
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
			array_push($all_years_arr, date('Y')+1); //Add extra one year
		}
		sort($all_years_arr);
		return array_unique($all_years_arr);
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
	// date format 2015-06-05
	function get_bungalows($arrival_date, $leave_date)
	{
		$user_id = 0;
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
				$reservation_array=$this->db->get_where("lb_reservation", array("bunglow_id"=>$bungalow_id, "is_active !="=>'Desactiver',"reservation_status !="=> 'Annulée' ))->result_array();
				$reservation_date_array=array();
				if(count($reservation_array)>0)
				{
					$x=0;
					//echo $arrival_date."@@@".$leave_date;
					//print_r($reservation_array); die;
					foreach($reservation_array as $reservation)
					{
						//Getting all dates between every arrival date and leave date
						$all_days=$this->dateRange($reservation['arrival_date'], $reservation['leave_date']);
						foreach($all_days as $days)
						{
							$options_icon_array=array();
							if($reservation['options_id']!="")
							{
								$options_details=$this->db->query("select * from `lb_bunglow_options` where `id` IN (".$reservation['options_id'].")")->result_array();
								foreach($options_details as $options_images)
								{
									array_push($options_icon_array, $options_images['option_icon']);
								}
							}
							$reservation_date_array[$days]=array();
							$reservation_date_array[$days]['reservation_id']=$reservation['id'];
							$reservation_date_array[$days]['color_code']=$reservation['color_code'];
							$reservation_date_array[$days]['options']=$reservation['options_id'];
							$reservation_date_array[$days]['options_image']=implode(",", $options_icon_array);
							$reservation_date_array[$days]['payment_status']=$reservation['payment_status'];
							$reservation_date_array[$days]['no_of_folding_bed_adult']=$reservation['no_of_folding_bed_adult'];
							$reservation_date_array[$days]['no_of_folding_bed_kid']=$reservation['no_of_folding_bed_kid'];
							$reservation_date_array[$days]['no_of_baby_bed']=$reservation['no_of_baby_bed'];

							
							//if($user_id != $reservation['user_id']){
								$user_id=$reservation['user_id'];
								$user_details=$this->get_user_details($user_id);
								$reservation_date_array[$days]['user_name'] = $user_details[0]["name"];
							//}
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
	
	
	function getActivites($date)
	{
		
		$retour = array();
		
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
				$retour[$i]['bungalow'] = $bungalows;
				$retour[$i]["cleaning"] = false ;
				
				$bungalow_id=$bungalows['bunglow_id'];
				//Getting all reservation for a particular bungalow
				$reservation_array=$this->db->get_where("lb_reservation", array("bunglow_id"=>$bungalow_id, "is_active !="=>'Desactiver',"reservation_status !="=> 'Annulée' ))->result_array();
				$reservation_date_array=array();
				if(count($reservation_array)>0)
				{
					foreach($reservation_array as $reservation)
					{
						$user_id=$reservation['user_id'];
						$user_details=$this->get_user_details($user_id);
						$user_name = $user_details[0]["name"];
						if($reservation['arrival_date']==$date)
						{
							$retour[$i]["arrive"] = $reservation;
							$retour[$i]["arrive"]['user_name'] = $user_name;
						}
						if($reservation['leave_date']==$date)
						{
							$retour[$i]["depart"] = $reservation;
							$retour[$i]["depart"]['user_name'] = $user_name;
						}
					}
				}
				$cleaning_array=$this->db->get_where("lb_bunglow_cleaning", array("bunglow_id"=>$bungalow_id))->result_array();
				$cleaning_date_array=array();
				if(count($cleaning_array)>0)
				{
					$x=0;
					foreach($cleaning_array as $cleaning)
					{
						if($cleaning['cleaning_date']==$date)
						{
							$retour[$i]["cleaning"] = true ;
						}
					}
				}
				$i++;
			}
		}
		
		return $retour;
	}
	
	//Function for getting all dates between two dates
	function dateRange($first_date, $last_date, $step = '+1 day', $format = 'Y-m-d' ) 
	{ 
		$dates = array();
		$current = strtotime($first_date);
		$last = strtotime($last_date);

		while( $current < $last ) 
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
	
	//Get all users
	function get_all_users()
	{
		$this->db->order_by("id", "desc");
		$result=$this->db->get_where("lb_users", array("status"=>"A"))->result_array();
		return $result;
	}
	
	
	//Get name users
	function get_user_name($u_id)
	{ 
		/*$this->db->order_by("id", "desc");
		$result=$this->db->get_where("lb_users", array("id"=>"$u_id", "status"=>"A"))->result_array();
		return $result;*/
	   $result = array();

            $this->db->where('id', $u_id);
			$this->db->where('status', "A");
			$this->db->order_by('id','DESC');
			$query = $this->db->get('lb_users')->result_array();
			
			if(count($query) > 0)
			{
				/*foreach ($query->result() as $row) 
				{
				$result = array(
                                    'name' => $row->name,
                                    'contact_number' => $row->contact_number
									);*/
									$result=$query[0]['name']."^".$query[0]['contact_number'];
       		 
				return $result;
			}
			else
		   {

				return FALSE;
			}

	}
	
	function get_user_name_new($u_id)
	{ 
		/*$user_parts = explode("[", $u_id);
		$u_name = trim($user_parts[0]);
		$u_email = rtrim(trim($user_parts[1]),"]");*/

		/*$this->db->order_by("id", "desc");
		$result=$this->db->get_where("lb_users", array("id"=>"$u_id", "status"=>"A"))->result_array();
		return $result;*/
	   $result = array();
	   		//$u_id = str_replace("%20", " ", $u_id);
            $this->db->where('name', $u_id);
          //  $this->db->where('email', $u_email);
			$this->db->where('status', "A");
			$this->db->order_by('id','DESC');
			$query = $this->db->get('lb_users')->result_array();
			//print_r($query);

			if(count($query) > 0)
			{
				/*foreach ($query->result() as $row) 
				{
				$result = array(
                                    'name' => $row->name,
                                    'contact_number' => $row->contact_number
									);*/
									$result=$query[0]['email']."^".$query[0]['contact_number']."^".$query[0]['id'];
       		 
				return  json_encode($result);
			}
			else
		   {

				return FALSE;
			}

	}
	
	
	//function for getting all registered user
	function get_registered_user()
	{
		$this->db->order_by("id", "desc");
		$result=$this->db->get_where("lb_users", array("status"=>"A", "user_type"=>"R"))->result_array();
		return $result;
	}
	//function for getting all registered user
	function get_all_bunglow()
	{
		$default_language=$this->db->get_where("mast_language", array("set_as_default"=>"Y"))->result_array();
		$default_language_id=$default_language[0]['id'];
		$this->db->select('lb_bunglow.id, lb_bunglow_lang.bunglow_name');
		$this->db->from('lb_bunglow');
		$this->db->join('lb_bunglow_lang', 'lb_bunglow.id = lb_bunglow_lang.bunglow_id AND lb_bunglow_lang.language_id='.$default_language_id);
		$this->db->order_by('lb_bunglow.sort_order','asc');
                $get_details_arr = $this->db->get()->result_array();
		return $get_details_arr;
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
		$options_details_arr=array();
		if($options_ids)
		{
			$this->db->select('*');
			$this->db->from('lb_bunglow_options');
			$this->db->join('lb_bunglow_options_lang', 'lb_bunglow_options.id = lb_bunglow_options_lang.options_id AND lb_bunglow_options.is_active="Y" AND lb_bunglow_options.id IN ('.$options_ids.') AND lb_bunglow_options_lang.language_id='.$default_language_id);
			$options_details_arr=$this->db->get()->result_array();
			return $options_details_arr;
		}
		else 
		{
			return $options_details_arr;
		}
	}
	
	//Generating random color
	function randomColor() 
	{
		$possibilities = array(1, 2, 3, 4, 5, 6, 7, 8, 9, "A", "B", "C", "D", "E", "F" );
		shuffle($possibilities);
		$color = "#";
		for($i=1;$i<=6;$i++)
		{
			$color .= $possibilities[rand(0,14)];
		}
		//check if color exist in reservation table and also check for cleaning color
		$this->db->where('color_code', $color);
		$this->db->or_where('color_code', '#70C4A5'); 
		$color_arr=$this->db->get("lb_reservation")->result_array();
		if(count($color_arr)>0)
		{
			$this->randomColor();
		}
		else 
		{
			return $color;
		}
	} 
	


	//function for add reservation from calendar
	function add_reservation()
	{
		$chk = $this->ajax_check_availability($this->input->post("bungalow_id"),$this->input->post('arrival_date'),$this->input->post('leave_date'));
		//echo $chk; die();
		if($chk == "available"){
			$default_language=$this->db->get_where("mast_language", array("set_as_default"=>"Y"))->result_array();
			$default_language_id=$default_language[0]['id'];
			$currency_arr=$this->db->get_where("lb_currency_master", array("set_as_default"=>"Y"))->result_array();
			$admin_arr=$this->db->get_where("mast_admin_info", array('id'=>1))->result_array();
			$admin_email=$admin_arr[0]['email'];
			$random_color=$this->randomColor();

			if($this->input->post("user_type")=="R")//If user type is registered
			{
				$user_id=$this->input->post("user_id");
				$user_details=$this->db->get_where("lb_users", array("id"=>$user_id))->result_array();				
				$bungalow_id=$this->input->post("bungalow_id");
				$bungalow_details=$this->get_bungalow_details($bungalow_id);
				$name=$this->input->post("reservation_name");
				$contact=$user_details[0]["contact_number"];
				$address=$user_details[0]["address"];
				$email = $user_details[0]["email"];
			}
			else if($this->input->post("user_type")=="U")
			{
				$bungalow_id=$this->input->post("bungalow_id");
				$bungalow_details=$this->get_bungalow_details($bungalow_id);
				$user_language=$this->input->post("user_language");
				$name=$this->input->post("reservation_name");
				$email=$this->input->post("reservation_email");
				$contact=$this->input->post("reservation_contact");
				$address=$this->input->post("reservation_address");
				//insert into user table as unregistered user
				$ins_user_arr=array(
					"user_language"=>$user_language,
					"name"=>$name,
					"address"=>$address,
					"email"=>$email,
					"reg_type"=>"N",
					"contact_number"=>$contact,
					"status"=>"A",
					"creation_date"=>date("Y-m-d H:i:s"),
					"user_type"=>"R"
				);
				$this->db->insert("lb_users", $ins_user_arr);
				$user_id=$this->db->insert_id();
				$user_details=$this->db->get_where("lb_users", array("id"=>$user_id))->result_array();
			}		

			$arrival_date_arr=explode("/",$this->input->post('arrival_date'));
			$arrival_date = mktime(0,0,0, $arrival_date_arr[1], $arrival_date_arr[0], $arrival_date_arr[2] );
			$leave_date_arr=explode("/", $this->input->post('leave_date'));
			$leave_date=mktime(0,0,0, $leave_date_arr[1], $leave_date_arr[0], $leave_date_arr[2] );
			$date_arr=$this->dateRanges($arrival_date, $leave_date);
			$days_count=count($date_arr) - 1;
			//$days_count=count($date_arr);


			$arrival_date_new_format=$arrival_date_arr[2]."-".$arrival_date_arr[1]."-".$arrival_date_arr[0];
			$leave_date_new_format=$leave_date_arr[2]."-".$leave_date_arr[1]."-".$leave_date_arr[0];
			$diff = ceil(abs($leave_date - $arrival_date) / 86400); 
			$text=$this->input->post("reservation_text");
			$invoice_number=$this->get_unique_invoice_number();
			

			$q_val = explode("/",$this->input->post('arrival_date'));		 
			$season_id = $this->getSeasons($q_val[0],$q_val[1],$q_val[2]);

			$rate_details_arr=$this->db->get_where("lb_bunglow_rates", array("bunglow_id"=>$bungalow_id, "season_id"=>$season_id))->result_array();
			$total_bungalow_rate=$rate_details_arr[0]['rate_per_day_euro']*$diff; //Multiplying with total days of staying
			$total_bungalow_rate_dollar=$rate_details_arr[0]['rate_per_day_dollar']*$diff;
			$discount=$rate_details_arr[0]['discount_per_night']; //discount in %
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

			$get_tax_id=$this->db->get_where("lb_bunglow", array("id"=>$this->input->post('bungalow_id')))->result_array();
			
			//$stay_euro = 0;
			//if( $days_count > 6 ){
			//	$stay_euro = $days_count * $rate_details_arr[0]['extranight_perday_europrice'];
			//}else {
			//		$stay_euro = $rate_details_arr[0]['rate_per_day_euro'] * $days_count;
			//}
			
			$CI = &get_instance();
			$CI->load->model('reservation_model');

			$result_resa=$CI->reservation_model->get_bungalows_price($this->input->post('bungalow_id'), $this->input->post('arrival_date'), $this->input->post('leave_date'));
			$stay_euro = $result_resa['stay_euro'];
	
			
			$val1 = $val2 = $val3 = $val4 = $val5 = $val6 = $val7 = 0;
			
			$val1 = ($this->input->post('no_of_adult') != "--Sélectionner--") ? $this->input->post('no_of_adult') :"0";
			$val2 = ($this->input->post('no_of_extra_real_adult') != "--Sélectionner--") ?$this->input->post('no_of_extra_real_adult') :"0";
			$val3 = ($this->input->post('no_of_extra_adult') != "--Sélectionner--") ?$this->input->post('no_of_extra_adult') :"0";
			$val4 = ($this->input->post('no_of_extra_kid') != "--Sélectionner--") ?$this->input->post('no_of_extra_kid') :"0";
			$val5 = ($this->input->post('no_of_folding_bed_kid') != "--Sélectionner--") ?$this->input->post('no_of_folding_bed_kid') :"0";
			$val6 = ($this->input->post('no_of_folding_bed_adult') != "--Sélectionner--") ?$this->input->post('no_of_folding_bed_adult') :"0";
			$val7 = ($this->input->post('no_of_baby_bed') != "--Sélectionner--") ?$this->input->post('no_of_baby_bed') :"0";

		 	$total = ($val2 * 15 * $days_count) + ($val3 * 15 * $days_count) + ($val6 * 15 * $days_count) + $stay_euro;

		 	$disc = ($this->input->post('reservation_discount') != "") ? $this->input->post('reservation_discount') : "0";

		 	if($disc != "0") $total = $total - ($total * $disc/100);
		 	
			$final_amount = $total + (($total) * 4/100); 

			$taxes=$get_tax_id[0]['tax_id'];

			$ins_arr=array(
				"user_id"=>$user_id,
				"name"=>$name,
				"phone"=>$contact,
				"email"=>$email,
				"bunglow_id"=>$bungalow_id,
				"options_id"=>$options_ids,
				"options_rate"=>$options_rates,
				"options_rate_dollar"=>$options_rates_dollar,
				"tax_id"=>$taxes_ids,
				"tax_id"=>$taxes_ids,
				"tax_rate"=>$taxes_rate,
				//"bunglow_per_day"=>$rate_details_arr[0]['rate_per_day_euro'],
				//"bunglow_per_day_dollar"=>$rate_details_arr[0]['rate_per_day_dollar'],
				"discount"=>$disc,
				"reservation_date"=>date("Y-m-d H:i:s"),
				"arrival_date"=>$arrival_date_new_format,
				"leave_date"=>$leave_date_new_format,
				"comment"=>$text,
				"comments"=>$text,
				"reservation_status"=>"En Attente",
				"payment_mode"=>"ONARRIVAL",
				"amount_to_be_paid"=>$final_amount,
				"paid_amount"=>0,
				"due_amount"=>$final_amount,
				"invoice_number"=>$invoice_number,
				"payment_status"=>"En Attente",
				"is_active"=>"Activer",
				"color_code"=>$random_color,
				"source"=>$this->input->post('source'),
				"admin_comments"=>nl2br($this->input->post('admin_comments')),
				"invoice_comments"=>nl2br($this->input->post('invoice_comments')),
				"no_of_adult" => $val1,
				"no_of_extra_real_adult" => $val2,
				"no_of_extra_adult" => $val3,
				"no_of_extra_kid" => $val4,
				"no_of_folding_bed_kid" => $val5,
				"no_of_folding_bed_adult" => $val6,
				"no_of_baby_bed" => $val7,
				"created_by" => $this->session->userdata('user_id'),
				"parent_id" => $this->input->post('parent_id')
			);
			$this->db->insert("lb_reservation", $ins_arr);
			$id = $this->db->insert_id();	
			if($this->input->post('parent_id') == '' && $this->session->userdata('last_reservation_id') == ''){
				$this->session->set_userdata("last_reservation_id", $id);
				$this->session->set_userdata("user_idd", $user_id);
				$this->session->set_userdata("name", $name);
				$this->session->set_userdata("phone", $contact);
				$this->session->set_userdata("email", $email);
				$this->session->set_userdata("address", $address);
				$this->session->set_userdata("cat_type", $this->get_bungalow_catergory_type($bungalow_id));
				$this->session->set_userdata("max_person", $this->get_bungalow_max_personbyID($bungalow_id));

			}
			
			//if user belongs to french then email text will be in french otherwise in english
			/*if($user_details[0]['user_language']==1)
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
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Tax:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">4%</td>
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
			}*/
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
	
	//Function for getting reservation details
	function get_linked_reservations($reservation_id)
	{
		$result = array();
		$results_array=$this->db->get_where("lb_reservation", array("parent_id"=>$reservation_id))->result_array();
		//print_r($results_array);
		if(count($results_array) > 0){
			for($i=0;$i<count($results_array);$i++){
				$bungalow_details=$this->get_bungalow_details($results_array[$i]["bunglow_id"]);
				$bungalow_name_part = explode("<span>", $bungalow_details[0]["bunglow_name"]);
				$bunglow_name = $bungalow_name_part[0];
				
				if($results_array[$i]["reservation_status"]!="Annulée")
				{
					$result[] = array(
								"id" => $results_array[$i]["id"],
								"arrival_date" => $results_array[$i]["arrival_date"],
								"leave_date" => $results_array[$i]["leave_date"],
								"bunglow_name" => $bunglow_name
					);		
				}
			}
		}else{
			$results_array2=$this->db->get_where("lb_reservation", array("id"=>$reservation_id))->result_array();
			$results_array1=$this->db->get_where("lb_reservation", array("id"=>$results_array2[0]["parent_id"]))->result_array();
			if(count($results_array1) > 0){
				$bungalow_details1=$this->get_bungalow_details($results_array1[0]["bunglow_id"]);
				$bungalow_name_part1 = explode("<span>", $bungalow_details1[0]["bunglow_name"]);
				$bunglow_name1 = $bungalow_name_part1[0];
				
				if($results_array1[0]["reservation_status"]!="Annulée")
				{
					$result[] = array(
									"id" => $results_array1[0]["id"],
									"arrival_date" => $results_array1[0]["arrival_date"],
									"leave_date" => $results_array1[0]["leave_date"],
									"bunglow_name" => $bunglow_name1
					);	
				}

				$presults_array=$this->db->get_where("lb_reservation", array("parent_id"=>$results_array2[0]["parent_id"], "id !=" =>$reservation_id))->result_array();
				//print_r($results_array);
				if(count($presults_array) > 0){
					for($i=0;$i<count($presults_array);$i++){
						$pbungalow_details=$this->get_bungalow_details($presults_array[$i]["bunglow_id"]);
						$pbungalow_name_part = explode("<span>", $pbungalow_details[0]["bunglow_name"]);
						$pbunglow_name = $pbungalow_name_part[0];
						
						if($presults_array[$i]["reservation_status"]!="Annulée")
						{
		
							$result[] = array(
											"id" => $presults_array[$i]["id"],
											"arrival_date" => $presults_array[$i]["arrival_date"],
											"leave_date" => $presults_array[$i]["leave_date"],
											"bunglow_name" => $pbunglow_name
							);	
						}
					}
				}
			}
		}
		//print_r($result); 
		return $result;
	}
	
	//function for editing reservation
	function edit_reservation()
	{
		//echo "aaaa"; die;
		$default_language=$this->db->get_where("mast_language", array("set_as_default"=>"Y"))->result_array();
		$default_language_id=$default_language[0]['id'];
		$currency_arr=$this->db->get_where("lb_currency_master", array("set_as_default"=>"Y"))->result_array();
		$admin_arr=$this->db->get_where("mast_admin_info", array('id'=>1))->result_array();
		$admin_email=$admin_arr[0]['email'];

		$user_id=$this->input->post("user_id");
		$user_details=$this->db->get_where("lb_users", array("id"=>$user_id))->result_array();
		$bungalow_id=$this->input->post("bungalow_id");
		$cur_bungalow_id=$this->input->post("cur_bungalow_id");
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


		$arrival_dates = mktime(0,0,0, $arrival_date_arr[1], $arrival_date_arr[0], $arrival_date_arr[2] );
		$leave_dates =mktime(0,0,0, $leave_date_arr[1], $leave_date_arr[0], $leave_date_arr[2] );
		$date_arr=$this->dateRanges($arrival_dates, $leave_dates);
		$days_count=count($date_arr) - 1;
		//$days_count=count($date_arr);
		
		//Getting Bungalow Rate
		$q_val = explode("/",$this->input->post("arrival_date"));	
		$season_id = $this->getSeasons($q_val[0],$q_val[1],$q_val[2]);

		$q_val1 = explode("/",$this->input->post("leave_date"));		 
		$another_season_id = $this->getSeasons($q_val1[0],$q_val1[1],$q_val1[2]);

		$rate_details_arr=$this->db->get_where("lb_bunglow_rates", array("bunglow_id"=>$bungalow_id, "season_id"=>$season_id))->result_array();
		$total_bungalow_rate=$rate_details_arr[0]['rate_per_day_euro']*$diff; //Multiplying with total days of staying
		$total_bungalow_rate_dollar=$rate_details_arr[0]['rate_per_day_dollar']*$diff;
		//$discount=$rate_details_arr[0]['discount']; //discount in %
		$discount = $this->input->post("reservation_discount");

		//Calculating options rate
		$options_rate_euro=array();
		$options_rate_dollar=array();
		$options_text_for_mail="";
		$total_options_rate=0; //By default currency is euro so that calculation will be in euro
		$x=0;
		/*if($this->input->post("options_id"))
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
		}*/
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

		$get_tax_id=$this->db->get_where("lb_bunglow", array("id"=>$this->input->post('bungalow_id')))->result_array();
		$stay_euro = 0;

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

			//echo "Arrival Date: ".$arrival_date1.", Leave Date: ".$leave_date1.". No. of high days: ".$high_days.". No. of low days: ".$low_days.", Price: ".$stay_euro."<br/>";
			
		}else{

			//Get rate details with season id and bungalow_id
			$rate_details_arr=$this->db->get_where("lb_bunglow_rates", array("bunglow_id"=>$bungalow_id, "season_id"=>$season_id))->result_array();

			if( $days_count > 6 ){
				$stay_euro = $days_count * $rate_details_arr[0]['extranight_perday_europrice'];
			}else {
				$stay_euro = $rate_details_arr[0]['rate_per_day_euro'] * $days_count;
			}
			//echo $stay_euro."@@@";
		}	

		$val1 = $val2 = $val3 = $val4 = $val5 = $val6 = $val7 = 0;

		$val1 = (int)($this->input->post('no_of_adult'));
		$val2 = (int)($this->input->post('no_of_extra_real_adult') != "") ?$this->input->post('no_of_extra_real_adult') :"0";
		$val3 = (int)($this->input->post('no_of_extra_adult') != "") ?$this->input->post('no_of_extra_adult') :"0";
		$val4 = (int)($this->input->post('no_of_extra_kid') != "") ?$this->input->post('no_of_extra_kid') :"0";
		$val5 = (int)($this->input->post('no_of_folding_bed_kid') != "") ?$this->input->post('no_of_folding_bed_kid') :"0";
		$val6 = (int)($this->input->post('no_of_folding_bed_adult') != "") ?$this->input->post('no_of_folding_bed_adult') :"0";
		$val7 = (int)($this->input->post('no_of_baby_bed') != "") ?$this->input->post('no_of_baby_bed') :"0";

		$paid = (int)($this->input->post('txt_amount_paid') != "") ?$this->input->post('txt_amount_paid') :"0";
		$paid +=  (int)($this->input->post('hid_paid_amount') );
	 	$total = ($val2 * 15 * $days_count) + ($val3 * 15 * $days_count) + ($val6 * 15 * $days_count);
		$due_amount = ($total + $stay_euro + (($total + $stay_euro) * 4/100)) - $paid; 
		$final_amount = ($total + $stay_euro + (($total + $stay_euro) * 4/100)); 

		$reservation_status = $this->input->post("sel_resrevation_status");
		$payment_status = $this->input->post("sel_pending_status");
		if($due_amount == "0"){
			$reservation_status = "Confirmé";
			$payment_status = "Réglé";
		}
//echo $total."=".$final_amount;
		$taxes=$get_tax_id[0]['tax_id'];

		if( $this->input->post('no_of_adult') != 0){
			$upd_arr=array(
				"user_id"=>$user_id,
				"name"=>$name,
				"phone"=>$contact,
				"email"=>$user_details[0]['email'],
				"bunglow_id"=>$bungalow_id,
				"options_id"=>$options_ids,
				"options_rate"=>$options_rates,
				"options_rate_dollar"=>$options_rates_dollar,
				"tax_id"=>$taxes_ids,
				"tax_id"=>$taxes_ids,
				"tax_rate"=>$taxes_rate,
				//"bunglow_per_day"=>$rate_details_arr[0]['rate_per_day_euro'],
				//"bunglow_per_day_dollar"=>$rate_details_arr[0]['rate_per_day_dollar'],
				"discount"=>$discount,
				"arrival_date"=>$arrival_date_new_format,
				"leave_date"=>$leave_date_new_format,
				"comment"=>$text,
				"comments"=>$text,
				"amount_to_be_paid"=>$final_amount,
				"paid_amount"=>$paid,
				"due_amount"=>$due_amount,
				"source"=>$this->input->post('source'),
				//"invoice_comments"=>nl2br($this->input->post('invoice_comments')),
                                "invoice_comments"=>nl2br($this->input->post('txt_comments')),
				"admin_comments"=>nl2br($this->input->post('admin_comments')),
				"reservation_status" => $reservation_status,
				"payment_status" => $payment_status,
				"comments" =>nl2br($this->input->post("txt_comments")),
				"no_of_adult" => $this->input->post('no_of_adult'),
				"no_of_extra_real_adult" => $this->input->post('no_of_extra_real_adult'),
				"no_of_extra_adult" => $this->input->post('no_of_extra_adult'),
				"no_of_extra_kid" => $this->input->post('no_of_extra_kid'),
				"no_of_folding_bed_kid" => $this->input->post('no_of_folding_bed_kid'),
				"no_of_folding_bed_adult" => $this->input->post('no_of_folding_bed_adult'),
				"no_of_baby_bed" => $this->input->post('no_of_baby_bed'),			
				"payment_mode" => $this->input->post('payment_mode'),
				"date_payment_mode" => $this->input->post('search_arrival_date_p'),
				"created_by" => $this->session->userdata('user_id')
			);
		}
		else{
			$upd_arr=array(
				"user_id"=>$user_id,
				"name"=>$name,
				"phone"=>$contact,
				"email"=>$user_details[0]['email'],
				"bunglow_id"=>$bungalow_id,
				"options_id"=>$options_ids,
				"options_rate"=>$options_rates,
				"options_rate_dollar"=>$options_rates_dollar,
				"tax_id"=>$taxes_ids,
				"tax_id"=>$taxes_ids,
				"tax_rate"=>$taxes_rate,
				//"bunglow_per_day"=>$rate_details_arr[0]['rate_per_day_euro'],
				//"bunglow_per_day_dollar"=>$rate_details_arr[0]['rate_per_day_dollar'],
				"discount"=>$discount,
				"arrival_date"=>$arrival_date_new_format,
				"leave_date"=>$leave_date_new_format,
				"comment"=>$text,
				"comments"=>$text,
				"amount_to_be_paid"=>$final_amount,
				"paid_amount"=>$paid,
				"due_amount"=>$due_amount,
				"source"=>$this->input->post('source'),
				"invoice_comments"=>nl2br($this->input->post('txt_comments')),
				"admin_comments"=>nl2br($this->input->post('admin_comments')),
				"reservation_status" => $reservation_status,
				"payment_status" => $payment_status,
				"comments" =>nl2br($this->input->post("txt_comments")),
				"payment_mode" => $this->input->post('payment_mode'),
				"date_payment_mode" => $this->input->post('search_arrival_date_p'),
				"created_by" => $this->session->userdata('user_id')
			);
		}
		//yrcode
		if($cur_bungalow_id==$bungalow_id)
			$chk="available";
		else	
			$chk = $this->ajax_check_availability($bungalow_id,strtotime($arrival_date_new_format),strtotime($leave_date_new_format)-(60*60*24));
			
		if($chk == "available")
		{
			echo "available";
			$this->db->update("lb_reservation", $upd_arr, array("id"=>$reservation_id));
		}
		else
		{
			return "notavailable";
		}
		//end yrcode
		//print_r($upd_arr); die;
		//$this->db->update("lb_reservation", $upd_arr, array("id"=>$reservation_id));

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
					';
					if($discount > 0){
						$msg_text2.='
						<tr  bgcolor="#f5e8c8">
							<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Discount:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$discount.'%</td>
						</tr>';
					}
					$msg_text2.='
					<tr>
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Tax: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">4%</td>
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
					</tr>';
					if($discount > 0){
						$msg_text2.='
					<tr  bgcolor="#f5e8c8">
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Réduction:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$discount.'%</td>
					</tr>';
				}
				$msg_text2.='
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
					';
					if($discount > 0){
						$msg_text2.='
					<tr  bgcolor="#f5e8c8">
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Discount:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$discount.'%</td>
					</tr>';
				}
				$msg_text2.='
					<tr>
						<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Tax: </b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">4%</td>
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
					</tr>';
					if($discount > 0){
						$msg_text2.='
						<tr  bgcolor="#f5e8c8">
							<td style="border-top:1px solid #C9AD64; padding:5px;"><b>Réduction:</b></td><td style="border-top:1px solid #C9AD64; padding:5px; border-left:1px solid #C9AD64;">'.$discount.'%</td>
						</tr>';
					}
					$msg_text2.='
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
		$reservation_list=$this->db->order_by("id", "desc")->get("lb_reservation",10)->result_array();
		$latest_reservation_arr=array();
		$i = 0;
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
				$options_arr=array();
				if($reservation_details[0]['options_id']!="")
				{
					$options_details=$this->db->query("SELECT * FROM `lb_bunglow_options_lang` WHERE `options_id` IN (".$reservation_details[0]['options_id'].") AND `language_id`='$default_langugage_id'")->result_array();
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
				$latest_reservation_arr[$i]['reservation_date']=date("d/m/Y H:i:s", strtotime($reservation_details[0]['reservation_date']));
				$latest_reservation_arr[$i]['arrival_date']=date("d/m/Y", strtotime($reservation_details[0]['arrival_date']));
				$latest_reservation_arr[$i]['leave_date']=date("d/m/Y", strtotime($reservation_details[0]['leave_date']));	
				$latest_reservation_arr[$i]['bungalow_name']=$bungalow_details[0]['bunglow_name'];	
				$latest_reservation_arr[$i]['options']=$options_text;
				$latest_reservation_arr[$i]['payment_status']=$reservation_details[0]['is_active'];
				$latest_reservation_arr[$i]['source']=$reservation_details[0]['source'];
				$i++;
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
	
	function shuffle_assoc($list) { 
	  if (!is_array($list)) return $list; 

	  $keys = array_keys($list); 
	  shuffle($keys); 
	  $random = array(); 
	  $i=0;
	  foreach ($keys as $key) { 
	  	if($i < 10){  $random[$key] = $list[$key]; }
	  	$i++;
	  }
	  return $random; 
	} 
	
	//###############Function to get bungalow listing in home page###############
	function get_bungalow()
	{
		$current_lang_id=$this->session->userdata("current_lang_id");
		$all_bunglow_array=array();
		//$this->db->order_by('id', 'desc');
		//Firstly Getting Featured bungalow
		$array=$this->db->get_where("lb_bunglow", array("type"=>"B","is_active"=>"Y", "is_featured"=>"Y"))->result_array();
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
			$array=$this->db->get_where("lb_bunglow", array("type"=>"B","is_active"=>"Y", "is_featured"=>"N"))->result_array();
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
		$all_bunglow_array1 = $this->shuffle_assoc($all_bunglow_array);
		return $all_bunglow_array1;
	}
	
	//###############Function to get latest testimonial in home page###############
	function get_latest_testimonial()
	{
		$this->db->order_by('id', 'desc');
		$result=$this->db->get_where("lb_testimonials_lang", array("status"=>"APPROVED"), 1, 0)->result_array();
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
			$result=$this->db->insert("lb_newsletter_email", array("email"=>$email, "creation_date"=>date("Y-m-d H:i:s")));
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


		
	//Function to get bungalow_details by slug
	function get_bungalow_max_personbyID($id)
	{
		$query=$this->db->get_where("lb_bunglow", array("id"=>$id));
		if($query->num_rows()){
		   $bungalow_person = $query->result_array();
		   return $bungalow_person[0]['max_person'];
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

	//Function for getting all dates between two dates
	function dateRanges($first_date, $last_date, $step = '+1 day', $format = 'Y-m-d' ) 
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

	//function to check availability via ajax
	function ajax_check_availability($bungalow_id, $arrival_date, $leave_date)
	{
		$date_arr=$this->dateRanges($arrival_date, $leave_date);
		$total_days=count($date_arr);

		$available_date=array();
		
		foreach($date_arr as $date)
			{
				//echo "SELECT * FROM `lb_reservation` WHERE `bunglow_id` = '$bungalow_id' AND (`arrival_date` <= '$date' AND `leave_date` >= '$date') AND `is_active`!='Desactiver' AND `reservation_status` != 'Annulé'"; 
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
	} 
	
}

?>