<?php
class rates_model extends CI_Model
{
    
	//###############################################################//
	//############### INITIALIZE CONSTRUCTOR CLASS ##################//
	//###############################################################//
	
	function  __construct() 
	{
        parent::__construct();
    }
	
	//###############################################################//
	//############### INITIALIZE CONSTRUCTOR CLASS ##################//
	//###############################################################//
	
	//*******************************************ADMIN PANEL CATEGORY**********************************************************************//
	
	

	//######################ADDING RATES ACCORDING TO SEASONS###########################
	
	function rates_add()
	{
		$this->db->order_by("id", "asc");
		$seasons_err=$this->db->get("lb_season")->result_array();
		$bunglow_id=$this->input->post("bunglow_id");
		$check_already_exist=$this->db->get_where("lb_bunglow_rates", array("bunglow_id"=>$bunglow_id))->result_array();
		if(count($check_already_exist)>0)
		{
			return "already_exist";
		}
		else 
		{
			foreach($seasons_err as $seasons)
			{
				$season_id=$seasons['id'];
				$rates_per_day_euro=$this->input->post("rate_in_euro_night".$season_id);
				$rates_per_day_dollar=$this->input->post("rate_in_dollar_night".$season_id);
                $extranight_perday_europrice=$this->input->post("extranight_perday_europrice".$season_id);
                $extranight_perday_dollerprice=$this->input->post("extranight_perday_dollerprice".$season_id);
				$rates_per_week_euro=$this->input->post("rate_in_euro_week".$season_id);
				$rates_per_week_dollar=$this->input->post("rate_in_dollar_week".$season_id);
				$discount_per_week=$this->input->post("discount_per_week".$season_id);
				$discount_per_night=$this->input->post("discount_per_night".$season_id);
				
				if($discount_week=="")
				{
					$discount_week=0;
				}
				if($discount_night=="")
				{
					$discount_night=0;
				}
				$insert_arr=array(
					"bunglow_id"=>$bunglow_id,
					"season_id"=>$season_id,
					"rate_per_day_euro"=>$rates_per_day_euro,
					"rate_per_day_dollar"=>$rates_per_day_dollar,
                    "extranight_perday_europrice"=>$extranight_perday_europrice,
					"extranight_perday_dollerprice"=>$extranight_perday_dollerprice,
					"rate_per_week_euro"=>$rates_per_week_euro,
					"rate_per_week_dollar"=>$rates_per_week_dollar,
					"discount_per_night"=>$discount_per_night,
				    "discount_per_week"=>$discount_per_week
				);
				$this->db->insert("lb_bunglow_rates", $insert_arr);
			}
			return "add_success";
		}
	}
		
	
	//###################################################################################
	
	//##################################Edit Rates#######################################
	
