<?php
//ini_set('zlib.output_compression', 'Off');
class Admin_trade extends MX_Controller {

	public function _this() {
		$this->index();
	}
	
	public function index() {
		
	}
	public function read($act) 
    {
		$this->load->model('assets_model');
        $assets = $this->assets_model->get_assets_list();
        $this->mysmarty->assign('assets', $assets);
        $this->mysmarty->assign('act', $act);
		$this->mysmarty->view('admin_trade');
    } 
	public function update()
	{
	
	$this->load->model('assets_model');
	$act = $this->uri->segment(5, FALSE);
	$url = $this->config->item('base_url');
	switch ($act) {
            case 'update':
	$assets_data = $this->input->post();
	if(!$assets_data['stock'])
		$assets_data['stock']=array();
	if(!$assets_data['currency'])
		$assets_data['currency']=array();
	if(!$assets_data['commodities'])
		$assets_data['commodities']=array();
	if(!$assets_data['indices'])
		$assets_data['indices']=array();
	
	foreach($assets_data as $key => $value)
	{
	$this->assets_model->save_change_assets_data($key,$value);
	}

	$assets = $this->assets_model->get_assets_list();
    $this->mysmarty->assign('assets', $assets);
	$this->mysmarty->assign('act', $act);
	$this->mysmarty->assign('url', $url);
	$this->mysmarty->view('admin_trade');
	echo "<script>window.location.href='{$url}admin/dashboard/trade/read';</script>";
	break;
	 default:
                return false;
                exit;
}}
}