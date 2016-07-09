<?php
class bunglow_model extends CI_Model
{
    
	//###############################################################//
	//############### INITIALIZE CONSTRUCTOR CLASS ##################//
	//###############################################################//
	
	function  __construct() 
	{
        parent::__construct();
		$this->load->library('upload');
    }
	
	//###############################################################//
	//############### INITIALIZE CONSTRUCTOR CLASS ##################//
	//###############################################################//
	
	//*******************************************ADMIN PANEL CATEGORY**********************************************************************//
	
	//Function to create unique slug
	public function create_unique_slug($string,$table,$field='slug',$key=NULL,$value=NULL)
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

	//######################//Adding Bunglow with multiple images###########################
	
	function bunglow_add()
	{
		$languages_err=$this->db->get("mast_language")->result_array();
		
		$this->db->select_max("sort_order");
		$max_order_array=$this->db->get('lb_bunglow')->result_array();
		$max_order=$max_order_array[0]['sort_order'];
		
		$b_type=$this->input->post("type");
		
		if($this->input->post("bunglow_options"))
		{
			$bunglow_options=implode(",", $this->input->post("bunglow_options"));
		}
		else 
		{
			$bunglow_options="";
		}
		if($this->input->post("bunglow_tax"))
		{
			$bunglow_tax=implode(",", $this->input->post("bunglow_tax"));
		}
		else 
		{
			$bunglow_tax="";
		}
		
		
		/*$slug=$this->input->post("bunglow_slug");
		$bunglow_slug=$this->create_unique_slug($slug, "lb_bunglow");*/
		//If admin is not providing slug then by default English language Bunglow name will create new slug
		if($this->input->post("bunglow_slug")!="")
		{
			$slug=$this->input->post("bunglow_slug");
			$bunglow_slug=$this->create_unique_slug($slug, "lb_bunglow");
		}
		else 
		{
			$slug=$this->input->post("bunglow_name1");
			$bunglow_slug=$this->create_unique_slug($slug, "lb_bunglow");
		}
		
		$is_featured=$this->input->post("is_featured");
		$max_person=$this->input->post("max_person");
		$virtual_tour_code=$this->input->post("virtual_tour_code");
		$image_size_error=0;
		
		
		//Checking multiple file size.
		foreach($_FILES["bunglow_image"]['tmp_name'] as $image_size)
		{
			list($width, $height, $type, $attr) = getimagesize($image_size); 
			if($height>='241' && $width>='488')
			{
				$image_size_error=0;
			}
			else  
			{
				$image_size_error++;
			}
		}
		//If image error is 0 then all data will be inserted
		if($image_size_error==0)
		{
			//Inserting data into main bunglow table
			$insert_arr=array(
					"type"=>$b_type,
					"option_id"=>$bunglow_options,
					"tax_id"=>$bunglow_tax,
					"sort_order"=>$max_order+1,
					"slug"=>$bunglow_slug,
					"max_person"=>$max_person,
					"virtual_tour_code"=>$virtual_tour_code,
					"is_featured"=>$is_featured,
					"is_active"=>"Y",
					"creation_date"=>date("Y-m-d H:i:s")
			);
			$this->db->insert("lb_bunglow", $insert_arr);
			$last_id=$this->db->insert_id();
				
			//Inserting data into bunglow language table
			foreach($languages_err as $language)
			{
				$language_id=$language['id'];
				$bunglow_id=$last_id;
				$bunglow_name=$this->input->post("bunglow_name".$language['id']);
				$overview=$this->input->post("overview".$language['id']);
				$meta_title=$this->input->post("meta_title".$language['id']);
				$meta_keyword=$this->input->post("meta_keyword".$language['id']);
				$meta_description=$this->input->post("meta_desc".$language['id']);
				$insert_arr_1=array(
					"language_id"=>$language_id,
					"bunglow_id"=>$bunglow_id,
					"bunglow_name"=>$bunglow_name,
					"bunglow_overview"=>$overview,
					"meta_title"=>$meta_title,
					"meta_keyword"=>$meta_keyword,
					"meta_description"=>$meta_description
				);
				$this->db->insert("lb_bunglow_lang", $insert_arr_1);
			}
			
			//Uploading image file and resizing
			foreach($_FILES['bunglow_image'] as $key=>$val)
			{
				$i = 1;
				foreach($val as $v)
				{
					$field_name = "file_".$i;
					$_FILES[$field_name][$key] = $v;
					$i++;   
				}
			}
			unset($_FILES['bunglow_image']);
			$caption_counter=0; //Variable for count caption
			foreach($_FILES as $field_name => $file)
			{
				//Uploading multiple images
				$new_file_name=time()."_".$file['name'];
				$config['upload_path'] = 'assets/upload/bunglow/';
				$config['allowed_types'] = 'gif|jpg|png|gif';
				$config['max_size']	= '1000000';
				$config['file_name']= $new_file_name;
				$this->upload->initialize( $config );
				if (!$this->upload->do_upload($field_name))
				{
					$error = $this->upload->display_errors();
				}
				else
				{
					//Resizing multiple images
					$data = array('upload_data' => $this->upload->data());
					$bunglow_image = $data['upload_data']['file_name'];
					$config['image_library'] = 'gd2';
					$config['source_image'] = 'assets/upload/bunglow/'.$bunglow_image;
					$config['new_image'] = 'assets/upload/bunglow/thumb/'.$bunglow_image;
					$config['allowed_types'] = "jpg|jpeg|gif|png";
					$config['maintain_ratio'] = FALSE;
					$config['width'] = 163;
					$config['height'] = 167;
					$config['quality'] = 100;
					$this->load->library('image_lib', $config);
					$this->image_lib->initialize($config);
					$this->image_lib->resize();
					//Resizing 2ng Thumb Image
					$config="";
					$config['image_library'] = 'gd2';
					$config['source_image'] = 'assets/upload/bunglow/'.$bunglow_image;
					$config['new_image'] = 'assets/upload/bunglow/thumb_medium/'.$bunglow_image;
					$config['allowed_types'] = "jpg|jpeg|gif|png";
					$config['maintain_ratio'] = FALSE;
					$config['width'] = 233;
					$config['height'] = 160;
					$config['quality'] = 100;
					$this->load->library('image_lib', $config);
					$this->image_lib->initialize($config);
					$this->image_lib->resize();
					//Resizing 3rd Thumb Image
					$config="";
					$config['image_library'] = 'gd2';
					$config['source_image'] = 'assets/upload/bunglow/'.$bunglow_image;
					$config['new_image'] = 'assets/upload/bunglow/thumb_large/'.$bunglow_image;
					$config['allowed_types'] = "jpg|jpeg|gif|png";
					$config['maintain_ratio'] = FALSE;
					$config['width'] = 360;
					$config['height'] = 241;
					$config['quality'] = 100;
					$this->load->library('image_lib', $config);
					$this->image_lib->initialize($config);
					$this->image_lib->resize();
					//Resizing 4th Thumb Image
					$config="";
					$config['image_library'] = 'gd2';
					$config['source_image'] = 'assets/upload/bunglow/'.$bunglow_image;
					$config['new_image'] = 'assets/upload/bunglow/thumb_big/'.$bunglow_image;
					$config['allowed_types'] = "jpg|jpeg|gif|png";
					$config['maintain_ratio'] = FALSE;
					$config['width'] = 488;
					$config['height'] = 233;
					$config['quality'] = 100;
					$this->load->library('image_lib', $config);
					$this->image_lib->initialize($config);
					$this->image_lib->resize();
					
				}
				//Inserting images into table
				$image_insert_arr=array(
					"bunglow_id"=>$last_id,
					"image"=>$new_file_name,
					"is_active"=>"Y"
				);
				$this->db->insert("lb_bunglow_image", $image_insert_arr);
				$img_last_id=$this->db->insert_id();
				
				//Insert image caption according to language
				foreach($languages_err as $language)
				{
					$language_id=$language['id'];
					$image_id=$img_last_id;
					$caption=$this->input->post("caption_lang".$language['id']);
					$caption_insert_arr=array(
						"language_id"=>$language_id,
						"image_id"=>$image_id,
						"caption"=>$caption[$caption_counter]
					);
					$this->db->insert("lb_bunglow_image_lang", $caption_insert_arr);
				}
				$new_file_name="";
				$caption_counter++;
			}
			return "add_success";
		}
		else  
		{
			return "file_size";
		}
	}
		
	
	//###################################################################################
	
