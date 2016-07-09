<?php
class gallery_model extends CI_Model
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
	
	function gallery_add()
	{
		$languages_err=$this->db->get("mast_language")->result_array();
		
		$this->db->select_max("sort_order");
		$max_order_array=$this->db->get('lb_gallery')->result_array();
		$max_order=$max_order_array[0]['sort_order'];
		
		//$size = list($width, $height, $type, $attr) = getimagesize($_FILES["gallery_image"]['tmp_name']); 
		$new_file_name=time()."_".$_FILES["gallery_image"]['name'];
		
		/*if($height>='360' && $width>='238')
		{*/
			//Uploading image;
			$config['file_name'] =$new_file_name;
			$config['upload_path'] = "assets/upload/gallery/";
			$config['allowed_types'] = "gif|jpg|jpeg|png|JPG";
			$config['max_size'] = '1000000';

			$this->load->library('upload', $config);
			if (!$this->upload->do_upload('gallery_image'))
			{
				return $this->upload->display_errors();
			}
			else
			{
				//Resizing uploaded images
				$data = array('upload_data' => $this->upload->data());
				$gallery_image = $data['upload_data']['file_name'];
				//Resize 1st Image
				$config['image_library'] = 'gd2';
				$config['source_image'] = 'assets/upload/gallery/'.$gallery_image;
				$config['new_image'] = 'assets/upload/gallery/thumb/'.$gallery_image;
				$config['allowed_types'] = "jpg|jpeg|gif|png|JPG";
				$config['maintain_ratio'] = FALSE;
				$config['width'] = 360;
				$config['height'] = 238;
				$config['quality'] = 100;
				$this->load->library('image_lib', $config);
				$this->image_lib->initialize($config);
				$this->image_lib->resize();
				//Resize 2nd Image
				$config="";
				$config['image_library'] = 'gd2';
				$config['source_image'] = 'assets/upload/gallery/'.$gallery_image;
				$config['new_image'] = 'assets/upload/gallery/thumb_large/'.$gallery_image;
				$config['allowed_types'] = "jpg|jpeg|gif|png|JPG";
				$config['maintain_ratio'] = FALSE;
				$config['width'] = 360;
				$config['height'] = 238;
				$config['quality'] = 100;
				$this->load->library('image_lib', $config);
				$this->image_lib->initialize($config);
				$this->image_lib->resize();

				//Inserting data in database
				$insert_arr=array(
					"image_file_name"=>$new_file_name,
					"is_featured"=>$this->input->post('is_featured'),
					"is_active"=>"Y",
					"sort_order"=>$max_order+1,
					"creation_date"=>date("Y-m-d H:i:s")
				);
				$this->db->insert("lb_gallery", $insert_arr);
				$last_id=$this->db->insert_id();
				foreach($languages_err as $language)
				{
					$language_id=$language['id'];
					$gallery_id=$last_id;
					$gallery_title=$this->input->post("gallery_title".$language['id']);
					$gallery_desc=$this->input->post("description".$language['id']);
					
					$insert_arr_1=array(
						"language_id"=>$language_id,
						"gallery_id"=>$gallery_id,
						"title"=>$gallery_title,
						"description"=>$gallery_desc
					);
					
					$this->db->insert("lb_gallery_lang", $insert_arr_1);
				}
				return "add_success";
			}
		/*}
		else 
		{
			return "file_size";
		}*/
	}
		
	
	//###################################################################################
	
	//##################################Edit Pages#######################################
	
	function get_gallery($language_id, $gallery_id) //Get all banners according to language for edit
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
			$this->db->where("gallery_id", $gallery_id);
			$gallery_arr=$this->db->get("lb_gallery_lang")->result_array();
			$all_gallery_arr[$i]['id']=$languages['id'];
			$all_gallery_arr[$i]['language_id']=$gallery_arr[0]['language_id'];
			$all_gallery_arr[$i]['gallery_id']=$gallery_arr[0]['gallery_id'];
			$all_gallery_arr[$i]['description']=$gallery_arr[0]['description'];
			$all_gallery_arr[$i]['title']=$gallery_arr[0]['title'];
			$all_gallery_arr[$i]['language_name']=$languages['language_name'];
			$all_gallery_arr[$i]['flag_image_name']=$languages['flag_image_name'];
			$i++;
		}
		return $all_gallery_arr;
	}
	
	function get_unique_details($gallery_id) //Get details of page unique to both languages e.g page_slug
	{
		$result=$this->db->get_where("lb_gallery", array("id"=>$gallery_id))->result_array();
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
            //$query = $this->db->get('lb_gallery_lang');
			$this->db->select('*');
			$this->db->from('lb_gallery');
			$this->db->order_by('lb_gallery.sort_order', 'asc');
			$this->db->join('lb_gallery_lang', 'lb_gallery.id = lb_gallery_lang.gallery_id AND lb_gallery_lang.language_id='.$language_id);
			$query = $this->db->get();
        }
        else //single row requested according to language id
        {
            $this->db->where('id', $id);
			$this->db->where('language_id', $language_id);
            $this->db->select('*');
            $query = $this->db->get('lb_gallery_lang');
        }
        foreach ($query->result() as $row) 
		{
			$gallery_id=$row->gallery_id;
			$gallery_details_arr=$this->db->get_where("lb_gallery", array("id"=>$gallery_id))->result_array();
			$result[] = array(
				'id' 					=> $row->id,
				'gallery_id' 			=> $row->gallery_id,
				'language_id' 			=> $row->language_id,
				'title' 				=> $row->title,
				'description' 			=> $row->description,
				'image' 				=> $gallery_details_arr[0]['image_file_name'],
				'is_featured'			=> $gallery_details_arr[0]['is_featured'],
				'is_active'				=> $gallery_details_arr[0]['is_active'],
				'sort_order'			=> $gallery_details_arr[0]['sort_order']
			);
        }
        return $result;
    }
	
	
	
	function inactive($gallery_id)
	{
		$this->db->update("lb_gallery", array("is_active"=>"N"), array("id"=>$gallery_id));
	}
	function active($gallery_id)
	{
		$this->db->update("lb_gallery", array("is_active"=>"Y"), array("id"=>$gallery_id));
	}
	
	function delete($gallery_id)
	{
		$gallery_details_arr=$this->db->get_where("lb_gallery", array("id"=>$gallery_id))->result_array();
		$gallery_image=$gallery_details_arr[0]['image_file_name'];
		if(!empty($gallery_image))
		{
			if(file_exists("assets/upload/gallery/".$gallery_image))
			{
				unlink("assets/upload/gallery/".$gallery_image);
				unlink("assets/upload/gallery/thumb/".$gallery_image);
				unlink("assets/upload/gallery/thumb_large/".$gallery_image);
			}
		}
		$this->db->delete("lb_gallery", array("id"=>$gallery_id));
		$this->db->delete("lb_gallery_lang", array("gallery_id"=>$gallery_id)); 
		clearstatcache();
	}
	
	
	function gallery_edit()
	{
		$languages_err=$this->db->get("mast_language")->result_array();
		$posted_gallery_id=$this->input->post("gallery_id");
		$posted_language_id=$this->input->post("language_id");
		if($_FILES["gallery_image"]['name']!="")
		{
			$size = list($width, $height, $type, $attr) = getimagesize($_FILES["gallery_image"]['tmp_name']); 
			$new_file_name=time()."_".$_FILES["gallery_image"]['name'];
			//if($height>='360' && $width>='238')
			//{
				//Unlink previous image 
				$pre_image_arr=$this->db->get_where("lb_gallery", array("id"=>$posted_gallery_id))->result_array();
				$pre_image=$pre_image_arr[0]['image_file_name'];
				if(!empty($pre_image))
				{
					if(file_exists("assets/upload/gallery/".$pre_image))
					{
						unlink("assets/upload/gallery/".$pre_image);
						unlink("assets/upload/gallery/thumb/".$pre_image);
						unlink("assets/upload/gallery/thumb_large/".$pre_image);
					}
				}
		
				//Uploading image;
				$config['file_name'] =$new_file_name;
				$config['upload_path'] = "assets/upload/gallery/";
				$config['allowed_types'] = "gif|jpg|jpeg|png|JPG";
				$config['max_size'] = '1000000';
				$this->load->library('upload', $config);
				if (!$this->upload->do_upload('gallery_image'))
				{
					return $this->upload->display_errors();
				}
				else
				{
					//Resizing uploaded images
					$data = array('upload_data' => $this->upload->data());
					$banner_image = $data['upload_data']['file_name'];
					$config['image_library'] = 'gd2';
					$config['source_image'] = 'assets/upload/gallery/'.$banner_image;
					$config['new_image'] = 'assets/upload/gallery/thumb/'.$banner_image;
					$config['allowed_types'] = "jpg|jpeg|gif|png|JPG";
					$config['maintain_ratio'] = FALSE;
					$config['width'] = 360;
					$config['height'] = 238;
					$config['quality'] = 100;
					$this->load->library('image_lib', $config);
					$this->image_lib->initialize($config);
					$this->image_lib->resize();
					
					$config="";
					$config['image_library'] = 'gd2';
					$config['source_image'] = 'assets/upload/gallery/'.$banner_image;
					$config['new_image'] = 'assets/upload/gallery/thumb_large/'.$banner_image;
					$config['allowed_types'] = "jpg|jpeg|gif|png|JPG";
					$config['maintain_ratio'] = FALSE;
					$config['width'] = 360;
					$config['height'] = 238;
					$config['quality'] = 100;
					$this->load->library('image_lib', $config);
					$this->image_lib->initialize($config);
					$this->image_lib->resize();

					//updating data in database
					$upd_arr=array(
						"image_file_name"=>$new_file_name,
						"is_featured"=>$this->input->post('is_featured'),
						"modified_date"=>date("Y-m-d H:i:s")
					);
					$this->db->update("lb_gallery", $upd_arr, array("id"=>$posted_gallery_id));
					foreach($languages_err as $language)
					{
						$gallery_desc=$this->input->post("description".$language['id']);
						$gallery_title=$this->input->post("gallery_title".$language['id']);
						$upd_arr_1=array(
							"title"=>$gallery_title,
							"description"=>$gallery_desc
						);
						
						$this->db->update("lb_gallery_lang", $upd_arr_1, array("language_id"=>$language['id'], "gallery_id"=>$posted_gallery_id));
					}
					return "edit_success";
				}
			/*}
			else 
			{
				return "file_size";
			}*/
		}
		else  
		{
			$upd_arr=array(
				"is_featured"=>$this->input->post('is_featured'),
				"modified_date"=>date("Y-m-d H:i:s")
			);
			$this->db->update("lb_gallery", $upd_arr, array("id"=>$posted_gallery_id));
			foreach($languages_err as $language)
			{
				$gallery_desc=$this->input->post("description".$language['id']);
				$gallery_title=$this->input->post("gallery_title".$language['id']);
				$upd_arr_1=array(
					"title"=>$gallery_title,
					"description"=>$gallery_desc
				);
				
				$this->db->update("lb_gallery_lang", $upd_arr_1, array("language_id"=>$language['id'], "gallery_id"=>$posted_gallery_id));
			}
			return "edit_success";
		}
	}
	
	//Set gallery as featured
	function set_featured($gallery_id)
	{
		$result=$this->db->get_where("lb_gallery", array("id"=>$gallery_id))->result_array();
		if($result[0]["is_featured"]=="Y")
		{
			$this->db->update("lb_gallery", array("is_featured"=>"N"), array("id"=>$gallery_id));
		}
		if($result[0]["is_featured"]=="N")
		{
			$this->db->update("lb_gallery", array("is_featured"=>"Y"), array("id"=>$gallery_id));
		}
	}
	
	function get_max_order()
	{
		$this->db->select_max('sort_order');
		$query = $this->db->get('lb_gallery')->result_array();
		return $query[0]['sort_order'];
	}
	
	function change_order($current_id, $current_order, $changed_order)
	{
		$get_banner_details=$this->db->get_where("lb_gallery", array("sort_order"=>$changed_order))->result_array();
		$this->db->update("lb_gallery", array("sort_order"=>$changed_order), array("id"=>$current_id));
		$this->db->update("lb_gallery", array("sort_order"=>$current_order), array("id"=>$get_banner_details[0]['id']));
	}
	
	//#########################Functions for front end#########################
	
	//Function to get all active gallery image in front end
	function get_rows_for_front_end($limit, $offset)
	{
		$current_lang_id=$this->session->userdata("current_lang_id");
		$this->db->select('*');
		$this->db->from('lb_gallery');
		$this->db->order_by('lb_gallery.sort_order', 'asc');
		$this->db->join('lb_gallery_lang', 'lb_gallery.id = lb_gallery_lang.gallery_id AND lb_gallery.is_active = "Y" AND lb_gallery_lang.language_id='.$current_lang_id);
		$this->db->limit($limit, $offset);
		$query = $this->db->get()->result_array();
		$this->db->last_query();
		return $query;
	}
	
	//Function to get total active gallery()
	function get_total_active_gallery()
	{
		$query=$this->db->get_where("lb_gallery", array("is_active"=>"Y"))->result_array();
		return count($query);
	}
}
	

?>