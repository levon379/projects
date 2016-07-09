<?php
class documents_model extends CI_Model
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
	
	

	//######################ADDING BANNERS ACCORDING TO LANGUAGE###########################
	
	function documents_add()
	{
		$languages_err=$this->db->get("mast_language")->result_array();
		$insert_arr=array(
			"is_active"=>"Y",
			"created_date"=>date("Y-m-d H:i:s")
		);
		$this->db->insert("mast_documents", $insert_arr);
		$last_id=$this->db->insert_id();
		foreach($languages_err as $language)
		{
			$new_file_name=time()."_".$language['id']."_".str_replace(" ", "-", $_FILES["document_file".$language['id']]['name']);
			
			$config= array();
			$config['file_name'] =$new_file_name;
			$config['upload_path'] = "assets/upload/documents/";
			$config['allowed_types'] = "doc|docx|pdf";
			$config['max_size'] = '1000000';
			$this->upload->initialize( $config );

			if ( ! $this->upload->do_upload('document_file'.$language['id']))
			{
				print_r($this->upload->display_errors());die;
			}
			//$this->upload->do_upload('document_file'.$language['id']);
			
			$language_id=$language['id'];
			$document_id=$last_id;
			$document_title=$this->input->post("document_title".$language['id']);
			$insert_arr_1=array(
				"language_id"=>$language_id,
				"document_id"=>$document_id,
				"document_title"=>$document_title,
				"document_file"=>$new_file_name
			);
			
			$this->db->insert("mast_documents_lang", $insert_arr_1);
		}
		return "add_success";
	}
		
	
	//###################################################################################
	
	//##################################Edit Documents#######################################
	
	function get_documents($language_id, $document_id) //Get all documents according to language for edit
	{
		//Get language data of selected language
		$this->db->order_by("id");
		$lang_arr_1=$this->db->get_where("mast_language", array("id"=>$language_id))->result_array();
		//Get language data of remaining languages
		$this->db->where("id !=", $language_id);
		$lang_arr_2=$this->db->get("mast_language")->result_array();
		$languages_arr=array_merge($lang_arr_1, $lang_arr_2);
		$all_documents_arr=array();
		$i=0;
		foreach($languages_arr as $languages)
		{
			$this->db->where("language_id", $languages['id']);
			$this->db->where("document_id", $document_id);
			$documents_arr=$this->db->get("mast_documents_lang")->result_array();
			$all_documents_arr[$i]['id']=$languages['id'];
			$all_documents_arr[$i]['language_id']=$documents_arr[0]['language_id'];
			$all_documents_arr[$i]['document_id']=$documents_arr[0]['document_id'];
			$all_documents_arr[$i]['document_title']=$documents_arr[0]['document_title'];
			$all_documents_arr[$i]['document_file']=$documents_arr[0]['document_file'];
			$all_documents_arr[$i]['language_name']=$languages['language_name'];
			$all_documents_arr[$i]['flag_image_name']=$languages['flag_image_name'];
			$i++;
		}
		return $all_documents_arr;
	}
	
	function get_unique_details($document_id) //Get details of documents unique to both languages e.g page_slug
	{
		$result=$this->db->get_where("mast_documents", array("id"=>$document_id))->result_array();
		return $result;
	}
	

	
	//Getting All documents At Once
	function get_rows($language_id, $id = 0)//Get all rows for listing page
    {
        $result = array();
        if ($id == 0) //all rows requested according to language id
        {
			$this->db->where('language_id', $language_id);
			$this->db->order_by('id');
            $query = $this->db->get('mast_documents_lang');
        }
        else //single row requested according to language id
        {
            $this->db->where('id', $id);
			$this->db->where('language_id', $language_id);
            $this->db->select('*');
            $query = $this->db->get('mast_documents_lang');
        }
        foreach ($query->result() as $row) 
		{
			$document_id=$row->document_id;
			$document_details_arr=$this->db->get_where("mast_documents", array("id"=>$document_id))->result_array();
			$result[] = array(
				'id' 					=> $row->id,
				'document_id' 			=> $row->document_id,
				'language_id' 			=> $row->language_id,
				'document_title' 		=> $row->document_title,
				'document_file' 		=> $row->document_file,
				'is_active'				=> $document_details_arr[0]['is_active']
			);
        }
        return $result;
    }
	
	
	
	function inactive($document_id)
	{
		$this->db->update("mast_documents", array("is_active"=>"N"), array("id"=>$document_id));
	}
	function active($document_id)
	{
		$this->db->update("mast_documents", array("is_active"=>"Y"), array("id"=>$document_id));
	}
	
	function delete($document_id)
	{
		$document_details_arr=$this->db->get_where("mast_documents_lang", array("document_id"=>$document_id))->result_array();
		foreach($document_details_arr as $docs)
		{
			if(!empty($docs['document_file']))
			{
				if(file_exists("assets/upload/documents/".$docs['document_file']))
				{
					unlink("assets/upload/documents/".$docs['document_file']);
				}
			}
		}
		$this->db->delete("mast_documents", array("id"=>$document_id));
		$this->db->delete("mast_documents_lang", array("document_id"=>$document_id));
	}
	
	
	function documents_edit()
	{
		$languages_err=$this->db->get("mast_language")->result_array();
		$posted_document_id=$this->input->post("document_id");
		$posted_language_id=$this->input->post("language_id");
		$upd_arr=array(
			"modified_date"=>date("Y-m-d H:i:s")
		);
		$this->db->update("mast_documents", $upd_arr, array("id"=>$posted_document_id));
		foreach($languages_err as $language)
		{
			$language_id=$language['id'];
			if($_FILES["document_file".$language['id']]['name']!="")
			{
				$pre_doc_details_arr=$this->db->get_where("mast_documents_lang", array("language_id"=>$language_id, "document_id"=>$posted_document_id))->result_array();
				if($pre_doc_details_arr[0]['document_file']!="")
				{
					if(file_exists("assets/upload/documents/".$pre_doc_details_arr[0]['document_file']))
					{
						unlink("assets/upload/documents/".$pre_doc_details_arr[0]['document_file']);
					}
				}
			
				$new_file_name=time()."_".$language['id']."_".str_replace(" ", "-", $_FILES["document_file".$language['id']]['name']);
				$config="";
				$config['file_name'] =$new_file_name;
				$config['upload_path'] = "assets/upload/documents/";
				$config['allowed_types'] = "doc|docx|pdf";
				$config['max_size'] = '1000000';
				$this->upload->initialize( $config );
				$this->upload->do_upload('document_file'.$language['id']);
				$document_title=$this->input->post("document_title".$language['id']);
				$upd_arr_1=array(
					"document_title"=>$document_title,
					"document_file"=>$new_file_name
				);
				$this->db->update("mast_documents_lang", $upd_arr_1, array("language_id"=>$language_id, "document_id"=>$posted_document_id));
			}
			else 
			{
				$document_title=$this->input->post("document_title".$language['id']);
				$upd_arr_1=array(
					"document_title"=>$document_title
				);
				$this->db->update("mast_documents_lang", $upd_arr_1, array("language_id"=>$language_id, "document_id"=>$posted_document_id));
			}
		}
		return "edit_success";
	}
}
	

?>