	//##################################Edit Bunglow#######################################
	
	function get_bunglow_for_edit($language_id, $bunglow_id) //Get all bunglows according to language for edit
	{
		//Get language data of selected language
		$this->db->order_by("id");
		$lang_arr_1=$this->db->get_where("mast_language", array("id"=>$language_id))->result_array();
		//Get language data of remaining languages
		$this->db->where("id !=", $language_id);
		$lang_arr_2=$this->db->get("mast_language")->result_array();
		$languages_arr=array_merge($lang_arr_1, $lang_arr_2);
		$all_bunglow_arr=array();
		$i=0;
		foreach($languages_arr as $languages)
		{
			$this->db->where("language_id", $languages['id']);
			$this->db->where("bunglow_id", $bunglow_id);
			$bunglow_arr=$this->db->get("lb_bunglow_lang")->result_array();
			$all_bunglow_arr[$i]['id']=$languages['id'];
			$all_bunglow_arr[$i]['language_id']=$bunglow_arr[0]['language_id'];
			$all_bunglow_arr[$i]['bunglow_id']=$bunglow_arr[0]['bunglow_id'];
			$all_bunglow_arr[$i]['bunglow_name']=$bunglow_arr[0]['bunglow_name'];
			$all_bunglow_arr[$i]['bunglow_overview']=$bunglow_arr[0]['bunglow_overview'];
			$all_bunglow_arr[$i]['meta_title']=$bunglow_arr[0]['meta_title'];
			$all_bunglow_arr[$i]['meta_keyword']=$bunglow_arr[0]['meta_keyword'];
			$all_bunglow_arr[$i]['meta_description']=$bunglow_arr[0]['meta_description'];
			$all_bunglow_arr[$i]['language_name']=$languages['language_name'];
			$all_bunglow_arr[$i]['flag_image_name']=$languages['flag_image_name'];
			$i++;
		}
		return $all_bunglow_arr;
	}
	
	function get_unique_details($bunglow_id) //Get language independent Details
	{
		$result=$this->db->get_where("lb_bunglow", array("id"=>$bunglow_id))->result_array();
		return $result;
	}
	

	
	//Getting All Bunglows At Once for Listing Page
	function get_rows($language_id, $id = 0)
    {
        $result = array();
        if ($id == 0) //all rows requested according to language id
        {
			//$this->db->where('language_id', $language_id);
			//$this->db->order_by('id');
            //$query = $this->db->get('lb_bunglow_lang');
			$this->db->select('*');
			$this->db->from('lb_bunglow');
			$this->db->order_by('lb_bunglow.sort_order', 'asc');
			$this->db->join('lb_bunglow_lang', 'lb_bunglow.id = lb_bunglow_lang.bunglow_id AND lb_bunglow_lang.language_id='.$language_id);
			$query = $this->db->get();
        }
        else //single row requested according to language id
        {
            $this->db->where('id', $id);
			$this->db->where('language_id', $language_id);
            $this->db->select('*');
            $query = $this->db->get('lb_bunglow_lang');
        }
        foreach ($query->result() as $row) 
		{
			$bunglow_id=$row->bunglow_id;
			$bunglow_details_arr=$this->db->get_where("lb_bunglow", array("id"=>$bunglow_id))->result_array();
			$result[] = array(
				'id' 					=> $row->id,
				'bunglow_id' 			=> $row->bunglow_id,
				'language_id' 			=> $row->language_id,
				'bunglow_name' 		=> $row->bunglow_name,
				'bunglow_overview' 		=> $row->bunglow_overview,
				'meta_title' 			=> $row->meta_title,
				'meta_keyword' 			=> $row->meta_keyword,
				'meta_description' 		=> $row->meta_description,
				'option_id' 			=> $bunglow_details_arr[0]['option_id'],
				'slug'					=> $bunglow_details_arr[0]['slug'],
				'sort_order'			=> $bunglow_details_arr[0]['sort_order'],
				'max_person'			=> $bunglow_details_arr[0]['max_person'],
				'is_featured'			=> $bunglow_details_arr[0]['is_featured'],
				'is_active'				=> $bunglow_details_arr[0]['is_active'],
				'cat_type'				=> $bunglow_details_arr[0]['cat_type']
			);
        }
        return $result;
    }
	
	//Function to get All options available
	function get_options($default_language_id)
	{
		//$options_details_arr=$this->db->get_where("lb_bunglow_options_lang", array("language_id"=>$default_language_id))->result_array();
		//return $options_details_arr;
		$this->db->select('*');
		$this->db->from('lb_bunglow_options');
		$this->db->join('lb_bunglow_options_lang', 'lb_bunglow_options.id = lb_bunglow_options_lang.options_id AND lb_bunglow_options.is_active="Y" AND lb_bunglow_options_lang.language_id='.$default_language_id);
		$options_details_arr=$this->db->get()->result_array();
		return $options_details_arr;
	}
	
	
	//Function to get All taxes available
	function get_tax($default_language_id)
	{
		$this->db->select('*');
		$this->db->from('lb_tax');
		$this->db->join('lb_tax_lang', 'lb_tax.id = lb_tax_lang.tax_id AND lb_tax.is_active="Y" AND lb_tax_lang.language_id='.$default_language_id);
		$tax_details_arr=$this->db->get()->result_array();
		return $tax_details_arr;
	}
	
	
	//Inactivate Bunglow 
	function inactive($bunglow_id)
	{
		$this->db->update("lb_bunglow", array("is_active"=>"N"), array("id"=>$bunglow_id));
	}
	