	function get_rates($bunglow_id, $default_language_id) //Get all rates for edit
	{
		//Get language data of selected language
		$this->db->order_by("season_id");
		$rates_arr=$this->db->get_where("lb_bunglow_rates", array("bunglow_id"=>$bunglow_id))->result_array();
		$all_rates_arr=array();
		$i=0;
		foreach($rates_arr as $rates)
		{
			$season_id=$rates['season_id'];
			$this->db->where("season_id", $season_id);
			$this->db->where("language_id", $default_language_id);
			$season_arr=$this->db->get("lb_season_lang")->result_array();
			
			$all_rates_arr[$i]['id']=$season_id;
			$all_rates_arr[$i]['bunglow_id']=$rates['bunglow_id'];
			$all_rates_arr[$i]['season_id']=$rates['season_id'];
			$all_rates_arr[$i]['season_name']=$season_arr[0]['season_name'];
			$all_rates_arr[$i]['rate_per_day_euro']=$rates['rate_per_day_euro'];
			$all_rates_arr[$i]['rate_per_day_dollar']=$rates['rate_per_day_dollar'];
            $all_rates_arr[$i]['extranight_perday_europrice']=$rates['extranight_perday_europrice'];
			$all_rates_arr[$i]['extranight_perday_dollerprice']=$rates['extranight_perday_dollerprice'];
			$all_rates_arr[$i]['rate_per_week_euro']=$rates['rate_per_week_euro'];
			$all_rates_arr[$i]['rate_per_week_dollar']=$rates['rate_per_week_dollar'];
			$all_rates_arr[$i]['discount_per_night']=$rates['discount_per_night'];
			$all_rates_arr[$i]['discount_per_week']=$rates['discount_per_night'];
			$i++;
		}
		/*$this->db->order_by("season_id");
		$seasons_arr=$this->db->get_where("lb_season_lang", array("language_id"=>$default_language_id))->result_array();
		$all_rates_arr=array();
		$i=0;
		foreach($seasons_arr as $season)
		{
			$season_id=$season['season_id'];
			$this->db->where("season_id", $season_id);
			$this->db->where("bunglow_id", $bunglow_id);
			$rates_arr=$this->db->get("lb_bunglow_rates")->result_array();
			$all_rates_arr[$i]['id']=$season_id;
			$all_rates_arr[$i]['season_name']=$season['season_name'];
			if($rates_arr)
			{
				$all_rates_arr[$i]['rate_per_day_euro']=$rates_arr[0]['rate_per_day_euro'];
				$all_rates_arr[$i]['rate_per_day_dollar']=$rates_arr[0]['rate_per_day_dollar'];
				$all_rates_arr[$i]['discount']=$rates_arr[0]['discount'];
			}
			else 
			{
				$all_rates_arr[$i]['rate_per_day_euro']=0;
				$all_rates_arr[$i]['rate_per_day_dollar']=0;
				$all_rates_arr[$i]['discount']=0;
			}
			$i++;
		}*/
		
		return $all_rates_arr;
	}
	
	
	//Getting All Rates At Once
	function get_rows($language_id, $id = 0)//Get all rows for listing page
    {
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
			$bunglow_details=$this->db->get_where("lb_bunglow_lang", array("bunglow_id"=>$bunglow_id['bunglow_id'], "language_id"=>$language_id))->result_array();
			$bunglow_arr[$i]['bunglow_id']=$bunglow_details[0]['bunglow_id'];
			$bunglow_arr[$i]['bunglow_name']=$bunglow_details[0]['bunglow_name'];
			$bunglow_arr[$i]['bunglow_rates']=array(); // An array to store rates according to season, This array will be stored in bunglow array
			$this->db->order_by("id", "asc");
			$season_arr=$this->db->get_where("lb_season")->result_array();
			$j=0;
			foreach($season_arr as $season)
			{
				$j=$season['id']; //We are indexing bunglow_rates array with season id
				$seasons_rate_arr=$this->db->get_where("lb_bunglow_rates", array("bunglow_id"=>$bunglow_id['bunglow_id'], "season_id"=>$season['id']))->result_array();
				if($seasons_rate_arr)
				{
					$bunglow_arr[$i]['bunglow_rates'][$j]['rate_per_day_euro']=$seasons_rate_arr[0]['rate_per_day_euro'];
					$bunglow_arr[$i]['bunglow_rates'][$j]['rate_per_day_dollar']=$seasons_rate_arr[0]['rate_per_day_dollar'];
                    $bunglow_arr[$i]['bunglow_rates'][$j]['extranight_perday_europrice']=$seasons_rate_arr[0]['extranight_perday_europrice'];
			        $bunglow_arr[$i]['bunglow_rates'][$j]['extranight_perday_dollerprice']=$seasons_rate_arr[0]['extranight_perday_dollerprice'];
					$bunglow_arr[$i]['bunglow_rates'][$j]['rate_per_week_euro']=$seasons_rate_arr[0]['rate_per_week_euro'];
					$bunglow_arr[$i]['bunglow_rates'][$j]['rate_per_week_dollar']=$seasons_rate_arr[0]['rate_per_week_dollar'];
					$bunglow_arr[$i]['bunglow_rates'][$j]['discount_per_night']=$seasons_rate_arr[0]['discount_per_night'];
					$bunglow_arr[$i]['bunglow_rates'][$j]['discount_per_week']=$seasons_rate_arr[0]['discount_per_week'];
				}
				else 
				{
					$bunglow_arr[$i]['bunglow_rates'][$j]['rate_per_day_euro']="N/A";
					$bunglow_arr[$i]['bunglow_rates'][$j]['rate_per_day_dollar']="N/A";
					$bunglow_arr[$i]['bunglow_rates'][$j]['rate_per_week_euro']="N/A";
					$bunglow_arr[$i]['bunglow_rates'][$j]['rate_per_week_dollar']="N/A";
					$bunglow_arr[$i]['bunglow_rates'][$j]['discount_per_night']="N/A";
					$bunglow_arr[$i]['bunglow_rates'][$j]['discount_per_week']="N/A";
				}
			}
			$i++;
		}
		return $bunglow_arr;
    }

	//Function for deleting rates
	function delete($bunglow_id)
	{
		$this->db->delete("lb_bunglow_rates", array("bunglow_id"=>$bunglow_id));
	}
	
	//Edit Rates
	function rates_edit()
	{
		$this->db->order_by("id", "asc");
		$seasons_err=$this->db->get("lb_season")->result_array();
		$posted_bunglow_id=$this->input->post("edit_bunglow_id");
		foreach($seasons_err as $seasons)
		{
			$season_id=$seasons['id'];
			$rates_per_day_euro=$this->input->post("rate_in_euro_night".$season_id);
			$rates_per_day_dollar=$this->input->post("rate_in_dollar_night".$season_id);
            $extranight_perday_europrice=$this->input->post("extranight_perday_europrice".$season_id);
            $extranight_perday_dollerprice=$this->input->post("extranight_perday_dollerprice".$season_id);
			$rates_per_week_euro=$this->input->post("rate_in_euro_week".$season_id);
			$rates_per_week_dollar=$this->input->post("rate_in_dollar_week".$season_id);
			//$discount=$this->input->post("discount".$season_id);
			$discount_per_week=$this->input->post("discount_per_week".$season_id);
			$discount_per_night=$this->input->post("discount_per_night".$season_id);
			
			if($discount_per_week=="")
				{
					$discount_per_week=0;
				}
				if($discount_per_night=="")
				{
					$discount_per_night=0;
				}
			$update_arr=array(
				"rate_per_day_euro"=>$rates_per_day_euro,
				"rate_per_day_dollar"=>$rates_per_day_dollar,
                "extranight_perday_europrice"=>$extranight_perday_europrice,
				"extranight_perday_dollerprice"=>$extranight_perday_dollerprice,
				"rate_per_week_euro"=>$rates_per_week_euro,
				"rate_per_week_dollar"=>$rates_per_week_dollar,
				"discount_per_night"=>$discount_per_night,
				"discount_per_week"=>$discount_per_week
			);
			$this->db->update("lb_bunglow_rates", $update_arr, array("bunglow_id"=>$posted_bunglow_id, "season_id"=>$season_id));
		}
		return "edit_success";
	}
	
	//Function to get all seasons
	/*function get_all_seasons($default_language_id)
	{
		$this->db->order_by("season_id", "asc");
		$result=$this->db->get_where("lb_season_lang", array("language_id"=>$default_language_id))->result_array();
		return $result;
	}*/
	
	//Getting All Season At Once
	
	function get_all_seasons($default_language_id)//Get all rows for listing page
    {
        $result = array();
        if ($id == 0) //all rows requested according to language id
        {
			$this->db->where('language_id', $default_language_id);
			$this->db->order_by('id');
            $query = $this->db->get('lb_season_lang');
        }
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
	
	
	//Function to get all bunglows
	function get_all_bunglows($default_language_id)
	{
		$this->db->order_by("bunglow_id", "asc");
		$result=$this->db->get_where("lb_bunglow_lang", array("language_id"=>$default_language_id))->result_array();
		return $result;
	}
	
	
	//###################	Functions for Front End	##############################
	
	function get_all_rates()
	{
		$language_id=$current_lang_id=$this->session->userdata("current_lang_id");
		$result = array();
		//Getting Distinct bunglows in which rates has been added;
		$distinct_bunglow_id_arr=$this->db->query('select distinct `bunglow_id` from `lb_bunglow_rates` order by `id` desc')->result_array();

		$bunglow_arr=array();//An array to store values
		$i=0;
		foreach($distinct_bunglow_id_arr as $bunglow_id)
		{
			$bunglow_main=$this->db->get_where("lb_bunglow", array("id"=>$bunglow_id['bunglow_id']))->result_array();
			//Getting Bunglow details according to language and store name of the bunglow in array
			$bunglow_details=$this->db->get_where("lb_bunglow_lang", array("bunglow_id"=>$bunglow_id['bunglow_id'], "language_id"=>$language_id))->result_array();
			$bunglow_arr[$i]['bunglow_id']=$bunglow_details[0]['bunglow_id'];
			$bunglow_arr[$i]['bunglow_name']=$bunglow_details[0]['bunglow_name'];
			$bunglow_arr[$i]['slug']=$bunglow_main[0]['slug'];
			$bunglow_arr[$i]['type']=$bunglow_main[0]['type'];
			$bunglow_arr[$i]['bunglow_rates']=array(); // An array to store rates according to season, This array will be stored in bunglow array
			$this->db->order_by("id", "asc");
			$season_arr=$this->db->get_where("lb_season")->result_array();
			$j=0;
			foreach($season_arr as $season)
			{
				$j=$season['id']; //We are indexing bunglow_rates array with season id
				$seasons_details_arr=$this->db->get_where("lb_season_lang", array("season_id"=>$j, "language_id"=>$language_id))->result_array();
				$seasons_rate_arr=$this->db->get_where("lb_bunglow_rates", array("bunglow_id"=>$bunglow_id['bunglow_id'], "season_id"=>$season['id']))->result_array();
				if($seasons_rate_arr)
				{
					$bunglow_arr[$i]['bunglow_rates'][$j]['season_id']=$season['id'];
					$bunglow_arr[$i]['bunglow_rates'][$j]['season_name']=$seasons_details_arr[0]['season_name'];
					$bunglow_arr[$i]['bunglow_rates'][$j]['season_icon']=$season['season_icon'];
					$bunglow_arr[$i]['bunglow_rates'][$j]['rate_per_day_euro']=$seasons_rate_arr[0]['rate_per_day_euro'];
					$bunglow_arr[$i]['bunglow_rates'][$j]['rate_per_day_dollar']=$seasons_rate_arr[0]['rate_per_day_dollar'];
                    $bunglow_arr[$i]['bunglow_rates'][$j]['extranight_perday_europrice']=$seasons_rate_arr[0]['extranight_perday_europrice'];
					$bunglow_arr[$i]['bunglow_rates'][$j]['extranight_perday_dollerprice']=$seasons_rate_arr[0]['extranight_perday_dollerprice'];
					$bunglow_arr[$i]['bunglow_rates'][$j]['rate_per_week_euro']=$seasons_rate_arr[0]['rate_per_week_euro'];
					$bunglow_arr[$i]['bunglow_rates'][$j]['rate_per_week_dollar']=$seasons_rate_arr[0]['rate_per_week_dollar'];
					$bunglow_arr[$i]['bunglow_rates'][$j]['discount_per_night']=$seasons_rate_arr[0]['discount_per_night'];
					$bunglow_arr[$i]['bunglow_rates'][$j]['discount_per_week']=$seasons_rate_arr[0]['discount_per_week'];
				}
				else 
				{
					$bunglow_arr[$i]['bunglow_rates'][$j]['season_id']=$season['id'];
					$bunglow_arr[$i]['bunglow_rates'][$j]['season_name']=$seasons_details_arr[0]['season_name'];
					$bunglow_arr[$i]['bunglow_rates'][$j]['season_icon']=$season['season_icon'];
					$bunglow_arr[$i]['bunglow_rates'][$j]['rate_per_day_euro']="N/A";
					$bunglow_arr[$i]['bunglow_rates'][$j]['rate_per_day_dollar']="N/A";
					$bunglow_arr[$i]['bunglow_rates'][$j]['rate_per_week_euro']="N/A";
					$bunglow_arr[$i]['bunglow_rates'][$j]['rate_per_week_dollar']="N/A";
					$bunglow_arr[$i]['bunglow_rates'][$j]['discount_per_night']="N/A";
					$bunglow_arr[$i]['bunglow_rates'][$j]['discount_per_week']="N/A";
				}
			}
			$i++;
		}
		return $bunglow_arr;
	}
	
	//Function to get all seasons for front_end
	function get_seasons_for_front_end()
	{
		$current_lang_id=$this->session->userdata("current_lang_id");
		$all_seasons_arr=array();
		$this->db->order_by("id", "asc");
		$seasons_arr=$this->db->get("lb_season")->result_array();
		$i=0;
		foreach($seasons_arr as $seasons)
		{
			$season_details_arr=$this->db->get_where("lb_season_lang", array("season_id"=>$seasons['id'], "language_id"=>$current_lang_id))->result_array();
			$all_seasons_arr[$i]['id']=$seasons['id'];
			$all_seasons_arr[$i]['season_icon']=$seasons['season_icon'];
			$all_seasons_arr[$i]['season_name']=$season_details_arr[0]['season_name'];
			$all_seasons_arr[$i]['language_id']=$season_details_arr[0]['language_id'];
			$all_seasons_arr[$i]['season_id']=$season_details_arr[0]['season_id'];
			$i++;
		}
		return $all_seasons_arr;
	}
}

?>
