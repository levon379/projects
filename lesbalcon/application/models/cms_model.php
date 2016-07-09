<?php
class cms_model extends CI_Model
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
	
	//Function to create unique slug
	public function create_unique_slug($string,$table,$field='pages_slug',$key=NULL,$value=NULL)
	{
		$slug = url_title($string);
		$slug = strtolower($slug);
		$i = 0;
		$params = array ();
		$params[$field] = $slug;
	 
		if($key)$params["$key !="] = $value;
	 
		while ($this->db->where($params)->get($table)->num_rows())
		{  
			if (!preg_match ('/-{1}[0-9]+$/', $slug ))
				$slug .= '-' . ++$i;
			else
				$slug = preg_replace ('/[0-9]+$/', ++$i, $slug );
			 
			$params [$field] = $slug;
		}  
		return $slug;  
	}
	
	//Function to create unique seo url
	public function create_unique_seo_url($string,$table,$field='pages_seo_url',$key=NULL,$value=NULL)
	{
		$slug = url_title($string);
		$slug = strtolower($slug);
		$i = 0;
		$params = array ();
		$params[$field] = $slug;
	 
		if($key)$params["$key !="] = $value;
	 
		while ($this->db->where($params)->get($table)->num_rows())
		{  
			if (!preg_match ('/-{1}[0-9]+$/', $slug ))
				$slug .= '-' . ++$i;
			else
				$slug = preg_replace ('/[0-9]+$/', ++$i, $slug );
			 
			$params [$field] = $slug;
		}  
		return $slug;  
	}

	
	//*******************************************ADMIN PANEL CATEGORY**********************************************************************//
	
	

	//######################ADDING PAGES ACCORDING TO LANGUAGE###########################
	
	function cms_add()
	{
		$languages_err=$this->db->get("mast_language")->result_array();
		$page_slug=$this->input->post("page_slug");
		$new_slug=$this->create_unique_slug($page_slug, "lb_pages");
		$page_seo_url=$this->input->post("page_seo_url");
		$page_seo_url=$this->create_unique_seo_url($page_seo_url, "lb_pages");
		$size = list($width, $height, $type, $attr) = getimagesize($_FILES["page_banner"]['tmp_name']); 
		$new_file_name=time()."_".$_FILES["page_banner"]['name'];
		if($height>='193' && $width>='1600')
		{
			//Uploading image;
			$config['file_name'] =$new_file_name;
			$config['upload_path'] = "assets/upload/page_banner/";
			$config['allowed_types'] = "gif|jpg|jpeg|png";
			$config['max_size'] = '1000000';
			$this->load->library('upload', $config);
			if (!$this->upload->do_upload('page_banner'))
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
				$config['source_image'] = 'assets/upload/page_banner/'.$banner_image;
				$config['new_image'] = 'assets/upload/page_banner/thumb/'.$banner_image;
				$config['allowed_types'] = "jpg|jpeg|gif|png";
				$config['maintain_ratio'] = FALSE;
				$config['width'] = 1600;
				$config['height'] = 193;
				$config['quality'] = 100;
				$this->load->library('image_lib', $config);
				$this->image_lib->initialize($config);
				$this->image_lib->resize();
				
				$insert_arr=array(
				"creation_date"=>date("Y-m-d H:i:s"),
				"page_banner"=>$new_file_name,
				"pages_slug"=>$new_slug,
				"pages_seo_url"=>$page_seo_url
				);
				$this->db->insert("lb_pages", $insert_arr);
				$last_id=$this->db->insert_id();
				foreach($languages_err as $language)
				{
					$language_id=$language['id'];
					$pages_id=$last_id;
					$pages_seo_url=$page_seo_url;
					$page_title=$this->input->post("page_title".$language['id']);
					$page_desc=$this->input->post("page_desc".$language['id']);
					$meta_title=$this->input->post("meta_title".$language['id']);
					$meta_keyword=$this->input->post("meta_keyword".$language['id']);
					$meta_desc=$this->input->post("meta_desc".$language['id']);
					$pages_slug=$new_slug;
					$modified_date=date("Y-m-d H:i:s");
					
					$insert_arr_1=array(
						"language_id"=>$language_id,
						"pages_id"=>$pages_id,
						"pages_seo_url"=>$page_seo_url,
						"pages_title"=>$page_title,
						"pages_content"=>$page_desc,
						"pages_meta_title"=>$meta_title,
						"pages_meta_description"=>$meta_desc,
						"pages_meta_keyword"=>$meta_keyword,
						"pages_slug"=>$pages_slug,
						"modified_date"=>$modified_date
					);
					
					$this->db->insert("lb_pages_lang", $insert_arr_1);
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
	
	function get_pages($language_id, $page_id) //Get all pages according to language for edit
	{
		//Get data of selected language
		$this->db->order_by("id");
		$lang_arr_1=$this->db->get_where("mast_language", array("id"=>$language_id))->result_array();
		//Get data of remaining languages
		$this->db->where("id !=", $language_id);
		$lang_arr_2=$this->db->get("mast_language")->result_array();
		$languages_arr=array_merge($lang_arr_1, $lang_arr_2);
		$all_pages_arr=array();
		$i=0;
		foreach($languages_arr as $languages)
		{
			$this->db->where("language_id", $languages['id']);
			$this->db->where("pages_id", $page_id);
			$pages_arr=$this->db->get("lb_pages_lang")->result_array();
			$all_pages_arr[$i]['id']=$languages['id'];
			$all_pages_arr[$i]['language_id']=$pages_arr[0]['language_id'];
			$all_pages_arr[$i]['pages_id']=$pages_arr[0]['pages_id'];
			$all_pages_arr[$i]['pages_title']=$pages_arr[0]['pages_title'];
			$all_pages_arr[$i]['pages_content']=$pages_arr[0]['pages_content'];
			$all_pages_arr[$i]['pages_meta_title']=$pages_arr[0]['pages_meta_title'];
			$all_pages_arr[$i]['pages_meta_description']=$pages_arr[0]['pages_meta_description'];
			$all_pages_arr[$i]['pages_meta_keyword']=$pages_arr[0]['pages_meta_keyword'];
			$all_pages_arr[$i]['language_name']=$languages['language_name'];
			$all_pages_arr[$i]['flag_image_name']=$languages['flag_image_name'];
			$i++;
		}
		return $all_pages_arr;
	}
	
	function get_unique_details($page_id) //Get details of page unique to both languages e.g page_slug
	{
		$result=$this->db->get_where("lb_pages", array("id"=>$page_id))->result_array();
		return $result;
	}
	
	
	function cms_edit()
	{
		$languages_err=$this->db->get("mast_language")->result_array();
		$page_id=$this->input->post("page_id");
		$page_slug=$this->input->post("page_slug");
		
		$page_details_arr=$this->db->get_where("lb_pages", array("id"=>$page_id))->result_array();
		$previous_seo_url=$page_details_arr[0]['pages_seo_url'];
		$previous_banner_image=$page_details_arr[0]['page_banner'];
		$page_seo_url=$this->input->post("page_seo_url");
		if($page_seo_url==$previous_seo_url)
		{
			$page_seo_url=$this->input->post("page_seo_url");
		}
		else 
		{
			$page_seo_url=$this->create_unique_seo_url($page_seo_url, "lb_pages");
		}
		
		if($_FILES["page_banner"]['name']!="")//If page is getting updated with banner images
		{
			$size = list($width, $height, $type, $attr) = getimagesize($_FILES["page_banner"]['tmp_name']); 
			$new_file_name=time()."_".$_FILES["page_banner"]['name'];
			if($height>='193' && $width>='1600')
			{
				//Uploading image;
				$config['file_name'] =$new_file_name;
				$config['upload_path'] = "assets/upload/page_banner/";
				$config['allowed_types'] = "gif|jpg|jpeg|png";
				$config['max_size'] = '1000000';
				$this->load->library('upload', $config);
				if (!$this->upload->do_upload('page_banner'))
				{
					return $this->upload->display_errors();
				}
				else 
				{
					//Unlinking previous banner image
					if($previous_banner_image!="")
					{
						if(file_exists("assets/upload/page_banner/".$previous_banner_image))
						{
							unlink("assets/upload/page_banner/".$previous_banner_image);
							unlink("assets/upload/page_banner/thumb/".$previous_banner_image);
						}
					}
					//Resizing uploaded images
					$data = array('upload_data' => $this->upload->data());
					$banner_image = $data['upload_data']['file_name'];
					//Resize 1st Image
					$config['image_library'] = 'gd2';
					$config['source_image'] = 'assets/upload/page_banner/'.$banner_image;
					$config['new_image'] = 'assets/upload/page_banner/thumb/'.$banner_image;
					$config['allowed_types'] = "jpg|jpeg|gif|png";
					$config['maintain_ratio'] = FALSE;
					$config['width'] = 1600;
					$config['height'] = 193;
					$config['quality'] = 100;
					$this->load->library('image_lib', $config);
					$this->image_lib->initialize($config);
					$this->image_lib->resize();
					$update_arr=array(
						"pages_seo_url"=>$page_seo_url,
						"page_banner"=>$new_file_name
					);
					$this->db->update("lb_pages",  $update_arr, array("id"=>$page_id));
					foreach($languages_err as $language)
					{
						$language_id=$language['id'];
						$pages_seo_url=$page_seo_url;
						$page_title=$this->input->post("page_title".$language['id']);
						$page_desc=$this->input->post("page_desc".$language['id']);
						$meta_title=$this->input->post("meta_title".$language['id']);
						$meta_keyword=$this->input->post("meta_keyword".$language['id']);
						$meta_desc=$this->input->post("meta_desc".$language['id']);
						$pages_slug=$page_slug;
						$modified_date=date("Y-m-d H:i:s");
						
						$update_arr_1=array(
							"pages_seo_url"=>$page_seo_url,
							"pages_title"=>$page_title,
							"pages_content"=>$page_desc,
							"pages_meta_title"=>$meta_title,
							"pages_meta_description"=>$meta_desc,
							"pages_meta_keyword"=>$meta_keyword,
							"pages_slug"=>$pages_slug,
							"modified_date"=>$modified_date
						);
						
						$this->db->update("lb_pages_lang", $update_arr_1, array("language_id"=>$language_id, "pages_id"=>$page_id));
					}
					return "edit_success";
				}
			}
			else 
			{
				return "file_size";
			}
		}
		else //If page is getting updated without banner images
		{
			$update_arr=array(
				"pages_seo_url"=>$page_seo_url
			);
			$this->db->update("lb_pages",  $update_arr, array("id"=>$page_id));
			foreach($languages_err as $language)
			{
				$language_id=$language['id'];
				$pages_seo_url=$page_seo_url;
				$page_title=$this->input->post("page_title".$language['id']);
				$page_desc=$this->input->post("page_desc".$language['id']);
				$meta_title=$this->input->post("meta_title".$language['id']);
				$meta_keyword=$this->input->post("meta_keyword".$language['id']);
				$meta_desc=$this->input->post("meta_desc".$language['id']);
				$pages_slug=$page_slug;
				$modified_date=date("Y-m-d H:i:s");
				
				$update_arr_1=array(
					"pages_seo_url"=>$page_seo_url,
					"pages_title"=>$page_title,
					"pages_content"=>$page_desc,
					"pages_meta_title"=>$meta_title,
					"pages_meta_description"=>$meta_desc,
					"pages_meta_keyword"=>$meta_keyword,
					"pages_slug"=>$pages_slug,
					"modified_date"=>$modified_date
				);
				
				$this->db->update("lb_pages_lang", $update_arr_1, array("language_id"=>$language_id, "pages_id"=>$page_id));
			}
			return "edit_success";
		}
	}
	

	function get_rows($language_id, $id = 0)//Get all rows for listing page
    {
        $result = array();

        if ($id == 0) //all rows requested according to language id
        {
			$this->db->where('language_id', $language_id);
			$this->db->order_by('id');
            $query = $this->db->get('lb_pages_lang');
        }
        else //single row requested according to language id
        {
            $this->db->where('id', $id);
			$this->db->where('language_id', $language_id);
            $this->db->select('*');
            $query = $this->db->get('lb_pages_lang');
        }
    
        foreach ($query->result() as $row) 
		{
	
			$result[] = array(
				'id' 					=> $row->id,
				'pages_id' 				=> $row->pages_id,
				'language_id' 			=> $row->language_id,
				'pages_slug' 			=> $row->pages_slug,
				'pages_title' 			=> $row->pages_title,
				'pages_content'			=> $row->pages_content,
				'pages_meta_title'		=> $row->pages_meta_title,
				'pages_meta_keyword'	=> $row->pages_meta_keyword,
				'pages_meta_description'=> $row->pages_meta_description,
				'pages_status'			=> $row->published
			);
        }
		//print_r($result);exit;
        return $result;
    }
}
	

?>