	//Activate Bunglow 
	function active($bunglow_id)
	{
		$this->db->update("lb_bunglow", array("is_active"=>"Y"), array("id"=>$bunglow_id));
	}
	
	
	//Delete Bunglow with images and captions
	function delete($bunglow_id)
	{
		$bunglow_image_arr=$this->db->get_where("lb_bunglow_image", array("bunglow_id"=>$bunglow_id))->result_array();
		if(count($bunglow_image_arr)>0)
		{
			foreach($bunglow_image_arr as $images)
			{
				if(file_exists("assets/upload/bunglow/".$images['image']))
				{
					unlink("assets/upload/bunglow/".$images['image']);
					unlink("assets/upload/bunglow/thumb/".$images['image']);
					unlink("assets/upload/bunglow/thumb_large/".$images['image']);
					unlink("assets/upload/bunglow/thumb_medium/".$images['image']);
					unlink("assets/upload/bunglow/thumb_big/".$images['image']);
				}
				//Deleting all image captions
				$this->db->delete("lb_bunglow_image_lang", array("image_id"=>$images['id']));
			}
		}
		$this->db->delete("lb_bunglow_image", array("bunglow_id"=>$bunglow_id));
		$this->db->delete("lb_bunglow", array("id"=>$bunglow_id));
		$this->db->delete("lb_bunglow_lang", array("bunglow_id"=>$bunglow_id));
		$this->db->delete("lb_bunglow_rates", array("bunglow_id"=>$bunglow_id));
	}
	
	
	//Set bunglow as featured
	function set_featured($bunglow_id)
	{
		$result=$this->db->get_where("lb_bunglow", array("id"=>$bunglow_id))->result_array();
		if($result[0]["is_featured"]=="Y")
		{
			$this->db->update("lb_bunglow", array("is_featured"=>"N"), array("id"=>$bunglow_id));
		}
		if($result[0]["is_featured"]=="N")
		{
			$this->db->update("lb_bunglow", array("is_featured"=>"Y"), array("id"=>$bunglow_id));
		}
	}
	
	
	//######################//Editing Bunglow with multiple images with captions###########################
	
