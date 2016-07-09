<?php 
class admin_setting_model extends CI_Model
{
    function  __construct() 
	{
        parent::__construct();
    }
	

	####################### FETCH ALL HOME DATA ################################ 
	
	function get_row($id=0)
	{
		$result = array();
		
		$result = array();
		$this->db->where(array('site_setting_id'=>$id));
        $query = $this->db->get('mast_setting');
        foreach ($query->result() as $row) {
                $result = array(
								'site_setting_id'						=> $row->site_setting_id,
								'site_name' 							=> $row->site_name,
								'pagination_no'							=> $row->pagination_no,
								'partial_amount_percentage'				=> $row->partial_amount_percentage,
								'site_title'							=> $row->site_title,
								'paypal_url'							=> $row->paypal_url,
								'paypal_id'								=> $row->paypal_id,
								'meta_title'							=> $row->meta_title,
								'meta_keyword'							=> $row->meta_keyword,
								'meta_description'						=> $row->meta_description
            					);
        }
		//echo $this->db->last_query(); die();
        return $result;
	}
	
	
	
	####################### FETCH ALL HOME BANNER DATA ################################ 
	
	
	####################### VALIDATE HOME BANNER DATA ################################ 
	
	function validate_data()
    {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('site_name', 'Site name', 'required');
		$this->form_validation->set_rules('pagination_no', 'Pagination no', 'required');
		$this->form_validation->set_rules('site_title', 'Site title', 'required');
	
		if ($this->form_validation->run() == TRUE)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
    }
	
	####################### END  ################################ 
	
	
	
	
	
	####################### UPDATE  DATA ################################ 
	
	function update_data($edit_id)
	{
		$postdate = array(
						  'site_name'  							=> $this->input->post('site_name'),
						  'pagination_no'  						=> $this->input->post('pagination_no'),
						  'partial_amount_percentage'			=> $this->input->post('partial_amount'),
						  'site_title'  						=> $this->input->post('site_title'),
						  'paypal_url'  						=> $this->input->post('paypal_url'),
						  'paypal_id'  							=> $this->input->post('paypal_id'),
						  'meta_title'  						=> $this->input->post('meta_title'),
						  'meta_keyword'  						=> $this->input->post('meta_keyword'),
						  'meta_description'  					=> $this->input->post('meta_description'),
						  'admin_time_zone'  					=> $this->input->post('admin_time_zone')
		                  );
        $this->db->where('site_setting_id',$edit_id);
		$query = $this->db->update('mast_setting',$postdate);
		$this->db->last_query();
		return $query;
	}
	
	####################### END ################################ 
	
	
	//function to get pagination limit
	function get_admin_pagination_limit()
	{
		$this->db->where(array('site_setting_id'=>1));
        $query = $this->db->get('mast_setting')->result_array();
		return $query[0]['pagination_no'];
	}

}

?>