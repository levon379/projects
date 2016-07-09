<?php
class options_model extends CI_Model
{
	
	function  __construct() 
	{
        parent::__construct();
    }

	//######################ADDING BANNERS ACCORDING TO LANGUAGE###########################
	
	function options_add()
	{
		$languages_err=$this->db->get("mast_language")->result_array();
		$charges_in_dollars=$this->input->post("charge_in_dollars");
		$charges_in_euro=$this->input->post("charge_in_euro");
		
		$size = list($width, $height, $type, $attr) = getimagesize($_FILES["option_icon"]['tmp_name']); 
		$new_file_name=time()."_".$_FILES["option_icon"]['name'];
		if($height>='16' && $width>='16')
		{
			//Uploading image;
			$config['file_name'] =$new_file_name;
			$config['upload_path'] = "assets/upload/option_icon/";
			$config['allowed_types'] = "gif|jpg|jpeg|png";
			$config['max_size'] = '1000000';
			$this->load->library('upload', $config);
			if (!$this->upload->do_upload('option_icon'))
			{
				return $this->upload->display_errors();
			}
			else
			{
				//Resizing uploaded images
				$data = array('upload_data' => $this->upload->data());
				$option_icon = $data['upload_data']['file_name'];
				//Resize 1st Image
				$config['image_library'] = 'gd2';
				$config['source_image'] = 'assets/upload/option_icon/'.$option_icon;
				$config['new_image'] = 'assets/upload/option_icon/'.$option_icon;
				$config['allowed_types'] = "jpg|jpeg|gif|png";
				$config['maintain_ratio'] = FALSE;
				$config['width'] = 16;
				$config['height'] = 16;
				$config['quality'] = 100;
				$this->load->library('image_lib', $config);
				$this->image_lib->initialize($config);
				$this->image_lib->resize();

				//Inserting data in database
				$insert_arr=array(
					"is_active"=>"Y",
					"charge_in_dollars"=>$charges_in_dollars,
					"charge_in_euro"=>$charges_in_euro,
					"option_icon"=>$option_icon
				);
				$this->db->insert("lb_bunglow_options", $insert_arr);
				$last_id=$this->db->insert_id();
				foreach($languages_err as $language)
				{
					$language_id=$language['id'];
					$options_id=$last_id;
					$options_name=$this->input->post("options_name".$language['id']);
					$insert_arr_1=array(
						"language_id"=>$language_id,
						"options_id"=>$options_id,
						"options_name"=>$options_name
					);
					
					$this->db->insert("lb_bunglow_options_lang", $insert_arr_1);
				}
				return "add_success";
			}
		}
		else
		{
			return "file_size";
		}
	}
		
	
	//###################################################################################
	
	//##################################Edit Pages#######################################
	
	function get_options($language_id, $options_id) //Get all options according to language for edit
	{
		//Get language data of selected language
		$this->db->order_by("id");
		$lang_arr_1=$this->db->get_where("mast_language", array("id"=>$language_id))->result_array();
		//Get language data of remaining languages
		$this->db->where("id !=", $language_id);
		$lang_arr_2=$this->db->get("mast_language")->result_array();
		$languages_arr=array_merge($lang_arr_1, $lang_arr_2);
		$all_options_arr=array();
		$i=0;
		foreach($languages_arr as $languages)
		{
			$this->db->where("language_id", $languages['id']);
			$this->db->where("options_id", $options_id);
			$options_arr=$this->db->get("lb_bunglow_options_lang")->result_array();
			$options_details_arr=$this->db->get_where("lb_bunglow_options", array("id"=>$options_id))->result_array();
			$all_options_arr[$i]['id']=$languages['id'];
			$all_options_arr[$i]['language_id']=$options_arr[0]['language_id'];
			$all_options_arr[$i]['options_id']=$options_arr[0]['options_id'];
			$all_options_arr[$i]['options_name']=$options_arr[0]['options_name'];
			$all_options_arr[$i]['options_icon']=$options_details_arr[0]['option_icon'];
			$all_options_arr[$i]['language_name']=$languages['language_name'];
			$all_options_arr[$i]['flag_image_name']=$languages['flag_image_name'];
			$i++;
		}
		return $all_options_arr;
	}
	
