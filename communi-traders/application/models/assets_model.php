<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Assets_model extends CI_Model {

    public function index() {
        return true;
    }

    /**
     * @desc Function  add_new_asset
     * @params $asset, $short_name, $full_name
     * @return 1
     */
    public function add_new_asset() {
        $asset = trim($this->input->post('asset'));
        $short_name = trim($this->input->post('short_name'));
        $full_name = trim($this->input->post('full_name'));
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select('id');
        $this->db->from($asset);
        $this->db->where('short_name', $short_name);
        $this->db->where('full_name', $full_name);
        $res = $this->db->get();
        $data = $res->result_array();
        if (count($data) > 0) {
            $this->session->set_flashdata('message', 'error');
            $this->session->set_flashdata('message_content', 'Assets you try to create is already exist.');
        } else {
            $data = array('short_name' => $short_name, 'full_name' => $full_name);
            $this->db->insert($asset, $data);
            $this->create_xml($full_name, $short_name);
            $this->session->set_flashdata('message', 'success');
            $this->session->set_flashdata('message_content', 'Asset:' . $full_name . ' was successfully added');
        }
        return 0;
    }
    
    private function create_xml($quote, $fname)
    {
        //$abs_path = $_SERVER['DOCUMENT_ROOT'] . 'option/CommuniTraders';
        $abs_path = $_SERVER['DOCUMENT_ROOT'] . '/CommuniTraders';
        $file = $abs_path . '/assets/js/configs/' . $fname . '.xml';
        $xml = $this->get_xml_content($quote, $fname);
        $fp   = fopen($file, 'w');
        fwrite($fp, $xml);
        fclose($fp);
    }
    
    private function get_xml_content($quote, $fname)
    {
        $current_server_url = $this->config->item('base_url');
        $xml = '<?xml version="1.0" encoding="utf-8"?>
<stock xmlns="http://anychart.com/products/stock/schemas/1.0.0/schema.xsd">
	<data>
		<data_sets>
			<data_set id="dataSet' . $quote . '" source_url="' . $current_server_url . 'ajax/get_preload/' . $fname . '">
				<csv_settings ignore_first_row="true" rows_separator="\n" columns_separator=","/>
				<locale>
					<date_time>
						<format><![CDATA[%u]]></format>
					</date_time>
				</locale>
			</data_set>
		</data_sets>
		<data_providers>
			<general_data_providers>
				<data_provider data_set="dataSet' . $quote . '" id="dp' . $quote . '">
					<fields>
						<field type="Value" column="4" />
					</fields>
				</data_provider>
			</general_data_providers>
			<scroller_data_providers>
				<data_provider id="scrDp" data_set="dataSet' . $quote . '" column="4"/>
			</scroller_data_providers>
		</data_providers>
	</data>

	<settings>
<settings>
    <outside_margin left="50" top="50" right="50" bottom="50" />
  </settings>
		<charts>
			<chart>
                <value_axes>
                    <primary position="Right" offset="0">
                    </primary>
                </value_axes>
				<series_list>
					<series type="Line" data_provider="dp' . $quote . '" color="#3463B0">
						<name><![CDATA[' . $quote . ']]></name>
					</series>
				</series_list>
			</chart>
		</charts>
		<time_scale>
            <selected_range type="Custom" start_date="2000-01-02"/>
        </time_scale>
		<scroller data_provider="scrDp"/>
	</settings>
</stock>
';
    return $xml;
    }

    /**
     * @desc Function get_assets_list 
     * @return $assets_list
     */
    public function get_assets_list() {
        $assets_list = array();
        $assets_list['stock'] = $this->get_stock_list();
        $assets_list['m_time'] = $this->get_m_time_list();
        $assets_list['commodities'] = $this->get_commodities_list();
        $assets_list['currency'] = $this->get_currency_list();
        $assets_list['indices'] = $this->get_indices_list();

        return $assets_list;
    }

    /**
     * @desc Function get_stock_list
     * @return $data 
     */
    private function get_stock_list() {
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select('m_time.id as m_id,symbols_company.*');
        $this->db->from('symbols_company');
		$this->db->join('m_time','symbols_company.m_time_id = m_time.id','left');
        $this->db->order_by('short_name asc');
        $res = $this->db->get();
        $data = $res->result_array();
        return $data;
    }
	public function get_m_time_list()
	{
		$this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select();
        $this->db->from('m_time');
		$res = $this->db->get();
        $data = $res->result_array();
        return $data;
	}

    /**
     * @desc Function get_commodities_list
     * @return $data 
     */
    private function get_commodities_list() {
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select();
        $this->db->from('symbols_metall');
        $this->db->order_by('short_name asc');
        $res = $this->db->get();
        $data = $res->result_array();
        return $data;
    }

    /**
     * @desc Function get_currency_list
     * @return $data 
     */
    private function get_currency_list() {
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select();
        $this->db->from('symbols_currency');
        $this->db->order_by('short_name asc');
        $res = $this->db->get();
        $data = $res->result_array();
        return $data;
    }

    /**
     * @desc Function get_indices_list
     * @return $data
     */
    private function get_indices_list() {
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select();
        $this->db->from('symbols_indices');
        $this->db->order_by('short_name asc');
        $res = $this->db->get();
        $data = $res->result_array();
        return $data;
    }

    /**
     * Function get_asset_info
     * @params $asset_type, $asset_id
     * @return $data
     */
    public function get_asset_info($asset_type, $asset_id) {
        $asset_table = $this->get_asset_table($asset_type);
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select();
        $this->db->from($asset_table);
        $this->db->where('id', $asset_id);
        $res = $this->db->get();
        $data = $res->result_array();
        return $data;
    }

    /**
     * @desc Function  add_update_asset
     * @params $short_name, $full_name, $asset_type, $asset_id
     * @return $result
     */
    public function add_update_asset($asset_type, $asset_id) {
        $result = 0;
        $asset_table = $this->get_asset_table($asset_type);
        $this->db = $this->load->database('default', TRUE, TRUE);

        // Check if exists
        $this->db->select('id');
        $this->db->from($asset_table);
        $this->db->where('short_name', $this->input->post('short_name'));
        $res = $this->db->get();
        $data = $res->result_array();
        if (count($data) == 0){
            // Update
            $short_name = $this->input->post('short_name');
            $full_name  = $this->input->post('full_name');
            $data = array('short_name' => $short_name, 'full_name'  => $full_name);
            $this->db->where('id', $asset_id);
            $this->db->update($asset_table, $data);
            $this->create_xml($full_name, $short_name);
            $result = 1;
        } else {
            if ($data[0]['id'] == $asset_id) {
                $short_name = $this->input->post('short_name');
                $full_name  = $this->input->post('full_name');
                $data = array('short_name' => $short_name, 'full_name' => $full_name);
                $this->db->where('id', $asset_id);
                $this->db->update($asset_table, $data);
                $this->create_xml($full_name, $short_name);
                $result = 1;
            }
        }
        return $result;
    }

    /**
     * @desc Function  
     * @params $asset_type, $asset_id
     */
    public function delete_asset($asset_type, $asset_id) {
        $asset_table = $this->get_asset_table($asset_type);
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->from($asset_table);
        $this->db->where('id', $asset_id);
        $this->db->delete();
        $this->session->set_flashdata('message', 'success');
        $this->session->set_flashdata('message_content', 'Asset successfully delete');
    }

    /**
     * @desc Function get_asset_table
     * @params $asset_type
     * @return $asset_table
     */
    private function get_asset_table($asset_type) {
        $asset_table = '';
        switch ($asset_type) {
            case 'stock':
                $asset_table = 'symbols_company';
                break;
            case 'commodities':
                $asset_table = 'symbols_metall';
                break;
            case 'currency':
                $asset_table = 'symbols_currency';
                break;
            case 'indices':
                $asset_table = 'symbols_indices';
                break;
        }
        return $asset_table;
    }
    
    public function get_fname_by_game_id($game_id)
    {
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select();
        $this->db->from('game');
        $this->db->where('id', $game_id);
        $this->db->limit(1);
        $res  =  $this->db->get();
        $data = $res->result_array();
        return $data[0];
    }
    
    public function change_visibility($asset_id, $type, $visibility)
    {
        $table_name = '';
        $this->db = $this->load->database('default', TRUE, TRUE);
        if ($visibility == 0) {
            $visibility = 1;
        }
        else if ($visibility == 1) {
            $visibility = 0;
        }
		
        switch ($type) {
            case 'company':
                $table_name = 'symbols_company';
            break;
            case 'currency':
                $table_name = 'symbols_currency';
            break;
            case 'indices':
                $table_name = 'symbols_indices';
            break;
            case 'metall':
                $table_name = 'symbols_metall';
            break;
        }
        $data = array('visibility' => $visibility);
        $this->db->where('id', $asset_id);
        $this->db->update($table_name, $data);
    }
	public function change_time($id,$m_time,$type=NULL)
	{
		$data = array('m_time_id'=>$m_time);
		$this->db = $this->load->database('default', TRUE, TRUE);
		$this->db->where('id', $id);
        $this->db->update('symbols_company', $data);	
	}
	public function get_short_name($asset_type,$show_forum = NULL){
		$asset_table = '';
		$asset_table = $this->get_asset_table($asset_type);
		$this->db = $this->load->database('default', TRUE, TRUE);
		$this->db->select('short_name')->from($asset_table);
		if(is_numeric($show_forum))
		{
			$this->db->where('show_forum', $asset_id);
		}
		$short_name = $this->db->get()->result_array();
		return $short_name;
	}
	public function get_short_name_by_full_name($asset_type,$assets_full_name){
		$asset_table = '';
		$asset_table = $this->get_asset_table($asset_type);
		$this->db = $this->load->database('default', TRUE, TRUE);
		$short_name = $this->db->select('short_name')->from($asset_table)->where('full_name',$assets_full_name)->get()->result_array();
		return $short_name;
	}
	public function get_full_name($symbol,$what){
		$asset_table = '';
		$this->db = $this->load->database('default', TRUE, TRUE);
		$asset_table = $this->get_asset_table($what);
		return $this->db->select('full_name')->from($asset_table)->where('short_name', $symbol)->get()->result_array(); 
	}
	public function save_change_assets_data($asset_type,$id_array)
	{
	    $asset_table = $this->get_asset_table($asset_type);
        $this->db = $this->load->database('default', TRUE, TRUE);
		$data_select=$this->get_select_data_depends_table($asset_table,'id');
		if(!empty($data_select))
		{
			foreach($data_select as $key=>$value)
			{
				if(!in_array($value,$id_array))
				{
					$show_forum = 0;
					$data = array('show_forum' => $show_forum);
					$this->db->where('id', $value);
					$this->db->update($asset_table, $data);
				   
				}else{
						unset($id_array[$value]);
				}
			}
		}
		
		if(!empty($id_array))
		{
			foreach($id_array as $key=>$value)
			{	
				$show_forum = 1;
				$data = array('show_forum' => $show_forum);
				$this->db->where('id', $value);
				$this->db->update($asset_table, $data);
			   
			}
		}
		
	
	}
	public function get_select_data_depends_table($table,$id=null)
	{  
		$this->db = $this->load->database('default', TRUE, TRUE);
	    $this->db->select('*');
		$this->db->where('show_forum', 1);
        $this->db->from($table);
		$res = $this->db->get();
        $data = $res->result_array();
		if($id=="id")
		{
			$new_data=array();
			
			foreach($data as $key=>$value)
			{
				$new_data[$key]=$value['id'];
			}
			
			return $new_data;
		}else{
		
			return $data;
		}
	}
	
}