	function bunglow_edit()
	{
		$b_type=$this->input->post("type");
		$languages_err=$this->db->get("mast_language")->result_array();
		
		if($this->input->post("bunglow_options"))
		{
			$bunglow_options=implode(",", $this->input->post("bunglow_options"));
		}
		else 
		{
			$bunglow_options="";
		}
		if($this->input->post("bunglow_tax"))
		{
			$bunglow_tax=implode(",", $this->input->post("bunglow_tax"));
		}
		else 
		{
			$bunglow_tax="";
		}
		
		$bunglow_slug=$this->input->post("bunglow_slug");
		$is_featured=$this->input->post("is_featured");
		$max_person=$this->input->post("max_person");
		$virtual_tour_code=$this->input->post("virtual_tour_code");
		$image_size_error=0;
		$posted_bunglow_id=$this->input->post("bunglow_id");
		$posted_language_id=$this->input->post("language_id");
		if($_FILES["bunglow_image"]['name'][0]!="") //If bunglow is being edited with images
		{
			//Checking multiple file size.
			foreach($_FILES["bunglow_image"]['tmp_name'] as $image_size)
			{
				list($width, $height, $type, $attr) = getimagesize($image_size); 
				if($height>='241' && $width>='488')
				{
					$image_size_error=0;
				}
				else  
				{
					$image_size_error++;
				}
			}
			//If image error is 0 then all data will be inserted
			if($image_size_error==0)
			{
				//updating data into main bunglow table
				$update_arr=array(
						"type"=>$b_type,
						"option_id"=>$bunglow_options,
						"tax_id"=>$bunglow_tax,
						"slug"=>$bunglow_slug,
						"max_person"=>$max_person,
						"virtual_tour_code"=>$virtual_tour_code,
						"is_featured"=>$is_featured,
						"modified_date"=>date("Y-m-d H:i:s")
				);
				$this->db->update("lb_bunglow", $update_arr, array("id"=>$posted_bunglow_id));
					
				//updating data into bunglow language table
				foreach($languages_err as $language)
				{
					$bunglow_name=$this->input->post("bunglow_name".$language['id']);
					$overview=$this->input->post("overview".$language['id']);
					$meta_title=$this->input->post("meta_title".$language['id']);
					$meta_keyword=$this->input->post("meta_keyword".$language['id']);
					$meta_description=$this->input->post("meta_desc".$language['id']);
					$update_arr_1=array(
						"bunglow_name"=>$bunglow_name,
						"bunglow_overview"=>$overview,
						"meta_title"=>$meta_title,
						"meta_keyword"=>$meta_keyword,
						"meta_description"=>$meta_description
					);
					$this->db->update("lb_bunglow_lang", $update_arr_1, array("bunglow_id"=>$posted_bunglow_id, "language_id"=>$language['id']));
				}
				
				
				//unlink old images
				$images_details_arr=$this->db->get_where("lb_bunglow_image", array("bunglow_id"=>$posted_bunglow_id))->result_array();
				foreach($images_details_arr as $image_details)
				{
					if($image_details['image']!="")
					{
						if(file_exists("assets/upload/bunglow/".$image_details['image']))
						{
							unlink("assets/upload/bunglow/".$image_details['image']);
							unlink("assets/upload/bunglow/thumb/".$image_details['image']);
							unlink("assets/upload/bunglow/thumb_large/".$image_details['image']);
							unlink("assets/upload/bunglow/thumb_medium/".$image_details['image']);
							unlink("assets/upload/bunglow/thumb_big/".$image_details['image']);
						}
					}
					//Deleting all old image captions
					$this->db->delete("lb_bunglow_image_lang", array("image_id"=>$image_details['id']));
				}
				//Deleting all old images from table
				$this->db->delete("lb_bunglow_image", array("bunglow_id"=>$posted_bunglow_id));
				
				
				//Uploading image file and resizing
				foreach($_FILES['bunglow_image'] as $key=>$val)
				{
					$i = 1;
					foreach($val as $v)
					{
						$field_name = "file_".$i;
						$_FILES[$field_name][$key] = $v;
						$i++;   
					}
				}
				unset($_FILES['bunglow_image']);
				$caption_counter=0; //Variable for count caption
				foreach($_FILES as $field_name => $file)
				{
					//Uploading multiple images
					$new_file_name=time()."_".$file['name'];
					$config['upload_path'] = 'assets/upload/bunglow/';
					$config['allowed_types'] = 'gif|jpg|png|gif';
					$config['max_size']	= '1000000';
					$config['file_name']= $new_file_name;
					$this->upload->initialize( $config );
					if (!$this->upload->do_upload($field_name))
					{
						$error = $this->upload->display_errors();
					}
					else
					{
						//Resizing multiple images
						$data = array('upload_data' => $this->upload->data());
						$bunglow_image = $data['upload_data']['file_name'];
						$config['image_library'] = 'gd2';
						$config['source_image'] = 'assets/upload/bunglow/'.$bunglow_image;
						$config['new_image'] = 'assets/upload/bunglow/thumb/'.$bunglow_image;
						$config['allowed_types'] = "jpg|jpeg|gif|png";
						$config['maintain_ratio'] = FALSE;
						$config['width'] = 163;
						$config['height'] = 167;
						$config['quality'] = 100;
						$this->load->library('image_lib', $config);
						$this->image_lib->initialize($config);
						$this->image_lib->resize();
						//Resizing 2ng Thumb Image
						$config="";
						$config['image_library'] = 'gd2';
						$config['source_image'] = 'assets/upload/bunglow/'.$bunglow_image;
						$config['new_image'] = 'assets/upload/bunglow/thumb_medium/'.$bunglow_image;
						$config['allowed_types'] = "jpg|jpeg|gif|png";
						$config['maintain_ratio'] = FALSE;
						$config['width'] = 233;
						$config['height'] = 160;
						$config['quality'] = 100;
						$this->load->library('image_lib', $config);
						$this->image_lib->initialize($config);
						$this->image_lib->resize();
						//Resizing 3rd Thumb Image
						$config="";
						$config['image_library'] = 'gd2';
						$config['source_image'] = 'assets/upload/bunglow/'.$bunglow_image;
						$config['new_image'] = 'assets/upload/bunglow/thumb_large/'.$bunglow_image;
						$config['allowed_types'] = "jpg|jpeg|gif|png";
						$config['maintain_ratio'] = FALSE;
						$config['width'] = 360;
						$config['height'] = 241;
						$config['quality'] = 100;
						$this->load->library('image_lib', $config);
						$this->image_lib->initialize($config);
						$this->image_lib->resize();
						//Resizing 4th Thumb Image
						$config="";
						$config['image_library'] = 'gd2';
						$config['source_image'] = 'assets/upload/bunglow/'.$bunglow_image;
						$config['new_image'] = 'assets/upload/bunglow/thumb_big/'.$bunglow_image;
						$config['allowed_types'] = "jpg|jpeg|gif|png";
						$config['maintain_ratio'] = FALSE;
						$config['width'] = 488;
						$config['height'] = 233;
						$config['quality'] = 100;
						$this->load->library('image_lib', $config);
						$this->image_lib->initialize($config);
						$this->image_lib->resize();
					}

					//Inserting new images in table
					$image_insert_arr=array(
						"bunglow_id"=>$posted_bunglow_id,
						"image"=>$new_file_name,
						"is_active"=>"Y"
					);
					$this->db->insert("lb_bunglow_image", $image_insert_arr);
					$img_last_id=$this->db->insert_id();
					
					//Insert image caption according to language
					foreach($languages_err as $language)
					{
						$language_id=$language['id'];
						$image_id=$img_last_id;
						$caption=$this->input->post("caption_lang".$language['id']);
						$caption_insert_arr=array(
							"language_id"=>$language_id,
							"image_id"=>$image_id,
							"caption"=>$caption[$caption_counter]
						);
						$this->db->insert("lb_bunglow_image_lang", $caption_insert_arr);
					}
					
					$new_file_name="";
					$caption_counter++;
				}
				return "edit_success";
			}
			else  
			{
				return "file_size";
			}
		}
		else //If bunglow is being edited without images
		{
			//updating data into main bunglow table
			$update_arr=array(
					"type"=>$b_type,
					"option_id"=>$bunglow_options,
					"tax_id"=>$bunglow_tax,
					"slug"=>$bunglow_slug,
					"max_person"=>$max_person,
					"virtual_tour_code"=>$virtual_tour_code,
					"is_featured"=>$is_featured,
					"modified_date"=>date("Y-m-d H:i:s")
			);
			$this->db->update("lb_bunglow", $update_arr, array("id"=>$posted_bunglow_id));
				
			//updating data into bunglow language table
			foreach($languages_err as $language)
			{
				$bunglow_name=$this->input->post("bunglow_name".$language['id']);
				$overview=$this->input->post("overview".$language['id']);
				$meta_title=$this->input->post("meta_title".$language['id']);
				$meta_keyword=$this->input->post("meta_keyword".$language['id']);
				$meta_description=$this->input->post("meta_desc".$language['id']);
				$update_arr_1=array(
					"bunglow_name"=>$bunglow_name,
					"bunglow_overview"=>$overview,
					"meta_title"=>$meta_title,
					"meta_keyword"=>$meta_keyword,
					"meta_description"=>$meta_description
				);
				$this->db->update("lb_bunglow_lang", $update_arr_1, array("bunglow_id"=>$posted_bunglow_id, "language_id"=>$language['id']));
			}
			return "edit_success";
		}
	}
	
	//#######################Functions For Bunglow Image Management########################//
	
	//Getting Bunglow Images row according to selected languages
	function get_bunglow_images_list($language_id, $bunglow_id)
	{
		$all_bunglow_images_arr=array();
		$this->db->order_by("id", "desc");
		$bunglow_image_arr=$this->db->get_where("lb_bunglow_image", array("bunglow_id"=>$bunglow_id))->result_array();
		$i=0;
		foreach($bunglow_image_arr as $bunglow_images)
		{
			$images_captions_arr=$this->db->get_where("lb_bunglow_image_lang", array("image_id"=>$bunglow_images['id'], "language_id"=>$language_id))->result_array();
			$all_bunglow_images_arr[$i]['id']=$bunglow_images['id'];
			$all_bunglow_images_arr[$i]['bunglow_id']=$bunglow_images['bunglow_id'];
			$all_bunglow_images_arr[$i]['image']=$bunglow_images['image'];
			$all_bunglow_images_arr[$i]['is_active']=$bunglow_images['is_active'];
			$all_bunglow_images_arr[$i]['language_id']=$images_captions_arr[0]['language_id'];
			$all_bunglow_images_arr[$i]['caption']=$images_captions_arr[0]['caption'];
			$i++;
		}
		return $all_bunglow_images_arr;
	}
	
	//Making Bunglow Image Inactive
	function image_inactive($bunglow_image_id)
	{
		$result=$this->db->update("lb_bunglow_image", array("is_active"=>"N"), array("id"=>$bunglow_image_id));
	}
	