	function get_unique_details($options_id) //Get details of page unique to both languages e.g page_slug
	{
		$result=$this->db->get_where("lb_bunglow_options", array("id"=>$options_id))->result_array();
		return $result;
	}
	

	
	//Getting All Options At Once
	function get_rows($language_id, $id = 0)//Get all rows for listing page
    {
        $result = array();
        if ($id == 0) //all rows requested according to language id
        {
			$this->db->where('language_id', $language_id);
			$this->db->order_by('id');
            $query = $this->db->get('lb_bunglow_options_lang');
        }
        else //single row requested according to language id
        {
            $this->db->where('id', $id);
			$this->db->where('language_id', $language_id);
            $this->db->select('*');
            $query = $this->db->get('lb_bunglow_options_lang');
        }
        foreach ($query->result() as $row) 
		{
			$options_id=$row->options_id;
			$options_details_arr=$this->db->get_where("lb_bunglow_options", array("id"=>$options_id))->result_array();
			$result[] = array(
				'id' 					=> $row->id,
				'options_id' 			=> $row->options_id,
				'language_id' 			=> $row->language_id,
				'options_name' 			=> $row->options_name,
				'charges_in_dollars' 	=> $options_details_arr[0]['charge_in_dollars'],
				'charges_in_euro' 		=> $options_details_arr[0]['charge_in_euro'],
				'option_icon' 			=> $options_details_arr[0]['option_icon'],
				'is_active' 			=> $options_details_arr[0]['is_active']
			);
        }
        return $result;
    }

	function inactive($options_id)
	{
		$this->db->update("lb_bunglow_options", array("is_active"=>"N"), array("id"=>$options_id));
	}
	function active($options_id)
	{
		$this->db->update("lb_bunglow_options", array("is_active"=>"Y"), array("id"=>$options_id));
	}
	
	function delete($options_id)
	{
		$this->db->delete("lb_bunglow_options", array("id"=>$options_id));
		$this->db->delete("lb_bunglow_options_lang", array("options_id"=>$options_id));
	}
	
	
	function options_edit()
	{
		$languages_err=$this->db->get("mast_language")->result_array();
		$posted_options_id=$this->input->post("options_id");
		$posted_language_id=$this->input->post("language_id");
		$languages_err=$this->db->get("mast_language")->result_array();
		$charges_in_dollars=$this->input->post("charge_in_dollars");
		$charges_in_euro=$this->input->post("charge_in_euro");
		
		if($_FILES["option_icon"]['name']!="")
		{
			$size = list($width, $height, $type, $attr) = getimagesize($_FILES["option_icon"]['tmp_name']); 
			$new_file_name=time()."_".$_FILES["option_icon"]['name'];
			if($height>='16' && $width>='16')
			{
				//Unlink previous image 
				$pre_image_arr=$this->db->get_where("lb_bunglow_options", array("id"=>$posted_options_id))->result_array();
				$pre_image=$pre_image_arr[0]['option_icon'];
				if(!empty($pre_image))
				{
					if(file_exists("assets/upload/option_icon/".$pre_image))
					{
						unlink("assets/upload/option_icon/".$pre_image);
					}
				}
		
				//Uploading image;
				$config['file_name'] =$new_file_name;
				$config['upload_path'] = "assets/upload/option_icon/";
				$config['allowed_types'] = "gif|jpg|jpeg|png";
				$config['max_size'] = '1000000';
				$this->load->library('upload', $config);
				if (!$this->upload->do_upload('option_icon'))
				{
					return $this->upload->display_errors();
				}
				else
				{
					//Resizing uploaded images
					$data = array('upload_data' => $this->upload->data());
					$option_icon = $data['upload_data']['file_name'];
					$config['image_library'] = 'gd2';
					$config['source_image'] = 'assets/upload/option_icon/'.$option_icon;
					$config['new_image'] = 'assets/upload/option_icon/'.$option_icon;
					$config['allowed_types'] = "jpg|jpeg|gif|png";
					$config['maintain_ratio'] = FALSE;
					$config['width'] = 16;
					$config['height'] = 16;
					$config['quality'] = 100;
					$this->load->library('image_lib', $config);
					$this->image_lib->initialize($config);
					$this->image_lib->resize();

					//updating data in database
					$update_arr=array(
						"charge_in_dollars"=>$charges_in_dollars,
						"charge_in_euro"=>$charges_in_euro,
						"option_icon"=>$option_icon
					);
					$this->db->update("lb_bunglow_options", $update_arr, array("id"=>$posted_options_id));
					foreach($languages_err as $language)
					{
						$language_id=$language['id'];
						$options_name=$this->input->post("options_name".$language['id']);
						$update_arr_1=array(
							"options_name"=>$options_name
						);
						
						$this->db->update("lb_bunglow_options_lang", $update_arr_1, array("language_id"=>$language['id'], "options_id"=>$posted_options_id));
					}
					return "edit_success";
				}
			}
			else 
			{
				return "file_size";
			}
		}
		else
		{
			$update_arr=array(
				"charge_in_dollars"=>$charges_in_dollars,
				"charge_in_euro"=>$charges_in_euro
			);
			$this->db->update("lb_bunglow_options", $update_arr, array("id"=>$posted_options_id));
			foreach($languages_err as $language)
			{
				$language_id=$language['id'];
				$options_name=$this->input->post("options_name".$language['id']);
				$update_arr_1=array(
					"options_name"=>$options_name
				);
				
				$this->db->update("lb_bunglow_options_lang", $update_arr_1, array("language_id"=>$language['id'], "options_id"=>$posted_options_id));
			}
			return "edit_success";
		}
	}
}
	

?>