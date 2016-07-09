<?php
class banner_model extends CI_Model
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
	
	

	//######################ADDING BANNERS ACCORDING TO LANGUAGE###########################
	
	function banner_add()
	{
		$languages_err=$this->db->get("mast_language")->result_array();
		$banner_url=$this->input->post("banner_url");
		$this->db->select_max("sort_order");
		$max_order_array=$this->db->get('lb_banner')->result_array();
		$max_order=$max_order_array[0]['sort_order'];
		$size = list($width, $height, $type, $attr) = getimagesize($_FILES["banner_image"]['tmp_name']); 
		$new_file_name=time()."_".$_FILES["banner_image"]['name'];
		if($height>='531' && $width>='1600')
		{
			//Uploading image;
			$config['file_name'] =$new_file_name;
			$config['upload_path'] = "assets/upload/banner/";
			$config['allowed_types'] = "gif|jpg|jpeg|png";
			$config['max_size'] = '1000000';
			$this->load->library('upload', $config);
			if (!$this->upload->do_upload('banner_image'))
			{
				return $this->upload->display_errors();
			}
			else
			{
				//Resizing uploaded images
				$data = array('upload_data' => $this->upload->data());
				$banner_image = $data['upload_data']['file_name'];
				//Resize 1st Image
				$config['image_library'] = 'gd2';
				$config['source_image'] = 'assets/upload/banner/'.$banner_image;
				$config['new_image'] = 'assets/upload/banner/thumb/'.$banner_image;
				$config['allowed_types'] = "jpg|jpeg|gif|png";
				$config['maintain_ratio'] = FALSE;
				$config['width'] = 1600;
				$config['height'] = 531;
				$config['quality'] = 100;
				$this->load->library('image_lib', $config);
				$this->image_lib->initialize($config);
				$this->image_lib->resize();

				//Inserting data in database
				$insert_arr=array(
					"banner_url"=>$banner_url,
					"banner_image"=>$new_file_name,
					"sort_order"=>$max_order+1,
				);
				$this->db->insert("lb_banner", $insert_arr);
				$last_id=$this->db->insert_id();
				foreach($languages_err as $language)
				{
					$language_id=$language['id'];
					$banner_id=$last_id;
					$banner_title=$this->input->post("banner_title".$language['id']);
					$banner_desc=$this->input->post("banner_desc".$language['id']);
					$banner_alt=$this->input->post("banner_alt".$language['id']);
					
					$insert_arr_1=array(
						"language_id"=>$language_id,
						"banner_id"=>$banner_id,
						"banner_title"=>$banner_title,
						"banner_alt"=>$banner_alt,
						"banner_desc"=>$banner_desc
					);
					
					$this->db->insert("lb_banner_lang", $insert_arr_1);
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
	
	function get_banners($language_id, $banner_id) //Get all banners according to language for edit
	{
		//Get language data of selected language
		$this->db->order_by("id");
		$lang_arr_1=$this->db->get_where("mast_language", array("id"=>$language_id))->result_array();
		//Get language data of remaining languages
		$this->db->where("id !=", $language_id);
		$lang_arr_2=$this->db->get("mast_language")->result_array();
		$languages_arr=array_merge($lang_arr_1, $lang_arr_2);
		$all_banners_arr=array();
		$i=0;
		foreach($languages_arr as $languages)
		{
			$this->db->where("language_id", $languages['id']);
			$this->db->where("banner_id", $banner_id);
			$banners_arr=$this->db->get("lb_banner_lang")->result_array();
			$all_banners_arr[$i]['id']=$languages['id'];
			$all_banners_arr[$i]['language_id']=$banners_arr[0]['language_id'];
			$all_banners_arr[$i]['banner_id']=$banners_arr[0]['banner_id'];
			$all_banners_arr[$i]['banner_desc']=$banners_arr[0]['banner_desc'];
			$all_banners_arr[$i]['banner_title']=$banners_arr[0]['banner_title'];
			$all_banners_arr[$i]['banner_alt']=$banners_arr[0]['banner_alt'];
			$all_banners_arr[$i]['language_name']=$languages['language_name'];
			$all_banners_arr[$i]['flag_image_name']=$languages['flag_image_name'];
			$i++;
		}
		return $all_banners_arr;
	}
	
	function get_unique_details($banner_id) //Get details of page unique to both languages e.g page_slug
	{
		$result=$this->db->get_where("lb_banner", array("id"=>$banner_id))->result_array();
		return $result;
	}
	

	
	//Getting All Banner At Once
	function get_rows($language_id, $id = 0)//Get all rows for listing page
    {
        $result = array();
        if ($id == 0) //all rows requested according to language id
        {
			//$this->db->where('language_id', $language_id);
			//$this->db->order_by('id');
            //$query = $this->db->get('lb_banner_lang');
			$this->db->select('*');
			$this->db->from('lb_banner');
			$this->db->order_by('lb_banner.sort_order', 'asc');
			$this->db->join('lb_banner_lang', 'lb_banner.id = lb_banner_lang.banner_id AND lb_banner_lang.language_id='.$language_id);
			$query = $this->db->get();
        }
        else //single row requested according to language id
        {
            $this->db->where('id', $id);
			$this->db->where('language_id', $language_id);
            $this->db->select('*');
            $query = $this->db->get('lb_banner_lang');
        }
        foreach ($query->result() as $row) 
		{
			$banner_id=$row->banner_id;
			$banner_details_arr=$this->db->get_where("lb_banner", array("id"=>$banner_id))->result_array();
			$result[] = array(
				'id' 					=> $row->id,
				'banner_id' 			=> $row->banner_id,
				'language_id' 			=> $row->language_id,
				'banner_desc' 			=> $row->banner_desc,
				'banner_title' 			=> $row->banner_title,
				'banner_alt' 			=> $row->banner_alt,
				'banner_image' 			=> $banner_details_arr[0]['banner_image'],
				'banner_url'			=> $banner_details_arr[0]['banner_url'],
				'sort_order'			=> $banner_details_arr[0]['sort_order'],
				'is_active'				=> $banner_details_arr[0]['is_active']
			);
        }
        return $result;
    }
	
	//Getting Banner According to Pagination but it is not required because no pagination is required
	function get_rows_pagination($language_id, $limit, $offset)
	{
		$result = array();
		$this->db->where('language_id', $language_id);
		$this->db->order_by('id');
		$query = $this->db->get('lb_banner_lang', $limit, $offset);
        
        foreach ($query->result() as $row) 
		{
			$banner_id=$row->banner_id;
			$banner_details_arr=$this->db->get_where("lb_banner", array("id"=>$banner_id))->result_array();
			$result[] = array(
				'id' 					=> $row->id,
				'banner_id' 			=> $row->banner_id,
				'language_id' 			=> $row->language_id,
				'banner_title' 			=> $row->banner_title,
				'banner_alt' 			=> $row->banner_alt,
				'banner_image' 			=> $banner_details_arr[0]['banner_image'],
				'banner_url'			=> $banner_details_arr[0]['banner_url'],
				'sort_order'			=> $banner_details_arr[0]['sort_order'],
				'is_active'				=> $banner_details_arr[0]['is_active']
			);
        }
        return $result;
	}
	
	
	function inactive($banner_id)
	{
		$this->db->update("lb_banner", array("is_active"=>"N"), array("id"=>$banner_id));
	}
	function active($banner_id)
	{
		$this->db->update("lb_banner", array("is_active"=>"Y"), array("id"=>$banner_id));
	}
	
	function delete($banner_id)
	{
		$banner_details_arr=$this->db->get_where("lb_banner", array("id"=>$banner_id))->result_array();
		$banner_image=$banner_details_arr[0]['banner_image'];
		if(!empty($banner_image))
		{
			if(file_exists("assets/upload/banner/".$banner_image))
			{
				unlink("assets/upload/banner/".$banner_image);
				unlink("assets/upload/banner/thumb/".$banner_image);
			}
		}
		$this->db->delete("lb_banner", array("id"=>$banner_id));
		$this->db->delete("lb_banner_lang", array("banner_id"=>$banner_id));
		
		$this->db->order_by("sort_order", "asc");
		$banner_details_arr=$this->db->get("lb_banner")->result_array();
		for($i=0; $i<count($banner_details_arr); $i++)
		{
			$banner_id=$banner_details_arr[$i]['id'];
			$this->db->update("lb_banner", array("sort_order"=>$i+1), array("id"=>$banner_id));
		}
	}
	
	
	function banner_edit()
	{
		$languages_err=$this->db->get("mast_language")->result_array();
		$banner_url=$this->input->post("banner_url");
		$posted_banner_id=$this->input->post("banner_id");
		$posted_language_id=$this->input->post("language_id");
		if($_FILES["banner_image"]['name']!="")
		{
			$size = list($width, $height, $type, $attr) = getimagesize($_FILES["banner_image"]['tmp_name']); 
			$new_file_name=time()."_".$_FILES["banner_image"]['name'];
			if($height>='531' && $width>='1600')
			{
				//Unlink previous image 
				$pre_image_arr=$this->db->get_where("lb_banner", array("id"=>$posted_banner_id))->result_array();
				$pre_image=$pre_image_arr[0]['banner_image'];
				if(!empty($pre_image))
				{
					if(file_exists("assets/upload/banner/".$pre_image))
					{
						unlink("assets/upload/banner/".$pre_image);
						unlink("assets/upload/banner/thumb/".$pre_image);
					}
				}
		
				//Uploading image;
				$config['file_name'] =$new_file_name;
				$config['upload_path'] = "assets/upload/banner/";
				$config['allowed_types'] = "gif|jpg|jpeg|png";
				$config['max_size'] = '1000000';
				$this->load->library('upload', $config);
				if (!$this->upload->do_upload('banner_image'))
				{
					return $this->upload->display_errors();
				}
				else
				{
					//Resizing uploaded images
					$data = array('upload_data' => $this->upload->data());
					$banner_image = $data['upload_data']['file_name'];
					$config['image_library'] = 'gd2';
					$config['source_image'] = 'assets/upload/banner/'.$banner_image;
					$config['new_image'] = 'assets/upload/banner/thumb/'.$banner_image;
					$config['allowed_types'] = "jpg|jpeg|gif|png";
					$config['maintain_ratio'] = FALSE;
					$config['width'] = 1600;
					$config['height'] = 531;
					$config['quality'] = 100;
					$this->load->library('image_lib', $config);
					$this->image_lib->initialize($config);
					$this->image_lib->resize();

					//updating data in database
					$upd_arr=array(
						"banner_url"=>$banner_url,
						"banner_image"=>$new_file_name
					);
					$this->db->update("lb_banner", $upd_arr, array("id"=>$posted_banner_id));
					foreach($languages_err as $language)
					{
						$banner_desc=$this->input->post("banner_desc".$language['id']);
						$banner_title=$this->input->post("banner_title".$language['id']);
						$banner_alt=$this->input->post("banner_alt".$language['id']);
						$upd_arr_1=array(
							"banner_title"=>$banner_title,
							"banner_alt"=>$banner_alt,
							"banner_desc"=>$banner_desc
						);
						
						$this->db->update("lb_banner_lang", $upd_arr_1, array("language_id"=>$language['id'], "banner_id"=>$posted_banner_id));
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
			$upd_arr=array(
				"banner_url"=>$banner_url,
			);
			$this->db->update("lb_banner", $upd_arr, array("id"=>$posted_banner_id));
	
			foreach($languages_err as $language)
			{
				$banner_desc=$this->input->post("banner_desc".$language['id']);
				$banner_title=$this->input->post("banner_title".$language['id']);
				$banner_alt=$this->input->post("banner_alt".$language['id']);
				$upd_arr_1=array(
					"banner_title"=>$banner_title,
					"banner_alt"=>$banner_alt,
					"banner_desc"=>$banner_desc
				);
				
				$this->db->update("lb_banner_lang", $upd_arr_1, array("language_id"=>$language['id'], "banner_id"=>$posted_banner_id));
			}
			return "edit_success";
		}
	}
	
	function get_max_order()
	{
		$this->db->select_max('sort_order');
		$query = $this->db->get('lb_banner')->result_array();
		return $query[0]['sort_order'];
	}
	
	function change_order($current_id, $current_order, $changed_order)
	{
		$get_banner_details=$this->db->get_where("lb_banner", array("sort_order"=>$changed_order))->result_array();
		$this->db->update("lb_banner", array("sort_order"=>$changed_order), array("id"=>$current_id));
		$this->db->update("lb_banner", array("sort_order"=>$current_order), array("id"=>$get_banner_details[0]['id']));
	}
	
}
	

?>