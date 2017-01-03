<?php
//ini_set('zlib.output_compression', 'Off');
class Admin_timezone extends MX_Controller {

	public function _this() {
		$this->index();
	}
	
	public function index() {
		
	}
	public function read() 
    {
		$config['time'] = '%H:%M:%S';
		$this->load->model('timezone_model');
		$act = $this->uri->segment(4, FALSE);
		$m_time = $this->timezone_model->get_time_zones();
		$this->mysmarty->assign('config', $config);
		$this->mysmarty->assign('m_time', $m_time);
		$this->mysmarty->assign('act', $act);
		$this->mysmarty->view('admin_timezeone');
    }
	public function update() 
	{
		
		$act = $this->uri->segment(5, FALSE);
		$id = $this->uri->segment(7, FALSE); 
		$this->load->model('timezone_model');
		$config['time'] = '%H:%M:%S';
		switch ($act) {
            case 'edit':
                $time = $this->timezone_model->get_time_zone($id);
                $this->mysmarty->assign('time', $time);
				$this->mysmarty->assign('config', $config);
                //$this->mysmarty->assign('asset_type', $asset_type);
                $this->mysmarty->assign('act', $act);
                $this->mysmarty->view("admin_timezeone");
                break;
            case 'update':
			$id = $this->uri->segment(6, FALSE); 
						$data_store = 	array(
										'name' => $this->input->post('time_name'),
										'open_time' => $this->input->post('open_time'),
										'close_time' => $this->input->post('close_time')
									);
				$this->timezone_model->add_update_asset($id,$data_store);
               echo "<script>window.location.href='{$url}admin/dashboard/timezone/read';</script>";
			break;
			
            default:
                return false;
                exit;
        }
	}
	public function createNewElement() 
    {
        $url = $this->config->item('base_url');
        $this->load->model('authmodel');
        $ci_csrf_token = $this->authmodel->getCSRF();
        $this->mysmarty->assign('ci_csrf_token', $ci_csrf_token);
        $act = $this->uri->segment(5, FALSE);
        switch ($act) {
            case 'new':
                $this->mysmarty->assign('act', $act);
                $this->mysmarty->view("admin_timezeone");
            break;
            case 'add':
                $this->load->model('timezone_model');
				$mysqldate1 = strtotime($this->input->post('open_time'));
				$mysqldate2 = strtotime($this->input->post('close_time'));
				
				$data_added = array(
								'name'       => $this->input->post('time_name'),
								'open_time'  => date( 'Y-m-d H:i:s', $mysqldate1 ),
								'close_time' => date( 'Y-m-d H:i:s', $mysqldate2 )
							);
//echo "<pre>"; print_r($data_added);die;

                $this->timezone_model->added_assets($data_added);
				echo "<script>window.location.href='{$url}admin/dashboard/timezone/read';</script>";
            break;
            default:
                return false;
            break;
        }
    }
	public function delete() 
	{
		$url = $this->config->item('base_url');
        $time_zone = $this->uri->segment(5, FALSE);
        $id = $this->uri->segment(7, FALSE);
        $this->load->model('timezone_model');
        if($this->timezone_model->delete_time_zone($id)){
			echo "<script>window.location.href='{$url}admin/dashboard/timezone/read';</script>";
		}
	}
	
	

}