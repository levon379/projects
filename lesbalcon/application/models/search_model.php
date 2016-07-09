<?php
class search_model extends CI_Model{
	
	function  __construct(){
        parent::__construct();
    }
	
	//function to get property or bungalow by searching
	function desktop_search_process(){
		$current_lang_id		= $this->session->userdata("current_lang_id");
		$person_no				= $this->input->post("search_keyword");
		$posted_arrival_date	= $this->input->post("search_arrival_date");
		$posted_leave_date		= $this->input->post("search_leave_date");
		$properties_arr			= array();
		$available_array		= array();
		
		//If Keyword is blank but dates are not blank
		if($person_no=="" && $posted_arrival_date!="" && $posted_leave_date!=""){
			//Getting arrival date in php format
			$arrival_date_arr	= explode("/", $posted_arrival_date);
			$arrival_date		= $arrival_date_arr[2] ."-".$arrival_date_arr[1]."-".$arrival_date_arr[0];
			
			//Getting leave date in php format
			$leave_date_arr		= explode("/", $posted_leave_date);
			$leave_date			= $leave_date_arr[2]."-".$leave_date_arr[1]."-".$leave_date_arr[0];

			$date_arr		= $this->dateRange($arrival_date, $leave_date);
			$total_days		= count($date_arr)-1; 
			
			if(in_array($arrival_date_arr[1], array(5,6,7,8,9,10,11,12))){
				$season_date_start	= strtotime($arrival_date_arr[2] ."-12-15");
				$season_date_end	= strtotime($arrival_date_arr[2]+1 ."-04-14");
			}else{ 
				$season_date_start	= strtotime($arrival_date_arr[2]-1 ."-12-15");
				$season_date_end	= strtotime($arrival_date_arr[2] ."-04-14");
			} 
			$booking_arrival_date	= strtotime($arrival_date);
			$booking_leave_date		= strtotime($leave_date);
			
			//echo "total_days=". $total_days ."<br />season_date_start=". $season_date_start  ."<br />season_date_end=". $season_date_end ."<br />arrival_date=". $arrival_date ."<br />leave_date=". $leave_date ; die;
			
			if((($booking_arrival_date >= $season_date_start) and ($booking_arrival_date <= $season_date_end)) || (($booking_arrival_date <= $season_date_start) and ($booking_leave_date >= $season_date_start)) || (($booking_arrival_date >= $season_date_start) and ($booking_arrival_date <= $season_date_end) and ($booking_leave_date >= $season_date_start) and ($booking_leave_date <= $season_date_end)) and ($total_days < 3)){
				$msg['msg'] = 3;
				return $msg;
			}elseif($total_days < 2){
				$msg['msg'] = 2;
				return $msg;
			}
			
			$where = '';
			if($total_days < 5){
				$where = ' AND lb_bunglow.slug NOT IN ("bungalow5-with-extralargeterrace-us-tv", "bungalow-with-extra-large-terrace-upper-level-1", "bungalow21-suite-with-separated-bedroom-and-xtra-large-terrace", "bungalow23-suite-with-2-separated-bedrooms-terrace-jacuzzi", "sweety-cottage")';
			} 
			
			$this->db->from('lb_bunglow');
			$this->db->join('lb_bunglow_lang', 'lb_bunglow.id = lb_bunglow_lang.bunglow_id AND lb_bunglow.is_active="Y" AND lb_bunglow_lang.language_id='.$current_lang_id .' '. $where );
			$search_arr = $this->db->get()->result_array();
			$i=0;
			//print_r($search_arr);
			foreach($search_arr as $search){
				$bungalow_id	= $search['bunglow_id']; 
				//echo $total_days=($total_days1-1);
				$available_date	= array();
				
				foreach($date_arr as $date){
					$check_query=$this->db->query("SELECT * FROM `lb_reservation` WHERE `bunglow_id` = '$bungalow_id' AND (`arrival_date` < '$date' AND `leave_date` > '$date') AND `is_active`!='Desactiver' AND `reservation_status` != 'Annulée'")->result_array();
					//If date is not reserved
					if(count($check_query)==0){
						$check_cleaning=$this->db->query("SELECT * FROM `lb_bunglow_cleaning` WHERE `bunglow_id`='$bungalow_id' AND `cleaning_date`='$date'")->result_array();
						if(count($check_cleaning)==0){
							//Check if date is reserved for cleaning
							$date_format_arr=explode("-", $date); //date format is yyyy-mm-dd. so change it to dd/mm/yyyy
							$new_date_format=$date_format_arr[2]."/".$date_format_arr[1]."/".$date_format_arr[0];
							array_push($available_date, $new_date_format);
						}
					}
				}
				//print_r($available_date); echo $total_days."aaaa"; die;
				//If User selected dates are not reserved
				if(count($available_date)==$total_days){
					$search_arr[$i]['availability']="available";
					array_push($available_array, $search_arr[$i]);
				}elseif(count($available_date)==0){ //If No available
					$search_arr[$i]['availability']="notavailable";
					array_push($available_array, $search_arr[$i]);
				}else{
					$search_arr[$i]['availability']=implode(", ", $available_date); //Implode the available dates
					array_push($available_array, $search_arr[$i]);
				} 
				
				foreach($available_array as $value){
					$peroperty_id	= $value['bunglow_id'];
					//Get bungalow Images
					$this->db->select('*');
					$this->db->from('lb_bunglow_image');
					$this->db->order_by('lb_bunglow_image.id', 'desc');
					$this->db->join('lb_bunglow_image_lang', 'lb_bunglow_image.id = lb_bunglow_image_lang.image_id AND lb_bunglow_image.bunglow_id='.$peroperty_id.' AND lb_bunglow_image.is_active = "Y" AND lb_bunglow_image_lang.language_id='.$current_lang_id);
					$this->db->limit(1);
					
					$image_arr 		= $this->db->get()->result_array();
					$currency_arr	= $this->db->get_where("lb_currency_master", array("set_as_default"=>"Y"))->result_array();
					$season_arr		= $this->db->get_where("lb_season")->result_array();
					$j				= 0;
					
					foreach($season_arr as $season){
						$j					= $season['id']; //We are indexing bunglow_rates array with season id
						$seasons_rate_arr 	= $this->db->get_where("lb_bunglow_rates", array("bunglow_id"=>$peroperty_id, "season_id"=>$season['id']))->result_array();
						
						if($seasons_rate_arr){
							$properties_arr[$i]['bunglow_rates'][$j]['rate_per_day_euro'] 				= $seasons_rate_arr[0]['rate_per_day_euro'];
							$properties_arr[$i]['bunglow_rates'][$j]['rate_per_day_dollar']				= $seasons_rate_arr[0]['rate_per_day_dollar'];
							$properties_arr[$i]['bunglow_rates'][$j]['rate_per_week_euro']				= $seasons_rate_arr[0]['rate_per_week_euro'];
							$properties_arr[$i]['bunglow_rates'][$j]['rate_per_week_dollar']			= $seasons_rate_arr[0]['rate_per_week_dollar'];
							$properties_arr[$i]['bunglow_rates'][$j]['extranight_perday_europrice']		= $seasons_rate_arr[0]['extranight_perday_europrice'];
							$properties_arr[$i]['bunglow_rates'][$j]['extranight_perday_dollerprice']	= $seasons_rate_arr[0]['extranight_perday_dollerprice'];
							$properties_arr[$i]['bunglow_rates'][$j]['discount_night']					= $seasons_rate_arr[0]['discount_night'];
							$properties_arr[$i]['bunglow_rates'][$j]['discount_week']					= $seasons_rate_arr[0]['discount_week'];
						}else{
							$properties_arr[$i]['bunglow_rates'][$j]['rate_per_day_euro']				= "N/A";
							$properties_arr[$i]['bunglow_rates'][$j]['rate_per_day_dollar']				= "N/A";
							$properties_arr[$i]['bunglow_rates'][$j]['rate_per_week_euro']				= "N/A";
							$properties_arr[$i]['bunglow_rates'][$j]['rate_per_week_dollar']			= "N/A";
							$properties_arr[$i]['bunglow_rates'][$j]['discount_night']					= "N/A";
							$properties_arr[$i]['bunglow_rates'][$j]['discount_week']					= "N/A";
						}
					}
					
					$j++;
					$properties_arr[$i]['id']				= $peroperty_id;
					$properties_arr[$i]['bunglow_name']		= $value['bunglow_name'];
					$properties_arr[$i]['max_person']		= $value['max_person'];
					$properties_arr[$i]['person_no_search']	= $person_no;
					$properties_arr[$i]['bunglow_overview']	= $value['bunglow_overview'];
					$properties_arr[$i]['slug']				= $value['slug'];
					$properties_arr[$i]['image']			= $image_arr[0]['image'];
					$properties_arr[$i]['caption']			= $image_arr[0]['caption'];
					$properties_arr[$i]['availability']		= $value['availability'];
					$properties_arr[$i]['total_days']		= $total_days;
					$properties_arr[$i]['arrival_date']		= $posted_arrival_date;
					$properties_arr[$i]['date_arr']			= $date_arr[0];
					$properties_arr[$i]['leave_date']		= $posted_leave_date;
					$properties_arr[$i]['date_arr1']		= $date_arr[1];
					$properties_arr[$i]['currency_symbol']	= $currency_arr[0]['currency_symbol'];
					$properties_arr[$i]['currency_code']	= $currency_arr[0]['currency_code'];
					$properties_arr[$i]['type']				= $value['type'];
				}
				
				if($properties_arr[$i]['availability'] == 'notavailable'){ 
					unset($properties_arr[$i]);
				}
				
				$i++;
			}
		}
		elseif($person_no!="" && $posted_arrival_date=="" && $posted_leave_date=="" ){ //If Keyword is not blank but dates are blank
			
			$this->db->from('lb_bunglow');
			$this->db->join('lb_bunglow_lang', 'lb_bunglow.id = lb_bunglow_lang.bunglow_id AND lb_bunglow.max_person >='.$person_no.' AND lb_bunglow.is_active="Y" AND lb_bunglow_lang.language_id='.$current_lang_id);
			$search_arr 		= $this->db->get()->result_array();
			$available_array	= $search_arr;
			$i					= 0;
			
			foreach($available_array as $value){
				$peroperty_id	= $value['bunglow_id']; 
				$this->db->select('*');
				$this->db->from('lb_bunglow_image');
				$this->db->order_by('lb_bunglow_image.id', 'desc');
				$this->db->join('lb_bunglow_image_lang', 'lb_bunglow_image.id = lb_bunglow_image_lang.image_id AND lb_bunglow_image.bunglow_id='.$peroperty_id.' AND lb_bunglow_image.is_active = "Y" AND lb_bunglow_image_lang.language_id='.$current_lang_id);
				$this->db->limit(1);
				
				$image_arr 		= $this->db->get()->result_array();
                $currency_arr	= $this->db->get_where("lb_currency_master", array("set_as_default"=>"Y"))->result_array();
                $season_arr		= $this->db->get_where("lb_season")->result_array();
				$j=0;
				
				foreach($season_arr as $season){
					$j=$season['id']; //We are indexing bunglow_rates array with season id
					$seasons_rate_arr = $this->db->get_where("lb_bunglow_rates", array("bunglow_id"=>$peroperty_id, "season_id"=>$season['id']))->result_array();
					
					//$seasons_rate_arr=$this->db->get_where("lb_bunglow_rates", array("bunglow_id"=>$bunglow_id['bunglow_id'], "season_id"=>$season['id']))->result_array();
					if($seasons_rate_arr){
						$properties_arr[$i]['bunglow_rates'][$j]['rate_per_day_euro']				= $seasons_rate_arr[0]['rate_per_day_euro'];
						$properties_arr[$i]['bunglow_rates'][$j]['rate_per_day_dollar']				= $seasons_rate_arr[0]['rate_per_day_dollar'];
						$properties_arr[$i]['bunglow_rates'][$j]['extranight_perday_europrice']		= $seasons_rate_arr[0]['extranight_perday_europrice'];
						$properties_arr[$i]['bunglow_rates'][$j]['extranight_perday_dollerprice']	= $seasons_rate_arr[0]['extranight_perday_dollerprice'];
						$properties_arr[$i]['bunglow_rates'][$j]['rate_per_week_euro']				= $seasons_rate_arr[0]['rate_per_week_euro'];
						$properties_arr[$i]['bunglow_rates'][$j]['rate_per_week_dollar']			= $seasons_rate_arr[0]['rate_per_week_dollar'];
						$properties_arr[$i]['bunglow_rates'][$j]['discount_night']					= $seasons_rate_arr[0]['discount_night'];
						$properties_arr[$i]['bunglow_rates'][$j]['discount_week']					= $seasons_rate_arr[0]['discount_week'];
					}else{
						$properties_arr[$i]['bunglow_rates'][$j]['rate_per_day_euro']				= "N/A";
						$properties_arr[$i]['bunglow_rates'][$j]['rate_per_day_dollar']				= "N/A";
						$properties_arr[$i]['bunglow_rates'][$j]['rate_per_week_euro']				= "N/A";
						$properties_arr[$i]['bunglow_rates'][$j]['rate_per_week_dollar']			= "N/A";
						$properties_arr[$i]['bunglow_rates'][$j]['discount_night']					= "N/A";
						$properties_arr[$i]['bunglow_rates'][$j]['discount_week']					= "N/A";
					}
				}
				$j++;
				$properties_arr[$i]['id']				= $peroperty_id;
				$properties_arr[$i]['bunglow_name']		= $value['bunglow_name'];
				$properties_arr[$i]['max_person']		= $value['max_person'];
                $properties_arr[$i]['person_no_search']	= $person_no;
				$properties_arr[$i]['bunglow_overview']	= $value['bunglow_overview'];
				$properties_arr[$i]['slug']				= $value['slug'];
				$properties_arr[$i]['image']			= $image_arr[0]['image'];
				$properties_arr[$i]['caption']			= $image_arr[0]['caption'];
				$properties_arr[$i]['arrival_date']		= $posted_arrival_date;
				$properties_arr[$i]['total_days']		= $total_days;
				$properties_arr[$i]['date_arr']			= $date_arr[0];
                $properties_arr[$i]['leave_date']		= $posted_leave_date;
				$properties_arr[$i]['date_arr1']		= $date_arr[1];
                $properties_arr[$i]['currency_symbol']	= $currency_arr[0]['currency_symbol'];
                $properties_arr[$i]['currency_code']	= $currency_arr[0]['currency_code'];
				$properties_arr[$i]['type']				= $value['type'];
				
				if($properties_arr[$i]['availability'] == 'notavailable'){ 
					unset($properties_arr[$i]);
				}
				
				$i++;
			}
		}
		elseif($person_no!="" && $posted_arrival_date!="" && $posted_leave_date!=""){ //If Keyword, dates are not blank
			//Getting arrival date in php format 
			$arrival_date_arr=explode("/", $posted_arrival_date);
			$arrival_date		= $arrival_date_arr[2]."-".$arrival_date_arr[1]."-".$arrival_date_arr[0];
			
			
			//Getting leave date in php format
			$leave_date_arr = explode("/", $posted_leave_date);
			$leave_date		= $leave_date_arr[2]."-".$leave_date_arr[1]."-".$leave_date_arr[0];
			
			$date_arr		= $this->dateRange($arrival_date, $leave_date);
			$total_days		= count($date_arr);
			
			if(in_array($arrival_date_arr[1], array(5,6,7,8,9,10,11,12))){
				$season_date_start	= strtotime($arrival_date_arr[2] ."-12-15");
				$season_date_end	= strtotime($arrival_date_arr[2]+1 ."-04-14");
			}else{ 
				$season_date_start	= strtotime($arrival_date_arr[2]-1 ."-12-15");
				$season_date_end	= strtotime($arrival_date_arr[2] ."-04-14");
			}
			$booking_arrival_date	= strtotime($arrival_date);
			$booking_leave_date		= strtotime($leave_date);
			//echo "total_days=". $total_days ."<br />season_date_start=". $season_date_start ."<br />arrival_date=". $arrival_date ."<br />season_date_end=". $season_date_end ."<br />leave_date=". $leave_date ;
			
			if((($booking_arrival_date >= $season_date_start) and ($booking_arrival_date <= $season_date_end)) || (($booking_arrival_date <= $season_date_start) and ($booking_leave_date >= $season_date_start)) || (($booking_arrival_date >= $season_date_start) and ($booking_arrival_date <= $season_date_end) and ($booking_leave_date >= $season_date_start) and ($booking_leave_date <= $season_date_end)) and ($total_days < 3)){
			//if(((strtotime($leave_date) > strtotime($season_date_start)) || (strtotime($leave_date) < strtotime($season_date_end)) || (strtotime($arrival_date) > strtotime($season_date_start)) || (strtotime($arrival_date) < strtotime($season_date_end))) && ($total_days < 3)){	
				$msg['msg'] = 3;
				return $msg;
			}elseif($total_days < 2){
				$msg['msg'] = 2;
				return $msg;
			}
			
			$where = '';
			if($total_days < 5){
				$where = ' AND lb_bunglow.slug NOT IN ("bungalow5-with-extralargeterrace-us-tv", "bungalow-with-extra-large-terrace-upper-level-1", "bungalow21-suite-with-separated-bedroom-and-xtra-large-terrace", "bungalow23-suite-with-2-separated-bedrooms-terrace-jacuzzi", "sweety-cottage")';
			} 
			
			$this->db->from('lb_bunglow');
			$this->db->join('lb_bunglow_lang', 'lb_bunglow.id = lb_bunglow_lang.bunglow_id AND lb_bunglow.max_person >='.$person_no.' AND lb_bunglow.is_active="Y" AND lb_bunglow_lang.language_id='.$current_lang_id .' '. $where);
			$search_arr = $this->db->get()->result_array();
			
			///echo $total_days ."<pre>"; print_r($search_arr); die;
			
			$i=0;
			foreach($search_arr as $search){
				$bungalow_id	= $search['bunglow_id']; 
				$available_date	= array();
				
				foreach($date_arr as $date){
					$check_query=$this->db->query("SELECT * FROM `lb_reservation` WHERE `bunglow_id` = '$bungalow_id' AND (`arrival_date` <= '$date' AND `leave_date` > '$date') AND `is_active`!='Desactiver' AND `reservation_status` != 'Annulée'")->result_array();
			
					if(count($check_query)==0){ //If date is not reserved
						$check_cleaning 		= $this->db->query("SELECT * FROM `lb_bunglow_cleaning` WHERE `bunglow_id`='$bungalow_id' AND `cleaning_date`='$date'")->result_array();
						if(count($check_cleaning)==0){ //Check if date is reserved for cleaning
							$date_format_arr	= explode("-", $date); //date format is yyyy-mm-dd. so change it to dd/mm/yyyy
							$new_date_format	= $date_format_arr[2]."/".$date_format_arr[1]."/".$date_format_arr[0];
							array_push($available_date, $new_date_format);
						}
					}
				}
				
				if(count($available_date)==$total_days){ //If User selected dates are not reserved
					$search_arr[$i]['availability'] = "available";
					array_push($available_array, $search_arr[$i]);
				}elseif(count($available_date)==0){ //If No available
					$search_arr[$i]['availability'] = "notavailable";
					array_push($available_array, $search_arr[$i]);
				}else{
					$search_arr[$i]['availability'] = implode(", ", $available_date); //Implode the available dates
					array_push($available_array, $search_arr[$i]);
				}
				
				//echo "<pre>"; print_r($available_array);
				
				foreach($available_array as $value){
					$peroperty_id=$value['bunglow_id'];
					//Get bungalow Images
					$this->db->select('*');
					$this->db->from('lb_bunglow_image');
					$this->db->order_by('lb_bunglow_image.id', 'desc');
					$this->db->join('lb_bunglow_image_lang', 'lb_bunglow_image.id = lb_bunglow_image_lang.image_id AND lb_bunglow_image.bunglow_id='.$peroperty_id.' AND lb_bunglow_image.is_active = "Y" AND lb_bunglow_image_lang.language_id='.$current_lang_id);
					$this->db->limit(1);
					$image_arr 		= $this->db->get()->result_array();
                    $currency_arr	= $this->db->get_where("lb_currency_master", array("set_as_default"=>"Y"))->result_array();
                    $season_arr		= $this->db->get_where("lb_season")->result_array();
					$j				= 0;
					
					foreach($season_arr as $season){
						$j			= $season['id']; //We are indexing bunglow_rates array with season id
						$seasons_rate_arr=$this->db->get_where("lb_bunglow_rates", array("bunglow_id"=>$peroperty_id, "season_id"=>$season['id']))->result_array();
						
						//echo "<pre>"; print_r($season_arr); die;
						
						//$seasons_rate_arr=$this->db->get_where("lb_bunglow_rates", array("bunglow_id"=>$bunglow_id['bunglow_id'], "season_id"=>$season['id']))->result_array();
						if($seasons_rate_arr){
							$properties_arr[$i]['bunglow_rates'][$j]['rate_per_day_euro']				= $seasons_rate_arr[0]['rate_per_day_euro'];
							$properties_arr[$i]['bunglow_rates'][$j]['rate_per_day_dollar']				= $seasons_rate_arr[0]['rate_per_day_dollar'];
                            $properties_arr[$i]['bunglow_rates'][$j]['extranight_perday_europrice']		= $seasons_rate_arr[0]['extranight_perday_europrice'];
							$properties_arr[$i]['bunglow_rates'][$j]['extranight_perday_dollerprice']	= $seasons_rate_arr[0]['extranight_perday_dollerprice'];
							$properties_arr[$i]['bunglow_rates'][$j]['rate_per_week_euro']				= $seasons_rate_arr[0]['rate_per_week_euro'];
							$properties_arr[$i]['bunglow_rates'][$j]['rate_per_week_dollar']			= $seasons_rate_arr[0]['rate_per_week_dollar'];
							$properties_arr[$i]['bunglow_rates'][$j]['discount_night']					= $seasons_rate_arr[0]['discount_night'];
							$properties_arr[$i]['bunglow_rates'][$j]['discount_week']					= $seasons_rate_arr[0]['discount_week'];
						}else{ 
							$properties_arr[$i]['bunglow_rates'][$j]['rate_per_day_euro']				= "N/A";
							$properties_arr[$i]['bunglow_rates'][$j]['rate_per_day_dollar']				= "N/A";
							$properties_arr[$i]['bunglow_rates'][$j]['rate_per_week_euro']				= "N/A";
							$properties_arr[$i]['bunglow_rates'][$j]['rate_per_week_dollar']			= "N/A";
							$properties_arr[$i]['bunglow_rates'][$j]['discount_night']					= "N/A";
							$properties_arr[$i]['bunglow_rates'][$j]['discount_week']					= "N/A";
						}
					}
					
					$j++;
					$properties_arr[$i]['id']				= $peroperty_id;
					$properties_arr[$i]['bunglow_name']		= $value['bunglow_name'];
					$properties_arr[$i]['max_person']		= $value['max_person'];
                    $properties_arr[$i]['person_no_search']	= $person_no;
					$properties_arr[$i]['bunglow_overview']	= $value['bunglow_overview'];
					$properties_arr[$i]['slug']				= $value['slug'];
					$properties_arr[$i]['image']			= $image_arr[0]['image'];
					$properties_arr[$i]['caption']			= $image_arr[0]['caption'];
					$properties_arr[$i]['availability']		= $value['availability'];
					$properties_arr[$i]['total_days']		= $total_days;
					$properties_arr[$i]['arrival_date']		= $posted_arrival_date;
					$properties_arr[$i]['date_arr']			= $date_arr[0];
                    $properties_arr[$i]['leave_date']		= $posted_leave_date;
					$properties_arr[$i]['date_arr1']		= $date_arr[1];
                    $properties_arr[$i]['currency_symbol']	= $currency_arr[0]['currency_symbol'];
                    $properties_arr[$i]['currency_code']	= $currency_arr[0]['currency_code'];
					$properties_arr[$i]['type']				= $value['type'];
				}
				
				if($properties_arr[$i]['availability'] == 'notavailable'){ 
					unset($properties_arr[$i]);
				}
				
				$i++;
			}
		}
		
		return $properties_arr;

		//echo count($properties_arr) ."<pre>"; print_r($properties_arr); die;
	}
	
	
	//function to get property or bungalow by searching
	function mobile_search_process(){
		$current_lang_id=$this->session->userdata("current_lang_id");
		$keyword=$this->input->post("mobile_search_keyword");
		$posted_arrival_date=$this->input->post("mobile_search_arrival_date");
		$posted_leave_date=$this->input->post("mobile_search_leave_date");
		$properties_arr=array();
		$available_array=array();
		//If Keyword is blank but dates are not blank
		if($keyword=="" && $posted_arrival_date!="" && $posted_leave_date!="")
		{
			//Getting arrival date in php format
			$arrival_date_arr=explode("/", $posted_arrival_date);
			$arrival_date=$arrival_date_arr[2]."-".$arrival_date_arr[1]."-".$arrival_date_arr[0];
			
			//Getting leave date in php format
			$leave_date_arr=explode("/", $posted_leave_date);
			$leave_date=$leave_date_arr[2]."-".$leave_date_arr[1]."-".$leave_date_arr[0];

			$this->db->from('lb_bunglow');
			$this->db->join('lb_bunglow_lang', 'lb_bunglow.id = lb_bunglow_lang.bunglow_id AND lb_bunglow.is_active="Y" AND lb_bunglow_lang.language_id='.$current_lang_id);
			$search_arr = $this->db->get()->result_array();
			$i=0;
			foreach($search_arr as $search)
			{
				$bungalow_id=$search['bunglow_id'];
				//$query=$this->db->get_where("lb_reservation", array("bunglow_id"=>$bungalow_id))->result_array();
				//if(count($query)>0)//Check if bungalow is reserved or not
				//{
					$date_arr=$this->dateRange($arrival_date, $leave_date);
					$total_days=count($date_arr)-1;
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
					if(count($available_date)==$total_days+1)//If User selected dates are not reserved
					{
						$search_arr[$i]['availability']="available";
						array_push($available_array, $search_arr[$i]);
					}
					elseif(count($available_date)==0)//If No available
					{
						$search_arr[$i]['availability']="notavailable";
						array_push($available_array, $search_arr[$i]);
					}
					else
					{
						$search_arr[$i]['availability']=implode(", ", $available_date); //Implode the available dates
						array_push($available_array, $search_arr[$i]);
					}
				//}
				//else 
				//{
					//$search_arr[$i]['availability']="available";
					//array_push($available_array, $search_arr[$i]);
				//}
				foreach($available_array as $value)
				{
					$peroperty_id=$value['bunglow_id'];
					//Get bungalow Images
					$this->db->select('*');
					$this->db->from('lb_bunglow_image');
					$this->db->order_by('lb_bunglow_image.id', 'desc');
					$this->db->join('lb_bunglow_image_lang', 'lb_bunglow_image.id = lb_bunglow_image_lang.image_id AND lb_bunglow_image.bunglow_id='.$peroperty_id.' AND lb_bunglow_image.is_active = "Y" AND lb_bunglow_image_lang.language_id='.$current_lang_id);
					$this->db->limit(1);
					$image_arr = $this->db->get()->result_array();
					$properties_arr[$i]['id']=$peroperty_id;
					$properties_arr[$i]['bunglow_name']=$value['bunglow_name'];
					$properties_arr[$i]['max_person']=$value['max_person'];
                    $properties_arr[$i]['person_no_search']=$person_no;
					$properties_arr[$i]['bunglow_overview']=$value['bunglow_overview'];
					$properties_arr[$i]['slug']=$value['slug'];
					$properties_arr[$i]['image']=$image_arr[0]['image'];
					$properties_arr[$i]['caption']=$image_arr[0]['caption'];
					$properties_arr[$i]['availability']=$value['availability'];
					$properties_arr[$i]['total_days']=$total_days;
					$properties_arr[$i]['arrival_date']=$posted_arrival_date;
					$properties_arr[$i]['date_arr']=$date_arr[0];
					$properties_arr[$i]['type']=$value['type'];
				}
				$i++;
			}
		}
		//If Keyword is not blank but dates are blank
		elseif($keyword!="" && $posted_arrival_date=="" && $posted_leave_date=="" )
		{
			$this->db->from('lb_bunglow');
			$this->db->join('lb_bunglow_lang', 'lb_bunglow.id = lb_bunglow_lang.bunglow_id AND lb_bunglow.max_person >='.$person_no.' AND lb_bunglow.is_active="Y" AND lb_bunglow_lang.language_id='.$current_lang_id);
			$search_arr = $this->db->get()->result_array();
			$available_array=$search_arr;
			$i=0;
			foreach($available_array as $value)
			{
				$peroperty_id=$value['bunglow_id'];
				//Get bungalow Images
				$this->db->select('*');
				$this->db->from('lb_bunglow_image');
				$this->db->order_by('lb_bunglow_image.id', 'desc');
				$this->db->join('lb_bunglow_image_lang', 'lb_bunglow_image.id = lb_bunglow_image_lang.image_id AND lb_bunglow_image.bunglow_id='.$peroperty_id.' AND lb_bunglow_image.is_active = "Y" AND lb_bunglow_image_lang.language_id='.$current_lang_id);
				$this->db->limit(1);
				$image_arr = $this->db->get()->result_array();
				$properties_arr[$i]['id']=$peroperty_id;
				$properties_arr[$i]['bunglow_name']=$value['bunglow_name'];
				$properties_arr[$i]['max_person']=$value['max_person'];
                $properties_arr[$i]['person_no_search']=$person_no;
				$properties_arr[$i]['bunglow_overview']=$value['bunglow_overview'];
				$properties_arr[$i]['slug']=$value['slug'];
				$properties_arr[$i]['image']=$image_arr[0]['image'];
				$properties_arr[$i]['caption']=$image_arr[0]['caption'];
				$properties_arr[$i]['total_days']=$total_days;
				$properties_arr[$i]['arrival_date']=$posted_arrival_date;
				$properties_arr[$i]['date_arr']=$date_arr[0];
				$properties_arr[$i]['type']=$value['type'];
				$i++;
			}
		}
		//If Keyword, dates are not blank
		elseif($keyword!="" && $posted_arrival_date!="" && $posted_leave_date!="")
		{
			//Getting arrival date in php format
			$arrival_date_arr=explode("/", $posted_arrival_date);
			$arrival_date=$arrival_date_arr[2]."-".$arrival_date_arr[1]."-".$arrival_date_arr[0];
			
			//Getting leave date in php format
			$leave_date_arr=explode("/", $posted_leave_date);
			$leave_date=$leave_date_arr[2]."-".$leave_date_arr[1]."-".$leave_date_arr[0];
			
			$this->db->from('lb_bunglow');
			$this->db->join('lb_bunglow_lang', 'lb_bunglow.id = lb_bunglow_lang.bunglow_id AND lb_bunglow.max_person >='.$person_no.' AND lb_bunglow.is_active="Y" AND lb_bunglow_lang.language_id='.$current_lang_id);
			$search_arr = $this->db->get()->result_array();
			$i=0;
			foreach($search_arr as $search)
			{
				$bungalow_id=$search['bunglow_id'];
				//$query=$this->db->get_where("lb_reservation", array("bunglow_id"=>$bungalow_id))->result_array();
				//if(count($query)>0)//Check if bungalow is reserved or not
				//{
					$date_arr=$this->dateRange($arrival_date, $leave_date);
					$total_days=count($date_arr)-1;
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
					if(count($available_date)==$total_days+1)//If User selected dates are not reserved
					{
						$search_arr[$i]['availability']="available";
						array_push($available_array, $search_arr[$i]);
					}
					elseif(count($available_date)==0)//If No available
					{
						$search_arr[$i]['availability']="notavailable";
						array_push($available_array, $search_arr[$i]);
					}
					else
					{
						$search_arr[$i]['availability']=implode(", ", $available_date); //Implode the available dates
						array_push($available_array, $search_arr[$i]);
					}
				//}
				//else 
				//{
					//$search_arr[$i]['availability']="available";
					//array_push($available_array, $search_arr[$i]);
				//}
				foreach($available_array as $value)
				{
					$peroperty_id=$value['bunglow_id'];
					//Get bungalow Images
					$this->db->select('*');
					$this->db->from('lb_bunglow_image');
					$this->db->order_by('lb_bunglow_image.id', 'desc');
					$this->db->join('lb_bunglow_image_lang', 'lb_bunglow_image.id = lb_bunglow_image_lang.image_id AND lb_bunglow_image.bunglow_id='.$peroperty_id.' AND lb_bunglow_image.is_active = "Y" AND lb_bunglow_image_lang.language_id='.$current_lang_id);
					$this->db->limit(1);
					$image_arr = $this->db->get()->result_array();
					$properties_arr[$i]['id']=$peroperty_id;
					$properties_arr[$i]['bunglow_name']=$value['bunglow_name'];
					$properties_arr[$i]['max_person']=$value['max_person'];
                    $properties_arr[$i]['person_no_search']=$person_no;
					$properties_arr[$i]['bunglow_overview']=$value['bunglow_overview'];
					$properties_arr[$i]['slug']=$value['slug'];
					$properties_arr[$i]['image']=$image_arr[0]['image'];
					$properties_arr[$i]['caption']=$image_arr[0]['caption'];
					$properties_arr[$i]['availability']=$value['availability'];
					$properties_arr[$i]['total_days']=$total_days;
					$properties_arr[$i]['arrival_date']=$posted_arrival_date;
					$properties_arr[$i]['date_arr']=$date_arr[0];
					$properties_arr[$i]['type']=$value['type'];
				}
				$i++;
			}
		}
		return $properties_arr;

		//echo "<pre>";
		//print_r($properties_arr);
		//die;
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
	

	function get_season_data()
	{
		$result = $this->db->get("lb_season")->result_array();
		return $result;
	}
	
	//Getting All Rates At Once
	function get_rates_rows()//Get all rows for listing page
    {
		$person_no				= $this->input->post("search_keyword");
		$posted_arrival_date	= $this->input->post("search_arrival_date");
		$posted_leave_date		= $this->input->post("search_leave_date");
		
        $result = array();
		//At first getting default language id
		$default_language_arr=$this->db->get_where("mast_language", array("set_as_default"=>'Y'))->result_array();
		$default_language_id=$default_language_arr[0]['id'];
		
		//Getting Distinct bunglows in which rates has been added;
		$distinct_bunglow_id_arr=$this->db->query('select distinct `bunglow_id` from `lb_bunglow_rates` order by `id` desc')->result_array();

		$bunglow_arr=array();//An array to store values
		$i=0;
		foreach($distinct_bunglow_id_arr as $bunglow_id)
		{
			//Getting Bunglow details according to language and store name of the bunglow in array
			$bunglow_details=$this->db->get_where("lb_bunglow_lang", array("bunglow_id"=>$bunglow_id['bunglow_id'], "language_id"=>$default_language_id))->result_array();
			$bunglow_arr[$i]['bunglow_id']=$bunglow_details[0]['bunglow_id'];
			$bunglow_arr[$i]['bunglow_name']=$bunglow_details[0]['bunglow_name'];
			$bunglow_arr[$i]['bunglow_price']= $this->getPriceByBungalow($bunglow_details[0]['bunglow_id'],$posted_arrival_date,$posted_leave_date,$person_no);

			$bunglow_arr[$i]['bunglow_rates']=array(); // An array to store rates according to season, This array will be stored in bunglow array
			$this->db->order_by("id", "asc");
			$season_arr=$this->db->get_where("lb_season")->result_array();
			$j=0;
			foreach($season_arr as $season)
			{
				$j=$season['id']; //We are indexing bunglow_rates array with season id
				$seasons_rate_arr=$this->db->get_where("lb_bunglow_rates", array("bunglow_id"=>$bunglow_id['bunglow_id'], "season_id"=>$season['id']))->result_array();
				
				$seasons_rate_arr=$this->db->get_where("lb_bunglow_rates", array("bunglow_id"=>$bunglow_id['bunglow_id'], "season_id"=>$season['id']))->result_array();
				if($seasons_rate_arr)
				{
					$bunglow_arr[$i]['bunglow_rates'][$j]['rate_per_day_euro']=$seasons_rate_arr[0]['rate_per_day_euro'];
					$bunglow_arr[$i]['bunglow_rates'][$j]['rate_per_day_dollar']=$seasons_rate_arr[0]['rate_per_day_dollar'];
					$bunglow_arr[$i]['bunglow_rates'][$j]['rate_per_week_euro']=$seasons_rate_arr[0]['rate_per_week_euro'];
					$bunglow_arr[$i]['bunglow_rates'][$j]['rate_per_week_dollar']=$seasons_rate_arr[0]['rate_per_week_dollar'];
					$bunglow_arr[$i]['bunglow_rates'][$j]['discount_night']=$seasons_rate_arr[0]['discount_night'];
					$bunglow_arr[$i]['bunglow_rates'][$j]['discount_week']=$seasons_rate_arr[0]['discount_week'];
                    $bunglow_arr[$i]['bunglow_rates'][$j]['extranight_perday_europrice']=$seasons_rate_arr[0]['extranight_perday_europrice'];
					$bunglow_arr[$i]['bunglow_rates'][$j]['extranight_perday_dollerprice']=$seasons_rate_arr[0]['extranight_perday_dollerprice'];
				}
				else 
				{
					$bunglow_arr[$i]['bunglow_rates'][$j]['rate_per_day_euro']="N/A";
					$bunglow_arr[$i]['bunglow_rates'][$j]['rate_per_day_dollar']="N/A";
					$bunglow_arr[$i]['bunglow_rates'][$j]['rate_per_week_euro']="N/A";
					$bunglow_arr[$i]['bunglow_rates'][$j]['rate_per_week_dollar']="N/A";
					$bunglow_arr[$i]['bunglow_rates'][$j]['discount_night']="N/A";
					$bunglow_arr[$i]['bunglow_rates'][$j]['discount_week']="N/A";
				}
			}
			$i++;
		}
		return $bunglow_arr;
    }
	
	
	//Getting All Season At Once
	function get_season_rows()//Get all rows for listing page
    {
        $result = array();
		
			$default_language_arr=$this->db->get_where("mast_language", array("set_as_default"=>'Y'))->result_array();
			$default_language_id=$default_language_arr[0]['id'];
      
            //$this->db->where('id', $id);
			$this->db->where('language_id', $default_language_id);
            $this->db->select('*');
            $query = $this->db->get('lb_season_lang');
       
        foreach ($query->result() as $row) 
		{
			$season_id=$row->season_id;
			$season_details_arr=$this->db->get_where("lb_season", array("id"=>$season_id))->result_array();
			$result[] = array(
				'id' 					=> $row->id,
				'season_id' 			=> $row->season_id,
				'language_id' 			=> $row->language_id,
				'season_name' 			=> $row->season_name,
				'months'				=> $season_details_arr[0]['months'],
				'is_active'				=> $season_details_arr[0]['is_active']
			);
        }
        return $result;
    }
	

	
	function getPriceByBungalow($bunglow_id,$arrival_date,$leave_date,$no_of_adult){
		$stay_euro = 0;
		$q_val = explode("/",$arrival_date);		 
		$season_id = $this->getSeasons($q_val[0],$q_val[1],$q_val[2]);

		$q_val1 = explode("/",$leave_date);		 
		$another_season_id = $this->getSeasons($q_val1[0],$q_val1[1],$q_val1[2]);
		
		$arrival_date1 = $arrival_date;
		$leave_date1 = $leave_date;

		$arrival_date_arr=explode("/",$arrival_date);
		$arrival_date = mktime(0,0,0, $arrival_date_arr[1], $arrival_date_arr[0], $arrival_date_arr[2] );
		$leave_date_arr=explode("/", $leave_date);
		$leave_date=mktime(0,0,0, $leave_date_arr[1], $leave_date_arr[0], $leave_date_arr[2] );

		$date_arr=$this->dateRanges($arrival_date, $leave_date);
		$days_count=count($date_arr) - 1;

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

			$rate_details_arr=$this->db->get_where("lb_bunglow_rates", array("bunglow_id"=>$bunglow_id, "season_id"=>"1"))->result_array();
			$rate_details_arr1=$this->db->get_where("lb_bunglow_rates", array("bunglow_id"=>$bunglow_id, "season_id"=>"2"))->result_array();
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
			$rate_details_arr=$this->db->get_where("lb_bunglow_rates", array("bunglow_id"=>$bunglow_id, "season_id"=>$season_id))->result_array();

			if( $days_count > 6 ){
				$stay_euro = $days_count * $rate_details_arr[0]['extranight_perday_europrice'];
			}else {
				$stay_euro = $rate_details_arr[0]['rate_per_day_euro'] * $days_count;
			}
		}		
		return $stay_euro;	
	}

	function getSeasons($day,$month,$year,$output=""){
		$cur_date = date('Y-m-d', mktime(0,0,0,$month,$day,$year));
		$high_start_date = date('Y-m-d', mktime(0,0,0,12,15,$year));
		$high_end_date = date('Y-m-d', mktime(0,0,0,4,14,($year+1)));

		$low_start_date = date('Y-m-d', mktime(0,0,0,4,15,$year));
		$low_end_date = date('Y-m-d', mktime(0,0,0,12,14,$year));
		$season_id = 0;
		if($cur_date >= $low_start_date && $cur_date <= $low_end_date) { $season_id = "2"; $season_name = lang("low_season"); }
		else {$season_id = "1";  $season_name = lang("high_season"); }

//echo $cur_date."*".$high_start_date."*".$high_end_date."*".$low_start_date."*".$low_end_date."---".$season_id;
		if($output == "") return $season_id;
		else return $season_name;
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

}

?>