	//Making Bunglow Image active
	function image_active($bunglow_image_id)
	{
		$result=$this->db->update("lb_bunglow_image", array("is_active"=>"Y"), array("id"=>$bunglow_image_id));
	}
	
	
	//Delete Bunglow Image
	function image_delete($bunglow_image_id)
	{
		$image_details=$this->db->get_where("lb_bunglow_image", array("id"=>$bunglow_image_id))->result_array();
		$image=$image_details[0]['image'];
		unlink("assets/upload/bunglow/".$image);
		unlink("assets/upload/bunglow/thumb/".$image);
		unlink("assets/upload/bunglow/thumb_large/".$image);
		unlink("assets/upload/bunglow/thumb_medium/".$image);
		unlink("assets/upload/bunglow/thumb_big/".$image);
		$this->db->delete("lb_bunglow_image", array("id"=>$bunglow_image_id));
		$this->db->delete("lb_bunglow_image_lang", array("image_id"=>$bunglow_image_id));
	}
	
	
	//Getting Bunglow Name
	function get_bunglow_name($language_id, $bunglow_id)
	{
		$bunglow_details_arr=$this->db->get_where("lb_bunglow_lang", array("language_id"=>$language_id, "bunglow_id"=>$bunglow_id))->result_array();
		return $bunglow_details_arr[0]['bunglow_name'];
	}
	
	
	//Adding Image for particular bunglow
	function bunglow_image_add()
	{
		$languages_arr=$this->db->get("mast_language")->result_array();
		$posted_language_id=$this->input->post("language_id");
		$posted_bunglow_id=$this->input->post("bunglow_id");
		$size = list($width, $height, $type, $attr) = getimagesize($_FILES["bunglow_image"]['tmp_name']); 
		$new_file_name=time()."_".$_FILES["bunglow_image"]['name'];
		if($height>='241' && $width>='488')
		{
			//Uploading image;
			$config['file_name'] =$new_file_name;
			$config['upload_path'] = "assets/upload/bunglow/";
			$config['allowed_types'] = "gif|jpg|jpeg|png";
			$config['max_size'] = '1000000';
			$this->upload->initialize($config);
			$this->load->library('upload', $config);
			if (!$this->upload->do_upload('bunglow_image'))
			{
				return $this->upload->display_errors();
			}
			else 
			{
				//Resizing uploaded images
				$data = array('upload_data' => $this->upload->data());
				$bunglow_image = $data['upload_data']['file_name'];
				//Resize 1st Image
				$config['image_library'] = 'gd2';
				$config['source_image'] = 'assets/upload/bunglow/'.$bunglow_image;
				$config['new_image'] = 'assets/upload/bunglow/thumb/'.$bunglow_image;
				$config['allowed_types'] = "jpg|jpeg|gif|png";
				$config['maintain_ratio'] = FALSE;
				$config['width'] = 163;
				$config['height'] = 167;
				$config['quality'] = 100;
				$this->load->library('image_lib', $config);
				$this->image_lib->initialize($config);
				$this->image_lib->resize();
				//Resize 2nd Image
				$config="";
				$config['image_library'] = 'gd2';
				$config['source_image'] = 'assets/upload/bunglow/'.$bunglow_image;
				$config['new_image'] = 'assets/upload/bunglow/thumb_medium/'.$bunglow_image;
				$config['allowed_types'] = "jpg|jpeg|gif|png";
				$config['maintain_ratio'] = FALSE;
				$config['width'] = 233;
				$config['height'] = 160;
				$config['quality'] = 100;
				$this->load->library('image_lib', $config);
				$this->image_lib->initialize($config);
				$this->image_lib->resize();
				//Resize 3rd Image
				$config="";
				$config['image_library'] = 'gd2';
				$config['source_image'] = 'assets/upload/bunglow/'.$bunglow_image;
				$config['new_image'] = 'assets/upload/bunglow/thumb_large/'.$bunglow_image;
				$config['allowed_types'] = "jpg|jpeg|gif|png";
				$config['maintain_ratio'] = FALSE;
				$config['width'] = 360;
				$config['height'] = 241;
				$config['quality'] = 100;
				$this->load->library('image_lib', $config);
				$this->image_lib->initialize($config);
				$this->image_lib->resize();
				//Resize 4th Image
				$config="";
				$config['image_library'] = 'gd2';
				$config['source_image'] = 'assets/upload/bunglow/'.$bunglow_image;
				$config['new_image'] = 'assets/upload/bunglow/thumb_big/'.$bunglow_image;
				$config['allowed_types'] = "jpg|jpeg|gif|png";
				$config['maintain_ratio'] = FALSE;
				$config['width'] = 488;
				$config['height'] = 233;
				$config['quality'] = 100;
				$this->load->library('image_lib', $config);
				$this->image_lib->initialize($config);
				$this->image_lib->resize();
				
				//Inserting data in database
				$insert_arr=array(
					"bunglow_id"=>$posted_bunglow_id,
					"image"=>$new_file_name,
					"is_active"=>"Y"
				);
				$this->db->insert("lb_bunglow_image", $insert_arr);
				$last_id=$this->db->insert_id();
				
				foreach($languages_arr as $language)
				{
					$language_id=$language['id'];
					$image_id=$last_id;
					$caption=$this->input->post("caption".$language['id']);
					
					$insert_arr_1=array(
						"language_id"=>$language_id,
						"image_id"=>$image_id,
						"caption"=>$caption
					);
					
					$this->db->insert("lb_bunglow_image_lang", $insert_arr_1);
				}
				return "add_success";
			}
		}
		else 
		{
			return "file_size";
		}
	}
	
	//Getting Language specific content of bunglow images
	function get_images($language_id, $image_id)
	{
		//Get language data of selected language
		$this->db->order_by("id");
		$lang_arr_1=$this->db->get_where("mast_language", array("id"=>$language_id))->result_array();
		//Get language data of remaining languages
		$this->db->where("id !=", $language_id);
		$lang_arr_2=$this->db->get("mast_language")->result_array();
		$languages_arr=array_merge($lang_arr_1, $lang_arr_2);
		$all_images_arr=array();
		$i=0;
		foreach($languages_arr as $languages)
		{
			$this->db->where("language_id", $languages['id']);
			$this->db->where("image_id", $image_id);
			$images_arr=$this->db->get("lb_bunglow_image_lang")->result_array();
			$all_images_arr[$i]['id']=$languages['id'];
			$all_images_arr[$i]['language_id']=$images_arr[0]['language_id'];
			$all_images_arr[$i]['image_id']=$images_arr[0]['image_id'];
			$all_images_arr[$i]['caption']=$images_arr[0]['caption'];
			$all_images_arr[$i]['language_name']=$languages['language_name'];
			$all_images_arr[$i]['flag_image_name']=$languages['flag_image_name'];
			$i++;
		}
		return $all_images_arr;
	}
	
	//Getting Language Independent content for image
	function get_image_unique_details($image_id)
	{	
		$result=$this->db->get_where("lb_bunglow_image", array("id"=>$image_id))->result_array();
		return $result;
	}
	
