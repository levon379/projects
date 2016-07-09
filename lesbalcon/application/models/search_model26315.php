<?php
class search_model extends CI_Model
{
	function  __construct() 
	{
        parent::__construct();
    }

	//function to get property or bungalow by searching
	function desktop_search_process()
	{
		$current_lang_id=$this->session->userdata("current_lang_id");
		$keyword=$this->input->post("search_keyword");
		$posted_arrival_date=$this->input->post("search_arrival_date");
		$posted_leave_date=$this->input->post("search_leave_date");
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
					$properties_arr[$i]['bunglow_overview']=$value['bunglow_overview'];
					$properties_arr[$i]['slug']=$value['slug'];
					$properties_arr[$i]['image']=$image_arr[0]['image'];
					$properties_arr[$i]['caption']=$image_arr[0]['caption'];
					$properties_arr[$i]['availability']=$value['availability'];
					$properties_arr[$i]['type']=$value['type'];
				}
				$i++;
			}
		}
		//If Keyword is not blank but dates are blank
		elseif($keyword!="" && $posted_arrival_date=="" && $posted_leave_date=="" )
		{
			$this->db->from('lb_bunglow');
			$this->db->join('lb_bunglow_lang', 'lb_bunglow.id = lb_bunglow_lang.bunglow_id AND lb_bunglow_lang.bunglow_name LIKE "%'.$keyword.'%" AND lb_bunglow.is_active="Y" AND lb_bunglow_lang.language_id='.$current_lang_id);
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
				$properties_arr[$i]['bunglow_overview']=$value['bunglow_overview'];
				$properties_arr[$i]['slug']=$value['slug'];
				$properties_arr[$i]['image']=$image_arr[0]['image'];
				$properties_arr[$i]['caption']=$image_arr[0]['caption'];
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
			$this->db->join('lb_bunglow_lang', 'lb_bunglow.id = lb_bunglow_lang.bunglow_id AND lb_bunglow_lang.bunglow_name LIKE "%'.$keyword.'%" AND lb_bunglow.is_active="Y" AND lb_bunglow_lang.language_id='.$current_lang_id);
			$search_arr = $this->db->get()->result_array();
			$i=0;
			foreach($search_arr as $search)
			{
				$bungalow_id=$search['bunglow_id'];
				//$query=$this->db->get_where("lb_reservation", array("bunglow_id"=>$bungalow_id))->result_array();
				//if(count($query)>0)//Check if bungalow is reserved or not
				//{
					$date_arr=$this->dateRange($arrival_date, $leave_date);
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
					$properties_arr[$i]['bunglow_overview']=$value['bunglow_overview'];
					$properties_arr[$i]['slug']=$value['slug'];
					$properties_arr[$i]['image']=$image_arr[0]['image'];
					$properties_arr[$i]['caption']=$image_arr[0]['caption'];
					$properties_arr[$i]['availability']=$value['availability'];
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
	
	
	//function to get property or bungalow by searching
	function mobile_search_process()
	{
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
					$properties_arr[$i]['bunglow_overview']=$value['bunglow_overview'];
					$properties_arr[$i]['slug']=$value['slug'];
					$properties_arr[$i]['image']=$image_arr[0]['image'];
					$properties_arr[$i]['caption']=$image_arr[0]['caption'];
					$properties_arr[$i]['availability']=$value['availability'];
					$properties_arr[$i]['type']=$value['type'];
				}
				$i++;
			}
		}
		//If Keyword is not blank but dates are blank
		elseif($keyword!="" && $posted_arrival_date=="" && $posted_leave_date=="" )
		{
			$this->db->from('lb_bunglow');
			$this->db->join('lb_bunglow_lang', 'lb_bunglow.id = lb_bunglow_lang.bunglow_id AND lb_bunglow_lang.bunglow_name LIKE "%'.$keyword.'%" AND lb_bunglow.is_active="Y" AND lb_bunglow_lang.language_id='.$current_lang_id);
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
				$properties_arr[$i]['bunglow_overview']=$value['bunglow_overview'];
				$properties_arr[$i]['slug']=$value['slug'];
				$properties_arr[$i]['image']=$image_arr[0]['image'];
				$properties_arr[$i]['caption']=$image_arr[0]['caption'];
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
			$this->db->join('lb_bunglow_lang', 'lb_bunglow.id = lb_bunglow_lang.bunglow_id AND lb_bunglow_lang.bunglow_name LIKE "%'.$keyword.'%" AND lb_bunglow.is_active="Y" AND lb_bunglow_lang.language_id='.$current_lang_id);
			$search_arr = $this->db->get()->result_array();
			$i=0;
			foreach($search_arr as $search)
			{
				$bungalow_id=$search['bunglow_id'];
				//$query=$this->db->get_where("lb_reservation", array("bunglow_id"=>$bungalow_id))->result_array();
				//if(count($query)>0)//Check if bungalow is reserved or not
				//{
					$date_arr=$this->dateRange($arrival_date, $leave_date);
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
					$properties_arr[$i]['bunglow_overview']=$value['bunglow_overview'];
					$properties_arr[$i]['slug']=$value['slug'];
					$properties_arr[$i]['image']=$image_arr[0]['image'];
					$properties_arr[$i]['caption']=$image_arr[0]['caption'];
					$properties_arr[$i]['availability']=$value['availability'];
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
}

?>