	//Editing Bunglow Particular Images 
	function bunglow_image_edit()
	{
		$languages_err=$this->db->get("mast_language")->result_array();
		$posted_image_id=$this->input->post("image_id");
		$posted_bunglow_id=$this->input->post("bunglow_id");
		$posted_language_id=$this->input->post("language_id");
		if($_FILES["bunglow_image"]['name']!="")
		{
			$size = list($width, $height, $type, $attr) = getimagesize($_FILES["bunglow_image"]['tmp_name']); 
			$new_file_name=time()."_".$_FILES["bunglow_image"]['name'];
			if($height>='241' && $width>='488')
			{
				//Unlink previous image 
				$pre_image_arr=$this->db->get_where("lb_bunglow_image", array("id"=>$posted_image_id))->result_array();
				$pre_image=$pre_image_arr[0]['image'];
				if(!empty($pre_image))
				{
					if(file_exists("assets/upload/bunglow/".$pre_image))
					{
						unlink("assets/upload/bunglow/".$pre_image);
						unlink("assets/upload/bunglow/thumb/".$pre_image);
						unlink("assets/upload/bunglow/thumb_medium/".$pre_image);
						unlink("assets/upload/bunglow/thumb_large/".$pre_image);
						unlink("assets/upload/bunglow/thumb_big/".$pre_image);
					}
				}
				//Uploading image;
				$config['file_name'] =$new_file_name;
				$config['upload_path'] = "assets/upload/bunglow/";
				$config['allowed_types'] = "gif|jpg|jpeg|png";
				$config['max_size'] = '1000000';
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if (!$this->upload->do_upload('bunglow_image'))
				{
					return $this->upload->display_errors();
				}
				else 
				{
					//Resizing uploaded images
					$data = array('upload_data' => $this->upload->data());
					$bunglow_image = $data['upload_data']['file_name'];
					//Resize 1st Image
					$config['image_library'] = 'gd2';
					$config['source_image'] = 'assets/upload/bunglow/'.$bunglow_image;
					$config['new_image'] = 'assets/upload/bunglow/thumb/'.$bunglow_image;
					$config['allowed_types'] = "jpg|jpeg|gif|png";
					$config['maintain_ratio'] = FALSE;
					$config['width'] = 163;
					$config['height'] = 167;
					$config['quality'] = 100;
					$this->load->library('image_lib', $config);
					$this->image_lib->initialize($config);
					$this->image_lib->resize();
					//Resize 2nd Image
					$config="";
					$config['image_library'] = 'gd2';
					$config['source_image'] = 'assets/upload/bunglow/'.$bunglow_image;
					$config['new_image'] = 'assets/upload/bunglow/thumb_medium/'.$bunglow_image;
					$config['allowed_types'] = "jpg|jpeg|gif|png";
					$config['maintain_ratio'] = FALSE;
					$config['width'] = 233;
					$config['height'] = 160;
					$config['quality'] = 100;
					$this->load->library('image_lib', $config);
					$this->image_lib->initialize($config);
					$this->image_lib->resize();
					//Resize 3rd Image
					$config="";
					$config['image_library'] = 'gd2';
					$config['source_image'] = 'assets/upload/bunglow/'.$bunglow_image;
					$config['new_image'] = 'assets/upload/bunglow/thumb_large/'.$bunglow_image;
					$config['allowed_types'] = "jpg|jpeg|gif|png";
					$config['maintain_ratio'] = FALSE;
					$config['width'] = 360;
					$config['height'] = 241;
					$config['quality'] = 100;
					$this->load->library('image_lib', $config);
					$this->image_lib->initialize($config);
					$this->image_lib->resize();
					//Resize 4th Image
					$config="";
					$config['image_library'] = 'gd2';
					$config['source_image'] = 'assets/upload/bunglow/'.$bunglow_image;
					$config['new_image'] = 'assets/upload/bunglow/thumb_big/'.$bunglow_image;
					$config['allowed_types'] = "jpg|jpeg|gif|png";
					$config['maintain_ratio'] = FALSE;
					$config['width'] = 488;
					$config['height'] = 233;
					$config['quality'] = 100;
					$this->load->library('image_lib', $config);
					$this->image_lib->initialize($config);
					$this->image_lib->resize();
					//updating data in database
					$upd_arr=array(
						"image"=>$new_file_name
					);
					$this->db->update("lb_bunglow_image", $upd_arr, array("id"=>$posted_image_id));
					foreach($languages_err as $language)
					{
						$caption=$this->input->post("caption".$language['id']);
						$upd_arr_1=array(
							"caption"=>$caption
						);
						
						$this->db->update("lb_bunglow_image_lang", $upd_arr_1, array("language_id"=>$language['id'], "image_id"=>$posted_image_id));
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
			foreach($languages_err as $language)
			{
				$caption=$this->input->post("caption".$language['id']);
				$upd_arr_1=array(
					"caption"=>$caption
				);
				
				$this->db->update("lb_bunglow_image_lang", $upd_arr_1, array("language_id"=>$language['id'], "image_id"=>$posted_image_id));
			}
			return "edit_success";
		}
	}
	
	
	//###################Function for Bunglow Testimonials###########################
	function get_bunglow_testimonials($language_id, $bunglow_id)
	{
		$this->db->order_by("id", "desc");
		$result=$this->db->get_where("lb_testimonials_lang", array("language_id"=>$language_id,"bunglow_id"=>$bunglow_id))->result_array();
		return $result;
	}

	function delete_testimonials($testimonial_id)
	{
		$result=$this->db->delete("lb_testimonials_lang", array("id"=>$testimonial_id));
	}
	
	function testimonial_status_change($test_id, $status)
	{
		$result=$this->db->update("lb_testimonials_lang", array("status"=>$status), array("id"=>$test_id));
		return $result;
	}
	
	
	//Function for changing order of bungalow
	function get_max_order()
	{
		$this->db->select_max('sort_order');
		$query = $this->db->get('lb_bunglow')->result_array();
		return $query[0]['sort_order'];
	}
	
	function change_order($current_id, $current_order, $changed_order)
	{
		$get_details=$this->db->get_where("lb_bunglow", array("sort_order"=>$changed_order))->result_array();
		$this->db->update("lb_bunglow", array("sort_order"=>$changed_order), array("id"=>$current_id));
		$this->db->update("lb_bunglow", array("sort_order"=>$current_order), array("id"=>$get_details[0]['id']));
	}
	
	
	//#############################	Function for front end	########################
	
	//Getting properties for properties page
	function get_properties($limit, $offset)
	{
		$current_lang_id=$this->session->userdata("current_lang_id");
		$properties_arr=array();
		$this->db->order_by("id", "desc");
		$array=$this->db->get_where("lb_bunglow", array("is_active"=>"Y", "type"=>"P"), $limit, $offset)->result_array();
		$i=0;
		foreach($array as $value)
		{
			$peroperty_id=$value['id'];
			$get_details_arr=$this->db->get_where("lb_bunglow_lang", array("bunglow_id"=>$peroperty_id, "language_id"=>$current_lang_id))->result_array();
			//Get bungalow Images
			$this->db->select('*');
			$this->db->from('lb_bunglow_image');
			$this->db->order_by('lb_bunglow_image.id', 'desc');
			$this->db->join('lb_bunglow_image_lang', 'lb_bunglow_image.id = lb_bunglow_image_lang.image_id AND lb_bunglow_image.bunglow_id='.$peroperty_id.' AND lb_bunglow_image.is_active = "Y" AND lb_bunglow_image_lang.language_id='.$current_lang_id);
			$this->db->limit(1);
			$image_arr = $this->db->get()->result_array();
			$properties_arr[$i]['id']=$value['id'];
			$properties_arr[$i]['bunglow_name']=$get_details_arr[0]['bunglow_name'];
			$properties_arr[$i]['bunglow_overview']=$get_details_arr[0]['bunglow_overview'];
			$properties_arr[$i]['slug']=$value['slug'];
			$properties_arr[$i]['image']=$image_arr[0]['image'];
			$properties_arr[$i]['caption']=$image_arr[0]['caption'];
			$i++;
		}
		return $properties_arr;
	}
	
	//function to get total property
	function get_total_properties()
	{
		$array=$this->db->get_where("lb_bunglow", array("is_active"=>"Y", "type"=>"P"))->result_array();
		return count($array);
	}
	
	//function to get property details for property details page
	function get_properties_details($slug)
	{
		$current_lang_id=$this->session->userdata("current_lang_id");
		$get_main_data=$this->db->get_where("lb_bunglow", array("slug"=>$slug))->result_array();
		$auto_id=$get_main_data[0]['id'];
		//$get_details_arr=$this->db->get_where("lb_bunglow_lang", array("bunglow_id"=>$auto_id, "language_id"=>$current_lang_id))->result_array();
		$this->db->select('*');
		$this->db->from('lb_bunglow');
		$this->db->join('lb_bunglow_lang', 'lb_bunglow.id = lb_bunglow_lang.bunglow_id AND lb_bunglow.id='.$auto_id.' AND lb_bunglow_lang.language_id='.$current_lang_id);
		$get_details_arr = $this->db->get()->result_array();
		return $get_details_arr;
	}
	
	//function to get property all images for property details page
	function get_properties_images($slug)
	{
		$current_lang_id=$this->session->userdata("current_lang_id");
		$get_main_data=$this->db->get_where("lb_bunglow", array("slug"=>$slug))->result_array();
		$auto_id=$get_main_data[0]['id'];
		$this->db->select('*');
		$this->db->from('lb_bunglow_image');
		$this->db->order_by('lb_bunglow_image.id', 'desc');
		$this->db->join('lb_bunglow_image_lang', 'lb_bunglow_image.id = lb_bunglow_image_lang.image_id AND lb_bunglow_image.bunglow_id='.$auto_id.' AND lb_bunglow_image.is_active = "Y" AND lb_bunglow_image_lang.language_id='.$current_lang_id);
		$image_arr = $this->db->get()->result_array();
		return $image_arr;
	}
	
	//function to get rates for particular property
	function get_properties_rates($slug)
	{
		$current_lang_id=$this->session->userdata("current_lang_id");
		$get_main_data=$this->db->get_where("lb_bunglow", array("slug"=>$slug))->result_array();
		$auto_id=$get_main_data[0]['id'];//Id of property or bungalow
		$this->db->order_by("id", "asc");
		$season_arr=$this->db->get_where("lb_season")->result_array();
		$rates_arr=array();
		$j=0;
		foreach($season_arr as $season)
		{
			$seasons_details_arr=$this->db->get_where("lb_season_lang", array("season_id"=>$season['id'], "language_id"=>$current_lang_id))->result_array();
			$seasons_rate_arr=$this->db->get_where("lb_bunglow_rates", array("bunglow_id"=>$auto_id, "season_id"=>$season['id']))->result_array();
			if($seasons_rate_arr)
			{
				$rates_arr[$j]['season_id']=$season['id'];
				$rates_arr[$j]['season_name']=$seasons_details_arr[0]['season_name'];
				$rates_arr[$j]['season_icon']=$season['season_icon'];
				$rates_arr[$j]['rate_per_day_euro']=$seasons_rate_arr[0]['rate_per_day_euro'];
				$rates_arr[$j]['rate_per_day_dollar']=$seasons_rate_arr[0]['rate_per_day_dollar'];
				$rates_arr[$j]['discount_per_night']=$seasons_rate_arr[0]['discount_per_night'];
				$rates_arr[$j]['rate_per_week_euro']=$seasons_rate_arr[0]['rate_per_week_euro'];
				$rates_arr[$j]['rate_per_week_dollar']=$seasons_rate_arr[0]['rate_per_week_dollar'];
				$rates_arr[$j]['discount_per_week']=$seasons_rate_arr[0]['discount_per_week'];
				$rates_arr[$j]['extranight_perday_europrice']=$seasons_rate_arr[0]['extranight_perday_europrice'];
				$rates_arr[$j]['extranight_perday_dollerprice']=$seasons_rate_arr[0]['extranight_perday_dollerprice'];
			}
			else 
			{
				$rates_arr[$j]['season_id']=$season['id'];
				$rates_arr[$j]['season_name']=$seasons_details_arr[0]['season_name'];
				$rates_arr[$j]['season_icon']=$season['season_icon'];
				$rates_arr[$j]['rate_per_day_euro']="N/A";
				$rates_arr[$j]['rate_per_day_dollar']="N/A";
				$rates_arr[$j]['discount_per_night']="N/A";
                $rates_arr[$j]['rate_per_week_euro']="N/A";
				$rates_arr[$j]['rate_per_week_dollar']="N/A";
				$rates_arr[$j]['discount_per_week']="N/A";
				$rates_arr[$j]['extranight_perday_europrice']="N/A";
				$rates_arr[$j]['extranight_perday_dollerprice']="N/A";
			}
			$j++;
		}
		return $rates_arr;
	}
	
	
	//function to get testimonials for a particular bunglaow
	function get_testimonials()
	{
	
	    $current_lang_id=$this->session->userdata("current_lang_id");
	
		//$get_main_data=$this->db->get_where("lb_bunglow", array("slug"=>$slug))->result_array();
		//$auto_id=$get_main_data[0]['id'];
		$this->db->order_by("id", "desc");
		$result=$this->db->get_where("lb_testimonials_lang", array("language_id"=>$current_lang_id, "status"=>"APPROVED"))->result_array();
		return $result;
	}
	
	//function to get testimonials for a particular bunglaow admin panel
	function get_testimonials_admin($language_id, $testimonials_id)
	{
		//Get language data of selected language
		$this->db->order_by("id");
		$lang_arr_1=$this->db->get_where("mast_language", array("id"=>$language_id))->result_array();
		//Get language data of remaining languages
		$this->db->where("id !=", $language_id);
		$lang_arr_2=$this->db->get("mast_language")->result_array();
		$languages_arr=array_merge($lang_arr_1, $lang_arr_2);

		$all_testimonials_arr=array();
		$i=0;
		foreach($languages_arr as $languages)
		{
			$testimonials_arr=$this->db->get_where("lb_testimonials_lang", array("language_id"=>$languages['id'], "testimonials_id"=>$testimonials_id))->result_array();
			/*echo "<pre>";
			print_r($testimonials_arr);
			die;*/
			$all_testimonials_arr[$i]['id']=$languages['id'];
			$all_testimonials_arr[$i]['language_id']=$testimonials_arr[0]['language_id'];
			
			$all_testimonials_arr[$i]['testimonials_id']=$testimonials_arr[0]['testimonials_id'];
			//$all_testimonials_arr[$i]['bunglow_id']=$testimonials_arr[0]['bunglow_id'];
			$all_testimonials_arr[$i]['user_name']=$testimonials_arr[0]['user_name'];
			$all_testimonials_arr[$i]['user_email']=$testimonials_arr[0]['user_email'];
			$all_testimonials_arr[$i]['content']=$testimonials_arr[0]['content'];
			$all_testimonials_arr[$i]['language_name']=$languages['language_name'];
			$all_testimonials_arr[$i]['flag_image_name']=$languages['flag_image_name'];
			
			$i++;
		}
		return $all_testimonials_arr;
		
	}
	
	function shuffle_assoc($list) { 
	  if (!is_array($list)) return $list; 

	  $keys = array_keys($list); 
	  shuffle($keys); 
	  $random = array(); 
	  foreach ($keys as $key) { 
	    $random[$key] = $list[$key]; 
	  }
	  return $random; 
	} 
	
	//Getting bungalows for bungalows page
	function get_bungalows($limit, $offset)
	{
		$current_lang_id=$this->session->userdata("current_lang_id");
		$bungalows_arr=array();
		//$this->db->order_by("id", "desc");
		$array=$this->db->get_where("lb_bunglow", array("is_active"=>"Y", "type"=>"B"))->result_array();
		$i=0;
		foreach($array as $value)
		{
			$bungalow_id=$value['id'];
			$get_details_arr=$this->db->get_where("lb_bunglow_lang", array("bunglow_id"=>$bungalow_id, "language_id"=>$current_lang_id))->result_array();
			//Get bungalow Images
			$this->db->select('*');
			$this->db->from('lb_bunglow_image');
			$this->db->order_by('lb_bunglow_image.id', 'desc');
			$this->db->join('lb_bunglow_image_lang', 'lb_bunglow_image.id = lb_bunglow_image_lang.image_id AND lb_bunglow_image.bunglow_id='.$bungalow_id.' AND lb_bunglow_image.is_active = "Y" AND lb_bunglow_image_lang.language_id='.$current_lang_id);
			$this->db->limit(1);
			$image_arr = $this->db->get()->result_array();

			$seasons_details_arr=$this->db->get_where("lb_season_lang", array("season_id"=>2, "language_id"=>$current_lang_id))->result_array();
			$seasons_rate_arr=$this->db->get_where("lb_bunglow_rates", array("bunglow_id"=>$bungalow_id, "season_id"=>2))->result_array();
			if($seasons_rate_arr)
			{
				$bungalows_arr[$i]['rate_per_week_euro']=$seasons_rate_arr[0]['rate_per_week_euro'];
			}
			else 
			{
				$bungalows_arr[$i]['rate_per_week_euro']=="N/A";
			}

			$bungalows_arr[$i]['id']=$value['id'];
			$bungalows_arr[$i]['max_person']=$value['max_person'];
			$bungalows_arr[$i]['bunglow_name']=$get_details_arr[0]['bunglow_name'];
			$bungalows_arr[$i]['bunglow_overview']=$get_details_arr[0]['bunglow_overview'];
			$bungalows_arr[$i]['slug']=$value['slug'];
			$bungalows_arr[$i]['image']=$image_arr[0]['image'];
			$bungalows_arr[$i]['caption']=$image_arr[0]['caption'];
			$i++;
		}
		$bungalows_arr1 = $this->shuffle_assoc($bungalows_arr);
		return $bungalows_arr1;
	}
	
	//function to get total bungalows
	function get_total_bungalows()
	{
		$array=$this->db->get_where("lb_bunglow", array("is_active"=>"Y", "type"=>"B"))->result_array();
		return count($array);
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
	
	function add_testimonials($bungalow_id)
	{
	
	    //echo $bungalow_id;die();
		$languages_err=$this->db->get("mast_language")->result_array();
		//Inserting data in database
		$insert_arr=array(
			"is_active"=>"Y"
		);
		$this->db->insert("lb_testimonials", $insert_arr);
		$last_id=$this->db->insert_id();
		foreach($languages_err as $language)
		{
			$language_id=$language['id'];
			$testimonials_id=$last_id;
			$bungalow_id=$bungalow_id;
			$name=$this->input->post("test_name".$language['id']);
			$email=$this->input->post("test_email".$language['id']);
			$comment=$this->input->post("test_comment".$language['id']);
			
			$insert_arr_1=array(
				"language_id"=>$language_id,
				"testimonials_id"=>$testimonials_id,
				"bunglow_id"=>$bungalow_id,
				"user_name"=>$name,
				"user_email"=>$email,
				"content"=>$comment,
				"created"=>date("Y-m-d H:i:s"),
				"status"=>"APPROVED"
			);
			$this->db->insert("lb_testimonials_lang", $insert_arr_1);
		}
		return "add_success";
	}
		
	//function to save testimonials from details page 
	/*function save_testimonials()
	{
		$bungalow_id=$this->input->post("bungalow_id");
		$name=$this->input->post("test_name");
		$email=$this->input->post("test_email");
		$comment=$this->input->post("test_comment");
		$ins_arr=array(
			"bunglow_id"=>$bungalow_id,
			"user_name"=>$name,
			"user_email"=>$email,
			"content"=>$comment,
			"created"=>date("Y-m-d H:i:s"),
			"status"=>"PENDING"
		);
		$result=$this->db->insert("lb_testimonials", $ins_arr);
		return "success";
	}*/
	
	//function to edit testimonials from  
	function testimonials_edit()
	{
		$languages_err=$this->db->get("mast_language")->result_array();
		$posted_testimonials_id=$this->input->post("testimonials_id");
		$posted_language_id=$this->input->post("language_id");
		$posted_bunglow_id=$this->input->post("bunglow_id");
		
		
		foreach($languages_err as $language)
		{
			$bunglow_id=$bunglow_id;
			$name=$this->input->post("test_name".$language['id']);
			$email=$this->input->post("test_email".$language['id']);
			$comment=$this->input->post("test_comment".$language['id']);
			$upd_arr_1=array(
				//"language_id"=>$posted_language_id,
				"testimonials_id"=>$posted_testimonials_id,
				"bunglow_id"=>$posted_bunglow_id,
				"user_name"=>$name,
				"user_email"=>$email,
				"content"=>$comment
			);
			
			$this->db->update("lb_testimonials_lang", $upd_arr_1, array("language_id"=>$language['id'], "testimonials_id"=>$posted_testimonials_id));
		}
		return "edit_success";
	}
	
}
?>